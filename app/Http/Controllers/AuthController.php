<?php

namespace App\Http\Controllers;

use App\Mail\SendOTPMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    // clear session liên quan đến đổi mật khẩu
    public function clearResetSession()
    {
        session()->forget([
            'student_code',
            'otp_code',
            'otp_expires_at',
            'otp_verified',
            'otp_sent'
        ]);
    }

    public function cancelReset()
    {
        $this->clearResetSession();
        return redirect()->route('login');
    }

    public function showLoginForm()
    {
        // nếu đã có session thì quay lại trang trước đó
        if (session()->has('user_id')) {
            return back();
        }

        return view('auth.login');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function showResetPasswordForm()
    {
        if (!session('otp_verified') || !session('student_code')) {
            return redirect()->route('password.forgot')->with('error', 'Vui lòng nhập MSSV!');
        }

        return view('auth.reset-password');
    }

    public function login(Request $request)
    {
        // validate
        ['student_code' => $student_code, 'password' => $password] = $request->validate([
            'student_code' => ['required', 'numeric'],
            'password' => ['required', 'string'],
        ], [
            'student_code.required' => "Mã số sinh viên không được bỏ trống!",
            'student_code.numeric' => "Mã số sinh viên phải là số!",
            'password.required' => "Mật khẩu không được bỏ trống!",
        ]);

        // format của dhhcm
        if (!str_starts_with($student_code, '15000')) {
            return back()->withErrors([
                'student_code' => "Tài khoản không hợp lệ"
            ]);
        }

        //lấy mssv
        $real_code = substr($student_code, 5);
        $user = DB::table('user')->where('student_code', $real_code)->first();

        //kiểm tra
        if (!$user) {
            return back()->withErrors([
                'student_code' => "Tài khoản không hợp lệ"
            ]);
        }

        if (!Hash::check($password, $user->hashed_password)) {
            return back()->withErrors([
                'password' => 'Mật khẩu không chính xác'
            ])->onlyInput('student_code');
        }

        session(['user_id' => $user->user_id, 'role' => $user->role]);
        $request->session()->regenerate();

        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin_index')->with('success', 'Chào mừng Quản Trị Viên!');
            case 'member':
                return redirect()->route('client_index')->with('success', 'Đăng nhập thành công');
            default:
                return abort(404);
        }
    }

    public function forgotPassword(Request $request)
    {
        // validate
        ['student_code' => $student_code] = $request->validate([
            'student_code' => ['required', 'numeric'],
        ], [
            'student_code.required' => "Mã số sinh viên không được bỏ trống!",
            'student_code.numeric' => "Mã số sinh viên phải là số!",
        ]);

        // kiểm tra user
        $user = DB::table('user')->where('student_code', $student_code)->first();
        if (!$user) {
            return back()->withErrors([
                'student_code' => "Mã số sinh viên không tồn tại!"
            ])->withInput();
        }

        // tạo otp và gửi gmail
        $otp = rand(10000000, 99999999); // OTP 8 số
        Mail::to($user->email)->send(new SendOTPMail($otp, $student_code));

        session([
            'otp_code' => $otp,
            'otp_sent' => true,
            'student_code' => $student_code,
            'otp_expires_at' => now()->addMinutes(5),
        ]);

        return back()->with('success', "Mã OTP đã được gửi đến gmail của bạn!");
    }

    public function verifyOTP(Request $request)
    {
        ['otp_code' => $otp_code] = $request->validate([
            'otp_code' => ['required', 'size:8'],
        ], [
            'otp_code.required' => "Vui lòng nhập mã OTP xác nhận!",
            'otp_code.size' => "Mã OTP không đúng định dạng!",
        ]);

        // kiểm tra OTP còn tồn tại không
        if (!session()->has('otp_code') || !session()->has('otp_expires_at')) {
            return redirect()->route('password.forgot')->with('error', 'Vui lòng nhập lại MSSV!');
        }

        // kiểm tra mã OTP còn hiệu lực không
        $expiresAt = session('otp_expires_at');
        if (Carbon::now()->greaterThan($expiresAt)) {
            session()->forget(['otp_code', 'otp_sent', 'otp_expires_at', 'student_code']);
            return redirect()->route('password.forgot')
                ->withErrors([
                    'student_code' => "Mã OTP đã hết hiệu lực. Vui lòng nhập lại MSSV!"
                ]);
        }

        // kiểm tra OTP có đúng không
        if ($request->otp_code != session('otp_code')) {
            return back()->withErrors([
                'otp_code' => "Mã OTP không chính xác!"
            ]);
        }

        //nếu đúng thì xóa session lưu otp
        session()->forget(['otp_code', 'otp_expires_at', 'otp_sent']);
        session(['otp_verified' => true]); // đánh dấu là đã nhập thành công

        return redirect()->route('password.reset')->with('success', 'Xác thực OTP thành công!');
    }

    public function resetPassword(Request $request)
    {
        // kiểm tra đã nhập otp chưa
        if (!session('otp_verified') || !session('student_code')) {
            return redirect()->route('password.forgot')->with('error', 'Vui lòng nhập lại MSSV!');
        }

        ['password' => $password] = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/[A-Z]/', 'regex:/\d/'],
        ], [
            'password.required' => "Vui lòng nhập mật khẩu mới!",
            'password.min' => "Mật khẩu phải có ít nhất 8 ký tự!",
            'password.confirmed' => "Xác nhận mật khẩu không khớp!",
            'password.regex' => "Mật khẩu phải chứa ít nhất 1 ký tự viết hoa và 1 chữ số!",
        ]);

        // tìm user
        $student_code = session('student_code');
        $user = DB::table('user')->where('student_code', $student_code)->first();
        if (!$user) {
            return redirect()->route('password.forgot')->with('error', 'Không tìm thấy tài khoản cần đổi mật khẩu!');
        }

        // cập nhật pass
        DB::table('user')->where('student_code', $student_code)->update([
            'hashed_password' => Hash::make($password)
        ]);

        // xóa session
        $this->clearResetSession();

        return redirect()->route('login.submit')->with('success', 'Đổi mật khẩu mới thành công!');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate(); // xóa toàn bộ session
        $request->session()->regenerateToken();

        return redirect()->route('login.submit')->with('success', 'Đăng xuất thành công!');
    }
}

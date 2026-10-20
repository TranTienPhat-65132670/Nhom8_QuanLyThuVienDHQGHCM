<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    Member
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Đăng Xuất</button>

        Đã làm xong hết chức năng login và đổi mật khẩu bằng gmail. Tiếp theo là làm ui cho thư viện.
    </form>
</body>

</html>

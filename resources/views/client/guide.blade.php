  @extends('layout.client')

  @section('title', 'Hướng Dẫn Sử Dụng')

  @section('content')
      <div class="max-w-4xl mx-auto px-4 py-8">

          <!-- Tiêu đề trang -->
          <div class="mb-6 border-b border-slate-200 pb-4">
              <h1 class="text-2xl font-bold text-slate-900 flex items-center gap-2">
                  <i class="fa-solid fa-circle-info text-teal-600"></i> Hướng Dẫn Sử Dụng Thư Viện
              </h1>
              <p class="text-xs text-slate-500 mt-1">Tổng hợp quy trình, thủ tục và các bước khai thác dịch vụ thư viện cho
                  bạn đọc.</p>
          </div>

          <!-- Nội dung các hướng dẫn -->
          <div class="space-y-6 text-xs text-slate-700 leading-relaxed">

              <!-- Mục 1 -->
              <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-xs">
                  <h2 class="font-bold text-slate-900 text-sm mb-2 flex items-center gap-2">
                      <span
                          class="w-6 h-6 rounded-full bg-teal-100 text-teal-700 flex items-center justify-center text-xs">1</span>
                      Hướng dẫn tra cứu tài liệu (OPAC)
                  </h2>
                  <ul class="list-disc pl-5 space-y-1.5 text-slate-600">
                      <li>Sử dụng thanh tìm kiếm tập trung trên trang chủ hoặc tại mục tra cứu của hệ thống.</li>
                      <li>Nhập từ khóa theo tên sách, tên tác giả, chuyên ngành hoặc mã số ISBN.</li>
                      <li>Kiểm tra trạng thái tài liệu (sách còn trên kệ hay đang được mượn) và ghi nhận vị trí phân loại.
                      </li>
                  </ul>
              </div>

              <!-- Mục 2 -->
              <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-xs">
                  <h2 class="font-bold text-slate-900 text-sm mb-2 flex items-center gap-2">
                      <span
                          class="w-6 h-6 rounded-full bg-teal-100 text-teal-700 flex items-center justify-center text-xs">2</span>
                      Quy trình mượn, trả và gia hạn sách
                  </h2>
                  <ul class="list-disc pl-5 space-y-1.5 text-slate-600">
                      <li><strong>Mượn sách:</strong> Đăng nhập tài khoản sinh viên trên hệ thống hoặc làm thủ tục trực tiếp
                          tại quầy lưu thông.</li>
                      <li><strong>Gia hạn:</strong> Truy cập vào tài khoản cá nhân, chọn danh sách sách đang mượn để thực
                          hiện gia hạn trực tuyến (nếu chưa có người đặt trước).</li>
                      <li><strong>Trả sách:</strong> Nộp lại sách tại quầy thủ thư hoặc bỏ vào thùng trả sách tự động đúng
                          hạn.</li>
                  </ul>
              </div>

              <!-- Mục 3 -->
              <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-xs">
                  <h2 class="font-bold text-slate-900 text-sm mb-2 flex items-center gap-2">
                      <span
                          class="w-6 h-6 rounded-full bg-teal-100 text-teal-700 flex items-center justify-center text-xs">3</span>
                      Khai thác cơ sở dữ liệu số quốc tế
                  </h2>
                  <ul class="list-disc pl-5 space-y-1.5 text-slate-600">
                      <li>Sử dụng tài khoản được cấp để truy cập miễn phí các cơ sở dữ liệu học thuật liên kết
                          (ScienceDirect, SpringerLink...).</li>
                      <li>Tra cứu kho tài nguyên số nội sinh gồm luận văn, luận án và các bài báo khoa học phục vụ nghiên
                          cứu.</li>
                  </ul>
              </div>

              <!-- Mục 4 -->
              <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-xs">
                  <h2 class="font-bold text-slate-900 text-sm mb-2 flex items-center gap-2">
                      <span
                          class="w-6 h-6 rounded-full bg-teal-100 text-teal-700 flex items-center justify-center text-xs">4</span>
                      Đặt phòng học nhóm & dịch vụ khác
                  </h2>
                  <ul class="list-disc pl-5 space-y-1.5 text-slate-600">
                      <li>Đăng ký lịch sử dụng phòng học nhóm trực tuyến thông qua hệ thống quản lý độc giả.</li>
                      <li>Tuân thủ nghiêm ngặt thời gian sử dụng các thiết bị máy tính và không gian tự học chung.</li>
                  </ul>
              </div>

          </div>

          <!-- Nút quay lại trang chủ -->
          <div class="mt-8 text-center">
              <a href="{{ route('client_index') }}"
                  class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold transition">
                  <i class="fa-solid fa-arrow-left"></i> Quay lại trang chủ
              </a>
          </div>

      </div>
  @endsection

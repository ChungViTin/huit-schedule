<?php
$pageTitle = 'Thêm Giảng Viên Mới - HUIT Schedule Hub';
?>

<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center space-x-2 text-xs text-slate-500 mb-1">
                <a href="/teachers" class="hover:underline">Giảng viên</a>
                <span>/</span>
                <span class="text-slate-800 font-semibold">Thêm mới</span>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight flex items-center space-x-2">
                <i class="ti ti-user-plus text-huit-blue"></i>
                <span>Thêm Giảng Viên Mới</span>
            </h1>
        </div>
        <a href="/teachers" class="inline-flex items-center space-x-1 text-xs text-slate-600 hover:text-slate-900 bg-white border border-slate-200 px-3 py-2 rounded-xl transition">
            <i class="ti ti-arrow-left"></i>
            <span>Quay lại</span>
        </a>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <form action="/teachers" method="POST" class="space-y-4">
            
            <div>
                <label for="full_name" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Họ và Tên Giảng Viên <span class="text-red-500">*</span></label>
                <input type="text" id="full_name" name="full_name" required placeholder="Ví dụ: TS. Nguyễn Văn A" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-blue">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Email (Đăng nhập) <span class="text-red-500">*</span></label>
                    <input type="email" id="email" name="email" required placeholder="gv.a@huit.edu.vn" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-blue">
                </div>

                <div>
                    <label for="phone" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Số Điện Thoại <span class="text-red-500">*</span></label>
                    <input type="text" id="phone" name="phone" required placeholder="0901234567" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-blue">
                </div>
            </div>

            <div>
                <label for="expertise" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Chuyên Môn Chính <span class="text-red-500">*</span></label>
                <input type="text" id="expertise" name="expertise" required placeholder="Ví dụ: Công nghệ phần mềm, Khoa học dữ liệu, Công nghệ thực phẩm..." class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-blue">
                <span class="text-[11px] text-slate-400 mt-1 block">Hệ thống phân lịch thông minh sẽ dựa vào chuyên môn này để đề xuất giảng viên</span>
            </div>

            <div>
                <label for="password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Mật khẩu ban đầu</label>
                <input type="password" id="password" name="password" placeholder="Mặc định: 123456" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-blue">
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="/teachers" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-medium text-slate-600 hover:bg-slate-50 transition">Hủy bỏ</a>
                <button type="submit" class="px-6 py-2.5 bg-huit-blue hover:bg-huit-dark text-white text-xs font-bold rounded-xl shadow-md transition flex items-center space-x-1.5">
                    <i class="ti ti-check"></i>
                    <span>Lưu Giảng Viên</span>
                </button>
            </div>

        </form>
    </div>

</div>

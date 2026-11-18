<?php
$pageTitle = 'Chỉnh sửa Giảng viên - HUIT Schedule Hub';
?>

<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center space-x-2 text-xs text-slate-500 mb-1">
                <a href="/teachers" class="hover:underline">Giảng viên</a>
                <span>/</span>
                <span class="text-slate-800 font-semibold">Chỉnh sửa</span>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight flex items-center space-x-2">
                <i class="ti ti-edit text-huit-blue"></i>
                <span>Chỉnh Sửa Hồ Sơ Giảng Viên</span>
            </h1>
        </div>
        <a href="/teachers" class="inline-flex items-center space-x-1 text-xs text-slate-600 hover:text-slate-900 bg-white border border-slate-200 px-3 py-2 rounded-xl transition">
            <i class="ti ti-arrow-left"></i>
            <span>Quay lại</span>
        </a>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <form action="/teachers/<?= $teacher['id'] ?>/edit" method="POST" class="space-y-4">
            
            <div>
                <label for="full_name" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Họ và Tên Giảng Viên <span class="text-red-500">*</span></label>
                <input type="text" id="full_name" name="full_name" required value="<?= htmlspecialchars($teacher['full_name']) ?>" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-blue">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Email (Đăng nhập) <span class="text-red-500">*</span></label>
                    <input type="email" id="email" name="email" required value="<?= htmlspecialchars($teacher['email']) ?>" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-blue">
                </div>

                <div>
                    <label for="phone" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Số Điện Thoại <span class="text-red-500">*</span></label>
                    <input type="text" id="phone" name="phone" required value="<?= htmlspecialchars($teacher['phone']) ?>" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-blue">
                </div>
            </div>

            <div>
                <label for="expertise" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Chuyên Môn Chính <span class="text-red-500">*</span></label>
                <input type="text" id="expertise" name="expertise" required value="<?= htmlspecialchars($teacher['expertise']) ?>" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-blue">
            </div>

            <div>
                <label for="password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Đổi Mật Khẩu (Để trống nếu không đổi)</label>
                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu mới nếu muốn đổi..." class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-blue">
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="/teachers" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-medium text-slate-600 hover:bg-slate-50 transition">Hủy bỏ</a>
                <button type="submit" class="px-6 py-2.5 bg-huit-blue hover:bg-huit-dark text-white text-xs font-bold rounded-xl shadow-md transition flex items-center space-x-1.5">
                    <i class="ti ti-device-floppy"></i>
                    <span>Cập Nhật Thông Tin</span>
                </button>
            </div>

        </form>
    </div>

</div>

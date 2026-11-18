<?php
$pageTitle = 'Cổng Thông Tin Đăng Nhập - HUIT';
?>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

    <!-- Cột trái: Bảng thông báo (Ảnh 1) -->
    <div class="lg:col-span-8 bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        
        <!-- Tab Navigation -->
        <div class="flex items-center space-x-6 border-b border-slate-200 pb-3 text-sm font-bold">
            <button type="button" class="text-huit-header border-b-2 border-huit-header pb-3 -mb-3.5 tracking-wide">
                THÔNG BÁO CHUNG
            </button>
            <button type="button" class="text-slate-500 hover:text-huit-header pb-3 -mb-3.5 tracking-wide transition">
                ĐẠI HỌC - CAO ĐẲNG
            </button>
            <button type="button" class="text-slate-500 hover:text-huit-header pb-3 -mb-3.5 tracking-wide transition">
                SAU ĐẠI HỌC
            </button>
            <button type="button" class="text-slate-500 hover:text-huit-header pb-3 -mb-3.5 tracking-wide transition">
                PHÂN LỊCH ĐA CƠ SỞ
            </button>
        </div>

        <!-- Notification List -->
        <div class="divide-y divide-slate-100 mt-4 space-y-4">
            
            <!-- Item 1 -->
            <div class="flex items-start space-x-4 pt-3 group">
                <div class="flex-shrink-0 w-14 text-center rounded-lg overflow-hidden border border-huit-blue shadow-xs">
                    <div class="bg-huit-header text-white text-[10px] font-bold py-0.5">Tháng 11</div>
                    <div class="bg-white text-huit-header text-xl font-black py-1">17</div>
                </div>
                <div class="flex-grow">
                    <a href="javascript:void(0)" class="text-sm font-semibold text-slate-800 group-hover:text-huit-header transition leading-snug">
                        Thông báo về việc công bố và phân bổ thời khóa biểu giảng dạy đa cơ sở Học kỳ 1 (2026 - 2027)
                    </a>
                    <span class="inline-block bg-red-600 text-white text-[9px] font-bold px-1.5 py-0.2 rounded-full ml-1">new</span>
                    <div class="text-[11px] text-red-600 font-medium mt-1">Xem chi tiết &raquo;</div>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="flex items-start space-x-4 pt-3 group">
                <div class="flex-shrink-0 w-14 text-center rounded-lg overflow-hidden border border-huit-blue shadow-xs">
                    <div class="bg-huit-header text-white text-[10px] font-bold py-0.5">Tháng 11</div>
                    <div class="bg-white text-huit-header text-xl font-black py-1">13</div>
                </div>
                <div class="flex-grow">
                    <a href="javascript:void(0)" class="text-sm font-semibold text-slate-800 group-hover:text-huit-header transition leading-snug">
                        Thông báo hướng dẫn giảng viên di chuyển giảng dạy giữa Cơ sở Tân Phú và Cơ sở Tân Bình
                    </a>
                    <span class="inline-block bg-red-600 text-white text-[9px] font-bold px-1.5 py-0.2 rounded-full ml-1">new</span>
                    <div class="text-[11px] text-red-600 font-medium mt-1">Xem chi tiết &raquo;</div>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="flex items-start space-x-4 pt-3 group">
                <div class="flex-shrink-0 w-14 text-center rounded-lg overflow-hidden border border-huit-blue shadow-xs">
                    <div class="bg-huit-header text-white text-[10px] font-bold py-0.5">Tháng 11</div>
                    <div class="bg-white text-huit-header text-xl font-black py-1">13</div>
                </div>
                <div class="flex-grow">
                    <a href="javascript:void(0)" class="text-sm font-semibold text-slate-800 group-hover:text-huit-header transition leading-snug">
                        Trung tâm Thí nghiệm Thực hành - Thông báo lịch thực hành phòng máy các chuyên ngành CNTT & Thực phẩm
                    </a>
                    <span class="inline-block bg-red-600 text-white text-[9px] font-bold px-1.5 py-0.2 rounded-full ml-1">new</span>
                    <div class="text-[11px] text-red-600 font-medium mt-1">Xem chi tiết &raquo;</div>
                </div>
            </div>

            <!-- Item 4 -->
            <div class="flex items-start space-x-4 pt-3 group">
                <div class="flex-shrink-0 w-14 text-center rounded-lg overflow-hidden border border-huit-blue shadow-xs">
                    <div class="bg-huit-header text-white text-[10px] font-bold py-0.5">Tháng 11</div>
                    <div class="bg-white text-huit-header text-xl font-black py-1">12</div>
                </div>
                <div class="flex-grow">
                    <a href="javascript:void(0)" class="text-sm font-semibold text-slate-800 group-hover:text-huit-header transition leading-snug">
                        Thông báo triển khai hệ thống thông minh HUIT Schedule Hub hỗ trợ gợi ý phân lịch tối ưu
                    </a>
                    <div class="text-[11px] text-red-600 font-medium mt-1">Xem chi tiết &raquo;</div>
                </div>
            </div>

        </div>

        <div class="text-right mt-6 pt-3 border-t border-slate-100">
            <a href="javascript:void(0)" class="text-xs font-bold text-red-600 hover:text-red-700 tracking-wider">
                XEM THÊM &raquo;
            </a>
        </div>

    </div>

    <!-- Cột phải: Form Đăng nhập Cổng HUIT (Ảnh 1) -->
    <div class="lg:col-span-4 bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex flex-col justify-between">
        
        <div>
            <!-- Tiêu đề Cổng Thông Tin -->
            <div class="text-center mb-5">
                <h2 class="text-sm font-bold text-huit-header uppercase tracking-wider">CỔNG THÔNG TIN PHÂN LỊCH HUIT</h2>
                <h3 class="text-base font-extrabold text-huit-blue tracking-tight mt-1">ĐĂNG NHẬP HỆ THỐNG</h3>
            </div>

            <!-- Tabs chọn vai trò: Phòng Đào tạo (Admin) vs Giảng viên -->
            <div class="flex p-1 bg-slate-100 rounded-xl mb-4 text-xs font-semibold">
                <button type="button" id="tabAdmin" onclick="switchLoginRole('admin')" class="flex-1 py-2 text-center rounded-lg bg-white shadow-xs text-huit-header">
                    Phòng Đào Tạo
                </button>
                <button type="button" id="tabTeacher" onclick="switchLoginRole('teacher')" class="flex-1 py-2 text-center rounded-lg text-slate-500 hover:text-slate-800">
                    Giảng Viên
                </button>
            </div>

            <!-- Flash Error -->
            <?php if (!empty($_SESSION['flash_error'])): ?>
                <div class="p-3 mb-4 text-xs text-red-700 rounded-xl bg-red-50 border border-red-200 flex items-center space-x-2">
                    <i class="ti ti-alert-circle text-base flex-shrink-0"></i>
                    <div><?= $_SESSION['flash_error'] ?></div>
                </div>
                <?php unset($_SESSION['flash_error']); ?>
            <?php endif; ?>

            <?php if (!empty($_SESSION['flash_success'])): ?>
                <div class="p-3 mb-4 text-xs text-emerald-700 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center space-x-2">
                    <i class="ti ti-circle-check text-base flex-shrink-0"></i>
                    <div><?= $_SESSION['flash_success'] ?></div>
                </div>
                <?php unset($_SESSION['flash_success']); ?>
            <?php endif; ?>

            <!-- Form Đăng Nhập -->
            <form id="loginForm" action="/login" method="POST" class="space-y-3.5">
                
                <!-- Input Tài khoản -->
                <div>
                    <input type="text" id="loginField" name="login" required 
                        placeholder="Nhập tên đăng nhập hoặc email" 
                        class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-huit-header focus:bg-white transition placeholder-slate-400">
                </div>

                <!-- Input Mật khẩu -->
                <div>
                    <input type="password" id="passwordField" name="password" required 
                        placeholder="Nhập mật khẩu" 
                        class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-huit-header focus:bg-white transition placeholder-slate-400">
                </div>

                <div class="flex items-center justify-between text-[11px] text-slate-500">
                    <label class="flex items-center space-x-1.5 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded text-huit-header focus:ring-huit-header">
                        <span>Ghi nhớ đăng nhập</span>
                    </label>
                    <a href="javascript:void(0)" class="text-huit-header hover:underline">Quên mật khẩu?</a>
                </div>

                <!-- Captcha Verification (như trong ảnh 1) -->
                <div class="flex items-center space-x-2">
                    <input type="text" id="captchaInput" placeholder="Nhập mã" required 
                        class="w-28 px-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-huit-header">
                    
                    <button type="button" onclick="generateCaptcha()" title="Đổi mã khác" class="p-1.5 text-slate-500 hover:text-huit-header rounded-lg border border-slate-200 bg-slate-50">
                        <i class="ti ti-refresh text-sm"></i>
                    </button>

                    <div id="captchaBox" class="flex-grow py-1 px-3 bg-slate-100 rounded-xl border border-slate-200 text-center font-mono font-bold text-sm tracking-widest text-slate-700 select-none shadow-inner" style="background-image: repeating-linear-gradient(45deg, #f1f5f9 0, #f1f5f9 5px, #e2e8f0 5px, #e2e8f0 10px);">
                        7LY8
                    </div>
                </div>

                <!-- Submit Button Cam lớn (Ảnh 1) -->
                <button type="submit" 
                    class="w-full py-2.5 px-4 bg-huit-orange hover:bg-huit-orangeHover text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-md transition flex items-center justify-center space-x-2">
                    <span>ĐĂNG NHẬP</span>
                </button>

            </form>

            <!-- Nút phụ -->
            <div class="mt-3 text-center">
                <button type="button" class="w-full py-2 text-xs font-semibold rounded-xl bg-teal-500 hover:bg-teal-600 text-white transition">
                    Dành cho giảng viên / cán bộ
                </button>
            </div>
        </div>

        <!-- Phần tải App Mobile & QR Code (như trong Ảnh 1) -->
        <div class="mt-6 pt-4 border-t border-slate-100 text-center">
            <span class="text-[11px] text-slate-500 font-medium block mb-2">Tải App Mobile giảng viên:</span>
            <div class="flex items-center justify-center space-x-3">
                <!-- QR Code Dummy -->
                <div class="w-16 h-16 bg-white p-1 rounded-lg border border-slate-200 shadow-xs flex items-center justify-center">
                    <svg class="w-14 h-14" viewBox="0 0 100 100" fill="currentColor">
                        <path d="M10 10h30v30h-30z M15 15v20h20v-20z M60 10h30v30h-30z M65 15v20h20v-20z M10 60h30v30h-30z M15 65v20h20v-20z M20 20h10v10h-10z M70 20h10v10h-10z M20 70h10v10h-10z M50 20h5v10h-5z M50 50h10v10h-10z M70 50h20v5h-20z M50 70h10v20h-10z M70 70h10v10h-10z M85 85h5v5h-5z"/>
                    </svg>
                </div>
                <div class="space-y-1.5">
                    <div class="bg-black text-white text-[9px] px-2.5 py-1 rounded flex items-center space-x-1 cursor-pointer hover:bg-slate-800">
                        <i class="ti ti-brand-apple text-sm"></i>
                        <div class="text-left leading-none">
                            <span class="text-[7px] block text-slate-300">Download on the</span>
                            <span class="font-bold">App Store</span>
                        </div>
                    </div>
                    <div class="bg-black text-white text-[9px] px-2.5 py-1 rounded flex items-center space-x-1 cursor-pointer hover:bg-slate-800">
                        <i class="ti ti-brand-google-play text-sm"></i>
                        <div class="text-left leading-none">
                            <span class="text-[7px] block text-slate-300">ANDROID APP ON</span>
                            <span class="font-bold">Google play</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <button type="button" class="w-full py-1.5 text-[11px] font-bold rounded-xl bg-cyan-500 hover:bg-cyan-600 text-white transition">
                    Hướng dẫn sử dụng App HUIT Schedule
                </button>
            </div>
        </div>

    </div>

</div>

<!-- Script xử lý chuyển Tab & Captcha -->
<script>
let currentCaptcha = '';

function generateCaptcha() {
    const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    let res = '';
    for (let i = 0; i < 4; i++) {
        res += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    currentCaptcha = res;
    document.getElementById('captchaBox').innerText = res;
}

function switchLoginRole(role) {
    const tabAdmin = document.getElementById('tabAdmin');
    const tabTeacher = document.getElementById('tabTeacher');
    const form = document.getElementById('loginForm');
    const loginField = document.getElementById('loginField');
    const passwordField = document.getElementById('passwordField');

    if (role === 'admin') {
        tabAdmin.className = 'flex-1 py-2 text-center rounded-lg bg-white shadow-xs text-huit-header font-bold';
        tabTeacher.className = 'flex-1 py-2 text-center rounded-lg text-slate-500 hover:text-slate-800 font-medium';
        form.action = '/login';
        loginField.name = 'login';
        loginField.placeholder = 'Tài khoản admin (admin hoặc admin@huit.edu.vn)';
        loginField.value = 'admin';
        passwordField.value = 'admin123';
    } else {
        tabTeacher.className = 'flex-1 py-2 text-center rounded-lg bg-white shadow-xs text-huit-orange font-bold';
        tabAdmin.className = 'flex-1 py-2 text-center rounded-lg text-slate-500 hover:text-slate-800 font-medium';
        form.action = '/teacher-login';
        loginField.name = 'email';
        loginField.placeholder = 'Email giảng viên (nguyenvana@huit.edu.vn)';
        loginField.value = 'nguyenvana@huit.edu.vn';
        passwordField.value = '123456';
    }
}

// Khởi tạo captcha và mặc định role
document.addEventListener('DOMContentLoaded', function() {
    generateCaptcha();
    switchLoginRole('admin');

    // Tự động điền captcha mẫu để demo thuận tiện nhất
    document.getElementById('captchaInput').value = currentCaptcha;

    // Validate captcha trước khi submit
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const userInput = document.getElementById('captchaInput').value.trim().toUpperCase();
        if (userInput !== currentCaptcha) {
            e.preventDefault();
            alert('Mã xác nhận Captcha không chính xác! Vui lòng nhập lại.');
            generateCaptcha();
            document.getElementById('captchaInput').value = '';
            document.getElementById('captchaInput').focus();
        }
    });
});
</script>

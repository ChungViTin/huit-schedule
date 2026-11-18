<?php
use App\Core\Auth;
$user = Auth::user();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'HUIT Schedule Hub - Hệ thống phân lịch đa cơ sở') ?></title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        huit: {
                            blue: '#0054A6',
                            header: '#005BAA',
                            orange: '#FF6600',
                            orangeHover: '#E65C00',
                            light: '#F4F7FA'
                        }
                    }
                }
            }
        }
    </script>
    <!-- Font & Tabler Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .sidebar-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</head>
<body class="bg-[#F4F7FA] text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- TOP HEADER TRẮNG THEO ẢNH 2 & 3 -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-xs">
        <div class="px-4 py-2.5 flex items-center justify-between">
            
            <!-- Left: Toggle Sidebar + Brand + Search -->
            <div class="flex items-center space-x-3 sm:space-x-4">
                
                <!-- Nút Hide / Show Sidebar (Icon Menu) -->
                <button type="button" id="sidebarToggleBtn" class="p-2 rounded-xl text-slate-600 hover:text-huit-header hover:bg-slate-100 transition focus:outline-none" title="Ẩn/Hiện Menu Trái">
                    <i class="ti ti-menu-2 text-xl"></i>
                </button>

                <!-- Logo HUIT -->
                <a href="/dashboard" class="flex items-center space-x-2">
                    <div class="w-9 h-9 rounded-full bg-huit-header flex items-center justify-center text-white shadow-xs">
                        <i class="ti ti-school text-lg"></i>
                    </div>
                    <div class="hidden sm:block">
                        <span class="text-base font-black tracking-tight text-huit-header block leading-none">HUIT</span>
                        <span class="text-[9px] uppercase tracking-wider text-slate-500 font-bold block mt-0.5">TRƯỜNG ĐẠI HỌC CÔNG THƯƠNG TP.HCM</span>
                    </div>
                </a>

                <!-- Search Input Bar (Ảnh 2 & 3) -->
                <div class="hidden md:flex items-center relative ml-4">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i class="ti ti-search text-sm"></i>
                    </span>
                    <input type="text" placeholder="Tìm kiếm môn học, giảng viên, phòng..." 
                        class="w-72 pl-9 pr-4 py-1.5 text-xs bg-slate-100 hover:bg-slate-50 focus:bg-white border border-slate-200 rounded-full focus:outline-none focus:ring-2 focus:ring-huit-header transition">
                </div>
            </div>

            <!-- Right: Quick Icons & User Profile -->
            <div class="flex items-center space-x-3 sm:space-x-5">
                
                <a href="/dashboard" class="hidden sm:flex items-center space-x-1 text-xs text-slate-600 hover:text-huit-header font-medium transition">
                    <i class="ti ti-home text-base"></i>
                    <span>Trang chủ</span>
                </a>

                <div class="relative cursor-pointer text-slate-600 hover:text-huit-header transition" title="Thông báo mới">
                    <i class="ti ti-bell text-lg"></i>
                    <span class="absolute -top-1.5 -right-2 bg-red-600 text-white text-[9px] font-bold px-1.5 py-0.2 rounded-full">
                        102
                    </span>
                </div>

                <!-- User Profile Pill -->
                <div class="flex items-center space-x-2 border-l border-slate-200 pl-3 sm:pl-4">
                    <div class="w-8 h-8 rounded-full bg-blue-100 text-huit-header flex items-center justify-center font-bold text-xs shadow-xs">
                        <?= mb_substr($user['full_name'] ?? 'A', 0, 1) ?>
                    </div>
                    <div class="hidden sm:block text-left leading-tight">
                        <span class="text-xs font-bold text-slate-800 block truncate max-w-[130px]">
                            <?= htmlspecialchars($user['full_name'] ?? 'Quản Trị Viên') ?>
                        </span>
                        <span class="text-[10px] text-orange-600 font-semibold uppercase">Phòng Đào Tạo</span>
                    </div>
                </div>

                <!-- Đăng xuất -->
                <a href="/logout" title="Đăng xuất" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition">
                    <i class="ti ti-logout text-lg"></i>
                </a>

            </div>

        </div>
    </header>

    <!-- WRAPPER: SIDEBAR + MAIN CONTENT -->
    <div class="flex-grow flex relative overflow-x-hidden">
        
        <!-- SIDEBAR BÊN TRÁI CÓ THỂ HIDE / TOGGLE (THEO ẢNH 2 & 3) -->
        <aside id="sidebar" class="sidebar-transition w-64 bg-white border-r border-slate-200 flex-shrink-0 flex flex-col justify-between z-30 select-none">
            
            <div class="p-3 space-y-1">
                
                <div class="px-3 py-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                    DANH MỤC HỆ THỐNG
                </div>

                <!-- 1. Trang chủ -->
                <a href="/dashboard" class="flex items-center space-x-2.5 px-3 py-2.5 rounded-xl text-xs font-bold transition <?= str_contains($_SERVER['REQUEST_URI'], '/dashboard') ? 'bg-blue-50 text-huit-header border-l-4 border-huit-header' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
                    <i class="ti ti-home text-base"></i>
                    <span>TRANG CHỦ</span>
                </a>

                <!-- 2. Quản lý phân lịch (Accordion) -->
                <div>
                    <div class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 cursor-pointer">
                        <div class="flex items-center space-x-2.5">
                            <i class="ti ti-calendar-stats text-base text-huit-header"></i>
                            <span>QUẢN LÝ PHÂN LỊCH</span>
                        </div>
                        <i class="ti ti-chevron-down text-xs text-slate-400"></i>
                    </div>
                    
                    <div class="pl-8 pr-2 py-1 space-y-1 text-xs font-medium">
                        <a href="/dashboard" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-huit-header hover:bg-slate-50 transition <?= str_contains($_SERVER['REQUEST_URI'], '/dashboard') ? 'text-huit-header font-bold' : '' ?>">
                            &bull; Lịch học theo tuần
                        </a>
                        <a href="/schedules/create" class="block py-1.5 px-2 rounded-lg text-orange-600 font-bold hover:bg-orange-50 transition <?= str_contains($_SERVER['REQUEST_URI'], '/schedules/create') ? 'bg-orange-50' : '' ?>">
                            &bull; Phân lịch thông minh
                        </a>
                        <a href="/schedules" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-huit-header hover:bg-slate-50 transition <?= str_contains($_SERVER['REQUEST_URI'], '/schedules') && !str_contains($_SERVER['REQUEST_URI'], '/schedules/create') ? 'text-huit-header font-bold' : '' ?>">
                            &bull; Danh sách lịch giảng dạy
                        </a>
                    </div>
                </div>

                <!-- 3. Quản lý Giảng viên -->
                <a href="/teachers" class="flex items-center space-x-2.5 px-3 py-2.5 rounded-xl text-xs font-bold transition <?= str_contains($_SERVER['REQUEST_URI'], '/teachers') ? 'bg-blue-50 text-huit-header border-l-4 border-huit-header' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
                    <i class="ti ti-users text-base text-slate-500"></i>
                    <span>GIẢNG VIÊN</span>
                </a>

                <!-- 4. Quản lý Cơ sở đào tạo -->
                <a href="/branches" class="flex items-center space-x-2.5 px-3 py-2.5 rounded-xl text-xs font-bold transition <?= str_contains($_SERVER['REQUEST_URI'], '/branches') ? 'bg-blue-50 text-huit-header border-l-4 border-huit-header' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
                    <i class="ti ti-building-community text-base text-slate-500"></i>
                    <span>CƠ SỞ ĐÀO TẠO</span>
                </a>

                <div class="pt-3 border-t border-slate-100">
                    <div class="px-3 py-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                        LIÊN KẾT NGOÀI
                    </div>
                    <a href="/portal" target="_blank" class="flex items-center space-x-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-huit-header hover:bg-slate-50 transition">
                        <i class="ti ti-external-link text-base text-teal-600"></i>
                        <span>Cổng tra cứu Giảng viên</span>
                    </a>
                </div>

            </div>

            <!-- Footer sidebar nhỏ -->
            <div class="p-3 border-t border-slate-100 bg-slate-50 text-[10px] text-slate-500 text-center">
                <span class="font-bold text-slate-700">HUIT Schedule Hub v1.0</span>
                <p class="text-slate-400 mt-0.5">Phân lịch đa cơ sở thông minh</p>
            </div>

        </aside>

        <!-- MAIN CONTENT CONTAINER (Tự động mở rộng khi sidebar ẩn) -->
        <main class="flex-grow min-w-0 p-4 sm:p-6 overflow-y-auto">
            
            <!-- Flash Notification Messages -->
            <div class="w-full mb-4">
                <?php if (!empty($_SESSION['flash_success'])): ?>
                    <div class="p-3.5 mb-3 text-xs text-emerald-800 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center space-x-2">
                        <i class="ti ti-circle-check text-lg text-emerald-600 flex-shrink-0"></i>
                        <div><?= $_SESSION['flash_success'] ?></div>
                    </div>
                    <?php unset($_SESSION['flash_success']); ?>
                <?php endif; ?>

                <?php if (!empty($_SESSION['flash_error'])): ?>
                    <div class="p-3.5 mb-3 text-xs text-red-800 rounded-xl bg-red-50 border border-red-200 flex items-center space-x-2">
                        <i class="ti ti-alert-triangle text-lg text-red-600 flex-shrink-0"></i>
                        <div><?= $_SESSION['flash_error'] ?></div>
                    </div>
                    <?php unset($_SESSION['flash_error']); ?>
                <?php endif; ?>
            </div>

            <?= $content ?>

        </main>

    </div>

    <!-- JS XỬ LÝ HIDE / SHOW SIDEBAR + LƯU LOCALSTORAGE -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebarToggleBtn');

        // Đọc trạng thái từ localStorage
        const isHidden = localStorage.getItem('huit_sidebar_hidden') === 'true';
        if (isHidden) {
            sidebar.classList.add('-ml-64');
        }

        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('-ml-64');
            const hidden = sidebar.classList.contains('-ml-64');
            localStorage.setItem('huit_sidebar_hidden', hidden);
        });
    });
    </script>

</body>
</html>

<?php
use App\Core\Auth;
$user = Auth::user();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'HUIT Schedule Hub - Quản lý phân lịch giảng dạy') ?></title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        huit: {
                            blue: '#003366',
                            dark: '#002244',
                            orange: '#EA580C',
                            light: '#F0F4F8'
                        }
                    }
                }
            }
        }
    </script>
    <!-- Font & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- Top Navigation Bar -->
    <header class="bg-huit-blue text-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo & Brand -->
                <div class="flex items-center space-x-3">
                    <a href="/dashboard" class="flex items-center space-x-2 text-white group">
                        <div class="w-10 h-10 rounded-lg bg-huit-orange flex items-center justify-center shadow-inner group-hover:scale-105 transition-transform">
                            <i class="ti ti-calendar-stats text-2xl text-white"></i>
                        </div>
                        <div>
                            <span class="text-xl font-bold tracking-tight text-white block leading-none">HUIT Schedule Hub</span>
                            <span class="text-xs text-orange-200 tracking-wider font-medium">Hệ thống phân lịch đa cơ sở thông minh</span>
                        </div>
                    </a>
                </div>

                <!-- Main Menu Links -->
                <nav class="hidden md:flex space-x-1">
                    <a href="/dashboard" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white/10 transition-colors flex items-center space-x-1.5 <?= str_contains($_SERVER['REQUEST_URI'], '/dashboard') ? 'bg-white/20 text-white' : 'text-slate-200' ?>">
                        <i class="ti ti-layout-dashboard"></i>
                        <span>Tổng quan TKB</span>
                    </a>
                    <a href="/schedules" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white/10 transition-colors flex items-center space-x-1.5 <?= str_contains($_SERVER['REQUEST_URI'], '/schedules') ? 'bg-white/20 text-white' : 'text-slate-200' ?>">
                        <i class="ti ti-calendar-event"></i>
                        <span>Quản lý Lịch dạy</span>
                    </a>
                    <a href="/schedules/create" class="px-3 py-2 rounded-md text-sm font-medium bg-huit-orange hover:bg-orange-600 text-white transition-colors flex items-center space-x-1.5 shadow-sm">
                        <i class="ti ti-sparkles"></i>
                        <span>Phân lịch thông minh</span>
                    </a>
                    <a href="/teachers" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white/10 transition-colors flex items-center space-x-1.5 <?= str_contains($_SERVER['REQUEST_URI'], '/teachers') ? 'bg-white/20 text-white' : 'text-slate-200' ?>">
                        <i class="ti ti-users"></i>
                        <span>Giảng viên</span>
                    </a>
                    <a href="/branches" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white/10 transition-colors flex items-center space-x-1.5 <?= str_contains($_SERVER['REQUEST_URI'], '/branches') ? 'bg-white/20 text-white' : 'text-slate-200' ?>">
                        <i class="ti ti-building-community"></i>
                        <span>Cơ sở Đào tạo</span>
                    </a>
                </nav>

                <!-- User Profile & Action -->
                <div class="flex items-center space-x-4">
                    <a href="/portal" target="_blank" class="hidden sm:inline-flex items-center space-x-1 text-xs bg-white/10 hover:bg-white/20 text-slate-100 px-2.5 py-1.5 rounded-md border border-white/20 transition">
                        <i class="ti ti-external-link"></i>
                        <span>Xem Cổng Giảng viên</span>
                    </a>
                    <div class="flex items-center space-x-2 text-sm text-slate-200">
                        <div class="w-8 h-8 rounded-full bg-orange-500/30 border border-orange-400/50 flex items-center justify-center font-bold text-orange-200">
                            <i class="ti ti-user-shield text-base"></i>
                        </div>
                        <span class="hidden sm:inline font-medium"><?= htmlspecialchars($user['full_name'] ?? 'Admin Đào tạo') ?></span>
                    </div>
                    <a href="/logout" title="Đăng xuất" class="p-2 rounded-md hover:bg-red-500/20 text-slate-200 hover:text-red-300 transition">
                        <i class="ti ti-logout text-lg"></i>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Flash Notification Messages -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        <?php if (!empty($_SESSION['flash_success'])): ?>
            <div class="p-4 mb-4 text-sm text-emerald-800 rounded-lg bg-emerald-50 border border-emerald-200 flex items-center space-x-2">
                <i class="ti ti-circle-check text-xl text-emerald-600 flex-shrink-0"></i>
                <div><?= $_SESSION['flash_success'] ?></div>
            </div>
            <?php unset($_SESSION['flash_success']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['flash_error'])): ?>
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200 flex items-center space-x-2">
                <i class="ti ti-alert-triangle text-xl text-red-600 flex-shrink-0"></i>
                <div><?= $_SESSION['flash_error'] ?></div>
            </div>
            <?php unset($_SESSION['flash_error']); ?>
        <?php endif; ?>
    </div>

    <!-- Main Content Container -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <?= $content ?>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 mt-12 text-center text-xs text-slate-500">
        <div class="max-w-7xl mx-auto px-4">
            <p class="font-semibold text-slate-700">HUIT Schedule Hub - Trường Đại học Công Thương TP. Hồ Chí Minh</p>
            <p class="mt-1">Hệ thống Quản lý và phân lịch giảng dạy đa cơ sở thông minh &bull; Phiên bản Open Source 1.0 (Giấy phép MIT)</p>
        </div>
    </footer>

</body>
</html>

<?php
use App\Core\Auth;
$user = Auth::user();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Cổng thông tin Giảng viên - HUIT Schedule Hub') ?></title>
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- Top Teacher Portal Bar -->
    <header class="bg-gradient-to-r from-huit-blue to-slate-900 text-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Brand -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-orange-500 to-amber-500 flex items-center justify-center shadow-md">
                        <i class="ti ti-school text-2xl text-white"></i>
                    </div>
                    <div>
                        <div class="flex items-center space-x-2">
                            <span class="text-lg font-bold tracking-tight text-white">HUIT Portal</span>
                            <span class="bg-orange-500/20 text-orange-300 text-[11px] font-semibold px-2 py-0.5 rounded-full border border-orange-400/30">Giảng Viên</span>
                        </div>
                        <span class="text-xs text-slate-300">Tra cứu Thời khóa biểu cá nhân đa cơ sở</span>
                    </div>
                </div>

                <!-- Teacher Info & Actions -->
                <div class="flex items-center space-x-4">
                    <div class="hidden sm:flex flex-col text-right">
                        <span class="text-sm font-semibold text-white"><?= htmlspecialchars($user['full_name'] ?? 'Giảng viên') ?></span>
                        <span class="text-xs text-orange-200"><?= htmlspecialchars($user['expertise'] ?? 'Bộ môn') ?></span>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-orange-600 flex items-center justify-center font-bold text-white shadow">
                        <?= mb_substr($user['full_name'] ?? 'G', 0, 1) ?>
                    </div>
                    <a href="/logout" title="Đăng xuất" class="p-2 rounded-lg hover:bg-white/10 text-slate-300 hover:text-red-400 transition">
                        <i class="ti ti-logout text-lg"></i>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <?= $content ?>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 mt-12 text-center text-xs text-slate-500">
        <p class="font-medium text-slate-700">Trường Đại học Công Thương TP. Hồ Chí Minh (HUIT) - Cổng thông tin Giảng viên</p>
        <p class="mt-1">Địa chỉ chính: 140 Lê Trọng Tấn, P. Tây Thạnh, Q. Tân Phú, TP.HCM</p>
    </footer>

</body>
</html>

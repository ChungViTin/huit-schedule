<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Đăng nhập - Cổng Thông Tin HUIT') ?></title>
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#EFF2F6] text-slate-800 min-h-screen flex flex-col justify-between">

    <!-- Header theo chuẩn Cổng HUIT -->
    <header class="bg-huit-header text-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-3 sm:px-6 lg:px-8 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <!-- HUIT Emblemed Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center p-1 shadow-sm">
                        <svg class="w-10 h-10 text-huit-header" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                            <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center space-x-2">
                            <span class="text-2xl font-black tracking-wider text-white">HUIT</span>
                            <span class="text-[10px] leading-tight text-blue-100 hidden sm:inline-block border-l border-blue-400 pl-2">
                                HO CHI MINH CITY UNIVERSITY OF<br>INDUSTRY AND TRADE
                            </span>
                        </div>
                        <div class="text-xs uppercase tracking-widest text-blue-100 font-medium">
                            BỘ CÔNG THƯƠNG &bull; TRƯỜNG ĐẠI HỌC CÔNG THƯƠNG TP. HỒ CHÍ MINH
                        </div>
                    </div>
                </div>
            </div>

            <div class="hidden md:flex items-center space-x-4 text-xs text-blue-100">
                <span class="flex items-center"><i class="ti ti-phone mr-1"></i> (028) 3816 1673</span>
                <span class="flex items-center"><i class="ti ti-mail mr-1"></i> huit@huit.edu.vn</span>
            </div>
        </div>
    </header>

    <!-- Main Container Layout (2 Cột giống hệt Cổng thông tin HUIT thực tế) -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <?= $content ?>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-4 text-center text-xs text-slate-500 mt-6">
        <div class="max-w-7xl mx-auto px-4">
            <p class="font-semibold text-slate-700">TRƯỜNG ĐẠI HỌC CÔNG THƯƠNG TP. HỒ CHÍ MINH (HUIT)</p>
            <p class="text-slate-500 mt-0.5">Địa chỉ: 140 Lê Trọng Tấn, P. Tây Thạnh, Q. Tân Phú, TP. Hồ Chí Minh &bull; Hệ thống Quản lý và Phân lịch Giảng dạy Đa cơ sở</p>
        </div>
    </footer>

</body>
</html>

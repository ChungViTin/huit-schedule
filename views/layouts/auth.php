<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Đăng nhập - HUIT Schedule Hub') ?></title>
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
<body class="bg-gradient-to-br from-slate-900 via-huit-blue to-slate-900 text-slate-800 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-huit-orange shadow-lg shadow-orange-500/30 mb-3">
                <i class="ti ti-calendar-stats text-3xl text-white"></i>
            </div>
            <h1 class="text-2xl font-bold text-white tracking-tight">HUIT Schedule Hub</h1>
            <p class="text-sm text-slate-300 mt-1">Trường Đại học Công Thương TP. Hồ Chí Minh</p>
        </div>

        <!-- Flash messages -->
        <?php if (!empty($_SESSION['flash_error'])): ?>
            <div class="p-4 mb-4 text-sm text-red-200 rounded-xl bg-red-950/60 border border-red-500/30 flex items-center space-x-2 backdrop-blur-sm">
                <i class="ti ti-alert-triangle text-xl text-red-400 flex-shrink-0"></i>
                <div><?= $_SESSION['flash_error'] ?></div>
            </div>
            <?php unset($_SESSION['flash_error']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['flash_success'])): ?>
            <div class="p-4 mb-4 text-sm text-emerald-200 rounded-xl bg-emerald-950/60 border border-emerald-500/30 flex items-center space-x-2 backdrop-blur-sm">
                <i class="ti ti-circle-check text-xl text-emerald-400 flex-shrink-0"></i>
                <div><?= $_SESSION['flash_success'] ?></div>
            </div>
            <?php unset($_SESSION['flash_success']); ?>
        <?php endif; ?>

        <!-- Card Container -->
        <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl p-8 border border-white/20">
            <?= $content ?>
        </div>

        <p class="text-center text-xs text-slate-400 mt-6">&copy; 2026 HUIT Schedule Hub &bull; Giấy phép MIT</p>
    </div>

</body>
</html>

<?php
$pageTitle = 'Tổng quan Thời khóa biểu - HUIT Schedule Hub';
$dayNames = [
    2 => 'Thứ Hai',
    3 => 'Thứ Ba',
    4 => 'Thứ Tư',
    5 => 'Thứ Năm',
    6 => 'Thứ Sáu',
    7 => 'Thứ Bảy',
    8 => 'Chủ Nhật'
];

$branchColors = [
    1 => ['bg' => 'bg-blue-50', 'border' => 'border-blue-300', 'text' => 'text-blue-900', 'badge' => 'bg-blue-600 text-white'],
    2 => ['bg' => 'bg-emerald-50', 'border' => 'border-emerald-300', 'text' => 'text-emerald-900', 'badge' => 'bg-emerald-600 text-white'],
    3 => ['bg' => 'bg-purple-50', 'border' => 'border-purple-300', 'text' => 'text-purple-900', 'badge' => 'bg-purple-600 text-white'],
    4 => ['bg' => 'bg-amber-50', 'border' => 'border-amber-300', 'text' => 'text-amber-900', 'badge' => 'bg-amber-600 text-white'],
];
?>

<div class="space-y-6">

    <!-- Header & Statistics Cards -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight flex items-center space-x-2">
                <i class="ti ti-layout-dashboard text-huit-blue"></i>
                <span>Trang Tổng Quan & Biểu Đồ Phân Bổ</span>
            </h1>
            <p class="text-sm text-slate-500 mt-0.5">Theo dõi ma trận thời khóa biểu và tối ưu hóa thời gian di chuyển đa cơ sở</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="/schedules/create" class="inline-flex items-center space-x-1.5 px-4 py-2 bg-huit-orange hover:bg-orange-600 text-white font-medium text-sm rounded-xl shadow-sm hover:shadow transition">
                <i class="ti ti-plus"></i>
                <span>Thêm Lịch Dạy Mới</span>
            </a>
            <a href="/schedules" class="inline-flex items-center space-x-1.5 px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium text-sm rounded-xl shadow-sm transition">
                <i class="ti ti-list"></i>
                <span>Xem Bảng CRUD</span>
            </a>
        </div>
    </div>

    <!-- Key Metrics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-huit-blue flex items-center justify-center text-2xl">
                <i class="ti ti-building-community"></i>
            </div>
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Cơ sở Đào tạo</span>
                <p class="text-2xl font-bold text-slate-800"><?= $totalBranches ?></p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl">
                <i class="ti ti-users"></i>
            </div>
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Tổng Giảng viên</span>
                <p class="text-2xl font-bold text-slate-800"><?= $totalTeachers ?></p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl">
                <i class="ti ti-calendar-event"></i>
            </div>
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Tổng Ca Lịch Dạy</span>
                <p class="text-2xl font-bold text-slate-800"><?= $totalSchedules ?></p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl">
                <i class="ti ti-route"></i>
            </div>
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Tối ưu Di chuyển</span>
                <p class="text-base font-bold text-emerald-600 flex items-center">
                    <i class="ti ti-shield-check mr-1 text-lg"></i> Đang kích hoạt
                </p>
            </div>
        </div>
    </div>

    <!-- Quick Filters & Analytics Card -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-100 pb-4">
            <div>
                <h2 class="text-base font-bold text-slate-800 flex items-center space-x-2">
                    <i class="ti ti-filter text-huit-orange"></i>
                    <span>Bộ Lọc Nhanh Phân Bổ Thời Gian</span>
                </h2>
                <p class="text-xs text-slate-500">Lọc theo Cơ sở hoặc Giảng viên để theo dõi biểu đồ ma trận TKB</p>
            </div>

            <!-- Filter Form -->
            <form method="GET" action="/dashboard" class="flex flex-wrap items-center gap-2">
                <!-- Filter by Branch -->
                <div class="min-w-[180px]">
                    <select name="branch_id" onchange="this.form.submit()" class="w-full text-xs font-medium bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-700 focus:outline-none focus:ring-2 focus:ring-huit-blue">
                        <option value="">-- Tất cả cơ sở --</option>
                        <?php foreach ($branches as $b): ?>
                            <option value="<?= $b['id'] ?>" <?= $selectedBranchId === (int)$b['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($b['branch_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Filter by Teacher -->
                <div class="min-w-[200px]">
                    <select name="teacher_id" onchange="this.form.submit()" class="w-full text-xs font-medium bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-700 focus:outline-none focus:ring-2 focus:ring-huit-blue">
                        <option value="">-- Tất cả giảng viên --</option>
                        <?php foreach ($teachers as $t): ?>
                            <option value="<?= $t['id'] ?>" <?= $selectedTeacherId === (int)$t['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($t['full_name']) ?> (<?= htmlspecialchars($t['expertise']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <?php if ($selectedBranchId || $selectedTeacherId): ?>
                    <a href="/dashboard" class="px-3 py-2 text-xs bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl transition flex items-center space-x-1">
                        <i class="ti ti-x"></i>
                        <span>Xóa lọc</span>
                    </a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Distribution Progress Bars -->
        <div>
            <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Biểu đồ tỷ lệ phân bổ lịch dạy theo cơ sở:</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                <?php foreach ($branchDistribution as $idx => $dist): 
                    $percent = $totalSchedules > 0 ? round(($dist['count'] / $totalSchedules) * 100) : 0;
                ?>
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                        <div class="flex justify-between items-center text-xs mb-1">
                            <span class="font-semibold text-slate-700 truncate" title="<?= htmlspecialchars($dist['name']) ?>">
                                <?= htmlspecialchars($dist['name']) ?>
                            </span>
                            <span class="font-bold text-huit-blue"><?= $dist['count'] ?> ca (<?= $percent ?>%)</span>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                            <div class="bg-huit-blue h-2 rounded-full transition-all duration-500" style="width: <?= $percent ?>%"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Interactive Timetable Grid (Matrix) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <h2 class="text-lg font-bold text-slate-800 flex items-center space-x-2">
                    <i class="ti ti-table text-huit-blue"></i>
                    <span>Ma Trận Thời Khóa Biểu Tuần</span>
                </h2>
                <p class="text-xs text-slate-500">Hiển thị các ca học từ Thứ 2 đến Chủ nhật</p>
            </div>
            <!-- Legend -->
            <div class="flex flex-wrap items-center gap-2 text-xs">
                <span class="text-slate-400">Ghi chú cơ sở:</span>
                <?php foreach ($branches as $idx => $b): 
                    $color = $branchColors[($idx % 4) + 1];
                ?>
                    <span class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-md border <?= $color['border'] ?> <?= $color['bg'] ?> <?= $color['text'] ?>">
                        <span class="w-2 h-2 rounded-full <?= $color['badge'] ?>"></span>
                        <span class="font-medium truncate max-w-[120px]"><?= htmlspecialchars($b['branch_name']) ?></span>
                    </span>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse min-w-[950px] text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600">
                        <th class="p-3 text-left w-36 font-semibold border-r border-slate-200">Ca Học / Tiết</th>
                        <?php for ($day = 2; $day <= 8; $day++): ?>
                            <th class="p-3 text-center font-bold border-r border-slate-200 <?= $day === 8 ? 'text-red-600' : 'text-slate-700' ?>">
                                <?= $dayNames[$day] ?>
                            </th>
                        <?php endfor; ?>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <?php foreach ($shifts as $shift): 
                        $shiftInfo = $shiftDetails[$shift] ?? null;
                    ?>
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-3 bg-slate-50/70 border-r border-slate-200 align-top">
                                <div class="font-bold text-slate-800"><?= htmlspecialchars($shift) ?></div>
                                <?php if ($shiftInfo): ?>
                                    <div class="text-[11px] text-slate-500 font-medium flex items-center mt-1">
                                        <i class="ti ti-clock mr-1 text-slate-400"></i>
                                        <?= $shiftInfo['time'] ?>
                                    </div>
                                <?php endif; ?>
                            </td>

                            <?php for ($day = 2; $day <= 8; $day++): 
                                $cellSchedules = $timetableGrid[$day][$shift] ?? [];
                            ?>
                                <td class="p-2 border-r border-slate-200 align-top min-w-[140px] h-28 <?= empty($cellSchedules) ? 'bg-slate-50/20' : 'bg-white' ?>">
                                    <?php if (empty($cellSchedules)): ?>
                                        <div class="h-full flex items-center justify-center text-slate-300 italic text-[11px]">
                                            (Trống)
                                        </div>
                                    <?php else: ?>
                                        <div class="space-y-1.5">
                                            <?php foreach ($cellSchedules as $sch): 
                                                $branchId = (int)$sch['branch_id'];
                                                $color = $branchColors[(($branchId - 1) % 4) + 1] ?? $branchColors[1];
                                            ?>
                                                <div class="p-2 rounded-lg border <?= $color['border'] ?> <?= $color['bg'] ?> <?= $color['text'] ?> shadow-xs hover:shadow transition group relative">
                                                    <div class="font-bold text-[11px] leading-tight truncate" title="<?= htmlspecialchars($sch['subject_name']) ?>">
                                                        <?= htmlspecialchars($sch['subject_name']) ?>
                                                    </div>
                                                    <div class="flex items-center text-[10px] text-slate-600 mt-1">
                                                        <i class="ti ti-user mr-1 text-slate-400"></i>
                                                        <span class="truncate"><?= htmlspecialchars($sch['teacher_name']) ?></span>
                                                    </div>
                                                    <div class="flex items-center justify-between text-[10px] font-medium mt-1">
                                                        <span class="bg-white/80 px-1 py-0.5 rounded border border-slate-200 text-slate-700">
                                                            P. <?= htmlspecialchars($sch['room']) ?>
                                                        </span>
                                                        <span class="text-[9px] px-1 py-0.5 rounded <?= $color['badge'] ?> truncate max-w-[80px]" title="<?= htmlspecialchars($sch['branch_name']) ?>">
                                                            <?= htmlspecialchars($sch['branch_name']) ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            <?php endfor; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

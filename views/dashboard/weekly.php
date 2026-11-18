<?php
$pageTitle = 'Lịch học, lịch thi theo tuần - HUIT Schedule Hub';

$dayNames = [
    2 => ['name' => 'Thứ 2', 'date' => '16/11/2026'],
    3 => ['name' => 'Thứ 3', 'date' => '17/11/2026'],
    4 => ['name' => 'Thứ 4', 'date' => '18/11/2026'],
    5 => ['name' => 'Thứ 5', 'date' => '19/11/2026'],
    6 => ['name' => 'Thứ 6', 'date' => '20/11/2026'],
    7 => ['name' => 'Thứ 7', 'date' => '21/11/2026'],
    8 => ['name' => 'Chủ nhật', 'date' => '22/11/2026']
];

$sessions = [
    'Sáng' => [
        'Ca 1: Sáng (Tiết 1-3)',
        'Ca 2: Sáng (Tiết 4-6)'
    ],
    'Chiều' => [
        'Ca 3: Chiều (Tiết 7-9)',
        'Ca 4: Chiều (Tiết 10-12)'
    ],
    'Tối' => [
        'Ca 5: Tối (Tiết 13-15)'
    ]
];
?>

<div class="space-y-5">

    <!-- Thanh Toolbar Bộ lọc & Điều hướng chuẩn Ảnh 3 -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4">
        
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            
            <!-- Tiêu đề + Radio filter (Ảnh 3) -->
            <div class="flex flex-wrap items-center gap-4">
                <h1 class="text-base font-bold text-slate-800 tracking-tight flex items-center space-x-2">
                    <i class="ti ti-calendar-event text-huit-header"></i>
                    <span>Lịch học, lịch thi theo tuần</span>
                </h1>

                <!-- Radio buttons -->
                <div class="flex items-center space-x-3 text-xs text-slate-600 font-medium">
                    <label class="flex items-center space-x-1 cursor-pointer">
                        <input type="radio" name="schedule_type" checked class="text-huit-header focus:ring-huit-header">
                        <span>Tất cả</span>
                    </label>
                    <label class="flex items-center space-x-1 cursor-pointer">
                        <input type="radio" name="schedule_type" class="text-huit-header focus:ring-huit-header">
                        <span>Lịch học</span>
                    </label>
                    <label class="flex items-center space-x-1 cursor-pointer">
                        <input type="radio" name="schedule_type" class="text-huit-header focus:ring-huit-header">
                        <span>Lịch thi</span>
                    </label>
                </div>
            </div>

            <!-- Các nút điều hướng tuần (Ảnh 3) -->
            <div class="flex flex-wrap items-center gap-2 text-xs">
                
                <div class="relative">
                    <input type="text" value="18/11/2026" readonly class="w-24 text-center py-1.5 px-2 bg-slate-50 border border-slate-300 rounded-lg font-medium text-slate-700">
                </div>

                <button type="button" class="px-3 py-1.5 bg-sky-600 hover:bg-sky-700 text-white font-medium rounded-lg shadow-xs flex items-center space-x-1 transition">
                    <i class="ti ti-calendar"></i>
                    <span>Hiện tại</span>
                </button>

                <button type="button" onclick="window.print()" class="px-3 py-1.5 bg-sky-600 hover:bg-sky-700 text-white font-medium rounded-lg shadow-xs flex items-center space-x-1 transition">
                    <i class="ti ti-printer"></i>
                    <span>In lịch</span>
                </button>

                <div class="inline-flex rounded-lg shadow-xs">
                    <button type="button" class="px-2.5 py-1.5 bg-sky-600 hover:bg-sky-700 text-white font-medium rounded-l-lg border-r border-sky-500 transition">
                        &lt; Trở về
                    </button>
                    <button type="button" class="px-2.5 py-1.5 bg-sky-600 hover:bg-sky-700 text-white font-medium rounded-r-lg transition">
                        Tiếp &gt;
                    </button>
                </div>

                <a href="/schedules/create" class="px-3 py-1.5 bg-huit-orange hover:bg-huit-orangeHover text-white font-bold rounded-lg shadow-xs transition flex items-center space-x-1">
                    <i class="ti ti-plus"></i>
                    <span>Phân lịch mới</span>
                </a>
            </div>

        </div>

        <!-- Bộ Lọc Nhanh Cơ Sở & Giảng Viên (Đề Bài) -->
        <div class="mt-4 pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3 text-xs">
            <form method="GET" action="/timetable" class="flex flex-wrap items-center gap-2">
                <span class="font-bold text-slate-600"><i class="ti ti-filter mr-1 text-huit-header"></i>Lọc thời khóa biểu:</span>
                
                <select name="branch_id" onchange="this.form.submit()" class="py-1 px-3 bg-slate-50 border border-slate-200 rounded-lg text-slate-700 focus:ring-1 focus:ring-huit-header font-medium">
                    <option value="">-- Tất cả cơ sở đào tạo --</option>
                    <?php foreach ($branches as $b): ?>
                        <option value="<?= $b['id'] ?>" <?= $selectedBranchId === (int)$b['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($b['branch_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <select name="teacher_id" onchange="this.form.submit()" class="py-1 px-3 bg-slate-50 border border-slate-200 rounded-lg text-slate-700 focus:ring-1 focus:ring-huit-header font-medium">
                    <option value="">-- Tất cả giảng viên --</option>
                    <?php foreach ($teachers as $t): ?>
                        <option value="<?= $t['id'] ?>" <?= $selectedTeacherId === (int)$t['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($t['full_name']) ?> (<?= htmlspecialchars($t['expertise']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>

                <?php if ($selectedBranchId || $selectedTeacherId): ?>
                    <a href="/timetable" class="px-2 py-1 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition">
                        <i class="ti ti-x"></i> Bỏ lọc
                    </a>
                <?php endif; ?>
            </form>

            <div class="text-slate-500">
                Hiển thị: <strong class="text-huit-header"><?= $totalSchedules ?></strong> ca lịch
            </div>
        </div>

    </div>

    <!-- MA TRẬN THỜI KHÓA BIỂU TUẦN CHUẨN THEO ẢNH 3 -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse min-w-[1050px] text-xs">
                <thead>
                    <tr class="bg-blue-50/70 border-b border-slate-200 text-slate-700">
                        <th class="p-3 text-center w-24 font-bold border-r border-slate-200 text-sky-800">
                            Ca học
                        </th>
                        <?php for ($day = 2; $day <= 8; $day++): ?>
                            <th class="p-2.5 text-center font-bold border-r border-slate-200 w-40 <?= $day === 8 ? 'text-red-600' : 'text-sky-900' ?>">
                                <div><?= $dayNames[$day]['name'] ?></div>
                                <div class="text-[11px] font-normal text-slate-500 mt-0.5"><?= $dayNames[$day]['date'] ?></div>
                            </th>
                        <?php endfor; ?>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    
                    <?php foreach ($sessions as $sessionName => $sessionShifts): ?>
                        <tr>
                            <!-- Cột Ca Học: Sáng / Chiều / Tối (Ảnh 3) -->
                            <td class="p-4 bg-slate-50/90 border-r border-slate-200 text-center font-bold text-slate-800 align-middle">
                                <div class="text-sm font-extrabold text-slate-700"><?= $sessionName ?></div>
                            </td>

                            <!-- Các ô Thứ 2 -> Chủ Nhật -->
                            <?php for ($day = 2; $day <= 8; $day++): 
                                $sessionSchedules = [];
                                foreach ($sessionShifts as $sh) {
                                    if (!empty($timetableGrid[$day][$sh])) {
                                        foreach ($timetableGrid[$day][$sh] as $item) {
                                            $sessionSchedules[] = $item;
                                        }
                                    }
                                }
                            ?>
                                <td class="p-2 border-r border-slate-200 align-top min-w-[145px] h-36 bg-white hover:bg-slate-50/30 transition">
                                    
                                    <?php if (empty($sessionSchedules)): ?>
                                        <div class="h-full flex items-center justify-center text-slate-200 text-[11px] select-none">
                                            &bull;
                                        </div>
                                    <?php else: ?>
                                        <div class="space-y-2">
                                            <?php foreach ($sessionSchedules as $sch): 
                                                $isPractice = stripos($sch['subject_name'], 'thực hành') !== false 
                                                           || stripos($sch['subject_name'], 'lab') !== false
                                                           || stripos($sch['subject_name'], 'web') !== false
                                                           || stripos($sch['subject_name'], 'vi sinh') !== false;

                                                if ($isPractice) {
                                                    // Khối xanh lá HUIT (chuẩn Ảnh 3)
                                                    $cardBg = 'bg-[#66BB6A] text-white shadow-xs';
                                                    $subText = 'text-green-50';
                                                } else {
                                                    // Khối lý thuyết pastel (chuẩn Ảnh 3)
                                                    $cardBg = 'bg-[#EBF3FA] text-slate-800 border border-blue-200 shadow-xs';
                                                    $subText = 'text-slate-600';
                                                }
                                            ?>
                                                <div class="p-2.5 rounded-lg <?= $cardBg ?> transition group relative leading-tight">
                                                    
                                                    <!-- Tên môn học -->
                                                    <div class="font-bold text-xs line-clamp-2">
                                                        <?= htmlspecialchars($sch['subject_name']) ?>
                                                    </div>

                                                    <!-- Mã lớp & Tiết học -->
                                                    <div class="text-[10px] <?= $subText ?> mt-1 font-mono">
                                                        <?= htmlspecialchars($sch['shift_or_periods']) ?>
                                                    </div>

                                                    <!-- Phòng & Cơ sở -->
                                                    <div class="text-[10px] <?= $subText ?> mt-1 font-medium">
                                                        Phòng: <span class="font-bold"><?= htmlspecialchars($sch['room']) ?></span>
                                                    </div>

                                                    <div class="text-[9px] <?= $subText ?> truncate mt-0.5" title="<?= htmlspecialchars($sch['branch_name']) ?> - <?= htmlspecialchars($sch['branch_address']) ?>">
                                                        <?= htmlspecialchars($sch['branch_name']) ?>
                                                    </div>

                                                    <!-- Tên Giảng Viên -->
                                                    <div class="text-[10px] <?= $subText ?> font-semibold mt-1 pt-1 border-t border-white/20">
                                                        GV: <?= htmlspecialchars($sch['teacher_name']) ?>
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

        <!-- Chú thích màu sắc (Legend bar dưới chân bảng như trong Ảnh 3) -->
        <div class="p-3 bg-slate-50 border-t border-slate-200 flex flex-wrap items-center gap-x-6 gap-y-2 text-xs text-slate-600">
            <div class="flex items-center space-x-1.5">
                <span class="w-4 h-3 rounded bg-[#EBF3FA] border border-blue-200 inline-block"></span>
                <span>Lịch học lý thuyết</span>
            </div>
            <div class="flex items-center space-x-1.5">
                <span class="w-4 h-3 rounded bg-[#66BB6A] inline-block"></span>
                <span>Lịch học thực hành</span>
            </div>
            <div class="flex items-center space-x-1.5">
                <span class="w-4 h-3 rounded bg-[#81D4FA] inline-block"></span>
                <span>Lịch học trực tuyến</span>
            </div>
            <div class="flex items-center space-x-1.5">
                <span class="w-4 h-3 rounded bg-[#FFF59D] inline-block"></span>
                <span>Lịch thi</span>
            </div>
            <div class="flex items-center space-x-1.5">
                <span class="w-4 h-3 rounded bg-[#EF5350] inline-block"></span>
                <span>Lịch tạm ngưng</span>
            </div>
        </div>

    </div>

</div>

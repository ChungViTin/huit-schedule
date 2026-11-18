<?php
$pageTitle = 'Thời Khóa Biểu Giảng Dạy - Cổng Giảng Viên HUIT';

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
        'session_code' => 'morning',
        'shifts' => [
            'Sáng - Thực hành (Tiết 1-5)',
            'Sáng - Lý thuyết (Tiết 1-3)',
            'Sáng - Lý thuyết (Tiết 4-6)',
            'Ca 1: Sáng (Tiết 1-3)',
            'Ca 2: Sáng (Tiết 4-6)'
        ]
    ],
    'Chiều' => [
        'session_code' => 'afternoon',
        'shifts' => [
            'Chiều - Thực hành (Tiết 7-11)',
            'Chiều - Lý thuyết (Tiết 7-9)',
            'Chiều - Lý thuyết (Tiết 10-12)',
            'Ca 3: Chiều (Tiết 7-9)',
            'Ca 4: Chiều (Tiết 10-12)'
        ]
    ],
    'Tối' => [
        'session_code' => 'evening',
        'shifts' => [
            'Tối - Thực hành (Tiết 11-15)',
            'Tối - Lý thuyết (Tiết 13-15)',
            'Ca 5: Tối (Tiết 13-15)'
        ]
    ]
];
?>

<div class="space-y-5">

    <!-- Profile & Header Box -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="w-14 h-14 rounded-2xl bg-huit-header text-white flex items-center justify-center font-bold text-xl shadow-xs">
                    <?= mb_substr($teacher['full_name'], 0, 1) ?>
                </div>
                <div>
                    <div class="flex items-center space-x-2">
                        <h1 class="text-lg font-bold text-slate-800"><?= htmlspecialchars($teacher['full_name']) ?></h1>
                        <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-full border border-emerald-200">Giảng Viên HUIT</span>
                    </div>
                    <p class="text-xs text-slate-500 mt-1 flex flex-wrap items-center gap-x-4 gap-y-1">
                        <span><i class="ti ti-briefcase mr-1 text-slate-400"></i><?= htmlspecialchars($teacher['expertise']) ?></span>
                        <span><i class="ti ti-mail mr-1 text-slate-400"></i><?= htmlspecialchars($teacher['email']) ?></span>
                        <span><i class="ti ti-phone mr-1 text-slate-400"></i><?= htmlspecialchars($teacher['phone']) ?></span>
                    </p>
                </div>
            </div>

            <!-- Toolbar buttons -->
            <div class="flex items-center space-x-2 text-xs">
                <button type="button" onclick="window.print()" class="px-3 py-1.5 bg-sky-600 hover:bg-sky-700 text-white font-medium rounded-lg shadow-xs flex items-center space-x-1 transition">
                    <i class="ti ti-printer"></i>
                    <span>In lịch tuần</span>
                </button>
                <div class="inline-flex p-1 bg-slate-100 rounded-lg">
                    <a href="/portal?view=week" class="px-2.5 py-1 text-xs font-semibold rounded-md transition <?= $viewMode === 'week' ? 'bg-white text-huit-header shadow-xs' : 'text-slate-600' ?>">
                        Xem theo tuần
                    </a>
                    <a href="/portal?view=list" class="px-2.5 py-1 text-xs font-semibold rounded-md transition <?= $viewMode === 'list' ? 'bg-white text-huit-header shadow-xs' : 'text-slate-600' ?>">
                        Xem danh sách
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Cảnh báo di chuyển đa cơ sở nếu có trong tuần -->
    <?php if (!empty($travelAlertsByDay)): ?>
        <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-xs space-y-1.5">
            <div class="font-bold flex items-center text-amber-800 text-sm">
                <i class="ti ti-car text-xl mr-2 text-amber-600"></i>
                LƯU Ý DI CHUYỂN GIỮA CÁC CƠ SỞ TRONG NGÀY:
            </div>
            <ul class="list-disc pl-5 space-y-1">
                <?php foreach ($travelAlertsByDay as $dayNum => $alertText): ?>
                    <li><strong><?= $dayNames[$dayNum]['name'] ?>:</strong> <?= htmlspecialchars($alertText) ?>. Thầy/Cô vui lòng sắp xếp thời gian di chuyển an toàn giữa các tiết dạy.</li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($viewMode === 'week'): ?>
        <!-- MA TRẬN THỜI KHÓA BIỂU TUẦN CỦA GIẢNG VIÊN (CHUẨN ẢNH 3) -->
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
                        <?php foreach ($sessions as $sessionName => $sessionData): 
                            $sessionShifts = $sessionData['shifts'];
                            $sessionCode = $sessionData['session_code'];
                        ?>
                            <tr>
                                <td class="p-4 bg-slate-50/90 border-r border-slate-200 text-center font-bold text-slate-800 align-middle">
                                    <div class="text-sm font-extrabold text-slate-700"><?= $sessionName ?></div>
                                </td>

                                <?php for ($day = 2; $day <= 8; $day++): 
                                    $sessionSchedules = [];
                                    foreach ($sessionShifts as $sh) {
                                        if (!empty($timetableGrid[$day][$sh])) {
                                            $sessionSchedules[$timetableGrid[$day][$sh]['id']] = $timetableGrid[$day][$sh];
                                        }
                                    }
                                    // Fallback
                                    if (isset($schedules)) {
                                        foreach ($schedules as $s) {
                                            if ((int)$s['day_of_week'] === $day) {
                                                if (($s['session_time'] ?? '') === $sessionCode || stripos($s['shift_or_periods'], $sessionName) !== false) {
                                                    $sessionSchedules[$s['id']] = $s;
                                                }
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
                                                    $isPractice = ($sch['class_type'] ?? '') === 'practice'
                                                               || stripos($sch['subject_name'], 'thực hành') !== false 
                                                               || stripos($sch['shift_or_periods'], 'thực hành') !== false;

                                                    if ($isPractice) {
                                                        // Xanh lá nổi bật chuẩn Ảnh 3
                                                        $cardBg = 'bg-[#5cb85c] text-slate-900 border border-[#4cae4c] shadow-xs';
                                                        $subText = 'text-slate-900';
                                                        $borderDivider = 'border-slate-800/20';
                                                    } else {
                                                        // Xám nhạt thanh lịch chuẩn Ảnh 3
                                                        $cardBg = 'bg-[#edf2f7] text-slate-800 border border-slate-300 shadow-xs';
                                                        $subText = 'text-slate-600';
                                                        $borderDivider = 'border-slate-300';
                                                    }
                                                ?>
                                                    <div class="p-2.5 rounded-lg <?= $cardBg ?> transition leading-tight">
                                                        <div class="font-bold text-xs line-clamp-2">
                                                            <?= htmlspecialchars($sch['subject_name']) ?>
                                                        </div>

                                                        <div class="text-[10px] <?= $subText ?> mt-0.5 font-medium">
                                                            <?= sprintf('14DHTH%02d - 01011019%04d', ((int)$teacher['id'] % 12) + 1, ((int)$sch['id'] * 137 + 7000)) ?>
                                                        </div>

                                                        <div class="text-[10px] <?= $subText ?> mt-0.5 font-semibold">
                                                            Tiết: <?= htmlspecialchars($sch['period_start'] ?? 1) ?> - <?= htmlspecialchars($sch['period_end'] ?? 3) ?>
                                                        </div>

                                                        <div class="text-[10px] <?= $subText ?> mt-0.5 font-medium">
                                                            Phòng: <span class="font-bold"><?= htmlspecialchars($sch['room']) ?></span> - <?= htmlspecialchars($sch['branch_name']) ?>
                                                        </div>

                                                        <div class="text-[9px] <?= $subText ?> truncate mt-0.5" title="<?= htmlspecialchars($sch['branch_address']) ?>">
                                                            <?= htmlspecialchars($sch['branch_address']) ?>
                                                        </div>

                                                        <div class="text-[10px] <?= $subText ?> font-bold mt-1 pt-1 border-t <?= $borderDivider ?>">
                                                            GV: <?= htmlspecialchars($teacher['full_name']) ?>
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

            <!-- Chú thích màu sắc (Legend bar dưới chân bảng chuẩn Ảnh 3) -->
            <div class="p-3 bg-slate-50 border-t border-slate-200 flex flex-wrap items-center gap-x-6 gap-y-2 text-xs text-slate-600">
                <div class="flex items-center space-x-1.5">
                    <span class="w-4 h-3 rounded bg-[#edf2f7] border border-slate-300 inline-block"></span>
                    <span class="font-medium">Lịch học lý thuyết (3 tiết)</span>
                </div>
                <div class="flex items-center space-x-1.5">
                    <span class="w-4 h-3 rounded bg-[#5cb85c] border border-[#4cae4c] inline-block"></span>
                    <span class="font-medium">Lịch học thực hành (5 tiết)</span>
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

    <?php else: ?>
        <!-- VIEW DANH SÁCH -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase tracking-wider text-[11px]">
                            <th class="p-3.5">Học Phần</th>
                            <th class="p-3.5">Loại Hình</th>
                            <th class="p-3.5">Cơ Sở & Địa Chỉ</th>
                            <th class="p-3.5 text-center">Phòng</th>
                            <th class="p-3.5">Thời Gian</th>
                            <th class="p-3.5">Ghi Chú</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if (empty($schedules)): ?>
                            <tr>
                                <td colspan="6" class="p-8 text-center text-slate-400">
                                    Thầy/Cô chưa có lịch giảng dạy nào trong học kỳ này.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($schedules as $s): 
                                $isPractice = ($s['class_type'] ?? '') === 'practice'
                                           || stripos($s['subject_name'], 'thực hành') !== false;
                            ?>
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="p-3.5 font-bold text-slate-800">
                                        <?= htmlspecialchars($s['subject_name']) ?>
                                    </td>
                                    <td class="p-3.5">
                                        <?php if ($isPractice): ?>
                                            <span class="px-2 py-0.5 bg-[#5cb85c]/20 text-[#14532d] font-bold rounded-md text-[10px] border border-[#5cb85c]/40">
                                                Thực hành (5 tiết)
                                            </span>
                                        <?php else: ?>
                                            <span class="px-2 py-0.5 bg-blue-50 text-blue-700 font-bold rounded-md text-[10px] border border-blue-200">
                                                Lý thuyết (3 tiết)
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="p-3.5">
                                        <div class="font-semibold text-slate-700"><?= htmlspecialchars($s['branch_name']) ?></div>
                                        <div class="text-[11px] text-slate-400"><?= htmlspecialchars($s['branch_address']) ?></div>
                                    </td>
                                    <td class="p-3.5 text-center font-bold text-huit-header font-mono">
                                        <?= htmlspecialchars($s['room']) ?>
                                    </td>
                                    <td class="p-3.5">
                                        <span class="font-bold text-slate-800"><?= $dayNames[$s['day_of_week']]['name'] ?></span>
                                        <span class="text-slate-500 block text-[11px] mt-0.5"><?= htmlspecialchars($s['shift_or_periods']) ?></span>
                                    </td>
                                    <td class="p-3.5 text-slate-500 italic">
                                        <?= htmlspecialchars($s['notes'] ?? 'Không có') ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

</div>

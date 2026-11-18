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
                        <?php foreach ($sessions as $sessionName => $sessionShifts): ?>
                            <tr>
                                <td class="p-4 bg-slate-50/90 border-r border-slate-200 text-center font-bold text-slate-800 align-middle">
                                    <div class="text-sm font-extrabold text-slate-700"><?= $sessionName ?></div>
                                </td>

                                <?php for ($day = 2; $day <= 8; $day++): 
                                    $sessionSchedules = [];
                                    foreach ($sessionShifts as $sh) {
                                        if (!empty($timetableGrid[$day][$sh])) {
                                            $sessionSchedules[] = $timetableGrid[$day][$sh];
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
                                                               || stripos($sch['subject_name'], 'web') !== false;

                                                    if ($isPractice) {
                                                        $cardBg = 'bg-[#66BB6A] text-white shadow-xs';
                                                        $subText = 'text-green-50';
                                                    } else {
                                                        $cardBg = 'bg-[#EBF3FA] text-slate-800 border border-blue-200 shadow-xs';
                                                        $subText = 'text-slate-600';
                                                    }
                                                ?>
                                                    <div class="p-2.5 rounded-lg <?= $cardBg ?> transition group relative leading-tight">
                                                        <div class="font-bold text-xs line-clamp-2">
                                                            <?= htmlspecialchars($sch['subject_name']) ?>
                                                        </div>
                                                        <div class="text-[10px] <?= $subText ?> mt-1 font-mono">
                                                            <?= htmlspecialchars($sch['shift_or_periods']) ?>
                                                        </div>
                                                        <div class="text-[10px] <?= $subText ?> mt-1 font-medium">
                                                            Phòng: <span class="font-bold"><?= htmlspecialchars($sch['room']) ?></span>
                                                        </div>
                                                        <div class="text-[9px] <?= $subText ?> truncate mt-0.5" title="<?= htmlspecialchars($sch['branch_name']) ?> - <?= htmlspecialchars($sch['branch_address']) ?>">
                                                            <?= htmlspecialchars($sch['branch_name']) ?>
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

            <!-- Legend -->
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

    <?php else: ?>
        <!-- List View -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-sm font-bold text-slate-800 border-b border-slate-100 pb-3 mb-4 flex items-center space-x-2">
                <i class="ti ti-list text-huit-header"></i>
                <span>Danh Sách Lịch Dạy Chi Tiết</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php foreach ($schedules as $s): ?>
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white hover:border-huit-header hover:shadow-sm transition">
                        <div class="flex items-start justify-between">
                            <span class="font-bold text-sm text-slate-800"><?= htmlspecialchars($s['subject_name']) ?></span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-huit-header text-white">
                                <?= $dayNames[$s['day_of_week']]['name'] ?? 'Thứ ' . $s['day_of_week'] ?>
                            </span>
                        </div>
                        <div class="mt-2.5 text-xs text-slate-600 space-y-1">
                            <p><i class="ti ti-clock mr-1 text-slate-400"></i> Ca dạy: <strong class="text-orange-600"><?= htmlspecialchars($s['shift_or_periods']) ?></strong></p>
                            <p><i class="ti ti-door mr-1 text-slate-400"></i> Phòng: <strong><?= htmlspecialchars($s['room']) ?></strong></p>
                            <p><i class="ti ti-map-pin mr-1 text-slate-400"></i> Cơ sở: <strong><?= htmlspecialchars($s['branch_name']) ?></strong> (<?= htmlspecialchars($s['branch_address']) ?>)</p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

</div>

<?php
$pageTitle = 'Thời Khóa Biểu Giảng Dạy - Cổng Giảng Viên HUIT';
$dayNames = [
    2 => 'Thứ Hai',
    3 => 'Thứ Ba',
    4 => 'Thứ Tư',
    5 => 'Thứ Năm',
    6 => 'Thứ Sáu',
    7 => 'Thứ Bảy',
    8 => 'Chủ Nhật'
];
?>

<div class="space-y-6">

    <!-- Profile & Summary Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-huit-blue to-blue-700 text-white flex items-center justify-center font-bold text-2xl shadow-md">
                    <?= mb_substr($teacher['full_name'], 0, 1) ?>
                </div>
                <div>
                    <div class="flex items-center space-x-2">
                        <h1 class="text-xl font-bold text-slate-800"><?= htmlspecialchars($teacher['full_name']) ?></h1>
                        <span class="bg-emerald-100 text-emerald-800 text-[11px] font-bold px-2 py-0.5 rounded-full border border-emerald-200">Đang công tác</span>
                    </div>
                    <p class="text-xs text-slate-500 mt-1 flex flex-wrap items-center gap-x-4 gap-y-1">
                        <span><i class="ti ti-briefcase mr-1 text-slate-400"></i><?= htmlspecialchars($teacher['expertise']) ?></span>
                        <span><i class="ti ti-mail mr-1 text-slate-400"></i><?= htmlspecialchars($teacher['email']) ?></span>
                        <span><i class="ti ti-phone mr-1 text-slate-400"></i><?= htmlspecialchars($teacher['phone']) ?></span>
                    </p>
                </div>
            </div>

            <!-- View switchers -->
            <div class="flex items-center space-x-2">
                <div class="inline-flex p-1 bg-slate-100 rounded-xl">
                    <a href="/portal?view=week" class="px-3 py-1.5 text-xs font-semibold rounded-lg transition <?= $viewMode === 'week' ? 'bg-white text-huit-blue shadow-sm' : 'text-slate-600 hover:text-slate-900' ?>">
                        <i class="ti ti-calendar mr-1"></i> Xem Theo Tuần
                    </a>
                    <a href="/portal?view=list" class="px-3 py-1.5 text-xs font-semibold rounded-lg transition <?= $viewMode === 'list' ? 'bg-white text-huit-blue shadow-sm' : 'text-slate-600 hover:text-slate-900' ?>">
                        <i class="ti ti-list mr-1"></i> Xem Theo Lịch Trình
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Travel Warnings Alert Banner if any -->
    <?php if (!empty($travelAlertsByDay)): ?>
        <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-xs space-y-2">
            <div class="font-bold flex items-center text-amber-800 text-sm">
                <i class="ti ti-car text-xl mr-2 text-amber-600"></i>
                LƯU Ý DI CHUYỂN ĐA CƠ SỞ TRONG TUẦN:
            </div>
            <ul class="list-disc pl-5 space-y-1">
                <?php foreach ($travelAlertsByDay as $dayNum => $alertText): ?>
                    <li><strong><?= $dayNames[$dayNum] ?>:</strong> <?= htmlspecialchars($alertText) ?>. Thầy/Cô vui lòng sắp xếp thời gian di chuyển an toàn giữa các tiết dạy.</li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($viewMode === 'week'): ?>
        <!-- TIMETABLE WEEKLY MATRIX VIEW -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-slate-800 flex items-center space-x-2">
                        <i class="ti ti-layout-grid text-huit-blue"></i>
                        <span>Thời Khóa Biểu Giảng Dạy Tuần</span>
                    </h2>
                    <p class="text-xs text-slate-500">Nắm bắt chính xác phòng học và cơ sở cần đến dạy</p>
                </div>
                <div class="text-xs text-slate-500">
                    Tổng số: <strong class="text-huit-blue"><?= count($schedules) ?></strong> ca dạy / tuần
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse min-w-[900px] text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-600">
                            <th class="p-3 text-left w-36 font-semibold border-r border-slate-200">Ca Học</th>
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
                                <td class="p-3 bg-slate-50/80 border-r border-slate-200 align-top">
                                    <div class="font-bold text-slate-800"><?= htmlspecialchars($shift) ?></div>
                                    <?php if ($shiftInfo): ?>
                                        <div class="text-[11px] text-slate-500 font-medium flex items-center mt-1">
                                            <i class="ti ti-clock mr-1 text-slate-400"></i>
                                            <?= $shiftInfo['time'] ?>
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <?php for ($day = 2; $day <= 8; $day++): 
                                    $sch = $timetableGrid[$day][$shift] ?? null;
                                ?>
                                    <td class="p-2.5 border-r border-slate-200 align-top min-w-[130px] h-28 <?= $sch ? 'bg-blue-50/40' : 'bg-slate-50/20' ?>">
                                        <?php if ($sch): ?>
                                            <div class="p-3 rounded-xl bg-white border border-blue-200 shadow-xs hover:shadow-md transition">
                                                <div class="font-bold text-xs text-huit-blue leading-tight mb-1.5">
                                                    <?= htmlspecialchars($sch['subject_name']) ?>
                                                </div>
                                                <div class="text-[11px] font-semibold text-slate-700 flex items-center mb-1">
                                                    <i class="ti ti-door mr-1 text-slate-400"></i>
                                                    <span>Phòng: <?= htmlspecialchars($sch['room']) ?></span>
                                                </div>
                                                <div class="text-[10px] text-slate-600 bg-slate-50 p-1.5 rounded-lg border border-slate-100">
                                                    <div class="font-bold text-orange-700 flex items-center">
                                                        <i class="ti ti-building-community mr-1 text-xs"></i>
                                                        <?= htmlspecialchars($sch['branch_name']) ?>
                                                    </div>
                                                    <div class="text-slate-400 text-[9px] mt-0.5 truncate" title="<?= htmlspecialchars($sch['branch_address']) ?>">
                                                        <?= htmlspecialchars($sch['branch_address']) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="h-full flex items-center justify-center text-slate-300 italic text-[11px]">
                                                (Trống)
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

    <?php else: ?>
        <!-- LIST / TIMELINE VIEW -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden p-6">
            <h2 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-3 mb-4 flex items-center space-x-2">
                <i class="ti ti-list text-huit-blue"></i>
                <span>Danh Sách Lịch Dạy Chi Tiết</span>
            </h2>

            <?php if (empty($schedules)): ?>
                <div class="p-8 text-center text-slate-400">
                    <i class="ti ti-calendar-off text-4xl block mb-2 text-slate-300"></i>
                    Thầy/Cô hiện chưa được phân công lịch dạy nào.
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php foreach ($schedules as $s): ?>
                        <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white hover:border-huit-blue hover:shadow transition">
                            <div class="flex items-start justify-between">
                                <div class="font-bold text-sm text-slate-800">
                                    <?= htmlspecialchars($s['subject_name']) ?>
                                </div>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-huit-blue text-white">
                                    <?= $dayNames[$s['day_of_week']] ?? 'Thứ ' . $s['day_of_week'] ?>
                                </span>
                            </div>

                            <div class="mt-2.5 text-xs text-slate-600 space-y-1">
                                <p class="flex items-center">
                                    <i class="ti ti-clock mr-1.5 text-slate-400"></i>
                                    <span class="font-medium text-orange-600"><?= htmlspecialchars($s['shift_or_periods']) ?></span>
                                </p>
                                <p class="flex items-center">
                                    <i class="ti ti-door mr-1.5 text-slate-400"></i>
                                    <span>Phòng học: <strong class="text-slate-800"><?= htmlspecialchars($s['room']) ?></strong></span>
                                </p>
                                <p class="flex items-start">
                                    <i class="ti ti-map-pin mr-1.5 text-slate-400 mt-0.5"></i>
                                    <span><strong><?= htmlspecialchars($s['branch_name']) ?></strong> &bull; <?= htmlspecialchars($s['branch_address']) ?></span>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

</div>

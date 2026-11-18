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
                
                <div class="relative flex items-center">
                    <span class="mr-1 text-slate-400"><i class="ti ti-calendar text-base"></i></span>
                    <input type="text" value="18/11/2026" readonly class="w-24 text-center py-1.5 px-2 bg-slate-50 border border-slate-300 rounded-lg font-medium text-slate-700">
                </div>

                <a href="/timetable" class="px-3 py-1.5 bg-sky-600 hover:bg-sky-700 text-white font-medium rounded-lg shadow-xs flex items-center space-x-1 transition">
                    <i class="ti ti-calendar"></i>
                    <span>Hiện tại</span>
                </a>

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

                <!-- Nút Fullscreen toggle (Ảnh 3) -->
                <button type="button" onclick="toggleFullScreen()" title="Toàn màn hình" class="p-1.5 bg-sky-600 hover:bg-sky-700 text-white rounded-lg shadow-xs transition">
                    <i class="ti ti-arrows-maximize text-sm"></i>
                </button>

                <!-- Nút Phân lịch Pop-up -->
                <button type="button" onclick="openCreateScheduleModal()" class="px-3 py-1.5 bg-huit-orange hover:bg-huit-orangeHover text-white font-bold rounded-lg shadow-xs transition flex items-center space-x-1">
                    <i class="ti ti-plus"></i>
                    <span>Phân lịch mới (Pop-up)</span>
                </button>
            </div>

        </div>

        <!-- Bộ Lọc Nhanh Cơ Sở, Giảng Viên & Loại Hình (Lý thuyết / Thực hành) -->
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

                <select name="class_type" onchange="this.form.submit()" class="py-1 px-3 bg-slate-50 border border-slate-200 rounded-lg text-slate-700 focus:ring-1 focus:ring-huit-header font-medium">
                    <option value="">-- Tất cả loại hình --</option>
                    <option value="theory" <?= ($selectedClassType ?? '') === 'theory' ? 'selected' : '' ?>>📘 Lý thuyết (3 tiết)</option>
                    <option value="practice" <?= ($selectedClassType ?? '') === 'practice' ? 'selected' : '' ?>>🧪 Thực hành (5 tiết)</option>
                </select>

                <?php if ($selectedBranchId || $selectedTeacherId || !empty($selectedClassType)): ?>
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
    <div id="timetableContainer" class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
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
                            <!-- Cột Ca Học: Sáng / Chiều / Tối (Ảnh 3) -->
                            <td class="p-4 bg-slate-50/90 border-r border-slate-200 text-center font-bold text-slate-800 align-middle">
                                <div class="text-sm font-extrabold text-slate-700"><?= $sessionName ?></div>
                            </td>

                            <!-- Các ô Thứ 2 -> Chủ Nhật -->
                            <?php for ($day = 2; $day <= 8; $day++): 
                                $sessionSchedules = [];
                                
                                // Tìm tất cả schedules thuộc buổi này trong ngày
                                foreach ($sessionShifts as $sh) {
                                    if (!empty($timetableGrid[$day][$sh])) {
                                        foreach ($timetableGrid[$day][$sh] as $item) {
                                            $sessionSchedules[$item['id']] = $item;
                                        }
                                    }
                                }

                                // Fallback tìm theo session_time
                                if (isset($timetableGrid[$day])) {
                                    foreach ($timetableGrid[$day] as $shKey => $items) {
                                        foreach ($items as $item) {
                                            if (($item['session_time'] ?? '') === $sessionCode || stripos($item['shift_or_periods'], $sessionName) !== false) {
                                                $sessionSchedules[$item['id']] = $item;
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
                                                    // Xanh lá nổi bật chuẩn Ảnh 3 (#5cb85c / #48bb78)
                                                    $cardBg = 'bg-[#5cb85c] text-slate-900 border border-[#4cae4c] shadow-xs';
                                                    $subText = 'text-slate-900';
                                                    $borderDivider = 'border-slate-800/20';
                                                } else {
                                                    // Xám nhạt thanh lịch chuẩn Ảnh 3 (#edf2f7 / #e2e8f0)
                                                    $cardBg = 'bg-[#edf2f7] text-slate-800 border border-slate-300 shadow-xs';
                                                    $subText = 'text-slate-600';
                                                    $borderDivider = 'border-slate-300';
                                                }
                                            ?>
                                                <div class="p-2.5 rounded-lg <?= $cardBg ?> transition group relative leading-tight">
                                                    
                                                    <!-- 1. Tên môn học (In đậm) -->
                                                    <div class="font-bold text-xs line-clamp-2">
                                                        <?= htmlspecialchars($sch['subject_name']) ?>
                                                    </div>

                                                    <!-- 2. Mã lớp & Mã học phần theo chuẩn HUIT (Ảnh 3) -->
                                                    <div class="text-[10px] <?= $subText ?> mt-0.5 font-medium">
                                                        <?= sprintf('14DHTH%02d - 01011019%04d', ((int)$sch['teacher_id'] % 12) + 1, ((int)$sch['id'] * 137 + 7000)) ?>
                                                    </div>

                                                    <!-- 3. Tiết học: 1 - 5 hoặc 1 - 3, 7 - 11, etc. -->
                                                    <div class="text-[10px] <?= $subText ?> mt-0.5 font-semibold">
                                                        Tiết: <?= htmlspecialchars($sch['period_start'] ?? 1) ?> - <?= htmlspecialchars($sch['period_end'] ?? 3) ?>
                                                    </div>

                                                    <!-- 4. Phòng & Cơ sở (Ảnh 3: Phòng: A107 - Phòng máy tính - 140 Lê Trọng Tấn) -->
                                                    <div class="text-[10px] <?= $subText ?> mt-0.5 font-medium">
                                                        Phòng: <span class="font-bold"><?= htmlspecialchars($sch['room']) ?></span> - <?= htmlspecialchars($sch['branch_name']) ?>
                                                    </div>

                                                    <div class="text-[9px] <?= $subText ?> truncate mt-0.5" title="<?= htmlspecialchars($sch['branch_address']) ?>">
                                                        <?= htmlspecialchars($sch['branch_address']) ?>
                                                    </div>

                                                    <!-- 5. Tên Giảng Viên (Ảnh 3: GV: Đinh Nguyễn Trọng Nghĩa) -->
                                                    <div class="text-[10px] <?= $subText ?> font-bold mt-1 pt-1 border-t <?= $borderDivider ?>">
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

</div>

<!-- MODAL POP-UP: THÊM LỊCH DẠY THÔNG MINH NGAY TRÊN TRANG TUẦN -->
<div id="createScheduleModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity">
    <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-4xl max-h-[90vh] overflow-y-auto transform transition-all scale-95 duration-200" id="createScheduleModalBox">
        
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50 sticky top-0 bg-white z-10">
            <h3 class="text-sm font-bold text-slate-800 flex items-center space-x-2">
                <i class="ti ti-sparkles text-orange-500 text-lg"></i>
                <span>Phân Lịch Giảng Dạy Mới (Hỗ trợ Gợi ý Thông Minh & Phân chia Lý thuyết / Thực hành)</span>
            </h3>
            <button type="button" onclick="closeCreateScheduleModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                <i class="ti ti-x text-lg"></i>
            </button>
        </div>

        <div class="p-6 grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <!-- Cột trái: Form nhập liệu -->
            <form action="/schedules" method="POST" class="lg:col-span-7 space-y-3.5">
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Cơ sở đào tạo <span class="text-red-500">*</span></label>
                    <select id="modal_branch_id" name="branch_id" required class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:ring-2 focus:ring-huit-header">
                        <option value="">-- Chọn Cơ Sở --</option>
                        <?php foreach ($branches as $b): ?>
                            <option value="<?= $b['id'] ?>"><?= htmlspecialchars($b['branch_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Môn học / Học phần <span class="text-red-500">*</span></label>
                    <input type="text" id="modal_subject_name" name="subject_name" required placeholder="Lập trình Web PHP, Thực hành Big data..." class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:ring-2 focus:ring-huit-header">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Thứ <span class="text-red-500">*</span></label>
                        <select id="modal_day_of_week" name="day_of_week" required class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:ring-2 focus:ring-huit-header">
                            <?php for ($d = 2; $d <= 8; $d++): ?>
                                <option value="<?= $d ?>"><?= $dayNames[$d]['name'] ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Ca học / Tiết học <span class="text-red-500">*</span></label>
                        <select id="modal_shift" name="shift_or_periods" required class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:ring-2 focus:ring-huit-header">
                            <option value="">-- Chọn Ca Học --</option>
                            <optgroup label="📘 Lý thuyết (3 tiết)">
                                <option value="Sáng - Lý thuyết (Tiết 1-3)">Sáng - Lý thuyết (Tiết 1-3) [07:00 - 09:30]</option>
                                <option value="Sáng - Lý thuyết (Tiết 4-6)">Sáng - Lý thuyết (Tiết 4-6) [09:45 - 12:15]</option>
                                <option value="Chiều - Lý thuyết (Tiết 7-9)">Chiều - Lý thuyết (Tiết 7-9) [13:00 - 15:30]</option>
                                <option value="Chiều - Lý thuyết (Tiết 10-12)">Chiều - Lý thuyết (Tiết 10-12) [15:45 - 18:15]</option>
                                <option value="Tối - Lý thuyết (Tiết 13-15)">Tối - Lý thuyết (Tiết 13-15) [18:30 - 21:00]</option>
                            </optgroup>
                            <optgroup label="🧪 Thực hành phòng máy / xưởng (5 tiết)">
                                <option value="Sáng - Thực hành (Tiết 1-5)">Sáng - Thực hành (Tiết 1-5) [07:00 - 11:30]</option>
                                <option value="Chiều - Thực hành (Tiết 7-11)">Chiều - Thực hành (Tiết 7-11) [12:30 - 17:00]</option>
                                <option value="Tối - Thực hành (Tiết 11-15)">Tối - Thực hành (Tiết 11-15) [17:15 - 21:45]</option>
                            </optgroup>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Phòng học <span class="text-red-500">*</span></label>
                        <input type="text" id="modal_room" name="room" required placeholder="A201, PM01..." class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:ring-2 focus:ring-huit-header">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Giảng viên <span class="text-red-500">*</span></label>
                        <select id="modal_teacher_id" name="teacher_id" required class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:ring-2 focus:ring-huit-header">
                            <option value="">-- Chọn Giảng Viên --</option>
                            <?php foreach ($teachers as $t): ?>
                                <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['full_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Ghi chú</label>
                    <textarea name="notes" rows="2" placeholder="Ghi chú thêm..." class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-1.5 text-slate-800 focus:ring-2 focus:ring-huit-header"></textarea>
                </div>

                <div id="modalConflictBox" class="hidden p-3 rounded-xl text-xs space-y-1"></div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end space-x-2">
                    <button type="button" onclick="closeCreateScheduleModal()" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-50">Hủy</button>
                    <button type="submit" id="modalSubmitBtn" class="px-5 py-2 bg-huit-header hover:bg-blue-800 text-white text-xs font-bold rounded-xl shadow-xs">Xác Nhận Lưu Lịch</button>
                </div>
            </form>

            <!-- Cột phải: Trợ lý Gợi ý Giảng Viên -->
            <div class="lg:col-span-5 bg-slate-50 p-4 rounded-xl border border-slate-200 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-slate-700 flex items-center">
                            <i class="ti ti-bulb text-amber-500 mr-1"></i> Gợi Ý Phù Hợp:
                        </span>
                        <span id="modalLoading" class="hidden text-[10px] text-huit-header font-bold animate-pulse">Đang tìm...</span>
                    </div>
                    <div id="modalSuggestionList" class="space-y-2 max-h-[300px] overflow-y-auto text-xs text-slate-400 text-center py-4">
                        Chọn Cơ sở, Ca học và Môn học để nhận gợi ý giảng viên tối ưu di chuyển.
                    </div>
                </div>
                <div class="text-[10px] text-slate-400 mt-2 border-t border-slate-200 pt-2">
                    Thuật toán tự động ưu tiên giảng viên đang có mặt tại cùng cơ sở trong ngày và ngăn ngừa xung đột tiết chồng chéo.
                </div>
            </div>

        </div>

    </div>
</div>

<script>
function openCreateScheduleModal() {
    const modal = document.getElementById('createScheduleModal');
    const box = document.getElementById('createScheduleModalBox');
    modal.classList.remove('hidden');
    setTimeout(() => box.classList.remove('scale-95'), 10);
}

function closeCreateScheduleModal() {
    const modal = document.getElementById('createScheduleModal');
    const box = document.getElementById('createScheduleModalBox');
    box.classList.add('scale-95');
    setTimeout(() => modal.classList.add('hidden'), 150);
}

function toggleFullScreen() {
    const elem = document.getElementById('timetableContainer');
    if (!document.fullscreenElement) {
        elem.requestFullscreen().catch(err => {
            alert(`Lỗi khi mở toàn màn hình: ${err.message}`);
        });
    } else {
        document.exitFullscreen();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const branchSel = document.getElementById('modal_branch_id');
    const subInput = document.getElementById('modal_subject_name');
    const daySel = document.getElementById('modal_day_of_week');
    const shiftSel = document.getElementById('modal_shift');
    const roomInput = document.getElementById('modal_room');
    const teacherSel = document.getElementById('modal_teacher_id');
    const sugList = document.getElementById('modalSuggestionList');
    const loading = document.getElementById('modalLoading');
    const conflictBox = document.getElementById('modalConflictBox');
    const submitBtn = document.getElementById('modalSubmitBtn');

    let timer = null;
    function triggerSuggest() {
        clearTimeout(timer);
        timer = setTimeout(fetchSuggestions, 300);
    }

    branchSel.addEventListener('change', triggerSuggest);
    subInput.addEventListener('input', triggerSuggest);
    daySel.addEventListener('change', triggerSuggest);
    shiftSel.addEventListener('change', triggerSuggest);

    function fetchSuggestions() {
        const branchId = branchSel.value;
        const subject = subInput.value.trim();
        const day = daySel.value;
        const shift = shiftSel.value;

        if (!branchId || !shift) {
            sugList.innerHTML = '<div class="py-4 text-slate-400 text-center">Vui lòng chọn Cơ sở và Ca học để gợi ý.</div>';
            return;
        }

        loading.classList.remove('hidden');
        fetch(`/api/suggest-teachers?branch_id=${branchId}&subject_name=${encodeURIComponent(subject)}&day_of_week=${day}&shift_or_periods=${encodeURIComponent(shift)}`)
            .then(res => res.json())
            .then(data => {
                loading.classList.add('hidden');
                if (!data.success || !data.suggestions || data.suggestions.length === 0) {
                    sugList.innerHTML = '<div class="py-4 text-slate-400 text-center">Không tìm thấy giảng viên phù hợp không vướng lịch.</div>';
                    return;
                }

                let html = '';
                data.suggestions.forEach(item => {
                    const t = item.teacher;
                    let tagClass = item.priority === 1 ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800';
                    html += `
                        <div onclick="selectTeacher(${t.id})" class="p-2.5 rounded-xl bg-white border border-slate-200 hover:border-huit-header cursor-pointer transition shadow-2xs text-left">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-slate-800">${t.full_name}</span>
                                <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-md ${tagClass}">${item.reason}</span>
                            </div>
                            <div class="text-[10px] text-slate-500 mt-0.5 flex items-center justify-between">
                                <span>${t.expertise}</span>
                                <span class="text-huit-header font-semibold">Chọn &rarr;</span>
                            </div>
                        </div>
                    `;
                });
                sugList.innerHTML = html;
            })
            .catch(() => {
                loading.classList.add('hidden');
            });
    }

    window.selectTeacher = function(id) {
        teacherSel.value = id;
        checkConflictRealtime();
    };

    function checkConflictRealtime() {
        const teacherId = teacherSel.value;
        const branchId = branchSel.value;
        const room = roomInput.value.trim();
        const day = daySel.value;
        const shift = shiftSel.value;

        if (!teacherId || !branchId || !day || !shift) {
            conflictBox.classList.add('hidden');
            submitBtn.disabled = false;
            return;
        }

        fetch(`/api/check-conflicts?teacher_id=${teacherId}&branch_id=${branchId}&room=${encodeURIComponent(room)}&day_of_week=${day}&shift_or_periods=${encodeURIComponent(shift)}`)
            .then(res => res.json())
            .then(data => {
                conflictBox.classList.remove('hidden');
                if (data.has_conflict) {
                    conflictBox.className = 'p-3 rounded-xl text-xs space-y-1 bg-red-50 text-red-800 border border-red-200';
                    conflictBox.innerHTML = `<strong><i class="ti ti-alert-triangle mr-1"></i> Xung đột lịch:</strong><div>${data.conflicts.join('<br>')}</div>`;
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                } else if (data.has_warning) {
                    conflictBox.className = 'p-3 rounded-xl text-xs space-y-1 bg-amber-50 text-amber-800 border border-amber-200';
                    conflictBox.innerHTML = `<strong><i class="ti ti-car mr-1"></i> Lưu ý di chuyển:</strong><div>${data.warnings.join('<br>')}</div>`;
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    conflictBox.className = 'p-3 rounded-xl text-xs space-y-1 bg-emerald-50 text-emerald-800 border border-emerald-200';
                    conflictBox.innerHTML = `<strong><i class="ti ti-circle-check mr-1"></i> Lịch hợp lệ:</strong> Giảng viên và phòng học sẵn sàng, không trùng lặp!`;
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            });
    }

    teacherSel.addEventListener('change', checkConflictRealtime);
    roomInput.addEventListener('input', checkConflictRealtime);
});
</script>

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

$sessions = ['Sáng', 'Chiều', 'Tối'];

if (!function_exists('getScheduleSessionName')) {
    function getScheduleSessionName(string $shift, array $shiftDetails): string {
        if (isset($shiftDetails[$shift]['session'])) {
            $sess = $shiftDetails[$shift]['session'];
            if ($sess === 'morning') return 'Sáng';
            if ($sess === 'afternoon') return 'Chiều';
            if ($sess === 'evening') return 'Tối';
        }
        if (stripos($shift, 'sáng') !== false || stripos($shift, 'tiết 1') !== false || stripos($shift, 'tiết 4') !== false) return 'Sáng';
        if (stripos($shift, 'chiều') !== false || stripos($shift, 'tiết 7') !== false || stripos($shift, 'tiết 10') !== false) return 'Chiều';
        if (stripos($shift, 'tối') !== false || stripos($shift, 'tiết 13') !== false) return 'Tối';
        return 'Sáng';
    }
}
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

                <!-- Nút Phân lịch Pop-up -->
                <button type="button" onclick="openCreateScheduleModal()" class="px-3 py-1.5 bg-huit-orange hover:bg-huit-orangeHover text-white font-bold rounded-lg shadow-xs transition flex items-center space-x-1">
                    <i class="ti ti-plus"></i>
                    <span>Phân lịch mới (Pop-up)</span>
                </button>
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
                    
                    <?php foreach ($sessions as $sessionName): ?>
                        <tr>
                            <!-- Cột Ca Học: Sáng / Chiều / Tối (Ảnh 3 với nền vàng nhạt) -->
                            <td class="p-3 bg-[#fffde7] border-r border-slate-200 text-center font-bold align-middle w-24">
                                <div class="text-sm font-extrabold text-[#78541a]"><?= $sessionName ?></div>
                            </td>

                            <!-- Các ô Thứ 2 -> Chủ Nhật -->
                            <?php for ($day = 2; $day <= 8; $day++): 
                                $cellSchedules = [];
                                if (!empty($timetableGrid[$day])) {
                                    foreach ($timetableGrid[$day] as $shiftKey => $items) {
                                        if (getScheduleSessionName($shiftKey, $shiftDetails) === $sessionName) {
                                            foreach ($items as $item) {
                                                $cellSchedules[] = $item;
                                            }
                                        }
                                    }
                                }
                                usort($cellSchedules, function($a, $b) use ($shiftDetails) {
                                    $startA = $shiftDetails[$a['shift_or_periods']]['start'] ?? 1;
                                    $startB = $shiftDetails[$b['shift_or_periods']]['start'] ?? 1;
                                    return $startA <=> $startB;
                                });
                            ?>
                                <td class="p-2 border-r border-slate-200 align-top min-w-[145px] h-36 bg-white hover:bg-slate-50/40 transition">
                                    
                                    <?php if (empty($cellSchedules)): ?>
                                        <div class="h-full flex items-center justify-center text-slate-200 text-[11px] select-none">
                                            &bull;
                                        </div>
                                    <?php else: ?>
                                        <div class="space-y-2">
                                            <?php foreach ($cellSchedules as $sch): 
                                                $shiftInfo = $shiftDetails[$sch['shift_or_periods']] ?? null;
                                                $isPractice = ($shiftInfo['type'] ?? '') === 'practice'
                                                           || stripos($sch['shift_or_periods'], 'thực hành') !== false 
                                                           || stripos($sch['subject_name'], 'thực hành') !== false 
                                                           || stripos($sch['subject_name'], 'lab') !== false;

                                                $periodLabel = '';
                                                if ($shiftInfo && isset($shiftInfo['start'], $shiftInfo['end'])) {
                                                    $periodLabel = "Tiết: {$shiftInfo['start']} - {$shiftInfo['end']}";
                                                } elseif (preg_match('/Tiết\s*(\d+)\s*-\s*(\d+)/i', $sch['shift_or_periods'], $m)) {
                                                    $periodLabel = "Tiết: {$m[1]} - {$m[2]}";
                                                } else {
                                                    $periodLabel = $sch['shift_or_periods'];
                                                }
                                                $classCode = !empty($sch['notes']) ? htmlspecialchars($sch['notes']) : '14DHTH' . str_pad($sch['id'], 2, '0', STR_PAD_LEFT);
                                            ?>
                                                <?php if ($isPractice): ?>
                                                    <!-- Khối Thực Hành 5 tiết: Xanh lá chuẩn HUIT Ảnh 3 -->
                                                    <div class="p-2.5 rounded-lg bg-[#59ba47] text-white shadow-xs text-left leading-snug">
                                                        <div class="font-bold text-xs leading-tight">
                                                            <?= htmlspecialchars($sch['subject_name']) ?>
                                                        </div>
                                                        <div class="text-[10px] text-green-100 font-mono mt-0.5">
                                                            <?= $classCode ?>
                                                        </div>
                                                        <div class="text-[10px] font-semibold text-white mt-1">
                                                            <?= $periodLabel ?> (5 tiết)
                                                        </div>
                                                        <div class="text-[10px] text-green-50 mt-0.5 font-medium">
                                                            Phòng: <span class="font-bold text-white"><?= htmlspecialchars($sch['room']) ?></span> - <?= htmlspecialchars($sch['branch_name']) ?>
                                                        </div>
                                                        <div class="text-[10px] font-medium text-green-100 mt-1 pt-1 border-t border-white/20">
                                                            GV: <?= htmlspecialchars($sch['teacher_name']) ?>
                                                        </div>
                                                    </div>
                                                <?php else: ?>
                                                    <!-- Khối Lý Thuyết 3 tiết: Xám xanh chuẩn HUIT Ảnh 3 -->
                                                    <div class="p-2.5 rounded-lg bg-[#ebf3fa] text-slate-800 border border-slate-300 shadow-xs text-left leading-snug">
                                                        <div class="font-bold text-xs text-slate-900 leading-tight">
                                                            <?= htmlspecialchars($sch['subject_name']) ?>
                                                        </div>
                                                        <div class="text-[10px] text-slate-500 font-mono mt-0.5">
                                                            <?= $classCode ?>
                                                        </div>
                                                        <div class="text-[10px] font-bold text-slate-700 mt-1">
                                                            <?= $periodLabel ?> (3 tiết)
                                                        </div>
                                                        <div class="text-[10px] text-slate-600 mt-0.5 font-medium">
                                                            Phòng: <span class="font-bold text-slate-900"><?= htmlspecialchars($sch['room']) ?></span> - <?= htmlspecialchars($sch['branch_name']) ?>
                                                        </div>
                                                        <div class="text-[10px] font-semibold text-slate-700 mt-1 pt-1 border-t border-slate-200">
                                                            GV: <?= htmlspecialchars($sch['teacher_name']) ?>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
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

<!-- MODAL POP-UP: THÊM LỊCH DẠY THÔNG MINH NGAY TRÊN TRANG TUẦN -->
<div id="createScheduleModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity">
    <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-4xl max-h-[90vh] overflow-y-auto transform transition-all scale-95 duration-200" id="createScheduleModalBox">
        
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50 sticky top-0 bg-white z-10">
            <h3 class="text-sm font-bold text-slate-800 flex items-center space-x-2">
                <i class="ti ti-sparkles text-orange-500 text-lg"></i>
                <span>Phân Lịch Giảng Dạy Mới (Hỗ trợ Gợi ý Thông Minh)</span>
            </h3>
            <button type="button" onclick="closeCreateScheduleModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                <i class="ti ti-x text-lg"></i>
            </button>
        </div>

        <div class="p-6 grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <!-- Cột trái: Form nhập liệu -->
            <form action="/schedules" method="POST" class="lg:col-span-7 space-y-3.5">
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Cơ sở <span class="text-red-500">*</span></label>
                    <select id="modal_branch_id" name="branch_id" required class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:ring-2 focus:ring-huit-header">
                        <option value="">-- Chọn Cơ Sở --</option>
                        <?php foreach ($branches as $b): ?>
                            <option value="<?= $b['id'] ?>"><?= htmlspecialchars($b['branch_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Môn học / Học phần <span class="text-red-500">*</span></label>
                    <input type="text" id="modal_subject_name" name="subject_name" required placeholder="Lập trình Web PHP, An toàn mạng..." class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:ring-2 focus:ring-huit-header">
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
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Ca học <span class="text-red-500">*</span></label>
                        <select id="modal_shift" name="shift_or_periods" required class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:ring-2 focus:ring-huit-header">
                            <option value="">-- Chọn Loại Ca Học --</option>
                            <optgroup label="📚 LÝ THUYẾT (3 TIẾT / CA)">
                                <?php foreach ($shifts as $sh): 
                                    $info = $shiftDetails[$sh] ?? null;
                                    if (($info['type'] ?? '') === 'theory'):
                                ?>
                                    <option value="<?= htmlspecialchars($sh) ?>">
                                        <?= htmlspecialchars($sh) ?> (<?= $info['time'] ?>)
                                    </option>
                                <?php endif; endforeach; ?>
                            </optgroup>
                            <optgroup label="💻 THỰC HÀNH (5 TIẾT / CA)">
                                <?php foreach ($shifts as $sh): 
                                    $info = $shiftDetails[$sh] ?? null;
                                    if (($info['type'] ?? '') === 'practice'):
                                ?>
                                    <option value="<?= htmlspecialchars($sh) ?>">
                                        <?= htmlspecialchars($sh) ?> (<?= $info['time'] ?>)
                                    </option>
                                <?php endif; endforeach; ?>
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
                    Thuật toán tự động ưu tiên giảng viên đang có mặt tại cùng cơ sở trong ngày.
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
        const bId = branchSel.value;
        const sub = subInput.value.trim();
        const d = daySel.value;
        const sh = shiftSel.value;

        if (!bId || !sh) return;
        loading.classList.remove('hidden');

        const params = new URLSearchParams({ branch_id: bId, subject_name: sub, day_of_week: d, shift: sh });
        fetch('/api/suggest-teachers?' + params.toString())
            .then(r => r.json())
            .then(res => {
                loading.classList.add('hidden');
                if (res.success && res.data.length > 0) {
                    let html = '';
                    res.data.slice(0, 4).forEach(item => {
                        const t = item.teacher;
                        html += `
                            <div class="p-2 bg-white rounded-lg border border-slate-200 flex items-center justify-between text-left">
                                <div class="truncate mr-2">
                                    <div class="font-bold text-slate-800 text-[11px] truncate">${t.full_name}</div>
                                    <span class="text-[9px] px-1.5 py-0.2 rounded ${item.badge_class}">${item.badge_text || 'Khả dụng'}</span>
                                </div>
                                ${item.is_available ? `
                                    <button type="button" onclick="document.getElementById('modal_teacher_id').value=${t.id}" class="px-2 py-1 bg-huit-header text-white rounded text-[10px] font-bold">Chọn</button>
                                ` : `<span class="text-[9px] text-red-500 font-bold">Bận</span>`}
                            </div>
                        `;
                    });
                    sugList.innerHTML = html;
                } else {
                    sugList.innerHTML = '<div class="text-center py-2">Không có gợi ý.</div>';
                }
            })
            .catch(() => loading.classList.add('hidden'));
    }

    function checkConflict() {
        const tId = teacherSel.value;
        const bId = branchSel.value;
        const rm = roomInput.value.trim();
        const d = daySel.value;
        const sh = shiftSel.value;

        if (!tId || !bId || !rm || !d || !sh) {
            conflictBox.classList.add('hidden');
            submitBtn.disabled = false;
            return;
        }

        const params = new URLSearchParams({ teacher_id: tId, branch_id: bId, room: rm, day_of_week: d, shift: sh });
        fetch('/api/check-conflicts?' + params.toString())
            .then(r => r.json())
            .then(data => {
                if (data.has_conflict) {
                    conflictBox.className = 'p-2.5 rounded-xl text-[11px] bg-red-50 border border-red-200 text-red-800';
                    conflictBox.innerHTML = `<strong>Xung đột:</strong> ${data.conflicts.join(', ')}`;
                    conflictBox.classList.remove('hidden');
                    submitBtn.disabled = true;
                } else if (data.has_warning) {
                    conflictBox.className = 'p-2.5 rounded-xl text-[11px] bg-amber-50 border border-amber-200 text-amber-800';
                    conflictBox.innerHTML = `<strong>Cảnh báo:</strong> ${data.warnings.join(', ')}`;
                    conflictBox.classList.remove('hidden');
                    submitBtn.disabled = false;
                } else {
                    conflictBox.classList.add('hidden');
                    submitBtn.disabled = false;
                }
            });
    }

    roomInput.addEventListener('input', checkConflict);
    teacherSel.addEventListener('change', checkConflict);
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeCreateScheduleModal();
    }
});
</script>

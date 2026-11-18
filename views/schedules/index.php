<?php
$pageTitle = 'Quản lý Lịch Giảng Dạy - HUIT Schedule Hub';
$dayNames = [
    2 => 'Thứ Hai',
    3 => 'Thứ Ba',
    4 => 'Thứ Tư',
    5 => 'Thứ Năm',
    6 => 'Thứ Sáu',
    7 => 'Thứ Bảy',
    8 => 'Chủ Nhật'
];
$shifts = array_keys(\App\Services\ScheduleOptimizerService::SHIFTS);
$shiftDetails = \App\Services\ScheduleOptimizerService::SHIFTS;
?>

<div class="space-y-6">

    <!-- Header Actions & Navigation Pill -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-800 tracking-tight flex items-center space-x-2">
                <i class="ti ti-list-details text-huit-header"></i>
                <span>Danh Sách Lịch Giảng Dạy</span>
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">Quản lý toàn bộ danh sách phân công lịch dạy, tìm kiếm và điều chỉnh thông tin</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="/timetable" class="inline-flex items-center space-x-1.5 px-3.5 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold text-xs rounded-xl shadow-xs transition">
                <i class="ti ti-calendar text-sky-600"></i>
                <span>Xem Ma Trận Tuần</span>
            </a>
            <!-- Nút mở Pop-up Thêm Lịch -->
            <button type="button" onclick="openCreateScheduleModal()" class="inline-flex items-center space-x-1.5 px-4 py-2 bg-huit-orange hover:bg-huit-orangeHover text-white font-bold text-xs rounded-xl shadow-sm transition">
                <i class="ti ti-plus"></i>
                <span>Phân Lịch Mới (Pop-up)</span>
            </button>
        </div>
    </div>

    <!-- Filters Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <form method="GET" action="/schedules" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3">
            
            <!-- Search Keyword -->
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Tìm kiếm</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i class="ti ti-search text-xs"></i>
                    </span>
                    <input type="text" name="keyword" value="<?= htmlspecialchars($filters['keyword'] ?? '') ?>" 
                        placeholder="Môn, phòng, giảng viên..." 
                        class="w-full pl-8 pr-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-huit-header">
                </div>
            </div>

            <!-- Filter Branch -->
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Cơ sở</label>
                <select name="branch_id" class="w-full py-2 px-3 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-huit-header">
                    <option value="">-- Tất cả cơ sở --</option>
                    <?php foreach ($branches as $b): ?>
                        <option value="<?= $b['id'] ?>" <?= ($filters['branch_id'] ?? null) == $b['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($b['branch_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Filter Teacher -->
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Giảng viên</label>
                <select name="teacher_id" class="w-full py-2 px-3 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-huit-header">
                    <option value="">-- Tất cả giảng viên --</option>
                    <?php foreach ($teachers as $t): ?>
                        <option value="<?= $t['id'] ?>" <?= ($filters['teacher_id'] ?? null) == $t['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($t['full_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Filter Day of Week -->
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Thứ</label>
                <select name="day_of_week" class="w-full py-2 px-3 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-huit-header">
                    <option value="">-- Tất cả các ngày --</option>
                    <?php foreach ($dayNames as $dNum => $dName): ?>
                        <option value="<?= $dNum ?>" <?= ($filters['day_of_week'] ?? null) == $dNum ? 'selected' : '' ?>>
                            <?= $dName ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Action buttons -->
            <div class="flex items-end space-x-2">
                <button type="submit" class="flex-1 py-2 px-3 bg-huit-header hover:bg-blue-800 text-white text-xs font-bold rounded-xl transition flex items-center justify-center space-x-1 shadow-xs">
                    <i class="ti ti-filter"></i>
                    <span>Lọc Dữ Liệu</span>
                </button>
                <a href="/schedules" class="py-2 px-3 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition flex items-center justify-center" title="Làm mới">
                    <i class="ti ti-refresh"></i>
                </a>
            </div>

        </form>
    </div>

    <!-- Schedules Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase tracking-wider text-[11px]">
                        <th class="p-3.5">Học Phần</th>
                        <th class="p-3.5">Giảng Viên</th>
                        <th class="p-3.5">Cơ Sở & Địa Chỉ</th>
                        <th class="p-3.5 text-center">Phòng</th>
                        <th class="p-3.5">Thời Gian</th>
                        <th class="p-3.5 text-right">Thao Tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($schedules)): ?>
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400">
                                <i class="ti ti-calendar-off text-3xl block mb-2 text-slate-300"></i>
                                Không tìm thấy lịch giảng dạy nào phù hợp.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($schedules as $s): 
                            $isPractice = stripos($s['subject_name'], 'thực hành') !== false 
                                       || stripos($s['subject_name'], 'lab') !== false
                                       || stripos($s['subject_name'], 'web') !== false;
                        ?>
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="p-3.5 font-bold text-slate-800">
                                    <div class="flex items-center space-x-1.5">
                                        <span class="w-2 h-2 rounded-full <?= $isPractice ? 'bg-emerald-500' : 'bg-sky-500' ?>"></span>
                                        <span><?= htmlspecialchars($s['subject_name']) ?></span>
                                    </div>
                                    <?php if (!empty($s['notes'])): ?>
                                        <span class="block text-[10px] font-normal text-slate-400 italic mt-0.5 pl-3.5">
                                            <?= htmlspecialchars($s['notes']) ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="p-3.5">
                                    <div class="font-bold text-slate-800"><?= htmlspecialchars($s['teacher_name']) ?></div>
                                    <div class="text-[10px] text-slate-500"><?= htmlspecialchars($s['teacher_expertise']) ?></div>
                                </td>
                                <td class="p-3.5">
                                    <div class="font-bold text-huit-header"><?= htmlspecialchars($s['branch_name']) ?></div>
                                    <div class="text-[10px] text-slate-400 truncate max-w-[200px]" title="<?= htmlspecialchars($s['branch_address']) ?>">
                                        <?= htmlspecialchars($s['branch_address']) ?>
                                    </div>
                                </td>
                                <td class="p-3.5 text-center">
                                    <span class="inline-block px-2.5 py-1 bg-slate-100 border border-slate-200 rounded-lg font-bold text-slate-700">
                                        <?= htmlspecialchars($s['room']) ?>
                                    </span>
                                </td>
                                <td class="p-3.5">
                                    <div class="font-bold text-slate-700">
                                        <?= $dayNames[$s['day_of_week']] ?? 'Thứ ' . $s['day_of_week'] ?>
                                    </div>
                                    <div class="text-[10px] text-orange-600 font-semibold mt-0.5">
                                        <?= htmlspecialchars($s['shift_or_periods']) ?>
                                    </div>
                                </td>
                                <td class="p-3.5 text-right">
                                    <div class="inline-flex items-center space-x-1">
                                        <!-- Nút Sửa Pop-up -->
                                        <button type="button" onclick='openEditScheduleModal(<?= json_encode($s, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)' class="p-1.5 text-slate-500 hover:text-huit-header hover:bg-blue-50 rounded-lg transition" title="Chỉnh sửa (Pop-up)">
                                            <i class="ti ti-edit text-base"></i>
                                        </button>
                                        <!-- Nút Xóa Pop-up -->
                                        <button type="button" onclick="openDeleteScheduleModal(<?= (int)$s['id'] ?>, '<?= htmlspecialchars(addslashes($s['subject_name'])) ?> - P.<?= htmlspecialchars(addslashes($s['room'])) ?>')" class="p-1.5 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Xóa (Pop-up)">
                                            <i class="ti ti-trash text-base"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- 1. MODAL POP-UP: THÊM LỊCH DẠY THÔNG MINH (2 Cột với Trợ lý Gợi ý) -->
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
            <form action="/schedules" method="POST" id="createSchedForm" class="lg:col-span-7 space-y-3.5">
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
                            <?php foreach ($dayNames as $dNum => $dName): ?>
                                <option value="<?= $dNum ?>"><?= $dName ?></option>
                            <?php endforeach; ?>
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

<!-- 2. MODAL POP-UP: SỬA LỊCH DẠY -->
<div id="editScheduleModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity">
    <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-lg overflow-hidden transform transition-all scale-95 duration-200" id="editScheduleModalBox">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <h3 class="text-sm font-bold text-slate-800 flex items-center space-x-2">
                <i class="ti ti-edit text-huit-header text-lg"></i>
                <span>Chỉnh Sửa Lịch Giảng Dạy</span>
            </h3>
            <button type="button" onclick="closeEditScheduleModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                <i class="ti ti-x text-lg"></i>
            </button>
        </div>

        <form id="editScheduleForm" method="POST" class="p-6 space-y-3.5">
            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Cơ sở <span class="text-red-500">*</span></label>
                <select id="edit_branch_id" name="branch_id" required class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:ring-2 focus:ring-huit-header">
                    <?php foreach ($branches as $b): ?>
                        <option value="<?= $b['id'] ?>"><?= htmlspecialchars($b['branch_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Môn học <span class="text-red-500">*</span></label>
                <input type="text" id="edit_subject_name" name="subject_name" required class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:ring-2 focus:ring-huit-header">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Thứ <span class="text-red-500">*</span></label>
                    <select id="edit_day_of_week" name="day_of_week" required class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:ring-2 focus:ring-huit-header">
                        <?php foreach ($dayNames as $dNum => $dName): ?>
                            <option value="<?= $dNum ?>"><?= $dName ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Ca học <span class="text-red-500">*</span></label>
                    <select id="edit_shift" name="shift_or_periods" required class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:ring-2 focus:ring-huit-header">
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
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Phòng <span class="text-red-500">*</span></label>
                    <input type="text" id="edit_room" name="room" required class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:ring-2 focus:ring-huit-header">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Giảng viên <span class="text-red-500">*</span></label>
                    <select id="edit_teacher_id" name="teacher_id" required class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:ring-2 focus:ring-huit-header">
                        <?php foreach ($teachers as $t): ?>
                            <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['full_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Ghi chú</label>
                <textarea id="edit_notes" name="notes" rows="2" class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-1.5 text-slate-800 focus:ring-2 focus:ring-huit-header"></textarea>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end space-x-2">
                <button type="button" onclick="closeEditScheduleModal()" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-50">Hủy</button>
                <button type="submit" class="px-5 py-2 bg-huit-header hover:bg-blue-800 text-white text-xs font-bold rounded-xl shadow-xs">Cập Nhật</button>
            </div>
        </form>
    </div>
</div>

<!-- 3. MODAL POP-UP: XÁC NHẬN XÓA LỊCH DẠY -->
<div id="deleteScheduleModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity">
    <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-sm overflow-hidden p-6 text-center transform transition-all scale-95 duration-200" id="deleteScheduleModalBox">
        <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-2xl mx-auto mb-3">
            <i class="ti ti-alert-triangle"></i>
        </div>
        <h3 class="text-sm font-bold text-slate-800">Xác Nhận Xóa Lịch Dạy</h3>
        <p class="text-xs text-slate-500 mt-1.5" id="deleteScheduleNameText">Bạn có chắc chắn muốn xóa lịch dạy này?</p>

        <form id="deleteScheduleForm" method="POST" class="mt-5 flex items-center justify-center space-x-2">
            <button type="button" onclick="closeDeleteScheduleModal()" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-50">Hủy</button>
            <button type="submit" class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl shadow-xs">Xóa Ngay</button>
        </form>
    </div>
</div>

<!-- JAVASCRIPT ĐIỀU KHIỂN CÁC POP-UP VÀ GỢI Ý LIVE -->
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

function openEditScheduleModal(s) {
    document.getElementById('editScheduleForm').action = '/schedules/' + s.id + '/edit';
    document.getElementById('edit_branch_id').value = s.branch_id;
    document.getElementById('edit_subject_name').value = s.subject_name;
    document.getElementById('edit_day_of_week').value = s.day_of_week;
    document.getElementById('edit_shift').value = s.shift_or_periods;
    document.getElementById('edit_room').value = s.room;
    document.getElementById('edit_teacher_id').value = s.teacher_id;
    document.getElementById('edit_notes').value = s.notes || '';

    const modal = document.getElementById('editScheduleModal');
    const box = document.getElementById('editScheduleModalBox');
    modal.classList.remove('hidden');
    setTimeout(() => box.classList.remove('scale-95'), 10);
}

function closeEditScheduleModal() {
    const modal = document.getElementById('editScheduleModal');
    const box = document.getElementById('editScheduleModalBox');
    box.classList.add('scale-95');
    setTimeout(() => modal.classList.add('hidden'), 150);
}

function openDeleteScheduleModal(id, text) {
    document.getElementById('deleteScheduleForm').action = '/schedules/' + id + '/delete';
    document.getElementById('deleteScheduleNameText').innerText = 'Bạn có chắc chắn muốn xóa: ' + text + '?';

    const modal = document.getElementById('deleteScheduleModal');
    const box = document.getElementById('deleteScheduleModalBox');
    modal.classList.remove('hidden');
    setTimeout(() => box.classList.remove('scale-95'), 10);
}

function closeDeleteScheduleModal() {
    const modal = document.getElementById('deleteScheduleModal');
    const box = document.getElementById('deleteScheduleModalBox');
    box.classList.add('scale-95');
    setTimeout(() => modal.classList.add('hidden'), 150);
}

// Logic Gợi ý & Kiểm tra xung đột trực tiếp trong Pop-up Thêm Mới
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

    // Kiểm tra xung đột khi chọn phòng hoặc giảng viên
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
        closeEditScheduleModal();
        closeDeleteScheduleModal();
    }
});
</script>

<?php
$pageTitle = 'Chỉnh sửa Lịch Giảng Dạy - HUIT Schedule Hub';
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

<div class="max-w-4xl mx-auto space-y-6">

    <!-- Breadcrumb & Header -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center space-x-2 text-xs text-slate-500 mb-1">
                <a href="/schedules" class="hover:underline">Quản lý Lịch dạy</a>
                <span>/</span>
                <span class="text-slate-800 font-semibold">Chỉnh sửa #<?= $schedule['id'] ?></span>
            </div>
            <h1 class="text-xl font-bold text-slate-800 tracking-tight flex items-center space-x-2">
                <i class="ti ti-edit text-huit-header"></i>
                <span>Chỉnh Sửa Lịch Giảng Dạy</span>
            </h1>
        </div>
        <a href="/schedules" class="inline-flex items-center space-x-1 text-xs text-slate-600 hover:text-slate-900 bg-white border border-slate-200 px-3 py-2 rounded-xl transition">
            <i class="ti ti-arrow-left"></i>
            <span>Quay lại</span>
        </a>
    </div>

    <!-- Form Container -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <form action="/schedules/<?= $schedule['id'] ?>/edit" method="POST" id="editScheduleForm" class="space-y-4">
            
            <!-- Cơ sở -->
            <div>
                <label for="branch_id" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Cơ sở trường học <span class="text-red-500">*</span></label>
                <select id="branch_id" name="branch_id" required class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-header">
                    <?php foreach ($branches as $b): ?>
                        <option value="<?= $b['id'] ?>" <?= (int)$schedule['branch_id'] === (int)$b['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($b['branch_name']) ?> (<?= htmlspecialchars($b['address']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Tên học phần -->
            <div>
                <label for="subject_name" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Tên Học Phần / Môn Học <span class="text-red-500">*</span></label>
                <input type="text" id="subject_name" name="subject_name" required 
                    value="<?= htmlspecialchars($schedule['subject_name']) ?>" 
                    class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-header">
            </div>

            <!-- Thời gian: Thứ & Ca học -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="day_of_week" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Thứ trong tuần <span class="text-red-500">*</span></label>
                    <select id="day_of_week" name="day_of_week" required class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-header">
                        <?php foreach ($dayNames as $dayNum => $dayName): ?>
                            <option value="<?= $dayNum ?>" <?= (int)$schedule['day_of_week'] === $dayNum ? 'selected' : '' ?>><?= $dayName ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="shift_or_periods" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Ca học / Tiết học <span class="text-red-500">*</span></label>
                    <select id="shift_or_periods" name="shift_or_periods" required class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-header">
                        <optgroup label="📘 Lý thuyết (3 tiết)">
                            <option value="Sáng - Lý thuyết (Tiết 1-3)" <?= $schedule['shift_or_periods'] === 'Sáng - Lý thuyết (Tiết 1-3)' ? 'selected' : '' ?>>Sáng - Lý thuyết (Tiết 1-3) [07:00 - 09:30]</option>
                            <option value="Sáng - Lý thuyết (Tiết 4-6)" <?= $schedule['shift_or_periods'] === 'Sáng - Lý thuyết (Tiết 4-6)' ? 'selected' : '' ?>>Sáng - Lý thuyết (Tiết 4-6) [09:45 - 12:15]</option>
                            <option value="Chiều - Lý thuyết (Tiết 7-9)" <?= $schedule['shift_or_periods'] === 'Chiều - Lý thuyết (Tiết 7-9)' ? 'selected' : '' ?>>Chiều - Lý thuyết (Tiết 7-9) [13:00 - 15:30]</option>
                            <option value="Chiều - Lý thuyết (Tiết 10-12)" <?= $schedule['shift_or_periods'] === 'Chiều - Lý thuyết (Tiết 10-12)' ? 'selected' : '' ?>>Chiều - Lý thuyết (Tiết 10-12) [15:45 - 18:15]</option>
                            <option value="Tối - Lý thuyết (Tiết 13-15)" <?= $schedule['shift_or_periods'] === 'Tối - Lý thuyết (Tiết 13-15)' ? 'selected' : '' ?>>Tối - Lý thuyết (Tiết 13-15) [18:30 - 21:00]</option>
                        </optgroup>
                        <optgroup label="🧪 Thực hành phòng máy / xưởng (5 tiết)">
                            <option value="Sáng - Thực hành (Tiết 1-5)" <?= $schedule['shift_or_periods'] === 'Sáng - Thực hành (Tiết 1-5)' ? 'selected' : '' ?>>Sáng - Thực hành (Tiết 1-5) [07:00 - 11:30]</option>
                            <option value="Chiều - Thực hành (Tiết 7-11)" <?= $schedule['shift_or_periods'] === 'Chiều - Thực hành (Tiết 7-11)' ? 'selected' : '' ?>>Chiều - Thực hành (Tiết 7-11) [12:30 - 17:00]</option>
                            <option value="Tối - Thực hành (Tiết 11-15)" <?= $schedule['shift_or_periods'] === 'Tối - Thực hành (Tiết 11-15)' ? 'selected' : '' ?>>Tối - Thực hành (Tiết 11-15) [17:15 - 21:45]</option>
                        </optgroup>
                    </select>
                </div>
            </div>

            <!-- Phòng học & Giảng viên -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="room" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Phòng học <span class="text-red-500">*</span></label>
                    <input type="text" id="room" name="room" required 
                        value="<?= htmlspecialchars($schedule['room']) ?>" 
                        class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-header">
                </div>

                <div>
                    <label for="teacher_id" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Giảng viên phụ trách <span class="text-red-500">*</span></label>
                    <select id="teacher_id" name="teacher_id" required class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-header">
                        <?php foreach ($teachers as $t): ?>
                            <option value="<?= $t['id'] ?>" <?= (int)$schedule['teacher_id'] === (int)$t['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($t['full_name']) ?> (<?= htmlspecialchars($t['expertise']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Ghi chú -->
            <div>
                <label for="notes" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Ghi chú thêm</label>
                <textarea id="notes" name="notes" rows="2" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-header"><?= htmlspecialchars($schedule['notes'] ?? '') ?></textarea>
            </div>

            <!-- Live Conflict Box -->
            <div id="conflictAlertBox" class="hidden p-4 rounded-xl text-xs space-y-1.5"></div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="/schedules" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-medium text-slate-600 hover:bg-slate-50 transition">Hủy bỏ</a>
                <button type="submit" id="submitBtn" class="px-6 py-2.5 bg-huit-header hover:bg-blue-800 text-white text-xs font-bold rounded-xl shadow-md transition flex items-center space-x-1.5">
                    <i class="ti ti-device-floppy"></i>
                    <span>Cập Nhật Thay Đổi</span>
                </button>
            </div>

        </form>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const branchSelect = document.getElementById('branch_id');
    const daySelect = document.getElementById('day_of_week');
    const shiftSelect = document.getElementById('shift_or_periods');
    const roomInput = document.getElementById('room');
    const teacherSelect = document.getElementById('teacher_id');
    const conflictAlertBox = document.getElementById('conflictAlertBox');
    const submitBtn = document.getElementById('submitBtn');
    const scheduleId = <?= (int)$schedule['id'] ?>;

    function checkLiveConflicts() {
        const teacherId = teacherSelect.value;
        const branchId = branchSelect.value;
        const room = roomInput.value.trim();
        const dayOfWeek = daySelect.value;
        const shift = shiftSelect.value;

        if (!teacherId || !branchId || !room || !dayOfWeek || !shift) {
            conflictAlertBox.classList.add('hidden');
            submitBtn.disabled = false;
            return;
        }

        const params = new URLSearchParams({
            teacher_id: teacherId,
            branch_id: branchId,
            room: room,
            day_of_week: dayOfWeek,
            shift: shift,
            exclude_id: scheduleId
        });

        fetch('/api/check-conflicts?' + params.toString())
            .then(res => res.json())
            .then(data => {
                if (data.has_conflict) {
                    conflictAlertBox.className = 'p-3 rounded-xl text-xs bg-red-50 border border-red-200 text-red-800 space-y-1';
                    conflictAlertBox.innerHTML = `
                        <div class="font-bold flex items-center text-red-700">
                            <i class="ti ti-alert-circle text-base mr-1"></i> Phát hiện xung đột:
                        </div>
                        ${data.conflicts.map(c => `<div>&bull; ${c}</div>`).join('')}
                    `;
                    conflictAlertBox.classList.remove('hidden');
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                } else if (data.has_warning) {
                    conflictAlertBox.className = 'p-3 rounded-xl text-xs bg-amber-50 border border-amber-200 text-amber-800 space-y-1';
                    conflictAlertBox.innerHTML = `
                        <div class="font-bold flex items-center text-amber-700">
                            <i class="ti ti-alert-triangle text-base mr-1"></i> Cảnh báo di chuyển:
                        </div>
                        ${data.warnings.map(w => `<div>&bull; ${w}</div>`).join('')}
                    `;
                    conflictAlertBox.classList.remove('hidden');
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    conflictAlertBox.classList.add('hidden');
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            })
            .catch(err => console.error(err));
    }

    branchSelect.addEventListener('change', checkLiveConflicts);
    daySelect.addEventListener('change', checkLiveConflicts);
    shiftSelect.addEventListener('change', checkLiveConflicts);
    roomInput.addEventListener('input', checkLiveConflicts);
    teacherSelect.addEventListener('change', checkLiveConflicts);
});
</script>

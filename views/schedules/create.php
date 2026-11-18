<?php
$pageTitle = 'Phân Lịch Giảng Dạy Thông Minh - HUIT Schedule Hub';
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

<div class="max-w-6xl mx-auto space-y-6">

    <!-- Breadcrumb & Header -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center space-x-2 text-xs text-slate-500 mb-1">
                <a href="/schedules" class="hover:underline">Quản lý Lịch dạy</a>
                <span>/</span>
                <span class="text-slate-800 font-semibold">Tạo mới thông minh</span>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight flex items-center space-x-2">
                <i class="ti ti-sparkles text-huit-orange"></i>
                <span>Phân Lịch Giảng Dạy Đa Cơ Sở Thông Minh</span>
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">Tự động gợi ý giảng viên phù hợp chuyên môn và tối ưu hóa thời gian di chuyển</p>
        </div>
        <a href="/schedules" class="inline-flex items-center space-x-1 text-xs text-slate-600 hover:text-slate-900 bg-white border border-slate-200 px-3 py-2 rounded-xl transition">
            <i class="ti ti-arrow-left"></i>
            <span>Quay lại</span>
        </a>
    </div>

    <!-- Main Two-Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Left: Schedule Form (7 cols) -->
        <div class="lg:col-span-7 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <h2 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-3 mb-5 flex items-center space-x-2">
                <i class="ti ti-edit text-huit-blue"></i>
                <span>Thông Tin Lịch Giảng Dạy</span>
            </h2>

            <form action="/schedules" method="POST" id="scheduleForm" class="space-y-4">
                
                <!-- 1. Cơ sở -->
                <div>
                    <label for="branch_id" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                        Cơ sở trường học <span class="text-red-500">*</span>
                    </label>
                    <select id="branch_id" name="branch_id" required class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-blue">
                        <option value="">-- Chọn Cơ Sở Đào Tạo --</option>
                        <?php foreach ($branches as $b): ?>
                            <option value="<?= $b['id'] ?>"><?= htmlspecialchars($b['branch_name']) ?> (<?= htmlspecialchars($b['address']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- 2. Tên học phần -->
                <div>
                    <label for="subject_name" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                        Tên Học Phần / Môn Học <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="subject_name" name="subject_name" required 
                        placeholder="Ví dụ: Lập trình Web PHP, An toàn mạng, Kỹ thuật chế biến thực phẩm..." 
                        class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-blue">
                    <span class="text-[11px] text-slate-400 mt-1 block">Hệ thống sẽ dựa vào tên môn học để lọc giảng viên đúng chuyên ngành</span>
                </div>

                <!-- 3. Thời gian: Thứ & Ca học -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="day_of_week" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                            Thứ trong tuần <span class="text-red-500">*</span>
                        </label>
                        <select id="day_of_week" name="day_of_week" required class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-blue">
                            <?php foreach ($dayNames as $dayNum => $dayName): ?>
                                <option value="<?= $dayNum ?>" <?= $dayNum === 2 ? 'selected' : '' ?>><?= $dayName ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label for="shift_or_periods" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                            Ca học / Tiết học <span class="text-red-500">*</span>
                        </label>
                        <select id="shift_or_periods" name="shift_or_periods" required class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-blue">
                            <option value="">-- Chọn Loại Ca Học --</option>
                            <optgroup label="📚 LÝ THUYẾT (3 TIẾT / CA)">
                                <?php foreach ($shifts as $shift): 
                                    $info = $shiftDetails[$shift] ?? null;
                                    if (($info['type'] ?? '') === 'theory'):
                                ?>
                                    <option value="<?= htmlspecialchars($shift) ?>">
                                        <?= htmlspecialchars($shift) ?> (<?= $info['time'] ?>)
                                    </option>
                                <?php endif; endforeach; ?>
                            </optgroup>
                            <optgroup label="💻 THỰC HÀNH (5 TIẾT / CA)">
                                <?php foreach ($shifts as $shift): 
                                    $info = $shiftDetails[$shift] ?? null;
                                    if (($info['type'] ?? '') === 'practice'):
                                ?>
                                    <option value="<?= htmlspecialchars($shift) ?>">
                                        <?= htmlspecialchars($shift) ?> (<?= $info['time'] ?>)
                                    </option>
                                <?php endif; endforeach; ?>
                            </optgroup>
                        </select>
                    </div>
                </div>

                <!-- 4. Phòng học & Giảng viên -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="room" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                            Phòng học <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="room" name="room" required 
                            placeholder="Ví dụ: B201, PM03, C105..." 
                            class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-blue">
                    </div>

                    <div>
                        <label for="teacher_id" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                            Giảng viên phụ trách <span class="text-red-500">*</span>
                        </label>
                        <select id="teacher_id" name="teacher_id" required class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-blue">
                            <option value="">-- Chọn hoặc bấm Gợi ý bên phải --</option>
                            <?php foreach ($teachers as $t): ?>
                                <option value="<?= $t['id'] ?>" data-name="<?= htmlspecialchars($t['full_name']) ?>">
                                    <?= htmlspecialchars($t['full_name']) ?> (<?= htmlspecialchars($t['expertise']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- 5. Ghi chú -->
                <div>
                    <label for="notes" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Ghi chú thêm</label>
                    <textarea id="notes" name="notes" rows="2" placeholder="Ví dụ: Yêu cầu cài đặt Visual Studio Code, máy chiếu..." 
                        class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-blue"></textarea>
                </div>

                <!-- Live Conflict & Validation Feedback Box -->
                <div id="conflictAlertBox" class="hidden p-4 rounded-xl text-xs space-y-2"></div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                    <a href="/schedules" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-medium text-slate-600 hover:bg-slate-50 transition">Hủy bỏ</a>
                    <button type="submit" id="submitBtn" class="px-6 py-2.5 bg-huit-blue hover:bg-huit-dark text-white text-xs font-bold rounded-xl shadow-md transition flex items-center space-x-1.5">
                        <i class="ti ti-check"></i>
                        <span>Xác Nhận & Lưu Lịch Dạy</span>
                    </button>
                </div>

            </form>
        </div>

        <!-- Right: Smart Recommendation Assistant (5 cols) -->
        <div class="lg:col-span-5 space-y-4">
            <div class="bg-gradient-to-br from-slate-900 to-huit-blue text-white p-5 rounded-2xl shadow-md">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 rounded-lg bg-orange-500 flex items-center justify-center">
                        <i class="ti ti-robot text-lg text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-white">Trợ Lý Gợi Ý Giảng Viên Thông Minh</h2>
                        <span class="text-[11px] text-orange-200">Thuật toán phân tích chuyên môn & địa điểm di chuyển</span>
                    </div>
                </div>
                <p class="text-xs text-slate-300 mt-3 leading-relaxed">
                    Hệ thống sẽ tự động quét cơ sở dữ liệu để tìm giảng viên:
                    <br>&bull; Đúng chuyên môn với môn học.
                    <br>&bull; Không bị trùng giờ dạy.
                    <br>&bull; Ưu tiên giảng viên đã có mặt tại cơ sở trong ngày để tránh di chuyển xa.
                </p>
            </div>

            <!-- Suggestion Results Box -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-3">
                    <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                        <i class="ti ti-bulb text-amber-500 text-base"></i>
                        <span>Giảng Viên Được Đề Xuất</span>
                    </h3>
                    <span id="loadingIndicator" class="hidden text-xs text-huit-blue font-medium flex items-center">
                        <i class="ti ti-loader animate-spin mr-1"></i> Đang phân tích...
                    </span>
                </div>

                <div id="suggestionList" class="space-y-2.5 max-h-[480px] overflow-y-auto pr-1">
                    <div class="p-6 text-center text-xs text-slate-400 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                        <i class="ti ti-hand-click text-2xl text-slate-300 block mb-1"></i>
                        Vui lòng chọn <strong>Cơ sở</strong>, <strong>Thứ</strong>, <strong>Ca học</strong> và nhập <strong>Tên môn học</strong> để nhận gợi ý phân lịch tối ưu.
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- Client-side Smart Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const branchSelect = document.getElementById('branch_id');
    const subjectInput = document.getElementById('subject_name');
    const daySelect = document.getElementById('day_of_week');
    const shiftSelect = document.getElementById('shift_or_periods');
    const roomInput = document.getElementById('room');
    const teacherSelect = document.getElementById('teacher_id');
    
    const suggestionList = document.getElementById('suggestionList');
    const loadingIndicator = document.getElementById('loadingIndicator');
    const conflictAlertBox = document.getElementById('conflictAlertBox');
    const submitBtn = document.getElementById('submitBtn');

    let debounceTimer = null;

    function triggerSuggestions() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            fetchSuggestions();
            checkLiveConflicts();
        }, 300);
    }

    branchSelect.addEventListener('change', triggerSuggestions);
    subjectInput.addEventListener('input', triggerSuggestions);
    daySelect.addEventListener('change', triggerSuggestions);
    shiftSelect.addEventListener('change', triggerSuggestions);
    roomInput.addEventListener('input', checkLiveConflicts);
    teacherSelect.addEventListener('change', checkLiveConflicts);

    function fetchSuggestions() {
        const branchId = branchSelect.value;
        const subjectName = subjectInput.value.trim();
        const dayOfWeek = daySelect.value;
        const shift = shiftSelect.value;

        if (!branchId || !shift) {
            return;
        }

        loadingIndicator.classList.remove('hidden');

        const params = new URLSearchParams({
            branch_id: branchId,
            subject_name: subjectName,
            day_of_week: dayOfWeek,
            shift: shift
        });

        fetch('/api/suggest-teachers?' + params.toString())
            .then(res => res.json())
            .then(res => {
                loadingIndicator.classList.add('hidden');
                if (res.success && res.data.length > 0) {
                    renderSuggestions(res.data);
                } else {
                    suggestionList.innerHTML = `
                        <div class="p-4 text-center text-xs text-slate-500 bg-slate-50 rounded-xl">
                            Không tìm thấy gợi ý phù hợp.
                        </div>`;
                }
            })
            .catch(err => {
                loadingIndicator.classList.add('hidden');
                console.error(err);
            });
    }

    function renderSuggestions(teachers) {
        let html = '';
        teachers.forEach(item => {
            const t = item.teacher;
            const isAvail = item.is_available;

            html += `
                <div class="p-3 rounded-xl border transition ${isAvail ? 'bg-white border-slate-200 hover:border-huit-blue shadow-xs' : 'bg-slate-50 border-slate-100 opacity-60'}">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <div class="font-bold text-xs text-slate-800">${escapeHtml(t.full_name)}</div>
                            <div class="text-[11px] text-slate-500">Chuyên môn: <span class="font-medium text-slate-700">${escapeHtml(t.expertise)}</span></div>
                        </div>
                        ${isAvail ? `
                            <button type="button" onclick="selectTeacher(${t.id})" class="px-2.5 py-1 bg-huit-blue hover:bg-huit-dark text-white text-[11px] font-semibold rounded-lg transition flex items-center space-x-1 flex-shrink-0">
                                <i class="ti ti-plus"></i>
                                <span>Chọn GV</span>
                            </button>
                        ` : `
                            <span class="text-[10px] font-bold text-red-600 bg-red-50 border border-red-200 px-2 py-0.5 rounded">Trùng lịch</span>
                        `}
                    </div>

                    <div class="mt-2 text-[11px] flex items-center">
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold border ${item.badge_class}">
                            ${item.badge_text || (isAvail ? 'Khả dụng' : 'Bận lịch')}
                        </span>
                    </div>
                    <div class="text-[10px] text-slate-500 mt-1 italic">
                        ${escapeHtml(item.reason)}
                    </div>
                </div>
            `;
        });

        suggestionList.innerHTML = html;
    }

    window.selectTeacher = function(id) {
        teacherSelect.value = id;
        checkLiveConflicts();
    };

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
            shift: shift
        });

        fetch('/api/check-conflicts?' + params.toString())
            .then(res => res.json())
            .then(data => {
                if (data.has_conflict) {
                    conflictAlertBox.className = 'p-4 rounded-xl text-xs space-y-1.5 bg-red-50 border border-red-200 text-red-800';
                    conflictAlertBox.innerHTML = `
                        <div class="font-bold flex items-center text-red-700">
                            <i class="ti ti-alert-circle text-base mr-1.5"></i>
                            Phát hiện xung đột lịch dạy (Không thể lưu):
                        </div>
                        ${data.conflicts.map(c => `<div>&bull; ${escapeHtml(c)}</div>`).join('')}
                    `;
                    conflictAlertBox.classList.remove('hidden');
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                } else if (data.has_warning) {
                    conflictAlertBox.className = 'p-4 rounded-xl text-xs space-y-1.5 bg-amber-50 border border-amber-200 text-amber-800';
                    conflictAlertBox.innerHTML = `
                        <div class="font-bold flex items-center text-amber-700">
                            <i class="ti ti-alert-triangle text-base mr-1.5"></i>
                            Cảnh báo phân bổ / Di chuyển cơ sở:
                        </div>
                        ${data.warnings.map(w => `<div>&bull; ${escapeHtml(w)}</div>`).join('')}
                    `;
                    conflictAlertBox.classList.remove('hidden');
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    conflictAlertBox.className = 'p-3 rounded-xl text-xs bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center';
                    conflictAlertBox.innerHTML = `
                        <i class="ti ti-circle-check text-base text-emerald-600 mr-1.5"></i>
                        <span>Phòng học và Giảng viên hoàn toàn trống lịch. Lịch dạy hợp lệ tối ưu!</span>
                    `;
                    conflictAlertBox.classList.remove('hidden');
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            })
            .catch(err => console.error(err));
    }

    function escapeHtml(text) {
        if (!text) return '';
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }
});
</script>

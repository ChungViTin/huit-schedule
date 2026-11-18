<?php
$pageTitle = 'Quản lý Giảng viên - HUIT Schedule Hub';
?>

<div class="space-y-6">

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-800 tracking-tight flex items-center space-x-2">
                <i class="ti ti-users text-huit-header"></i>
                <span>Danh Sách Giảng Viên</span>
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">Quản lý hồ sơ giảng viên, chuyên môn chính và tài khoản tra cứu</p>
        </div>
        <div>
            <!-- Nút mở Pop-up Thêm Mới -->
            <button type="button" onclick="openCreateTeacherModal()" class="inline-flex items-center space-x-1.5 px-4 py-2 bg-huit-header hover:bg-blue-800 text-white font-bold text-xs rounded-xl shadow-xs transition">
                <i class="ti ti-user-plus"></i>
                <span>Thêm Giảng Viên Mới (Pop-up)</span>
            </button>
        </div>
    </div>

    <!-- Teachers Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase tracking-wider text-[11px]">
                        <th class="p-3.5">Họ và Tên Giảng Viên</th>
                        <th class="p-3.5">Email (Tài khoản)</th>
                        <th class="p-3.5">Số Điện Thoại</th>
                        <th class="p-3.5">Chuyên Môn Chính</th>
                        <th class="p-3.5 text-center">Số Ca Dạy</th>
                        <th class="p-3.5 text-right">Thao Tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($teachers)): ?>
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400">
                                <i class="ti ti-user-off text-3xl block mb-2 text-slate-300"></i>
                                Chưa có giảng viên nào trong hệ thống.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($teachers as $t): ?>
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="p-3.5 font-bold text-slate-800 flex items-center space-x-2.5">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-huit-header flex items-center justify-center font-extrabold text-xs shadow-xs">
                                        <?= mb_substr($t['full_name'], 0, 1) ?>
                                    </div>
                                    <span><?= htmlspecialchars($t['full_name']) ?></span>
                                </td>
                                <td class="p-3.5 font-mono text-slate-600 text-[11px]">
                                    <?= htmlspecialchars($t['email']) ?>
                                </td>
                                <td class="p-3.5 text-slate-600 font-mono text-[11px]">
                                    <?= htmlspecialchars($t['phone']) ?>
                                </td>
                                <td class="p-3.5">
                                    <span class="inline-block px-2.5 py-1 bg-blue-50 text-huit-header border border-blue-200 rounded-lg font-semibold text-[11px]">
                                        <?= htmlspecialchars($t['expertise']) ?>
                                    </span>
                                </td>
                                <td class="p-3.5 text-center">
                                    <a href="/timetable?teacher_id=<?= $t['id'] ?>" class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-full text-[11px] font-bold <?= (int)$t['schedule_count'] > 0 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-500' ?> transition" title="Xem thời khóa biểu">
                                        <span><?= (int)$t['schedule_count'] ?> ca</span>
                                        <i class="ti ti-calendar text-[10px]"></i>
                                    </a>
                                </td>
                                <td class="p-3.5 text-right">
                                    <div class="inline-flex items-center space-x-1">
                                        <!-- Nút Sửa Pop-up -->
                                        <button type="button" onclick='openEditTeacherModal(<?= json_encode($t, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)' class="p-1.5 text-slate-500 hover:text-huit-header hover:bg-blue-50 rounded-lg transition" title="Chỉnh sửa (Pop-up)">
                                            <i class="ti ti-edit text-base"></i>
                                        </button>
                                        <!-- Nút Xóa Pop-up -->
                                        <button type="button" onclick="openDeleteTeacherModal(<?= (int)$t['id'] ?>, '<?= htmlspecialchars(addslashes($t['full_name'])) ?>')" class="p-1.5 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Xóa (Pop-up)">
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

<!-- 1. MODAL POP-UP: THÊM GIẢNG VIÊN MỚI -->
<div id="createTeacherModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity">
    <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-lg overflow-hidden transform transition-all scale-95 duration-200" id="createTeacherModalBox">
        
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <h3 class="text-sm font-bold text-slate-800 flex items-center space-x-2">
                <i class="ti ti-user-plus text-huit-header text-lg"></i>
                <span>Thêm Giảng Viên Mới</span>
            </h3>
            <button type="button" onclick="closeCreateTeacherModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                <i class="ti ti-x text-lg"></i>
            </button>
        </div>

        <form action="/teachers" method="POST" class="p-6 space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Họ và Tên Giảng Viên <span class="text-red-500">*</span></label>
                <input type="text" name="full_name" required placeholder="Ví dụ: TS. Nguyễn Văn A" class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-header">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" required placeholder="gv.a@huit.edu.vn" class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-header">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Số Điện Thoại <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" required placeholder="0901234567" class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-header">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Chuyên Môn Chính <span class="text-red-500">*</span></label>
                <input type="text" name="expertise" required placeholder="Ví dụ: Công nghệ phần mềm, Khoa học dữ liệu..." class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-header">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Mật khẩu ban đầu</label>
                <input type="password" name="password" placeholder="Mặc định: 123456" class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-header">
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end space-x-2">
                <button type="button" onclick="closeCreateTeacherModal()" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-50">Hủy</button>
                <button type="submit" class="px-5 py-2 bg-huit-header hover:bg-blue-800 text-white text-xs font-bold rounded-xl shadow-xs">Lưu Giảng Viên</button>
            </div>
        </form>
    </div>
</div>

<!-- 2. MODAL POP-UP: SỬA GIẢNG VIÊN -->
<div id="editTeacherModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity">
    <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-lg overflow-hidden transform transition-all scale-95 duration-200" id="editTeacherModalBox">
        
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <h3 class="text-sm font-bold text-slate-800 flex items-center space-x-2">
                <i class="ti ti-edit text-huit-header text-lg"></i>
                <span>Chỉnh Sửa Giảng Viên</span>
            </h3>
            <button type="button" onclick="closeEditTeacherModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                <i class="ti ti-x text-lg"></i>
            </button>
        </div>

        <form id="editTeacherForm" method="POST" class="p-6 space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Họ và Tên Giảng Viên <span class="text-red-500">*</span></label>
                <input type="text" id="edit_full_name" name="full_name" required class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-header">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" id="edit_email" name="email" required class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-header">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Số Điện Thoại <span class="text-red-500">*</span></label>
                    <input type="text" id="edit_phone" name="phone" required class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-header">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Chuyên Môn Chính <span class="text-red-500">*</span></label>
                <input type="text" id="edit_expertise" name="expertise" required class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-header">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Đổi Mật Khẩu (Để trống nếu giữ nguyên)</label>
                <input type="password" id="edit_password" name="password" placeholder="Nhập mật khẩu mới..." class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-header">
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end space-x-2">
                <button type="button" onclick="closeEditTeacherModal()" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-50">Hủy</button>
                <button type="submit" class="px-5 py-2 bg-huit-header hover:bg-blue-800 text-white text-xs font-bold rounded-xl shadow-xs">Cập Nhật</button>
            </div>
        </form>
    </div>
</div>

<!-- 3. MODAL POP-UP: XÁC NHẬN XÓA GIẢNG VIÊN -->
<div id="deleteTeacherModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity">
    <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-sm overflow-hidden p-6 text-center transform transition-all scale-95 duration-200" id="deleteTeacherModalBox">
        <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-2xl mx-auto mb-3">
            <i class="ti ti-alert-triangle"></i>
        </div>
        <h3 class="text-sm font-bold text-slate-800">Xác Nhận Xóa Giảng Viên</h3>
        <p class="text-xs text-slate-500 mt-1.5" id="deleteTeacherNameText">Bạn có chắc chắn muốn xóa giảng viên này không?</p>
        <p class="text-[11px] text-red-500 mt-1 italic">Các lịch giảng dạy liên quan sẽ bị xóa theo.</p>

        <form id="deleteTeacherForm" method="POST" class="mt-5 flex items-center justify-center space-x-2">
            <button type="button" onclick="closeDeleteTeacherModal()" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-50">Hủy</button>
            <button type="submit" class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl shadow-xs">Xóa Ngay</button>
        </form>
    </div>
</div>

<!-- JAVASCRIPT ĐIỀU KHIỂN POP-UP MODAL -->
<script>
function openCreateTeacherModal() {
    const modal = document.getElementById('createTeacherModal');
    const box = document.getElementById('createTeacherModalBox');
    modal.classList.remove('hidden');
    setTimeout(() => box.classList.remove('scale-95'), 10);
}

function closeCreateTeacherModal() {
    const modal = document.getElementById('createTeacherModal');
    const box = document.getElementById('createTeacherModalBox');
    box.classList.add('scale-95');
    setTimeout(() => modal.classList.add('hidden'), 150);
}

function openEditTeacherModal(teacher) {
    document.getElementById('editTeacherForm').action = '/teachers/' + teacher.id + '/edit';
    document.getElementById('edit_full_name').value = teacher.full_name;
    document.getElementById('edit_email').value = teacher.email;
    document.getElementById('edit_phone').value = teacher.phone;
    document.getElementById('edit_expertise').value = teacher.expertise;
    document.getElementById('edit_password').value = '';

    const modal = document.getElementById('editTeacherModal');
    const box = document.getElementById('editTeacherModalBox');
    modal.classList.remove('hidden');
    setTimeout(() => box.classList.remove('scale-95'), 10);
}

function closeEditTeacherModal() {
    const modal = document.getElementById('editTeacherModal');
    const box = document.getElementById('editTeacherModalBox');
    box.classList.add('scale-95');
    setTimeout(() => modal.classList.add('hidden'), 150);
}

function openDeleteTeacherModal(id, name) {
    document.getElementById('deleteTeacherForm').action = '/teachers/' + id + '/delete';
    document.getElementById('deleteTeacherNameText').innerText = 'Bạn có chắc chắn muốn xóa: ' + name + '?';

    const modal = document.getElementById('deleteTeacherModal');
    const box = document.getElementById('deleteTeacherModalBox');
    modal.classList.remove('hidden');
    setTimeout(() => box.classList.remove('scale-95'), 10);
}

function closeDeleteTeacherModal() {
    const modal = document.getElementById('deleteTeacherModal');
    const box = document.getElementById('deleteTeacherModalBox');
    box.classList.add('scale-95');
    setTimeout(() => modal.classList.add('hidden'), 150);
}

// Bấm phím ESC để đóng pop-up
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeCreateTeacherModal();
        closeEditTeacherModal();
        closeDeleteTeacherModal();
    }
});
</script>

<?php
$pageTitle = 'Quản lý Cơ sở Đào tạo - HUIT Schedule Hub';
?>

<div class="space-y-6">

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-800 tracking-tight flex items-center space-x-2">
                <i class="ti ti-building-community text-huit-header"></i>
                <span>Cơ Sở Đào Tạo HUIT</span>
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">Danh sách các cơ sở trường học và trung tâm thực hành</p>
        </div>
        <div>
            <button type="button" onclick="openCreateBranchModal()" class="inline-flex items-center space-x-1.5 px-4 py-2 bg-huit-header hover:bg-blue-800 text-white font-bold text-xs rounded-xl shadow-xs transition">
                <i class="ti ti-plus"></i>
                <span>Thêm Cơ Sở Mới (Pop-up)</span>
            </button>
        </div>
    </div>

    <!-- Branches Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <?php foreach ($branches as $idx => $b): ?>
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 hover:shadow-md hover:border-huit-header transition flex flex-col justify-between group">
                <div>
                    <div class="flex items-start justify-between mb-3">
                        <div class="w-11 h-11 rounded-xl bg-blue-50 text-huit-header flex items-center justify-center text-xl group-hover:scale-105 transition-transform">
                            <i class="ti ti-building"></i>
                        </div>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">
                            Cơ sở #<?= $b['id'] ?>
                        </span>
                    </div>
                    <h3 class="text-sm font-bold text-slate-800 group-hover:text-huit-header transition leading-snug">
                        <?= htmlspecialchars($b['branch_name']) ?>
                    </h3>
                    <p class="text-xs text-slate-500 mt-2 flex items-start space-x-1.5">
                        <i class="ti ti-map-pin text-orange-500 mt-0.5 flex-shrink-0"></i>
                        <span><?= htmlspecialchars($b['address']) ?></span>
                    </p>
                </div>

                <div class="mt-5 pt-3.5 border-t border-slate-100 flex items-center justify-between text-xs">
                    <a href="/timetable?branch_id=<?= $b['id'] ?>" class="text-huit-header font-bold hover:underline flex items-center space-x-1">
                        <span><?= (int)$b['schedule_count'] ?> lịch học</span>
                        <i class="ti ti-calendar text-[11px]"></i>
                    </a>
                    <div class="flex items-center space-x-1">
                        <!-- Nút Sửa Pop-up -->
                        <button type="button" onclick='openEditBranchModal(<?= json_encode($b, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)' class="p-1.5 text-slate-400 hover:text-huit-header hover:bg-blue-50 rounded-lg transition" title="Chỉnh sửa (Pop-up)">
                            <i class="ti ti-edit text-base"></i>
                        </button>
                        <!-- Nút Xóa Pop-up -->
                        <button type="button" onclick="openDeleteBranchModal(<?= (int)$b['id'] ?>, '<?= htmlspecialchars(addslashes($b['branch_name'])) ?>')" class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Xóa (Pop-up)">
                            <i class="ti ti-trash text-base"></i>
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<!-- 1. MODAL POP-UP: THÊM CƠ SỞ -->
<div id="createBranchModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity">
    <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-md overflow-hidden transform transition-all scale-95 duration-200" id="createBranchModalBox">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <h3 class="text-sm font-bold text-slate-800 flex items-center space-x-2">
                <i class="ti ti-building-plus text-huit-header text-lg"></i>
                <span>Thêm Cơ Sở Đào Tạo Mới</span>
            </h3>
            <button type="button" onclick="closeCreateBranchModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                <i class="ti ti-x text-lg"></i>
            </button>
        </div>

        <form action="/branches" method="POST" class="p-6 space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Tên Cơ Sở <span class="text-red-500">*</span></label>
                <input type="text" name="branch_name" required placeholder="Ví dụ: Cơ sở Tân Bình, Trung tâm Thực hành..." class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-header">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Địa Chỉ <span class="text-red-500">*</span></label>
                <input type="text" name="address" required placeholder="Ví dụ: 140 Lê Trọng Tấn, P. Tây Thạnh, Q. Tân Phú..." class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-header">
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end space-x-2">
                <button type="button" onclick="closeCreateBranchModal()" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-50">Hủy</button>
                <button type="submit" class="px-5 py-2 bg-huit-header hover:bg-blue-800 text-white text-xs font-bold rounded-xl shadow-xs">Lưu Cơ Sở</button>
            </div>
        </form>
    </div>
</div>

<!-- 2. MODAL POP-UP: SỬA CƠ SỞ -->
<div id="editBranchModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity">
    <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-md overflow-hidden transform transition-all scale-95 duration-200" id="editBranchModalBox">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <h3 class="text-sm font-bold text-slate-800 flex items-center space-x-2">
                <i class="ti ti-edit text-huit-header text-lg"></i>
                <span>Chỉnh Sửa Cơ Sở Đào Tạo</span>
            </h3>
            <button type="button" onclick="closeEditBranchModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                <i class="ti ti-x text-lg"></i>
            </button>
        </div>

        <form id="editBranchForm" method="POST" class="p-6 space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Tên Cơ Sở <span class="text-red-500">*</span></label>
                <input type="text" id="edit_branch_name" name="branch_name" required class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-header">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Địa Chỉ <span class="text-red-500">*</span></label>
                <input type="text" id="edit_branch_address" name="address" required class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-header">
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end space-x-2">
                <button type="button" onclick="closeEditBranchModal()" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-50">Hủy</button>
                <button type="submit" class="px-5 py-2 bg-huit-header hover:bg-blue-800 text-white text-xs font-bold rounded-xl shadow-xs">Cập Nhật</button>
            </div>
        </form>
    </div>
</div>

<!-- 3. MODAL POP-UP: XÁC NHẬN XÓA CƠ SỞ -->
<div id="deleteBranchModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity">
    <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-sm overflow-hidden p-6 text-center transform transition-all scale-95 duration-200" id="deleteBranchModalBox">
        <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-2xl mx-auto mb-3">
            <i class="ti ti-alert-triangle"></i>
        </div>
        <h3 class="text-sm font-bold text-slate-800">Xác Nhận Xóa Cơ Sở</h3>
        <p class="text-xs text-slate-500 mt-1.5" id="deleteBranchNameText">Bạn có chắc chắn muốn xóa cơ sở này?</p>
        <p class="text-[11px] text-red-500 mt-1 italic">Các lịch giảng dạy tại cơ sở này sẽ bị xóa theo.</p>

        <form id="deleteBranchForm" method="POST" class="mt-5 flex items-center justify-center space-x-2">
            <button type="button" onclick="closeDeleteBranchModal()" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-50">Hủy</button>
            <button type="submit" class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl shadow-xs">Xóa Ngay</button>
        </form>
    </div>
</div>

<script>
function openCreateBranchModal() {
    const modal = document.getElementById('createBranchModal');
    const box = document.getElementById('createBranchModalBox');
    modal.classList.remove('hidden');
    setTimeout(() => box.classList.remove('scale-95'), 10);
}

function closeCreateBranchModal() {
    const modal = document.getElementById('createBranchModal');
    const box = document.getElementById('createBranchModalBox');
    box.classList.add('scale-95');
    setTimeout(() => modal.classList.add('hidden'), 150);
}

function openEditBranchModal(branch) {
    document.getElementById('editBranchForm').action = '/branches/' + branch.id + '/edit';
    document.getElementById('edit_branch_name').value = branch.branch_name;
    document.getElementById('edit_branch_address').value = branch.address;

    const modal = document.getElementById('editBranchModal');
    const box = document.getElementById('editBranchModalBox');
    modal.classList.remove('hidden');
    setTimeout(() => box.classList.remove('scale-95'), 10);
}

function closeEditBranchModal() {
    const modal = document.getElementById('editBranchModal');
    const box = document.getElementById('editBranchModalBox');
    box.classList.add('scale-95');
    setTimeout(() => modal.classList.add('hidden'), 150);
}

function openDeleteBranchModal(id, name) {
    document.getElementById('deleteBranchForm').action = '/branches/' + id + '/delete';
    document.getElementById('deleteBranchNameText').innerText = 'Bạn có chắc chắn muốn xóa: ' + name + '?';

    const modal = document.getElementById('deleteBranchModal');
    const box = document.getElementById('deleteBranchModalBox');
    modal.classList.remove('hidden');
    setTimeout(() => box.classList.remove('scale-95'), 10);
}

function closeDeleteBranchModal() {
    const modal = document.getElementById('deleteBranchModal');
    const box = document.getElementById('deleteBranchModalBox');
    box.classList.add('scale-95');
    setTimeout(() => modal.classList.add('hidden'), 150);
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeCreateBranchModal();
        closeEditBranchModal();
        closeDeleteBranchModal();
    }
});
</script>

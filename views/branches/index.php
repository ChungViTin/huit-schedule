<?php
$pageTitle = 'Quản lý Cơ sở Đào tạo - HUIT Schedule Hub';
?>

<div class="space-y-6">

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight flex items-center space-x-2">
                <i class="ti ti-building-community text-huit-blue"></i>
                <span>Cơ Sở Đào Tạo HUIT</span>
            </h1>
            <p class="text-sm text-slate-500 mt-0.5">Danh sách các cơ sở trường học và trung tâm thực hành</p>
        </div>
        <div>
            <a href="/branches/create" class="inline-flex items-center space-x-1.5 px-4 py-2.5 bg-huit-blue hover:bg-huit-dark text-white font-semibold text-xs rounded-xl shadow-sm hover:shadow transition">
                <i class="ti ti-plus"></i>
                <span>Thêm Cơ Sở Mới</span>
            </a>
        </div>
    </div>

    <!-- Branches Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php foreach ($branches as $b): ?>
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-huit-blue flex items-center justify-center text-xl mb-3">
                            <i class="ti ti-building"></i>
                        </div>
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">
                            ID: #<?= $b['id'] ?>
                        </span>
                    </div>
                    <h3 class="text-base font-bold text-slate-800"><?= htmlspecialchars($b['branch_name']) ?></h3>
                    <p class="text-xs text-slate-500 mt-1 flex items-start space-x-1">
                        <i class="ti ti-map-pin text-slate-400 mt-0.5 flex-shrink-0"></i>
                        <span><?= htmlspecialchars($b['address']) ?></span>
                    </p>
                </div>

                <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                    <a href="/dashboard?branch_id=<?= $b['id'] ?>" class="text-huit-blue font-bold hover:underline flex items-center space-x-1">
                        <span><?= (int)$b['schedule_count'] ?> lịch học</span>
                        <i class="ti ti-arrow-right text-[11px]"></i>
                    </a>
                    <div class="flex items-center space-x-1">
                        <a href="/branches/<?= $b['id'] ?>/edit" class="p-1.5 text-slate-500 hover:text-huit-blue hover:bg-blue-50 rounded-lg transition" title="Chỉnh sửa">
                            <i class="ti ti-edit text-base"></i>
                        </a>
                        <form action="/branches/<?= $b['id'] ?>/delete" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa cơ sở này? Các lịch dạy liên quan sẽ bị xóa theo!');" class="inline">
                            <button type="submit" class="p-1.5 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Xóa">
                                <i class="ti ti-trash text-base"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>

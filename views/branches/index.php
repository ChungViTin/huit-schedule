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
            <a href="/branches/create" class="inline-flex items-center space-x-1.5 px-4 py-2 bg-huit-header hover:bg-blue-800 text-white font-bold text-xs rounded-xl shadow-xs transition">
                <i class="ti ti-plus"></i>
                <span>Thêm Cơ Sở Mới</span>
            </a>
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
                        <a href="/branches/<?= $b['id'] ?>/edit" class="p-1.5 text-slate-400 hover:text-huit-header hover:bg-blue-50 rounded-lg transition" title="Chỉnh sửa">
                            <i class="ti ti-edit text-base"></i>
                        </a>
                        <form action="/branches/<?= $b['id'] ?>/delete" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa cơ sở này?');" class="inline">
                            <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Xóa">
                                <i class="ti ti-trash text-base"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>

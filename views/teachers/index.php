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
            <a href="/teachers/create" class="inline-flex items-center space-x-1.5 px-4 py-2 bg-huit-header hover:bg-blue-800 text-white font-bold text-xs rounded-xl shadow-xs transition">
                <i class="ti ti-user-plus"></i>
                <span>Thêm Giảng Viên Mới</span>
            </a>
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
                                        <a href="/teachers/<?= $t['id'] ?>/edit" class="p-1.5 text-slate-500 hover:text-huit-header hover:bg-blue-50 rounded-lg transition" title="Chỉnh sửa">
                                            <i class="ti ti-edit text-base"></i>
                                        </a>
                                        <form action="/teachers/<?= $t['id'] ?>/delete" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa giảng viên này? Các lịch dạy liên quan sẽ bị xóa theo!');" class="inline">
                                            <button type="submit" class="p-1.5 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Xóa">
                                                <i class="ti ti-trash text-base"></i>
                                            </button>
                                        </form>
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

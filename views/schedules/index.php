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
?>

<div class="space-y-6">

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight flex items-center space-x-2">
                <i class="ti ti-calendar-event text-huit-blue"></i>
                <span>Danh Sách Lịch Giảng Dạy</span>
            </h1>
            <p class="text-sm text-slate-500 mt-0.5">Quản lý, tìm kiếm và điều chỉnh lịch học tập đa cơ sở</p>
        </div>
        <div>
            <a href="/schedules/create" class="inline-flex items-center space-x-1.5 px-4 py-2.5 bg-huit-orange hover:bg-orange-600 text-white font-semibold text-xs rounded-xl shadow-sm hover:shadow transition">
                <i class="ti ti-sparkles"></i>
                <span>Phân Lịch Thông Minh Mới</span>
            </a>
        </div>
    </div>

    <!-- Filters Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <form method="GET" action="/schedules" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3">
            
            <!-- Search Keyword -->
            <div>
                <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Tìm kiếm</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i class="ti ti-search text-xs"></i>
                    </span>
                    <input type="text" name="keyword" value="<?= htmlspecialchars($filters['keyword'] ?? '') ?>" 
                        placeholder="Môn, phòng, GV..." 
                        class="w-full pl-8 pr-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-huit-blue">
                </div>
            </div>

            <!-- Filter Branch -->
            <div>
                <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Cơ sở</label>
                <select name="branch_id" class="w-full py-2 px-3 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-huit-blue">
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
                <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Giảng viên</label>
                <select name="teacher_id" class="w-full py-2 px-3 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-huit-blue">
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
                <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Thứ</label>
                <select name="day_of_week" class="w-full py-2 px-3 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-huit-blue">
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
                <button type="submit" class="flex-1 py-2 px-3 bg-huit-blue hover:bg-huit-dark text-white text-xs font-semibold rounded-xl transition flex items-center justify-center space-x-1">
                    <i class="ti ti-filter"></i>
                    <span>Áp dụng</span>
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
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold uppercase tracking-wider">
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
                                Không tìm thấy lịch giảng dạy nào phù hợp với điều kiện tìm kiếm.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($schedules as $s): ?>
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="p-3.5 font-bold text-slate-800">
                                    <?= htmlspecialchars($s['subject_name']) ?>
                                    <?php if (!empty($s['notes'])): ?>
                                        <span class="block text-[11px] font-normal text-slate-400 italic mt-0.5">
                                            <?= htmlspecialchars($s['notes']) ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="p-3.5">
                                    <div class="font-medium text-slate-800"><?= htmlspecialchars($s['teacher_name']) ?></div>
                                    <div class="text-[11px] text-slate-500"><?= htmlspecialchars($s['teacher_expertise']) ?></div>
                                </td>
                                <td class="p-3.5">
                                    <div class="font-medium text-huit-blue"><?= htmlspecialchars($s['branch_name']) ?></div>
                                    <div class="text-[11px] text-slate-500 truncate max-w-[220px]" title="<?= htmlspecialchars($s['branch_address']) ?>">
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
                                    <div class="text-[11px] text-orange-600 font-medium mt-0.5">
                                        <?= htmlspecialchars($s['shift_or_periods']) ?>
                                    </div>
                                </td>
                                <td class="p-3.5 text-right">
                                    <div class="inline-flex items-center space-x-1.5">
                                        <a href="/schedules/<?= $s['id'] ?>/edit" class="p-1.5 text-slate-500 hover:text-huit-blue hover:bg-blue-50 rounded-lg transition" title="Chỉnh sửa">
                                            <i class="ti ti-edit text-base"></i>
                                        </a>
                                        <form action="/schedules/<?= $s['id'] ?>/delete" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa lịch dạy này không?');" class="inline">
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

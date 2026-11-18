<?php
$pageTitle = 'Trang Chủ Tổng Quan & Sơ Đồ Phân Bổ - HUIT Schedule Hub';
?>

<div class="space-y-6">

    <!-- 1. HEADER PROFILE & KPI WIDGET (MÔ PHỎNG CHUẨN ẢNH 2) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 sm:p-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
            
            <!-- Avatar & Thông tin cán bộ quản trị -->
            <div class="lg:col-span-6 flex items-start sm:items-center space-x-4">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-gradient-to-tr from-huit-header to-sky-600 text-white flex items-center justify-center font-black text-2xl sm:text-3xl shadow-md flex-shrink-0">
                    <?= mb_substr($user['full_name'] ?? 'A', 0, 1) ?>
                </div>
                <div class="space-y-1">
                    <div class="flex items-center space-x-2">
                        <h1 class="text-base sm:text-lg font-extrabold text-slate-800">
                            <?= htmlspecialchars($user['full_name'] ?? 'Quản Trị Viên Đào Tạo') ?>
                        </h1>
                        <span class="bg-orange-100 text-orange-700 text-[10px] font-bold px-2 py-0.5 rounded-full border border-orange-200">
                            HUIT Admin
                        </span>
                    </div>
                    <div class="text-xs text-slate-500 space-y-0.5">
                        <p><span class="font-medium text-slate-700">Đơn vị:</span> Phòng Đào Tạo &bull; Trường ĐH Công Thương TP.HCM</p>
                        <p><span class="font-medium text-slate-700">Hệ thống:</span> Quản lý & Phân lịch giảng dạy đa cơ sở thông minh</p>
                    </div>
                </div>
            </div>

            <!-- Mini KPI Stats Box (Ảnh 2) -->
            <div class="lg:col-span-6 grid grid-cols-3 gap-3 text-center">
                <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Lịch Trong Tuần</span>
                    <span class="text-xl sm:text-2xl font-black text-huit-header"><?= $totalSchedules ?></span>
                    <span class="text-[10px] text-slate-500 block">ca học</span>
                </div>
                <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Giảng Viên</span>
                    <span class="text-xl sm:text-2xl font-black text-emerald-600"><?= $totalTeachers ?></span>
                    <span class="text-[10px] text-slate-500 block">thầy/cô</span>
                </div>
                <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Cơ Sở Hoạt Động</span>
                    <span class="text-xl sm:text-2xl font-black text-orange-600"><?= $totalBranches ?></span>
                    <span class="text-[10px] text-slate-500 block">cơ sở</span>
                </div>
            </div>

        </div>
    </div>

    <!-- 2. QUICK SHORTCUT ICONS BAR (CHUẨN ẢNH 2) -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
        
        <a href="/timetable" class="bg-white p-3.5 rounded-xl border border-slate-200 hover:border-huit-header hover:shadow-sm transition flex flex-col items-center text-center group">
            <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 group-hover:scale-110 transition-transform flex items-center justify-center text-xl mb-2">
                <i class="ti ti-calendar"></i>
            </div>
            <span class="text-xs font-bold text-slate-700 group-hover:text-huit-header">Lịch Theo Tuần</span>
            <span class="text-[10px] text-slate-400">Xem ma trận TKB</span>
        </a>

        <a href="/schedules/create" class="bg-white p-3.5 rounded-xl border border-slate-200 hover:border-orange-500 hover:shadow-sm transition flex flex-col items-center text-center group">
            <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 group-hover:scale-110 transition-transform flex items-center justify-center text-xl mb-2">
                <i class="ti ti-sparkles"></i>
            </div>
            <span class="text-xs font-bold text-slate-700 group-hover:text-orange-600">Phân Lịch Thông Minh</span>
            <span class="text-[10px] text-slate-400">Gợi ý AI & Chống trùng</span>
        </a>

        <a href="/schedules" class="bg-white p-3.5 rounded-xl border border-slate-200 hover:border-huit-header hover:shadow-sm transition flex flex-col items-center text-center group">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-huit-header group-hover:scale-110 transition-transform flex items-center justify-center text-xl mb-2">
                <i class="ti ti-list-details"></i>
            </div>
            <span class="text-xs font-bold text-slate-700 group-hover:text-huit-header">Quản Lý Lịch Dạy</span>
            <span class="text-[10px] text-slate-400">Danh sách CRUD</span>
        </a>

        <a href="/teachers" class="bg-white p-3.5 rounded-xl border border-slate-200 hover:border-emerald-600 hover:shadow-sm transition flex flex-col items-center text-center group">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 group-hover:scale-110 transition-transform flex items-center justify-center text-xl mb-2">
                <i class="ti ti-users"></i>
            </div>
            <span class="text-xs font-bold text-slate-700 group-hover:text-emerald-600">Hồ Sơ Giảng Viên</span>
            <span class="text-[10px] text-slate-400">12 Thầy/Cô</span>
        </a>

        <a href="/branches" class="bg-white p-3.5 rounded-xl border border-slate-200 hover:border-purple-600 hover:shadow-sm transition flex flex-col items-center text-center group">
            <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 group-hover:scale-110 transition-transform flex items-center justify-center text-xl mb-2">
                <i class="ti ti-building-community"></i>
            </div>
            <span class="text-xs font-bold text-slate-700 group-hover:text-purple-600">Cơ Sở Đào Tạo</span>
            <span class="text-[10px] text-slate-400">4 Cơ sở HUIT</span>
        </a>

        <a href="/portal" target="_blank" class="bg-white p-3.5 rounded-xl border border-slate-200 hover:border-teal-600 hover:shadow-sm transition flex flex-col items-center text-center group">
            <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 group-hover:scale-110 transition-transform flex items-center justify-center text-xl mb-2">
                <i class="ti ti-school"></i>
            </div>
            <span class="text-xs font-bold text-slate-700 group-hover:text-teal-600">Cổng Giảng Viên</span>
            <span class="text-[10px] text-slate-400">Tra cứu cá nhân</span>
        </a>

    </div>

    <!-- 2.5. THANH COMBO BOX BỘ LỌC DỮ LIỆU ĐA CHIỀU (CHUẨN HUIT) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4">
        <form method="GET" action="/dashboard" id="dashboardFilterForm" class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-xl bg-blue-50 text-huit-header flex items-center justify-center text-lg flex-shrink-0">
                    <i class="ti ti-adjustments-horizontal"></i>
                </div>
                <div>
                    <h3 class="text-xs font-bold text-slate-800 flex items-center space-x-1.5">
                        <span>Bộ Lọc Dữ Liệu & Phân Tích Thông Minh</span>
                        <span class="text-[10px] font-semibold text-sky-700 bg-sky-50 px-2 py-0.5 rounded-full border border-sky-200">
                            Hiển thị: <?= $totalSchedules ?> ca
                        </span>
                    </h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">Tự động cập nhật các biểu đồ và danh sách phân bổ theo tiêu chí</p>
                </div>
            </div>

            <!-- Các Combo Box lọc -->
            <div class="flex flex-wrap items-center gap-2.5">
                
                <!-- Combo Box 1: Học kỳ / Năm học (chuẩn HUIT Ảnh 2) -->
                <div class="flex items-center space-x-1.5">
                    <span class="text-[11px] font-bold text-slate-500 whitespace-nowrap"><i class="ti ti-school mr-0.5 text-slate-400"></i>Học kỳ:</span>
                    <select name="semester" onchange="this.form.submit()" class="text-xs font-bold text-slate-700 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-huit-header cursor-pointer shadow-xs hover:border-slate-300 transition">
                        <option value="HK2_2026_2027" <?= $selectedSemester === 'HK2_2026_2027' ? 'selected' : '' ?>>HK2 (2026 - 2027)</option>
                        <option value="HK1_2026_2027" <?= $selectedSemester === 'HK1_2026_2027' ? 'selected' : '' ?>>HK1 (2026 - 2027)</option>
                        <option value="HK_HE_2026_2027" <?= $selectedSemester === 'HK_HE_2026_2027' ? 'selected' : '' ?>>HK Hè (2026 - 2027)</option>
                    </select>
                </div>

                <!-- Combo Box 2: Cơ sở đào tạo -->
                <div class="flex items-center space-x-1.5">
                    <span class="text-[11px] font-bold text-slate-500 whitespace-nowrap"><i class="ti ti-building mr-0.5 text-slate-400"></i>Cơ sở:</span>
                    <select name="branch_id" onchange="this.form.submit()" class="text-xs font-semibold text-slate-700 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-huit-header cursor-pointer shadow-xs hover:border-slate-300 transition max-w-[210px] truncate">
                        <option value="">-- Tất cả cơ sở --</option>
                        <?php foreach ($branches as $b): ?>
                            <option value="<?= $b['id'] ?>" <?= $selectedBranchId == $b['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($b['branch_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Combo Box 3: Loại hình đào tạo (Lý thuyết / Thực hành) -->
                <div class="flex items-center space-x-1.5">
                    <span class="text-[11px] font-bold text-slate-500 whitespace-nowrap"><i class="ti ti-category mr-0.5 text-slate-400"></i>Loại ca:</span>
                    <select name="type" onchange="this.form.submit()" class="text-xs font-semibold text-slate-700 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-huit-header cursor-pointer shadow-xs hover:border-slate-300 transition">
                        <option value="">-- Tất cả loại hình --</option>
                        <option value="theory" <?= $selectedType === 'theory' ? 'selected' : '' ?>>📚 Lý thuyết (3 tiết)</option>
                        <option value="practice" <?= $selectedType === 'practice' ? 'selected' : '' ?>>💻 Thực hành (5 tiết)</option>
                    </select>
                </div>

                <!-- Combo Box 4: Thứ trong tuần -->
                <div class="flex items-center space-x-1.5">
                    <span class="text-[11px] font-bold text-slate-500 whitespace-nowrap"><i class="ti ti-calendar-time mr-0.5 text-slate-400"></i>Thứ:</span>
                    <select name="day_of_week" onchange="this.form.submit()" class="text-xs font-semibold text-slate-700 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-huit-header cursor-pointer shadow-xs hover:border-slate-300 transition">
                        <option value="">-- Tất cả các ngày --</option>
                        <option value="2" <?= $selectedDay === 2 ? 'selected' : '' ?>>Thứ 2</option>
                        <option value="3" <?= $selectedDay === 3 ? 'selected' : '' ?>>Thứ 3</option>
                        <option value="4" <?= $selectedDay === 4 ? 'selected' : '' ?>>Thứ 4</option>
                        <option value="5" <?= $selectedDay === 5 ? 'selected' : '' ?>>Thứ 5</option>
                        <option value="6" <?= $selectedDay === 6 ? 'selected' : '' ?>>Thứ 6</option>
                        <option value="7" <?= $selectedDay === 7 ? 'selected' : '' ?>>Thứ 7</option>
                        <option value="8" <?= $selectedDay === 8 ? 'selected' : '' ?>>Chủ nhật</option>
                    </select>
                </div>

                <!-- Nút Làm Mới / Bỏ lọc nếu có tham số -->
                <?php if ($selectedBranchId || $selectedType || $selectedDay || ($selectedSemester && $selectedSemester !== 'HK2_2026_2027')): ?>
                    <a href="/dashboard" class="inline-flex items-center space-x-1 px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold rounded-xl transition shadow-xs" title="Khôi phục mặc định">
                        <i class="ti ti-rotate"></i>
                        <span>Bỏ lọc</span>
                    </a>
                <?php endif; ?>

            </div>

        </form>
    </div>

    <!-- 3. CÁC SƠ ĐỒ VÀ BIỂU ĐỒ PHÂN BỔ THÔNG MINH (CHARTS SECTION) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- SƠ ĐỒ 1: Biểu đồ Cột phân bổ Lịch dạy theo từng Cơ sở (7 Cột) -->
        <div class="lg:col-span-7 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
                    <div>
                        <h2 class="text-sm font-bold text-slate-800 flex items-center space-x-2">
                            <i class="ti ti-chart-bar text-huit-header"></i>
                            <span>Sơ Đồ Phân Bổ Lịch Dạy Theo Cơ Sở</span>
                        </h2>
                        <p class="text-[11px] text-slate-400 mt-0.5">Tối ưu hóa thời gian di chuyển và mức độ hoạt động tại các cơ sở</p>
                    </div>
                    <span class="text-xs font-bold px-2 py-0.5 bg-blue-50 text-huit-header rounded-full border border-blue-200">
                        4 Cơ sở
                    </span>
                </div>

                <div class="h-64 relative">
                    <canvas id="branchChart"></canvas>
                </div>
            </div>

            <!-- Tóm tắt số liệu các cơ sở -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mt-4 pt-3 border-t border-slate-100 text-center">
                <?php foreach ($branches as $idx => $b): 
                    $count = $branchChartData[$idx] ?? 0;
                    $percent = $totalSchedules > 0 ? round(($count / $totalSchedules) * 100) : 0;
                ?>
                    <div class="p-2 rounded-lg bg-slate-50 border border-slate-100">
                        <span class="text-[10px] text-slate-500 font-medium truncate block" title="<?= htmlspecialchars($b['branch_name']) ?>">
                            <?= htmlspecialchars($b['branch_name']) ?>
                        </span>
                        <span class="text-xs font-bold text-huit-header block mt-0.5"><?= $count ?> ca (<?= $percent ?>%)</span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- SƠ ĐỒ 2: Donut Chart - Tỷ lệ Buổi học & Loại hình học tập (5 Cột) -->
        <div class="lg:col-span-5 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
                    <div>
                        <h2 class="text-sm font-bold text-slate-800 flex items-center space-x-2">
                            <i class="ti ti-chart-donut text-emerald-600"></i>
                            <span>Tỷ Lệ Phân Bổ Ca Học</span>
                        </h2>
                        <p class="text-[11px] text-slate-400 mt-0.5">Tỷ lệ theo buổi (Sáng/Chiều/Tối) & Thực hành</p>
                    </div>
                    <span class="text-xs font-bold px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded-full border border-emerald-200">
                        <?= $totalSchedules ?> Ca
                    </span>
                </div>

                <div class="h-56 relative flex items-center justify-center">
                    <canvas id="sessionDonutChart"></canvas>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100 space-y-2 text-xs">
                <div class="flex items-center justify-between text-slate-600">
                    <span class="flex items-center"><span class="w-3 h-3 rounded-full bg-sky-500 mr-2"></span>Ca Sáng (07:00 - 12:15):</span>
                    <strong class="text-slate-800"><?= $sessionCount['morning'] ?> ca</strong>
                </div>
                <div class="flex items-center justify-between text-slate-600">
                    <span class="flex items-center"><span class="w-3 h-3 rounded-full bg-emerald-500 mr-2"></span>Ca Chiều (13:00 - 18:15):</span>
                    <strong class="text-slate-800"><?= $sessionCount['afternoon'] ?> ca</strong>
                </div>
                <div class="flex items-center justify-between text-slate-600">
                    <span class="flex items-center"><span class="w-3 h-3 rounded-full bg-orange-500 mr-2"></span>Ca Tối (18:30 - 21:00):</span>
                    <strong class="text-slate-800"><?= $sessionCount['evening'] ?> ca</strong>
                </div>
            </div>
        </div>

    </div>

    <!-- 4. HÀNG SƠ ĐỒ THỨ 2: Mật độ các ngày trong tuần & Top Giảng viên -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- SƠ ĐỒ 3: Biểu đồ đường mật độ các ngày trong tuần -->
        <div class="lg:col-span-7 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
                <div>
                    <h2 class="text-sm font-bold text-slate-800 flex items-center space-x-2">
                        <i class="ti ti-chart-line text-sky-600"></i>
                        <span>Mật Độ Phân Bổ Lịch Dạy Theo Ngày Trong Tuần</span>
                    </h2>
                    <p class="text-[11px] text-slate-400 mt-0.5">Số ca học được xếp từ Thứ 2 đến Chủ nhật</p>
                </div>
                <a href="/timetable" class="text-xs text-huit-header font-bold hover:underline flex items-center">
                    <span>Xem TKB Tuần</span>
                    <i class="ti ti-arrow-right ml-1"></i>
                </a>
            </div>

            <div class="h-60 relative">
                <canvas id="dayOfWeekChart"></canvas>
            </div>
        </div>

        <!-- BẢNG TOP GIẢNG VIÊN CÓ NHIỀU TIẾT DẠY NHẤT -->
        <div class="lg:col-span-5 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-3">
                    <h2 class="text-sm font-bold text-slate-800 flex items-center space-x-2">
                        <i class="ti ti-trophy text-amber-500"></i>
                        <span>Giảng Viên Phân Công Nhiều Nhất</span>
                    </h2>
                    <a href="/teachers" class="text-xs text-slate-400 hover:text-huit-header">Tất cả</a>
                </div>

                <div class="divide-y divide-slate-100">
                    <?php foreach ($topTeachers as $idx => $t): ?>
                        <div class="py-2.5 flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <span class="w-6 h-6 rounded-full bg-slate-100 text-slate-600 font-bold text-xs flex items-center justify-center flex-shrink-0">
                                    <?= $idx + 1 ?>
                                </span>
                                <div>
                                    <div class="font-bold text-xs text-slate-800"><?= htmlspecialchars($t['full_name']) ?></div>
                                    <div class="text-[10px] text-slate-400"><?= htmlspecialchars($t['expertise']) ?></div>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-blue-50 text-huit-header border border-blue-200">
                                <?= (int)$t['schedule_count'] ?> ca dạy
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100 text-center">
                <a href="/schedules/create" class="inline-flex items-center justify-center space-x-1.5 w-full py-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-xs font-bold text-slate-700 rounded-xl transition">
                    <i class="ti ti-plus text-huit-header"></i>
                    <span>Tiếp Tục Phân Lịch Mới</span>
                </a>
            </div>
        </div>

    </div>

</div>

<!-- SCRIPT VẼ CHARTS BẰNG CHART.JS -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Sơ đồ Cột: Phân bổ theo Cơ sở
    const ctxBranch = document.getElementById('branchChart').getContext('2d');
    new Chart(ctxBranch, {
        type: 'bar',
        data: {
            labels: <?= json_encode($branchChartLabels, JSON_UNESCAPED_UNICODE) ?>,
            datasets: [{
                label: 'Số ca lịch dạy',
                data: <?= json_encode($branchChartData) ?>,
                backgroundColor: [
                    'rgba(0, 84, 166, 0.85)',
                    'rgba(16, 185, 129, 0.85)',
                    'rgba(147, 51, 234, 0.85)',
                    'rgba(245, 158, 11, 0.85)'
                ],
                borderRadius: 8,
                barThickness: 32
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 2 }
                }
            }
        }
    });

    // 2. Sơ đồ Donut: Phân bổ theo Buổi học
    const ctxSession = document.getElementById('sessionDonutChart').getContext('2d');
    new Chart(ctxSession, {
        type: 'doughnut',
        data: {
            labels: ['Ca Sáng', 'Ca Chiều', 'Ca Tối'],
            datasets: [{
                data: [
                    <?= (int)$sessionCount['morning'] ?>,
                    <?= (int)$sessionCount['afternoon'] ?>,
                    <?= (int)$sessionCount['evening'] ?>
                ],
                backgroundColor: ['#0284C7', '#10B981', '#F97316'],
                borderWidth: 3,
                borderColor: '#FFFFFF',
                cutout: '68%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // 3. Sơ đồ Line: Mật độ theo các ngày trong tuần
    const ctxDay = document.getElementById('dayOfWeekChart').getContext('2d');
    new Chart(ctxDay, {
        type: 'line',
        data: {
            labels: ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ nhật'],
            datasets: [{
                label: 'Số ca học',
                data: [
                    <?= (int)$dayOfWeekDistribution[2] ?>,
                    <?= (int)$dayOfWeekDistribution[3] ?>,
                    <?= (int)$dayOfWeekDistribution[4] ?>,
                    <?= (int)$dayOfWeekDistribution[5] ?>,
                    <?= (int)$dayOfWeekDistribution[6] ?>,
                    <?= (int)$dayOfWeekDistribution[7] ?>,
                    <?= (int)$dayOfWeekDistribution[8] ?>
                ],
                borderColor: '#0284C7',
                backgroundColor: 'rgba(2, 132, 199, 0.1)',
                tension: 0.35,
                fill: true,
                pointBackgroundColor: '#0284C7',
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

});
</script>

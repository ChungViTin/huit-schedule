<?php
$pageTitle = 'Trang Chủ - Cổng Thông Tin HUIT';
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

    <!-- 1. PHẦN PROFILE & STAT CARDS (CHUẨN THEO ẢNH 2) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-stretch">
        
        <!-- Cột trái: Thẻ thông tin sinh viên / giảng viên (Ảnh 2) -->
        <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex flex-col justify-between">
            <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-wider mb-3">
                <i class="ti ti-layout-grid text-base text-slate-400"></i>
                <span>Thông Tin Sinh Viên / Cán Bộ</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                <!-- Avatar sinh viên / cán bộ -->
                <div class="md:col-span-3 text-center flex flex-col items-center">
                    <div class="w-24 h-28 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden shadow-xs relative flex items-center justify-center">
                        <!-- Silhouette or user avatar -->
                        <div class="w-full h-full bg-gradient-to-b from-blue-100 to-sky-200 flex flex-col items-center justify-center text-huit-header">
                            <i class="ti ti-user text-4xl mb-1"></i>
                            <span class="text-[10px] font-bold">HUIT ID</span>
                        </div>
                    </div>
                    <a href="javascript:void(0)" class="text-[11px] text-huit-header font-semibold hover:underline mt-1.5">
                        Xem chi tiết
                    </a>
                </div>

                <!-- Cột thông tin 1 (Ảnh 2) -->
                <div class="md:col-span-5 space-y-1.5 text-xs text-slate-700">
                    <p><span class="text-slate-400 font-medium">MSSV:</span> <strong class="text-slate-900 font-mono">2001230817</strong></p>
                    <p><span class="text-slate-400 font-medium">Họ tên:</span> <strong class="text-slate-900"><?= htmlspecialchars($user['full_name'] ?? 'Chung Vĩ Tín') ?></strong></p>
                    <p><span class="text-slate-400 font-medium">Giới tính:</span> <strong class="text-slate-900">Nam</strong></p>
                    <p><span class="text-slate-400 font-medium">Ngày sinh:</span> <span class="text-slate-900 font-medium">04/11/2005</span></p>
                    <p><span class="text-slate-400 font-medium">Nơi sinh:</span> <span class="text-slate-900 font-medium">Thành phố Hồ Chí Minh</span></p>
                </div>

                <!-- Cột thông tin 2 (Ảnh 2) -->
                <div class="md:col-span-4 space-y-1.5 text-xs text-slate-700">
                    <p><span class="text-slate-400 font-medium">Lớp học:</span> <strong class="text-slate-900">14DHTH14</strong></p>
                    <p><span class="text-slate-400 font-medium">Khóa học:</span> <span class="text-slate-900 font-medium">2023</span></p>
                    <p><span class="text-slate-400 font-medium">Bậc đào tạo:</span> <span class="text-slate-900 font-medium">Đại học</span></p>
                    <p><span class="text-slate-400 font-medium">Loại hình đào tạo:</span> <span class="text-slate-900 font-medium">Chính quy</span></p>
                    <p><span class="text-slate-400 font-medium">Ngành:</span> <strong class="text-slate-900">Công nghệ thông tin</strong></p>
                </div>
            </div>

            <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span class="flex items-center text-emerald-600 font-medium">
                    <i class="ti ti-circle-check mr-1 text-sm"></i> Trạng thái học tập: Bình thường
                </span>
                <span class="text-[11px] text-slate-400">Học kỳ 2 (2026 - 2027)</span>
            </div>
        </div>

        <!-- Cột phải: 3 Card chỉ số chuẩn Ảnh 2 -->
        <div class="lg:col-span-4 flex flex-col justify-between space-y-3">
            
            <!-- Card 1: Nhắc nhở mới, chưa xem (Ảnh 2) -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 flex items-center justify-between">
                <div>
                    <span class="text-xs text-slate-500 font-medium block">Nhắc nhở mới, chưa xem</span>
                    <span class="text-3xl font-black text-slate-800 block mt-1">0</span>
                    <a href="javascript:void(0)" class="text-[11px] text-slate-400 hover:text-huit-header font-medium mt-1 inline-block">
                        Xem chi tiết
                    </a>
                </div>
                <div class="w-12 h-12 rounded-full border border-slate-200 text-slate-400 flex items-center justify-center text-xl shadow-xs">
                    <i class="ti ti-bell"></i>
                </div>
            </div>

            <!-- Card 2: Lịch học trong tuần (Ảnh 2) -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 flex items-center justify-between">
                <div>
                    <span class="text-xs text-slate-500 font-medium block">Lịch học trong tuần</span>
                    <span class="text-3xl font-black text-sky-600 block mt-1"><?= $totalSchedules ?></span>
                    <a href="/timetable" class="text-[11px] text-sky-600 hover:underline font-semibold mt-1 inline-block">
                        Xem chi tiết &raquo;
                    </a>
                </div>
                <div class="w-12 h-12 rounded-full border border-sky-200 text-sky-500 bg-sky-50 flex items-center justify-center text-xl shadow-xs">
                    <i class="ti ti-calendar-event"></i>
                </div>
            </div>

            <!-- Card 3: Lịch thi trong tuần (Ảnh 2) -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 flex items-center justify-between">
                <div>
                    <span class="text-xs text-slate-500 font-medium block">Lịch thi trong tuần</span>
                    <span class="text-3xl font-black text-amber-500 block mt-1">0</span>
                    <a href="javascript:void(0)" class="text-[11px] text-slate-400 hover:text-amber-600 font-medium mt-1 inline-block">
                        Xem chi tiết
                    </a>
                </div>
                <div class="w-12 h-12 rounded-full border border-amber-200 text-amber-500 bg-amber-50 flex items-center justify-center text-xl shadow-xs">
                    <i class="ti ti-calendar-time"></i>
                </div>
            </div>

        </div>

    </div>

    <!-- 2. HÀNG 10 NÚT SHORTCUT THAO TÁC NHANH (CHUẨN ẢNH 2) -->
    <div class="grid grid-cols-2 sm:grid-cols-5 lg:grid-cols-10 gap-2.5">
        
        <!-- 1. Kết quả học tập -->
        <a href="javascript:void(0)" class="bg-white p-3 rounded-xl border border-slate-200 hover:border-huit-header hover:shadow-xs transition flex flex-col items-center justify-center text-center group h-24">
            <i class="ti ti-chart-arrows text-2xl text-sky-600 group-hover:scale-110 transition-transform mb-1.5"></i>
            <span class="text-[11px] font-semibold text-slate-700 group-hover:text-huit-header leading-tight">Kết quả<br>học tập</span>
        </a>

        <!-- 2. Lịch theo tuần (Dẫn sang trang lịch riêng biệt Ảnh 3) -->
        <a href="/timetable" class="bg-white p-3 rounded-xl border border-sky-300 bg-sky-50/30 hover:border-huit-header hover:shadow-xs transition flex flex-col items-center justify-center text-center group h-24">
            <i class="ti ti-calendar-event text-2xl text-sky-600 group-hover:scale-110 transition-transform mb-1.5"></i>
            <span class="text-[11px] font-bold text-sky-900 group-hover:text-huit-header leading-tight">Lịch theo<br>tuần</span>
        </a>

        <!-- 3. Lịch theo tiến độ -->
        <a href="javascript:void(0)" class="bg-white p-3 rounded-xl border border-slate-200 hover:border-huit-header hover:shadow-xs transition flex flex-col items-center justify-center text-center group h-24">
            <i class="ti ti-file-text text-2xl text-sky-600 group-hover:scale-110 transition-transform mb-1.5"></i>
            <span class="text-[11px] font-semibold text-slate-700 group-hover:text-huit-header leading-tight">Lịch theo<br>tiến độ</span>
        </a>

        <!-- 4. Chương trình khung -->
        <a href="javascript:void(0)" class="bg-white p-3 rounded-xl border border-slate-200 hover:border-huit-header hover:shadow-xs transition flex flex-col items-center justify-center text-center group h-24">
            <i class="ti ti-database text-2xl text-sky-600 group-hover:scale-110 transition-transform mb-1.5"></i>
            <span class="text-[11px] font-semibold text-slate-700 group-hover:text-huit-header leading-tight">Chương trình<br>khung</span>
        </a>

        <!-- 5. Đăng ký học phần / Phân lịch -->
        <a href="/schedules/create" class="bg-white p-3 rounded-xl border border-slate-200 hover:border-orange-500 hover:shadow-xs transition flex flex-col items-center justify-center text-center group h-24">
            <i class="ti ti-stack-2 text-2xl text-orange-500 group-hover:scale-110 transition-transform mb-1.5"></i>
            <span class="text-[11px] font-semibold text-slate-700 group-hover:text-orange-600 leading-tight">Đăng ký<br>học phần</span>
        </a>

        <!-- 6. Tra cứu công nợ -->
        <a href="javascript:void(0)" class="bg-white p-3 rounded-xl border border-slate-200 hover:border-huit-header hover:shadow-xs transition flex flex-col items-center justify-center text-center group h-24">
            <i class="ti ti-currency-dollar text-2xl text-sky-600 group-hover:scale-110 transition-transform mb-1.5"></i>
            <span class="text-[11px] font-semibold text-slate-700 group-hover:text-huit-header leading-tight">Tra cứu<br>công nợ</span>
        </a>

        <!-- 7. Thanh toán trực tuyến -->
        <a href="javascript:void(0)" class="bg-white p-3 rounded-xl border border-slate-200 hover:border-huit-header hover:shadow-xs transition flex flex-col items-center justify-center text-center group h-24">
            <i class="ti ti-receipt-2 text-2xl text-sky-600 group-hover:scale-110 transition-transform mb-1.5"></i>
            <span class="text-[11px] font-semibold text-slate-700 group-hover:text-huit-header leading-tight">Thanh toán<br>trực tuyến</span>
        </a>

        <!-- 8. Thanh toán nội trú -->
        <a href="javascript:void(0)" class="bg-white p-3 rounded-xl border border-slate-200 hover:border-huit-header hover:shadow-xs transition flex flex-col items-center justify-center text-center group h-24">
            <i class="ti ti-receipt-tax text-2xl text-sky-600 group-hover:scale-110 transition-transform mb-1.5"></i>
            <span class="text-[11px] font-semibold text-slate-700 group-hover:text-huit-header leading-tight">Thanh toán<br>nội trú</span>
        </a>

        <!-- 9. Phiếu thu tổng hợp -->
        <a href="javascript:void(0)" class="bg-white p-3 rounded-xl border border-slate-200 hover:border-huit-header hover:shadow-xs transition flex flex-col items-center justify-center text-center group h-24">
            <i class="ti ti-file-analytics text-2xl text-sky-600 group-hover:scale-110 transition-transform mb-1.5"></i>
            <span class="text-[11px] font-semibold text-slate-700 group-hover:text-huit-header leading-tight">Phiếu thu<br>tổng hợp</span>
        </a>

        <!-- 10. Hộp thư sinh viên -->
        <a href="javascript:void(0)" class="bg-white p-3 rounded-xl border border-slate-200 hover:border-huit-header hover:shadow-xs transition flex flex-col items-center justify-center text-center group h-24">
            <i class="ti ti-mail text-2xl text-sky-600 group-hover:scale-110 transition-transform mb-1.5"></i>
            <span class="text-[11px] font-semibold text-slate-700 group-hover:text-huit-header leading-tight">Hộp thư<br>sinh viên</span>
        </a>

    </div>

    <!-- 3. PHẦN 3 WIDGET CHUẨN ẢNH 2: Học tập, Tiến độ học tập & Lớp học phần -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-stretch">
        
        <!-- Widget 1: Học tập (Ảnh 2) -->
        <div class="lg:col-span-5 bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
                    <h3 class="text-sm font-bold text-slate-800">Học tập</h3>
                    <select class="text-xs bg-slate-50 border border-slate-200 rounded-lg px-2.5 py-1 text-slate-700 font-medium">
                        <option>HK2 (2026 - 2027)</option>
                        <option>HK1 (2026 - 2027)</option>
                    </select>
                </div>
                <div class="h-48 relative flex items-center justify-center">
                    <canvas id="studyOverviewChart"></canvas>
                </div>
            </div>
            <div class="text-[11px] text-slate-400 text-center mt-3 pt-2 border-t border-slate-100">
                Biểu đồ phân bổ tín chỉ & điểm trung bình tích lũy
            </div>
        </div>

        <!-- Widget 2: Tiến độ học tập (Vòng Donut xanh lá/xanh dương như Ảnh 2) -->
        <div class="lg:col-span-3 bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-3">
                    <h3 class="text-sm font-bold text-slate-800">Tiến độ học tập</h3>
                </div>
                <div class="h-48 relative flex items-center justify-center">
                    <canvas id="progressRingChart"></canvas>
                </div>
            </div>
            <div class="text-center mt-3 pt-2 border-t border-slate-100 text-xs">
                <span class="font-bold text-emerald-600">82%</span>
                <span class="text-slate-500 text-[11px]">hoàn thành chương trình</span>
            </div>
        </div>

        <!-- Widget 3: Lớp học phần (Ảnh 2) -->
        <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-3">
                    <h3 class="text-sm font-bold text-slate-800">Lớp học phần</h3>
                    <select class="text-xs bg-slate-50 border border-slate-200 rounded-lg px-2.5 py-1 text-slate-700 font-medium">
                        <option>HK2 (2026 - 2027)</option>
                        <option>HK1 (2026 - 2027)</option>
                    </select>
                </div>
                <div class="space-y-2 max-h-48 overflow-y-auto pr-1">
                    <?php if (empty($recentSchedules)): ?>
                        <div class="text-center py-8 text-xs text-slate-400">
                            Chưa có dữ liệu hiển thị
                        </div>
                    <?php else: ?>
                        <?php foreach (array_slice($recentSchedules, 0, 4) as $rs): ?>
                            <div class="p-2 rounded-xl bg-slate-50 border border-slate-100 text-xs flex items-center justify-between">
                                <div class="truncate mr-2">
                                    <strong class="text-slate-800 block truncate"><?= htmlspecialchars($rs['subject_name']) ?></strong>
                                    <span class="text-[10px] text-slate-500"><?= htmlspecialchars($rs['room']) ?> &bull; <?= htmlspecialchars($rs['teacher_name']) ?></span>
                                </div>
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold <?= ($rs['class_type'] ?? '') === 'practice' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' ?>">
                                    <?= ($rs['class_type'] ?? '') === 'practice' ? 'Thực hành' : 'Lý thuyết' ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="text-right mt-3 pt-2 border-t border-slate-100">
                <a href="/timetable" class="text-[11px] text-huit-header font-bold hover:underline">
                    Xem thời khóa biểu &raquo;
                </a>
            </div>
        </div>

    </div>

    <!-- 4. BỘ COMBOBOX LỌC ĐA CHIỀU TRÊN TRANG CHỦ THEO YÊU CẦU -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 sm:p-5">
        <div class="border-b border-slate-100 pb-3 mb-3 flex items-center justify-between">
            <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                <i class="ti ti-filter text-huit-header text-base"></i>
                <span>Bộ Combobox Lọc Dữ Liệu & Phân Tích Sơ Đồ</span>
            </h2>
            <?php if (!empty($filters['branch_id']) || !empty($filters['teacher_id']) || !empty($filters['class_type']) || !empty($filters['session_time']) || !empty($filters['day_of_week'])): ?>
                <a href="/dashboard" class="text-[11px] font-bold text-red-600 hover:underline flex items-center space-x-1">
                    <i class="ti ti-x"></i>
                    <span>Xóa toàn bộ lọc</span>
                </a>
            <?php endif; ?>
        </div>

        <form method="GET" action="/dashboard" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
            
            <!-- Combobox 1: Cơ sở đào tạo -->
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Cơ sở đào tạo</label>
                <select name="branch_id" onchange="this.form.submit()" class="w-full text-xs font-medium bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:ring-2 focus:ring-huit-header">
                    <option value="">-- Tất cả cơ sở --</option>
                    <?php foreach ($branches as $b): ?>
                        <option value="<?= $b['id'] ?>" <?= ($filters['branch_id'] ?? null) == $b['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($b['branch_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Combobox 2: Giảng viên -->
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Giảng viên</label>
                <select name="teacher_id" onchange="this.form.submit()" class="w-full text-xs font-medium bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:ring-2 focus:ring-huit-header">
                    <option value="">-- Tất cả giảng viên --</option>
                    <?php foreach ($teachers as $t): ?>
                        <option value="<?= $t['id'] ?>" <?= ($filters['teacher_id'] ?? null) == $t['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($t['full_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Combobox 3: Loại ca học (Lý thuyết 3 tiết vs Thực hành 5 tiết) -->
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Loại học phần</label>
                <select name="class_type" onchange="this.form.submit()" class="w-full text-xs font-medium bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:ring-2 focus:ring-huit-header">
                    <option value="">-- Tất cả loại hình --</option>
                    <option value="theory" <?= ($filters['class_type'] ?? '') === 'theory' ? 'selected' : '' ?>>📘 Lý thuyết (3 tiết)</option>
                    <option value="practice" <?= ($filters['class_type'] ?? '') === 'practice' ? 'selected' : '' ?>>🧪 Thực hành (5 tiết)</option>
                </select>
            </div>

            <!-- Combobox 4: Buổi học (Sáng / Chiều / Tối) -->
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Buổi học</label>
                <select name="session_time" onchange="this.form.submit()" class="w-full text-xs font-medium bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:ring-2 focus:ring-huit-header">
                    <option value="">-- Tất cả buổi --</option>
                    <option value="morning" <?= ($filters['session_time'] ?? '') === 'morning' ? 'selected' : '' ?>>Ca Sáng (Tiết 1-6)</option>
                    <option value="afternoon" <?= ($filters['session_time'] ?? '') === 'afternoon' ? 'selected' : '' ?>>Ca Chiều (Tiết 7-12)</option>
                    <option value="evening" <?= ($filters['session_time'] ?? '') === 'evening' ? 'selected' : '' ?>>Ca Tối (Tiết 13-15)</option>
                </select>
            </div>

            <!-- Combobox 5: Thứ trong tuần -->
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Thứ trong tuần</label>
                <select name="day_of_week" onchange="this.form.submit()" class="w-full text-xs font-medium bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:ring-2 focus:ring-huit-header">
                    <option value="">-- Tất cả các ngày --</option>
                    <?php foreach ($dayNames as $dNum => $dName): ?>
                        <option value="<?= $dNum ?>" <?= ($filters['day_of_week'] ?? null) == $dNum ? 'selected' : '' ?>>
                            <?= $dName ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

        </form>
    </div>

    <!-- 5. CÁC SƠ ĐỒ VÀ BIỂU ĐỒ PHÂN BỔ ĐA CƠ SỞ (TƯƠNG TÁC THEO COMBOBOX) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- SƠ ĐỒ 1: Biểu đồ Cột phân bổ Lịch dạy theo từng Cơ sở (7 Cột) -->
        <div class="lg:col-span-7 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
                    <div>
                        <h2 class="text-sm font-bold text-slate-800 flex items-center space-x-2">
                            <i class="ti ti-chart-bar text-huit-header"></i>
                            <span>Sơ Đồ Phân Bổ Theo Cơ Sở Đào Tạo</span>
                        </h2>
                        <p class="text-[11px] text-slate-400 mt-0.5">Số ca học được phân bổ tương ứng với điều kiện lọc</p>
                    </div>
                    <span class="text-xs font-bold px-2.5 py-1 bg-blue-50 text-huit-header rounded-full border border-blue-200">
                        <?= $totalSchedules ?> Ca Lịch
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

        <!-- SƠ ĐỒ 2: Donut Chart - Tỷ lệ Lý thuyết (3 tiết) vs Thực hành (5 tiết) (5 Cột) -->
        <div class="lg:col-span-5 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
                    <div>
                        <h2 class="text-sm font-bold text-slate-800 flex items-center space-x-2">
                            <i class="ti ti-chart-donut text-emerald-600"></i>
                            <span>Tỷ Lệ Lý Thuyết (3 Tiết) & Thực Hành (5 Tiết)</span>
                        </h2>
                        <p class="text-[11px] text-slate-400 mt-0.5">Cơ cấu loại hình tiết học trong kỳ</p>
                    </div>
                    <span class="text-xs font-bold px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded-full border border-emerald-200">
                        2 Loại hình
                    </span>
                </div>

                <div class="h-56 relative flex items-center justify-center">
                    <canvas id="typeDonutChart"></canvas>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100 space-y-2 text-xs">
                <div class="flex items-center justify-between text-slate-600">
                    <span class="flex items-center"><span class="w-3 h-3 rounded-full bg-sky-500 mr-2"></span>Lý thuyết (3 tiết):</span>
                    <strong class="text-slate-800"><?= $typeCount['theory'] ?> ca (<?= $totalSchedules > 0 ? round(($typeCount['theory'] / max(1, $totalSchedules)) * 100) : 0 ?>%)</strong>
                </div>
                <div class="flex items-center justify-between text-slate-600">
                    <span class="flex items-center"><span class="w-3 h-3 rounded-full bg-emerald-500 mr-2"></span>Thực hành phòng máy/xưởng (5 tiết):</span>
                    <strong class="text-slate-800"><?= $typeCount['practice'] ?> ca (<?= $totalSchedules > 0 ? round(($typeCount['practice'] / max(1, $totalSchedules)) * 100) : 0 ?>%)</strong>
                </div>
            </div>
        </div>

    </div>

    <!-- 6. HÀNG SƠ ĐỒ THỨ 2: Mật độ các ngày trong tuần & Top Giảng viên -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- SƠ ĐỒ 3: Biểu đồ đường mật độ các ngày trong tuần -->
        <div class="lg:col-span-7 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
                    <div>
                        <h2 class="text-sm font-bold text-slate-800 flex items-center space-x-2">
                            <i class="ti ti-chart-line text-sky-600"></i>
                            <span>Mật Độ Phân Bổ Theo Ngày Trong Tuần</span>
                        </h2>
                        <p class="text-[11px] text-slate-400 mt-0.5">Số ca học được xếp từ Thứ 2 đến Chủ nhật</p>
                    </div>
                </div>

                <div class="h-64 relative">
                    <canvas id="dayOfWeekLineChart"></canvas>
                </div>
            </div>
        </div>

        <!-- BẢNG TOP GIẢNG VIÊN -->
        <div class="lg:col-span-5 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-3">
                    <h2 class="text-sm font-bold text-slate-800 flex items-center space-x-2">
                        <i class="ti ti-award text-amber-500"></i>
                        <span>Giảng Viên Đang Giảng Dạy</span>
                    </h2>
                    <a href="/teachers" class="text-[11px] text-huit-header font-semibold hover:underline">Quản lý &raquo;</a>
                </div>

                <div class="space-y-2.5">
                    <?php foreach ($topTeachers as $idx => $t): ?>
                        <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-100 hover:bg-blue-50/50 transition">
                            <div class="flex items-center space-x-3">
                                <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold <?= $idx === 0 ? 'bg-amber-100 text-amber-800' : ($idx === 1 ? 'bg-slate-200 text-slate-700' : 'bg-orange-50 text-orange-700') ?>">
                                    <?= $idx + 1 ?>
                                </span>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800"><?= htmlspecialchars($t['full_name']) ?></h4>
                                    <p class="text-[10px] text-slate-500"><?= htmlspecialchars($t['expertise']) ?></p>
                                </div>
                            </div>
                            <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-white text-huit-header border border-slate-200 shadow-2xs">
                                <?= (int)$t['schedule_count'] ?> ca
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100 text-center">
                <a href="/timetable" class="text-xs text-sky-600 hover:underline font-bold">
                    Xem toàn bộ thời khóa biểu tuần &raquo;
                </a>
            </div>
        </div>

    </div>

</div>

<!-- SCRIPT RENDER TẤT CẢ CÁC BIỂU ĐỒ CHART.JS -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Sơ đồ Cột: Phân bổ theo Cơ sở đào tạo
    const ctxBranch = document.getElementById('branchChart').getContext('2d');
    new Chart(ctxBranch, {
        type: 'bar',
        data: {
            labels: <?= json_encode($branchChartLabels) ?>,
            datasets: [{
                label: 'Số ca học',
                data: <?= json_encode($branchChartData) ?>,
                backgroundColor: [
                    'rgba(0, 91, 170, 0.85)',
                    'rgba(2, 132, 199, 0.85)',
                    'rgba(16, 185, 129, 0.85)',
                    'rgba(249, 115, 22, 0.85)'
                ],
                borderRadius: 8,
                borderSkipped: false
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
                    ticks: { precision: 0, font: { size: 10 } },
                    grid: { color: '#F1F5F9' }
                },
                x: {
                    ticks: {
                        font: { size: 10, weight: '600' },
                        callback: function(val, index) {
                            let label = this.getLabelForValue(val);
                            return label.length > 20 ? label.substr(0, 18) + '...' : label;
                        }
                    },
                    grid: { display: false }
                }
            }
        }
    });

    // 2. Sơ đồ Donut: Lý thuyết (3 tiết) vs Thực hành (5 tiết)
    const ctxType = document.getElementById('typeDonutChart').getContext('2d');
    new Chart(ctxType, {
        type: 'doughnut',
        data: {
            labels: ['Lý thuyết (3 tiết)', 'Thực hành (5 tiết)'],
            datasets: [{
                data: [
                    <?= (int)$typeCount['theory'] ?>,
                    <?= (int)$typeCount['practice'] ?>
                ],
                backgroundColor: ['#0284C7', '#10B981'],
                borderWidth: 3,
                borderColor: '#FFFFFF',
                cutout: '68%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11, weight: '500' } } }
            }
        }
    });

    // 3. Sơ đồ Đường: Mật độ các ngày trong tuần
    const ctxDay = document.getElementById('dayOfWeekLineChart').getContext('2d');
    new Chart(ctxDay, {
        type: 'line',
        data: {
            labels: ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ Nhật'],
            datasets: [{
                label: 'Số ca học',
                data: [
                    <?= (int)($dayOfWeekDistribution[2] ?? 0) ?>,
                    <?= (int)($dayOfWeekDistribution[3] ?? 0) ?>,
                    <?= (int)($dayOfWeekDistribution[4] ?? 0) ?>,
                    <?= (int)($dayOfWeekDistribution[5] ?? 0) ?>,
                    <?= (int)($dayOfWeekDistribution[6] ?? 0) ?>,
                    <?= (int)($dayOfWeekDistribution[7] ?? 0) ?>,
                    <?= (int)($dayOfWeekDistribution[8] ?? 0) ?>
                ],
                borderColor: '#0284C7',
                backgroundColor: 'rgba(2, 132, 199, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.35,
                pointBackgroundColor: '#005BAA',
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0, font: { size: 10 } },
                    grid: { color: '#F1F5F9' }
                },
                x: {
                    ticks: { font: { size: 10, weight: '600' } },
                    grid: { display: false }
                }
            }
        }
    });

    // 4. Widget Học tập (Bar Chart theo Ảnh 2)
    const ctxStudy = document.getElementById('studyOverviewChart').getContext('2d');
    new Chart(ctxStudy, {
        type: 'bar',
        data: {
            labels: ['Môn 1', 'Môn 2', 'Môn 3', 'Môn 4', 'Môn 5', 'Môn 6', 'Môn 7', 'Môn 8'],
            datasets: [{
                data: [7.5, 8.2, 6.8, 9.0, 8.5, 7.8, 8.8, 9.2],
                backgroundColor: [
                    '#A7F3D0', '#BAE6FD', '#DDD6FE', '#FDE68A',
                    '#FECDD3', '#A7F3D0', '#BAE6FD', '#DDD6FE'
                ],
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { display: false, max: 10 },
                x: { display: false }
            }
        }
    });

    // 5. Widget Tiến độ học tập (Ring Chart theo Ảnh 2)
    const ctxProgress = document.getElementById('progressRingChart').getContext('2d');
    new Chart(ctxProgress, {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [82, 18],
                backgroundColor: ['#10B981', '#E2E8F0'],
                borderWidth: 0,
                cutout: '76%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } }
        }
    });

});
</script>

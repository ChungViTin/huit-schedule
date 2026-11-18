<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Core\Database;
use App\Models\Branch;
use App\Models\Teacher;
use App\Models\Schedule;
use App\Models\Admin;
use App\Services\ScheduleOptimizerService;
use Dotenv\Dotenv;
use Faker\Factory;

// Load .env
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->safeLoad();
}

echo "=== BẮT ĐẦU SEED DỮ LIỆU MẪU CHO HUIT SCHEDULE HUB ===\n";

$db = Database::getConnection();
$faker = Factory::create('vi_VN');

// Tắt foreign key checks để truncate sạch sẽ
$db->exec("SET FOREIGN_KEY_CHECKS = 0;");
$db->exec("TRUNCATE TABLE schedules;");
$db->exec("TRUNCATE TABLE teachers;");
$db->exec("TRUNCATE TABLE branches;");
$db->exec("TRUNCATE TABLE admins;");
$db->exec("SET FOREIGN_KEY_CHECKS = 1;");

// 1. Tạo tài khoản Admin mặc định
echo "[1/4] Đang tạo tài khoản Quản trị viên Phòng Đào Tạo...\n";
$adminPass = password_hash('admin123', PASSWORD_BCRYPT);
$stmtAdmin = $db->prepare("INSERT INTO admins (username, email, password, full_name, role) VALUES (?, ?, ?, ?, ?)");
$stmtAdmin->execute(['admin', 'admin@huit.edu.vn', $adminPass, 'Phòng Đào Tạo HUIT', 'admin']);
echo "  -> Tạo thành công: admin / admin123\n";

// 2. Tạo các cơ sở đào tạo của HUIT
echo "[2/4] Đang tạo danh sách Cơ sở Đào tạo HUIT...\n";
$huitBranches = [
    [
        'name' => 'Cơ sở chính (Tân Phú)',
        'address' => '140 Lê Trọng Tấn, P. Tây Thạnh, Q. Tân Phú, TP.HCM'
    ],
    [
        'name' => 'Cơ sở 2 (Tân Bình)',
        'address' => '338 Hoàng Văn Thụ, P. 4, Q. Tân Bình, TP.HCM'
    ],
    [
        'name' => 'Cơ sở 3 (Trung tâm Thí nghiệm)',
        'address' => '93 Tân Kỳ Tân Quý, P. Tân Sơn Nhì, Q. Tân Phú, TP.HCM'
    ],
    [
        'name' => 'Cơ sở 4 (Xưởng Thực hành)',
        'address' => 'Nguyễn Quý Anh, P. Tân Sơn Nhì, Q. Tân Phú, TP.HCM'
    ]
];

$branchIds = [];
foreach ($huitBranches as $b) {
    $branchIds[] = Branch::create([
        'branch_name' => $b['name'],
        'address' => $b['address']
    ]);
}
echo "  -> Đã tạo " . count($branchIds) . " cơ sở đào tạo.\n";

// 3. Tạo danh sách Giảng viên
echo "[3/4] Đang tạo danh sách Giảng viên bằng Faker...\n";
$expertises = [
    'Công nghệ thông tin',
    'Công nghệ phần mềm',
    'Mạng máy tính & An toàn thông tin',
    'Khoa học dữ liệu',
    'Công nghệ thực phẩm',
    'Kỹ thuật chế biến thực phẩm',
    'Quản trị kinh doanh',
    'Marketing & E-Commerce',
    'Kỹ thuật điện - Điện tử',
    'Ngôn ngữ Anh'
];

$teacherIds = [];

$fixedTeachers = [
    [
        'full_name' => 'TS. Nguyễn Văn An',
        'email' => 'nguyenvana@huit.edu.vn',
        'phone' => '0901234567',
        'expertise' => 'Công nghệ phần mềm'
    ],
    [
        'full_name' => 'ThS. Trần Thị Bích',
        'email' => 'tranthib@huit.edu.vn',
        'phone' => '0912345678',
        'expertise' => 'Công nghệ thực phẩm'
    ],
    [
        'full_name' => 'PGS.TS. Lê Hoàng Cường',
        'email' => 'lehoangc@huit.edu.vn',
        'phone' => '0923456789',
        'expertise' => 'Mạng máy tính & An toàn thông tin'
    ],
    [
        'full_name' => 'ThS. Phạm Minh Dũng',
        'email' => 'phammed@huit.edu.vn',
        'phone' => '0934567890',
        'expertise' => 'Quản trị kinh doanh'
    ],
    [
        'full_name' => 'TS. Vũ Thu Hương',
        'email' => 'vuthuhuong@huit.edu.vn',
        'phone' => '0945678901',
        'expertise' => 'Khoa học dữ liệu'
    ]
];

$defaultPassword = '123456';

foreach ($fixedTeachers as $ft) {
    $teacherIds[] = Teacher::create([
        'full_name' => $ft['full_name'],
        'email' => $ft['email'],
        'phone' => $ft['phone'],
        'expertise' => $ft['expertise'],
        'password' => $defaultPassword
    ]);
}

for ($i = 6; $i <= 12; $i++) {
    $title = $faker->randomElement(['ThS. ', 'TS. ', 'GVC. ']);
    $name = $title . $faker->lastName() . ' ' . $faker->middleName() . ' ' . $faker->firstName();
    $email = 'gv' . $i . '@huit.edu.vn';
    $phone = $faker->numerify('09########');
    $exp = $faker->randomElement($expertises);

    $teacherIds[] = Teacher::create([
        'full_name' => $name,
        'email' => $email,
        'phone' => $phone,
        'expertise' => $exp,
        'password' => $defaultPassword
    ]);
}
echo "  -> Đã tạo " . count($teacherIds) . " giảng viên.\n";

// 4. Sinh Lịch Dạy Mẫu phân chia rõ: Lý thuyết (3 tiết) vs Thực hành (5 tiết)
echo "[4/4] Đang phân bổ Lịch Dạy mẫu (Lý thuyết 3 tiết & Thực hành 5 tiết)...\n";

$theoryShifts = [
    'Sáng - Lý thuyết (Tiết 1-3)',
    'Sáng - Lý thuyết (Tiết 4-6)',
    'Chiều - Lý thuyết (Tiết 7-9)',
    'Chiều - Lý thuyết (Tiết 10-12)',
    'Tối - Lý thuyết (Tiết 13-15)'
];

$practiceShifts = [
    'Sáng - Thực hành (Tiết 1-5)',
    'Chiều - Thực hành (Tiết 7-11)',
    'Tối - Thực hành (Tiết 11-15)'
];

$schedulesCount = 0;

// 1. Thực hành 5 tiết: Lập trình Web PHP (Thứ 2, Sáng 1-5 tại Cơ sở chính)
Schedule::create([
    'teacher_id' => $teacherIds[0],
    'branch_id' => $branchIds[0],
    'subject_name' => 'Thực hành Lập trình Web PHP',
    'room' => 'PM01',
    'day_of_week' => 2,
    'shift_or_periods' => 'Sáng - Thực hành (Tiết 1-5)',
    'class_type' => 'practice',
    'notes' => 'Thực hành phòng máy tính 5 tiết'
]);
$schedulesCount++;

// 2. Lý thuyết 3 tiết: Kỹ thuật lập trình Java (Thứ 2, Chiều 7-9 cùng cơ sở chính -> Tối ưu di chuyển)
Schedule::create([
    'teacher_id' => $teacherIds[0],
    'branch_id' => $branchIds[0],
    'subject_name' => 'Kỹ thuật lập trình Java',
    'room' => 'B201',
    'day_of_week' => 2,
    'shift_or_periods' => 'Chiều - Lý thuyết (Tiết 7-9)',
    'class_type' => 'theory',
    'notes' => 'Lý thuyết phòng học chuyên đề'
]);
$schedulesCount++;

// 3. Thực hành 5 tiết: Kỹ thuật chế biến đồ uống (Thứ 3, Sáng 1-5 tại TT Thí nghiệm)
Schedule::create([
    'teacher_id' => $teacherIds[1],
    'branch_id' => $branchIds[2],
    'subject_name' => 'Thực hành chế biến đồ uống',
    'room' => 'TN01',
    'day_of_week' => 3,
    'shift_or_periods' => 'Sáng - Thực hành (Tiết 1-5)',
    'class_type' => 'practice',
    'notes' => 'Thực hành tại xưởng thí nghiệm 5 tiết'
]);
$schedulesCount++;

// 4. Lý thuyết 3 tiết: Vi sinh học thực phẩm (Thứ 3, Chiều 7-9 tại TT Thí nghiệm)
Schedule::create([
    'teacher_id' => $teacherIds[1],
    'branch_id' => $branchIds[2],
    'subject_name' => 'Vi sinh học thực phẩm',
    'room' => 'TN02',
    'day_of_week' => 3,
    'shift_or_periods' => 'Chiều - Lý thuyết (Tiết 7-9)',
    'class_type' => 'theory',
    'notes' => 'Lý thuyết vi sinh'
]);
$schedulesCount++;

// 5. Lý thuyết 3 tiết: An toàn mạng (Thứ 4, Sáng 1-3 tại Cơ sở 1)
Schedule::create([
    'teacher_id' => $teacherIds[2],
    'branch_id' => $branchIds[0],
    'subject_name' => 'An toàn và bảo mật hệ thống mạng',
    'room' => 'A201',
    'day_of_week' => 4,
    'shift_or_periods' => 'Sáng - Lý thuyết (Tiết 1-3)',
    'class_type' => 'theory',
    'notes' => 'Lý thuyết an toàn thông tin'
]);
$schedulesCount++;

// 6. Thực hành 5 tiết: Thực hành Mạng máy tính (Thứ 4, Chiều 7-11 tại Cơ sở 1)
Schedule::create([
    'teacher_id' => $teacherIds[2],
    'branch_id' => $branchIds[0],
    'subject_name' => 'Thực hành Mạng máy tính',
    'room' => 'PM02',
    'day_of_week' => 4,
    'shift_or_periods' => 'Chiều - Thực hành (Tiết 7-11)',
    'class_type' => 'practice',
    'notes' => 'Thực hành cấu hình router/switch'
]);
$schedulesCount++;

// Sinh thêm 12 lịch kết hợp lý thuyết và thực hành ngẫu nhiên
$otherSubjects = [
    ['name' => 'Cơ sở dữ liệu nâng cao', 'type' => 'theory', 'exp' => 'Khoa học dữ liệu'],
    ['name' => 'Thực hành Khoa học dữ liệu & Python', 'type' => 'practice', 'exp' => 'Khoa học dữ liệu'],
    ['name' => 'Quản trị Marketing số', 'type' => 'theory', 'exp' => 'Quản trị kinh doanh'],
    ['name' => 'Thực hành Vi điều khiển', 'type' => 'practice', 'exp' => 'Kỹ thuật điện - Điện tử'],
    ['name' => 'Tiếng Anh giao tiếp chuyên ngành', 'type' => 'theory', 'exp' => 'Ngôn ngữ Anh'],
    ['name' => 'Kiểm thử phần mềm tự động', 'type' => 'practice', 'exp' => 'Công nghệ phần mềm'],
    ['name' => 'Quản trị chuỗi cung ứng thực phẩm', 'type' => 'theory', 'exp' => 'Công nghệ thực phẩm'],
    ['name' => 'Điện toán đám mây Cloud Computing', 'type' => 'theory', 'exp' => 'Công nghệ thông tin']
];

$rooms = ['A201', 'A202', 'B101', 'B102', 'PM01', 'PM02', 'PM03', 'TN01', 'TN02', 'C104'];

$attempts = 0;
while ($schedulesCount < 18 && $attempts < 100) {
    $attempts++;
    $sub = $faker->randomElement($otherSubjects);
    $teacherId = $faker->randomElement($teacherIds);
    $branchId = $faker->randomElement($branchIds);
    $day = $faker->numberBetween(2, 7);
    $room = $faker->randomElement($rooms);

    $shift = ($sub['type'] === 'practice') 
        ? $faker->randomElement($practiceShifts) 
        : $faker->randomElement($theoryShifts);

    $check = ScheduleOptimizerService::checkConflicts($teacherId, $branchId, $room, $day, $shift);
    if (!$check['has_conflict']) {
        Schedule::create([
            'teacher_id' => $teacherId,
            'branch_id' => $branchId,
            'subject_name' => $sub['name'],
            'room' => $room,
            'day_of_week' => $day,
            'shift_or_periods' => $shift,
            'class_type' => $sub['type'],
            'notes' => 'Phân bổ mẫu ' . ($sub['type'] === 'practice' ? '5 tiết' : '3 tiết')
        ]);
        $schedulesCount++;
    }
}

echo "  -> Đã tạo {$schedulesCount} ca lịch dạy (gồm cả Lý thuyết 3 tiết & Thực hành 5 tiết).\n";
echo "=== HOÀN TẤT SEED DỮ LIỆU! ===\n";

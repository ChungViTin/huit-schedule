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

// Một số giảng viên cố định chuẩn test
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

// Sinh thêm 7 giảng viên ngẫu nhiên qua Faker
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
echo "  -> Đã tạo " . count($teacherIds) . " giảng viên (Mật khẩu: 123456).\n";

// 4. Sinh Lịch Dạy Mẫu (Schedules)
echo "[4/4] Đang phân bổ Lịch Dạy mẫu tối ưu...\n";
$subjects = [
    ['name' => 'Lập trình Web PHP & MySQL', 'exp' => 'Công nghệ phần mềm'],
    ['name' => 'Cơ sở dữ liệu nâng cao', 'exp' => 'Khoa học dữ liệu'],
    ['name' => 'An toàn và bảo mật hệ thống mạng', 'exp' => 'Mạng máy tính & An toàn thông tin'],
    ['name' => 'Kỹ thuật chế biến đồ uống', 'exp' => 'Công nghệ thực phẩm'],
    ['name' => 'Vi sinh học thực phẩm', 'exp' => 'Công nghệ thực phẩm'],
    ['name' => 'Quản trị Marketing số', 'exp' => 'Quản trị kinh doanh'],
    ['name' => 'Nhập môn Trí tuệ nhân tạo', 'exp' => 'Khoa học dữ liệu'],
    ['name' => 'Kỹ thuật lập trình Java', 'exp' => 'Công nghệ phần mềm'],
    ['name' => 'Thực hành Vi điều khiển', 'exp' => 'Kỹ thuật điện - Điện tử'],
    ['name' => 'Tiếng Anh giao tiếp chuyên ngành', 'exp' => 'Ngôn ngữ Anh']
];

$shifts = array_keys(ScheduleOptimizerService::SHIFTS);
$rooms = ['A201', 'A202', 'B101', 'B102', 'PM01', 'PM02', 'PM03', 'TN01', 'TN02', 'C104'];

$schedulesCount = 0;

// Xếp lịch mẫu đảm bảo tính hợp lệ, tối ưu
// Ví dụ: TS. Nguyễn Văn An dạy tại Cơ sở 1 vào Thứ 2 (Ca 1 & Ca 2 - cùng cơ sở tối ưu)
Schedule::create([
    'teacher_id' => $teacherIds[0],
    'branch_id' => $branchIds[0],
    'subject_name' => 'Lập trình Web PHP & MySQL',
    'room' => 'PM01',
    'day_of_week' => 2,
    'shift_or_periods' => $shifts[0], // Ca 1
    'notes' => 'Lớp thực hành máy tính phòng Lab'
]);
$schedulesCount++;

Schedule::create([
    'teacher_id' => $teacherIds[0],
    'branch_id' => $branchIds[0],
    'subject_name' => 'Kỹ thuật lập trình Java',
    'room' => 'PM01',
    'day_of_week' => 2,
    'shift_or_periods' => $shifts[1], // Ca 2 cùng phòng, cùng cơ sở -> CỰC KỲ TỐI ƯU
    'notes' => 'Lớp lý thuyết kết hợp bài tập'
]);
$schedulesCount++;

// ThS. Trần Thị Bích dạy tại Cơ sở 3 (Trung tâm TN) vào Thứ 3 (Ca 3 & Ca 4)
Schedule::create([
    'teacher_id' => $teacherIds[1],
    'branch_id' => $branchIds[2],
    'subject_name' => 'Kỹ thuật chế biến đồ uống',
    'room' => 'TN01',
    'day_of_week' => 3,
    'shift_or_periods' => $shifts[2], // Ca 3
    'notes' => 'Thực hành tại xưởng thí nghiệm'
]);
$schedulesCount++;

Schedule::create([
    'teacher_id' => $teacherIds[1],
    'branch_id' => $branchIds[2],
    'subject_name' => 'Vi sinh học thực phẩm',
    'room' => 'TN02',
    'day_of_week' => 3,
    'shift_or_periods' => $shifts[3], // Ca 4
    'notes' => 'Kiểm nghiệm mẫu phẩm'
]);
$schedulesCount++;

// PGS.TS. Lê Hoàng Cường dạy tại Cơ sở chính vào Thứ 4 (Ca 1) và Thứ 6 (Ca 3)
Schedule::create([
    'teacher_id' => $teacherIds[2],
    'branch_id' => $branchIds[0],
    'subject_name' => 'An toàn và bảo mật hệ thống mạng',
    'room' => 'B101',
    'day_of_week' => 4,
    'shift_or_periods' => $shifts[0],
    'notes' => 'Phòng máy lạnh có máy chiếu'
]);
$schedulesCount++;

Schedule::create([
    'teacher_id' => $teacherIds[2],
    'branch_id' => $branchIds[1],
    'subject_name' => 'An toàn và bảo mật hệ thống mạng',
    'room' => 'A201',
    'day_of_week' => 6,
    'shift_or_periods' => $shifts[2],
    'notes' => 'Cơ sở 2 Tân Bình'
]);
$schedulesCount++;

// Sinh thêm 12 lịch dạy ngẫu nhiên nhưng kiểm tra xung đột để luôn hợp lệ
$attempts = 0;
while ($schedulesCount < 18 && $attempts < 100) {
    $attempts++;
    $teacherId = $faker->randomElement($teacherIds);
    $branchId = $faker->randomElement($branchIds);
    $sub = $faker->randomElement($subjects);
    $day = $faker->numberBetween(2, 7);
    $shift = $faker->randomElement($shifts);
    $room = $faker->randomElement($rooms);

    $check = ScheduleOptimizerService::checkConflicts($teacherId, $branchId, $room, $day, $shift);
    if (!$check['has_conflict']) {
        Schedule::create([
            'teacher_id' => $teacherId,
            'branch_id' => $branchId,
            'subject_name' => $sub['name'],
            'room' => $room,
            'day_of_week' => $day,
            'shift_or_periods' => $shift,
            'notes' => 'Phân lịch tự động mẫu'
        ]);
        $schedulesCount++;
    }
}

echo "  -> Đã tạo {$schedulesCount} ca lịch dạy mẫu hoàn toàn hợp lệ.\n";
echo "=== HOÀN TẤT SEED DỮ LIỆU THÀNH CÔNG! ===\n";
echo "Đăng nhập Admin: admin / admin123\n";
echo "Đăng nhập Giảng viên: nguyenvana@huit.edu.vn / 123456\n";

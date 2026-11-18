<?php

namespace App\Services;

use App\Core\Database;
use App\Models\Branch;
use App\Models\Schedule;
use App\Models\Teacher;
use PDO;

class ScheduleOptimizerService
{
    /**
     * Danh sách các ca học phân chia rõ ràng: Lý thuyết (3 tiết) và Thực hành (5 tiết)
     */
    public const SHIFTS = [
        // 1. Lý thuyết (3 tiết)
        'Sáng - Lý thuyết (Tiết 1-3)' => [
            'type' => 'theory',
            'type_name' => 'Lý thuyết (3 tiết)',
            'session' => 'morning',
            'start' => 1,
            'end' => 3,
            'time' => '07:00 - 09:30'
        ],
        'Sáng - Lý thuyết (Tiết 4-6)' => [
            'type' => 'theory',
            'type_name' => 'Lý thuyết (3 tiết)',
            'session' => 'morning',
            'start' => 4,
            'end' => 6,
            'time' => '09:45 - 12:15'
        ],
        'Chiều - Lý thuyết (Tiết 7-9)' => [
            'type' => 'theory',
            'type_name' => 'Lý thuyết (3 tiết)',
            'session' => 'afternoon',
            'start' => 7,
            'end' => 9,
            'time' => '13:00 - 15:30'
        ],
        'Chiều - Lý thuyết (Tiết 10-12)' => [
            'type' => 'theory',
            'type_name' => 'Lý thuyết (3 tiết)',
            'session' => 'afternoon',
            'start' => 10,
            'end' => 12,
            'time' => '15:45 - 18:15'
        ],
        'Tối - Lý thuyết (Tiết 13-15)' => [
            'type' => 'theory',
            'type_name' => 'Lý thuyết (3 tiết)',
            'session' => 'evening',
            'start' => 13,
            'end' => 15,
            'time' => '18:30 - 21:00'
        ],

        // 2. Thực hành (5 tiết)
        'Sáng - Thực hành (Tiết 1-5)' => [
            'type' => 'practice',
            'type_name' => 'Thực hành (5 tiết)',
            'session' => 'morning',
            'start' => 1,
            'end' => 5,
            'time' => '07:00 - 11:30'
        ],
        'Chiều - Thực hành (Tiết 7-11)' => [
            'type' => 'practice',
            'type_name' => 'Thực hành (5 tiết)',
            'session' => 'afternoon',
            'start' => 7,
            'end' => 11,
            'time' => '12:30 - 17:00'
        ],
        'Tối - Thực hành (Tiết 11-15)' => [
            'type' => 'practice',
            'type_name' => 'Thực hành (5 tiết)',
            'session' => 'evening',
            'start' => 11,
            'end' => 15,
            'time' => '17:15 - 21:15'
        ]
    ];

    /**
     * Map giữa tên môn học và các từ khóa chuyên môn phù hợp
     */
    private const SUBJECT_EXPERTISE_MAP = [
        'lập trình' => ['Công nghệ thông tin', 'Công nghệ phần mềm', 'Khoa học máy tính', 'Kỹ thuật phần mềm'],
        'php' => ['Công nghệ thông tin', 'Công nghệ phần mềm', 'Kỹ thuật phần mềm'],
        'web' => ['Công nghệ thông tin', 'Công nghệ phần mềm', 'Kỹ thuật phần mềm'],
        'cơ sở dữ liệu' => ['Công nghệ thông tin', 'Hệ thống thông tin', 'Khoa học dữ liệu'],
        'database' => ['Công nghệ thông tin', 'Hệ thống thông tin', 'Khoa học dữ liệu'],
        'mạng' => ['Mạng máy tính & An toàn thông tin', 'Công nghệ thông tin'],
        'an toàn' => ['Mạng máy tính & An toàn thông tin', 'Công nghệ thông tin'],
        'thực phẩm' => ['Công nghệ thực phẩm', 'Dinh dưỡng & Ẩm thực', 'Bảo quản thực phẩm'],
        'chế biến' => ['Công nghệ thực phẩm', 'Kỹ thuật chế biến'],
        'kinh tế' => ['Quản trị kinh doanh', 'Tài chính - Ngân hàng', 'Kinh tế quốc tế'],
        'marketing' => ['Quản trị kinh doanh', 'Marketing & E-Commerce'],
        'quản trị' => ['Quản trị kinh doanh'],
        'điện' => ['Kỹ thuật điện - Điện tử', 'Tự động hóa', 'Cơ điện tử'],
        'điện tử' => ['Kỹ thuật điện - Điện tử', 'Viễn thông'],
        'tiếng anh' => ['Ngôn ngữ Anh', 'Sư phạm tiếng Anh'],
    ];

    /**
     * Kiểm tra hai ca học có bị trùng tiết (overlapping periods) hay không
     */
    public static function isPeriodsOverlap(int $startA, int $endA, int $startB, int $endB): bool
    {
        return ($startA <= $endB) && ($endA >= $startB);
    }

    /**
     * Gợi ý danh sách giảng viên phù hợp với môn học và khung giờ
     */
    public static function suggestTeachers(string $subjectName, int $dayOfWeek, string $shift, int $targetBranchId): array
    {
        $db = Database::getConnection();
        $teachers = Teacher::getAll();
        $results = [];

        $subjectLower = mb_strtolower(trim($subjectName), 'UTF-8');
        $shiftInfo = self::SHIFTS[$shift] ?? null;
        $targetStart = $shiftInfo['start'] ?? 1;
        $targetEnd = $shiftInfo['end'] ?? 3;

        foreach ($teachers as $teacher) {
            $teacherId = (int)$teacher['id'];
            $expertise = $teacher['expertise'];

            // Lấy tất cả lịch dạy của giảng viên trong ngày đó
            $stmtDay = $db->prepare("SELECT s.*, b.branch_name 
                                     FROM schedules s 
                                     JOIN branches b ON s.branch_id = b.id 
                                     WHERE s.teacher_id = ? AND s.day_of_week = ?");
            $stmtDay->execute([$teacherId, $dayOfWeek]);
            $daySchedules = $stmtDay->fetchAll();

            // 1. Kiểm tra TRÙNG TIẾT (Overlapping Conflict)
            $busySchedule = null;
            foreach ($daySchedules as $sch) {
                $schShift = $sch['shift_or_periods'];
                $schInfo = self::SHIFTS[$schShift] ?? null;
                $schStart = $sch['period_start'] ?? ($schInfo['start'] ?? 1);
                $schEnd = $sch['period_end'] ?? ($schInfo['end'] ?? 3);

                if (self::isPeriodsOverlap($targetStart, $targetEnd, $schStart, $schEnd)) {
                    $busySchedule = $sch;
                    break;
                }
            }

            if ($busySchedule) {
                $results[] = [
                    'teacher' => $teacher,
                    'is_available' => false,
                    'status' => 'busy',
                    'badge_class' => 'bg-red-100 text-red-800 border-red-200',
                    'reason' => "ĐÃ BẬN TIẾT: Đang dạy môn '{$busySchedule['subject_name']}' ({$busySchedule['shift_or_periods']}) tại {$busySchedule['branch_name']}",
                    'score' => -100
                ];
                continue;
            }

            // 2. Tính điểm phù hợp chuyên môn
            $expertiseScore = self::calculateExpertiseMatch($subjectLower, $expertise);

            // 3. Phân tích tối ưu hóa di chuyển đa cơ sở
            $travelStatus = 'empty_day';
            $travelReason = 'Trống lịch cả ngày - Sẵn sàng nhận lớp';
            $travelScoreBonus = 20;

            if (!empty($daySchedules)) {
                $hasSameBranch = false;
                $hasDifferentBranchAdjacent = false;
                $hasDifferentBranchOtherSession = false;
                $diffBranchName = '';

                foreach ($daySchedules as $sch) {
                    $schBranchId = (int)$sch['branch_id'];
                    $schShift = $sch['shift_or_periods'];
                    $schShiftInfo = self::SHIFTS[$schShift] ?? null;

                    if ($schBranchId === $targetBranchId) {
                        $hasSameBranch = true;
                    } else {
                        $diffBranchName = $sch['branch_name'];
                        if ($shiftInfo && $schShiftInfo && $shiftInfo['session'] === $schShiftInfo['session']) {
                            $hasDifferentBranchAdjacent = true;
                        } else {
                            $hasDifferentBranchOtherSession = true;
                        }
                    }
                }

                if ($hasDifferentBranchAdjacent) {
                    $travelStatus = 'impossible_travel';
                    $travelReason = "CẢNH BÁO NGUY HIỂM: Giảng viên có ca khác trong cùng buổi tại {$diffBranchName}! Không kịp di chuyển.";
                    $travelScoreBonus = -50;
                } elseif ($hasSameBranch) {
                    $travelStatus = 'optimal_same_branch';
                    $travelReason = "TỐI ƯU CAO NHẤT: Giảng viên đã có lịch dạy tại cơ sở này trong ngày (Tiết kiệm thời gian di chuyển).";
                    $travelScoreBonus = 50;
                } elseif ($hasDifferentBranchOtherSession) {
                    $travelStatus = 'warning_different_branch';
                    $travelReason = "LƯU Ý DI CHUYỂN: Giảng viên có ca khác buổi tại {$diffBranchName}.";
                    $travelScoreBonus = 0;
                }
            }

            $totalScore = $expertiseScore + $travelScoreBonus;

            $badgeClass = 'bg-emerald-100 text-emerald-800 border-emerald-200';
            $badgeText = 'Khả dụng & Phù hợp';

            if ($travelStatus === 'optimal_same_branch') {
                $badgeClass = 'bg-blue-100 text-blue-800 border-blue-200';
                $badgeText = '⭐ Khuyên dùng (Cùng cơ sở)';
            } elseif ($travelStatus === 'impossible_travel') {
                $badgeClass = 'bg-amber-100 text-amber-800 border-amber-200';
                $badgeText = '⚠️ Cảnh báo di chuyển gấp';
            } elseif ($travelStatus === 'warning_different_branch') {
                $badgeClass = 'bg-yellow-100 text-yellow-800 border-yellow-200';
                $badgeText = '🚗 Cần di chuyển cơ sở';
            }

            $results[] = [
                'teacher' => $teacher,
                'is_available' => true,
                'status' => $travelStatus,
                'badge_class' => $badgeClass,
                'badge_text' => $badgeText,
                'reason' => $travelReason,
                'expertise_score' => $expertiseScore,
                'score' => $totalScore
            ];
        }

        usort($results, fn($a, $b) => $b['score'] <=> $a['score']);
        return $results;
    }

    /**
     * Kiểm tra xung đột trước khi lưu lịch dạy
     */
    public static function checkConflicts(
        int $teacherId,
        int $branchId,
        string $room,
        int $dayOfWeek,
        string $shift,
        ?int $excludeScheduleId = null
    ): array {
        $db = Database::getConnection();
        $conflicts = [];
        $warnings = [];

        $targetShiftInfo = self::SHIFTS[$shift] ?? null;
        $targetStart = $targetShiftInfo['start'] ?? 1;
        $targetEnd = $targetShiftInfo['end'] ?? 3;

        // 1. Kiểm tra TRÙNG PHÒNG HỌC (chồng lấn tiết tại cơ sở này)
        $sqlRoom = "SELECT s.*, t.full_name AS teacher_name 
                    FROM schedules s 
                    JOIN teachers t ON s.teacher_id = t.id 
                    WHERE s.branch_id = ? AND s.room = ? AND s.day_of_week = ?";
        $paramsRoom = [$branchId, $room, $dayOfWeek];
        if ($excludeScheduleId) {
            $sqlRoom .= " AND s.id != ?";
            $paramsRoom[] = $excludeScheduleId;
        }
        $stmtRoom = $db->prepare($sqlRoom);
        $stmtRoom->execute($paramsRoom);
        $roomSchedules = $stmtRoom->fetchAll();

        foreach ($roomSchedules as $sch) {
            $schInfo = self::SHIFTS[$sch['shift_or_periods']] ?? null;
            $schStart = $sch['period_start'] ?? ($schInfo['start'] ?? 1);
            $schEnd = $sch['period_end'] ?? ($schInfo['end'] ?? 3);

            if (self::isPeriodsOverlap($targetStart, $targetEnd, $schStart, $schEnd)) {
                $conflicts[] = "TRÙNG PHÒNG HỌC: Phòng {$room} vào Thứ {$dayOfWeek} đã có lớp '{$sch['subject_name']}' ({$sch['shift_or_periods']}) của GV {$sch['teacher_name']}!";
                break;
            }
        }

        // 2. Kiểm tra TRÙNG TIẾT GIẢNG VIÊN (toàn trường)
        $sqlTeacher = "SELECT s.*, b.branch_name 
                       FROM schedules s 
                       JOIN branches b ON s.branch_id = b.id 
                       WHERE s.teacher_id = ? AND s.day_of_week = ?";
        $paramsTeacher = [$teacherId, $dayOfWeek];
        if ($excludeScheduleId) {
            $sqlTeacher .= " AND s.id != ?";
            $paramsTeacher[] = $excludeScheduleId;
        }
        $stmtTeacher = $db->prepare($sqlTeacher);
        $stmtTeacher->execute($paramsTeacher);
        $teacherSchedules = $stmtTeacher->fetchAll();

        foreach ($teacherSchedules as $sch) {
            $schInfo = self::SHIFTS[$sch['shift_or_periods']] ?? null;
            $schStart = $sch['period_start'] ?? ($schInfo['start'] ?? 1);
            $schEnd = $sch['period_end'] ?? ($schInfo['end'] ?? 3);

            if (self::isPeriodsOverlap($targetStart, $targetEnd, $schStart, $schEnd)) {
                $conflicts[] = "TRÙNG LỊCH GIẢNG VIÊN: Giảng viên đã có lịch dạy môn '{$sch['subject_name']}' ({$sch['shift_or_periods']}) tại {$sch['branch_name']} (Phòng {$sch['room']})!";
                break;
            }
        }

        // 3. Kiểm tra TỐI ƯU HÓA DI CHUYỂN
        foreach ($teacherSchedules as $sch) {
            if ((int)$sch['branch_id'] !== $branchId) {
                $schShiftInfo = self::SHIFTS[$sch['shift_or_periods']] ?? null;
                if ($targetShiftInfo && $schShiftInfo && $targetShiftInfo['session'] === $schShiftInfo['session']) {
                    $warnings[] = "XUNG ĐỘT DI CHUYỂN TRONG BUỔI: Giảng viên có ca khác ({$sch['shift_or_periods']}) tại {$sch['branch_name']}. Di chuyển giữa 2 cơ sở trong cùng 1 buổi là bất khả thi!";
                } else {
                    $warnings[] = "LƯU Ý DI CHUYỂN KHÁC BUỔI: Giảng viên có ca dạy tại {$sch['branch_name']} ({$sch['shift_or_periods']}) trong cùng ngày.";
                }
            }
        }

        return [
            'has_conflict' => !empty($conflicts),
            'conflicts' => $conflicts,
            'has_warning' => !empty($warnings),
            'warnings' => $warnings,
            'is_valid' => empty($conflicts)
        ];
    }

    private static function calculateExpertiseMatch(string $subjectLower, string $teacherExpertise): int
    {
        $expLower = mb_strtolower($teacherExpertise, 'UTF-8');
        $score = 10;

        foreach (self::SUBJECT_EXPERTISE_MAP as $keyword => $expertises) {
            if (str_contains($subjectLower, $keyword)) {
                foreach ($expertises as $exp) {
                    if (str_contains($expLower, mb_strtolower($exp, 'UTF-8'))) {
                        return 80;
                    }
                }
            }
        }

        if (str_contains($expLower, $subjectLower) || str_contains($subjectLower, $expLower)) {
            return 90;
        }

        return $score;
    }
}

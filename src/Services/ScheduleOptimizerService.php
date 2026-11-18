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
     * Danh sách các ca học chuẩn của HUIT phân rõ 2 loại:
     * - Lý thuyết: 3 tiết/ca
     * - Thực hành: 5 tiết/ca
     */
    public const SHIFTS = [
        // 1. LÝ THUYẾT (3 TIẾT)
        'Lý thuyết: Ca 1 (Tiết 1-3)' => [
            'type' => 'theory',
            'periods' => 3,
            'session' => 'morning',
            'start' => 1,
            'end' => 3,
            'time' => '07:00 - 09:30',
            'name' => 'Lý thuyết: Ca 1 (Tiết 1-3)'
        ],
        'Lý thuyết: Ca 2 (Tiết 4-6)' => [
            'type' => 'theory',
            'periods' => 3,
            'session' => 'morning',
            'start' => 4,
            'end' => 6,
            'time' => '09:45 - 12:15',
            'name' => 'Lý thuyết: Ca 2 (Tiết 4-6)'
        ],
        'Lý thuyết: Ca 3 (Tiết 7-9)' => [
            'type' => 'theory',
            'periods' => 3,
            'session' => 'afternoon',
            'start' => 7,
            'end' => 9,
            'time' => '13:00 - 15:30',
            'name' => 'Lý thuyết: Ca 3 (Tiết 7-9)'
        ],
        'Lý thuyết: Ca 4 (Tiết 10-12)' => [
            'type' => 'theory',
            'periods' => 3,
            'session' => 'afternoon',
            'start' => 10,
            'end' => 12,
            'time' => '15:45 - 18:15',
            'name' => 'Lý thuyết: Ca 4 (Tiết 10-12)'
        ],
        'Lý thuyết: Ca 5 (Tiết 13-15)' => [
            'type' => 'theory',
            'periods' => 3,
            'session' => 'evening',
            'start' => 13,
            'end' => 15,
            'time' => '18:30 - 21:00',
            'name' => 'Lý thuyết: Ca 5 (Tiết 13-15)'
        ],

        // 2. THỰC HÀNH (5 TIẾT)
        'Thực hành: Ca Sáng (Tiết 1-5)' => [
            'type' => 'practice',
            'periods' => 5,
            'session' => 'morning',
            'start' => 1,
            'end' => 5,
            'time' => '07:00 - 11:30',
            'name' => 'Thực hành: Ca Sáng (Tiết 1-5)'
        ],
        'Thực hành: Ca Chiều (Tiết 7-11)' => [
            'type' => 'practice',
            'periods' => 5,
            'session' => 'afternoon',
            'start' => 7,
            'end' => 11,
            'time' => '13:00 - 17:30',
            'name' => 'Thực hành: Ca Chiều (Tiết 7-11)'
        ],
    ];

    /**
     * Kiểm tra xem 2 ca học có bị trùng tiết (Overlap) hay không
     */
    public static function isPeriodOverlap(string $shiftA, string $shiftB): bool
    {
        $infoA = self::SHIFTS[$shiftA] ?? null;
        $infoB = self::SHIFTS[$shiftB] ?? null;

        if (!$infoA || !$infoB) {
            return $shiftA === $shiftB;
        }

        // Hai ca giao nhau khi: startA <= endB VÀ startB <= endA
        return ($infoA['start'] <= $infoB['end']) && ($infoB['start'] <= $infoA['end']);
    }

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
        'chế biến' => ['Công nghệ thực phẩm', 'Kỹ thuật chế biến thực phẩm'],
        'kinh tế' => ['Quản trị kinh doanh', 'Tài chính - Ngân hàng', 'Kinh tế quốc tế'],
        'marketing' => ['Quản trị kinh doanh', 'Marketing & E-Commerce'],
        'quản trị' => ['Quản trị kinh doanh'],
        'điện' => ['Kỹ thuật điện - Điện tử', 'Tự động hóa', 'Cơ điện tử'],
        'điện tử' => ['Kỹ thuật điện - Điện tử', 'Viễn thông'],
        'tiếng anh' => ['Ngôn ngữ Anh', 'Sư phạm tiếng Anh'],
        'tiếng hàn' => ['Ngôn ngữ Hàn Quốc'],
        'tiếng trung' => ['Ngôn ngữ Trung Quốc'],
    ];

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

        foreach ($teachers as $teacher) {
            $teacherId = (int)$teacher['id'];
            $expertise = $teacher['expertise'];

            // Lấy tất cả các ca dạy của giảng viên trong ngày này
            $stmtDay = $db->prepare("SELECT s.*, b.branch_name 
                                    FROM schedules s 
                                    JOIN branches b ON s.branch_id = b.id 
                                    WHERE s.teacher_id = ? AND s.day_of_week = ? 
                                    ORDER BY s.shift_or_periods ASC");
            $stmtDay->execute([$teacherId, $dayOfWeek]);
            $daySchedules = $stmtDay->fetchAll();

            // 1. Kiểm tra TRÙNG TIẾT (Overlap Conflict)
            $isBusy = false;
            $busyReason = '';

            foreach ($daySchedules as $sch) {
                if (self::isPeriodOverlap($sch['shift_or_periods'], $shift)) {
                    $isBusy = true;
                    $busyReason = "ĐÃ BẬN: Đang dạy môn '{$sch['subject_name']}' ({$sch['shift_or_periods']}) tại {$sch['branch_name']} (Phòng {$sch['room']})";
                    break;
                }
            }

            if ($isBusy) {
                $results[] = [
                    'teacher' => $teacher,
                    'is_available' => false,
                    'status' => 'busy',
                    'badge_class' => 'bg-red-100 text-red-800 border-red-200',
                    'reason' => $busyReason,
                    'score' => -100
                ];
                continue;
            }

            // 2. Tính điểm phù hợp chuyên môn
            $expertiseScore = self::calculateExpertiseMatch($subjectLower, $expertise);

            // 3. Phân tích các ca dạy khác của giảng viên trong cùng ngày (Tối ưu hóa di chuyển đa cơ sở)
            $travelStatus = 'empty_day'; // Ngày trống hoàn toàn
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
                        // Nếu cùng buổi học (ví dụ cùng Morning hoặc cùng Afternoon)
                        if ($shiftInfo && $schShiftInfo && $shiftInfo['session'] === $schShiftInfo['session']) {
                            $hasDifferentBranchAdjacent = true;
                        } else {
                            $hasDifferentBranchOtherSession = true;
                        }
                    }
                }

                if ($hasDifferentBranchAdjacent) {
                    $travelStatus = 'impossible_travel';
                    $travelReason = "CẢNH BÁO NGUY HIỂM: Giảng viên đã có ca khác trong cùng buổi tại {$diffBranchName}! Không đủ thời gian di chuyển.";
                    $travelScoreBonus = -50;
                } elseif ($hasSameBranch) {
                    $travelStatus = 'optimal_same_branch';
                    $travelReason = "TỐI ƯU CAO NHẤT: Giảng viên đã có ca dạy tại cơ sở này trong ngày (Tiết kiệm thời gian di chuyển).";
                    $travelScoreBonus = 50;
                } elseif ($hasDifferentBranchOtherSession) {
                    $travelStatus = 'warning_different_branch';
                    $travelReason = "LƯU Ý DI CHUYỂN: Giảng viên có ca khác buổi tại {$diffBranchName}. Cần di chuyển giữa 2 cơ sở.";
                    $travelScoreBonus = 0;
                }
            }

            // Tổng điểm xếp hạng
            $totalScore = $expertiseScore + $travelScoreBonus;

            $badgeClass = 'bg-emerald-100 text-emerald-800 border-emerald-200';
            $badgeText = 'Khả dụng & Phù hợp';

            if ($travelStatus === 'optimal_same_branch') {
                $badgeClass = 'bg-blue-100 text-blue-800 border-blue-200';
                $badgeText = '⭐ Khuyên dùng (Tối ưu cùng cơ sở)';
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

        // Sắp xếp theo điểm số từ cao xuống thấp
        usort($results, fn($a, $b) => $b['score'] <=> $a['score']);

        return $results;
    }

    /**
     * Kiểm tra xung đột trước khi lưu lịch dạy (kiểm tra giao nhau các tiết)
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

        // 1. Kiểm tra TRÙNG PHÒNG HỌC (Room Conflict tại cơ sở này trong cùng ngày)
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
        $existingRoomSchedules = $stmtRoom->fetchAll();

        foreach ($existingRoomSchedules as $rs) {
            if (self::isPeriodOverlap($rs['shift_or_periods'], $shift)) {
                $conflicts[] = "TRÙNG PHÒNG HỌC: Phòng {$room} vào Thứ {$dayOfWeek} đã có lớp '{$rs['subject_name']}' ({$rs['shift_or_periods']}) của GV {$rs['teacher_name']}!";
                break;
            }
        }

        // 2. Kiểm tra TRÙNG GIẢNG VIÊN (Teacher Conflict trên toàn bộ cơ sở trong cùng ngày)
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
        $existingTeacherSchedules = $stmtTeacher->fetchAll();

        foreach ($existingTeacherSchedules as $ts) {
            if (self::isPeriodOverlap($ts['shift_or_periods'], $shift)) {
                $conflicts[] = "TRÙNG LỊCH GIẢNG VIÊN: Giảng viên đã có lịch dạy môn '{$ts['subject_name']}' ({$ts['shift_or_periods']}) tại {$ts['branch_name']} (Phòng {$ts['room']})!";
                break;
            }
        }

        // 3. Kiểm tra TỐI ƯU HÓA DI CHUYỂN GIỮA CÁC CƠ SỞ
        $shiftInfo = self::SHIFTS[$shift] ?? null;

        foreach ($existingTeacherSchedules as $sch) {
            if ((int)$sch['branch_id'] !== $branchId) {
                $schShiftInfo = self::SHIFTS[$sch['shift_or_periods']] ?? null;
                if ($shiftInfo && $schShiftInfo && $shiftInfo['session'] === $schShiftInfo['session']) {
                    $warnings[] = "XUNG ĐỘT DI CHUYỂN TRONG BUỔI: Giảng viên có ca ({$sch['shift_or_periods']}) tại {$sch['branch_name']}. Việc di chuyển giữa 2 cơ sở trong cùng 1 buổi là không khả thi!";
                } else {
                    $warnings[] = "LƯU Ý DI CHUYỂN KHÁC BUỔI: Giảng viên có ca dạy tại {$sch['branch_name']} ({$sch['shift_or_periods']}) trong cùng ngày. Vui lòng đảm bảo giảng viên có đủ thời gian di chuyển.";
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

    /**
     * Tính điểm tương đồng giữa môn học và chuyên môn
     */
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

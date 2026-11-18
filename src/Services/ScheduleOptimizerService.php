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
     * Danh sách các ca học chuẩn của HUIT
     */
    public const SHIFTS = [
        'Ca 1: Sáng (Tiết 1-3)' => ['session' => 'morning', 'start' => 1, 'end' => 3, 'time' => '07:00 - 09:30'],
        'Ca 2: Sáng (Tiết 4-6)' => ['session' => 'morning', 'start' => 4, 'end' => 6, 'time' => '09:45 - 12:15'],
        'Ca 3: Chiều (Tiết 7-9)' => ['session' => 'afternoon', 'start' => 7, 'end' => 9, 'time' => '13:00 - 15:30'],
        'Ca 4: Chiều (Tiết 10-12)' => ['session' => 'afternoon', 'start' => 10, 'end' => 12, 'time' => '15:45 - 18:15'],
        'Ca 5: Tối (Tiết 13-15)' => ['session' => 'evening', 'start' => 13, 'end' => 15, 'time' => '18:30 - 21:00'],
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

            // 1. Kiểm tra trùng lịch chính xác tại khung giờ này (Hard Conflict)
            $stmtBusy = $db->prepare("SELECT s.*, b.branch_name 
                                     FROM schedules s 
                                     JOIN branches b ON s.branch_id = b.id 
                                     WHERE s.teacher_id = ? AND s.day_of_week = ? AND s.shift_or_periods = ?");
            $stmtBusy->execute([$teacherId, $dayOfWeek, $shift]);
            $busySchedule = $stmtBusy->fetch();

            if ($busySchedule) {
                $results[] = [
                    'teacher' => $teacher,
                    'is_available' => false,
                    'status' => 'busy',
                    'badge_class' => 'bg-red-100 text-red-800 border-red-200',
                    'reason' => "ĐÃ BẬN: Đang dạy môn '{$busySchedule['subject_name']}' tại {$busySchedule['branch_name']} (Phòng {$busySchedule['room']})",
                    'score' => -100
                ];
                continue;
            }

            // 2. Tính điểm phù hợp chuyên môn
            $expertiseScore = self::calculateExpertiseMatch($subjectLower, $expertise);

            // 3. Phân tích các ca dạy khác của giảng viên trong cùng ngày (Tối ưu hóa di chuyển đa cơ sở)
            $stmtDay = $db->prepare("SELECT s.*, b.branch_name 
                                    FROM schedules s 
                                    JOIN branches b ON s.branch_id = b.id 
                                    WHERE s.teacher_id = ? AND s.day_of_week = ? 
                                    ORDER BY s.shift_or_periods ASC");
            $stmtDay->execute([$teacherId, $dayOfWeek]);
            $daySchedules = $stmtDay->fetchAll();

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
                        // Kiểm tra xem có phải cùng buổi không (Morning / Afternoon / Evening)
                        if ($shiftInfo && $schShiftInfo && $shiftInfo['session'] === $schShiftInfo['session']) {
                            $hasDifferentBranchAdjacent = true;
                        } else {
                            $hasDifferentBranchOtherSession = true;
                        }
                    }
                }

                if ($hasDifferentBranchAdjacent) {
                    // Cực kỳ nguy hiểm: Dạy 2 cơ sở khác nhau trong cùng 1 buổi (ví dụ tiết 1-3 ở CS1, tiết 4-6 ở CS2)
                    $travelStatus = 'impossible_travel';
                    $travelReason = "CẢNH BÁO NGUY HIỂM: Giảng viên đã có ca khác trong cùng buổi tại {$diffBranchName}! Không đủ thời gian di chuyển.";
                    $travelScoreBonus = -50;
                } elseif ($hasSameBranch) {
                    // Tuyệt vời: Đã có ca tại cùng cơ sở trong ngày, không cần di chuyển cơ sở
                    $travelStatus = 'optimal_same_branch';
                    $travelReason = "TỐI ƯU CAO NHẤT: Giảng viên đã có lịch dạy tại cơ sở này trong ngày (Tiết kiệm thời gian di chuyển).";
                    $travelScoreBonus = 50;
                } elseif ($hasDifferentBranchOtherSession) {
                    // Cảnh báo nhẹ: Khác buổi, có thể di chuyển vào giờ nghỉ trưa nhưng cần lưu ý
                    $travelStatus = 'warning_different_branch';
                    $travelReason = "LƯU Ý DI CHUYỂN: Giảng viên có ca khác buổi tại {$diffBranchName}. Cần di chuyển giữa 2 cơ sở.";
                    $travelScoreBonus = 0;
                }
            }

            // Tổng điểm xếp hạng
            $totalScore = $expertiseScore + $travelScoreBonus;

            // Xác định nhãn hiển thị
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

        // 1. Kiểm tra TRÙNG PHÒNG HỌC (Room Conflict tại cơ sở này)
        $sqlRoom = "SELECT s.*, t.full_name AS teacher_name 
                    FROM schedules s 
                    JOIN teachers t ON s.teacher_id = t.id 
                    WHERE s.branch_id = ? AND s.room = ? AND s.day_of_week = ? AND s.shift_or_periods = ?";
        $paramsRoom = [$branchId, $room, $dayOfWeek, $shift];
        if ($excludeScheduleId) {
            $sqlRoom .= " AND s.id != ?";
            $paramsRoom[] = $excludeScheduleId;
        }
        $stmtRoom = $db->prepare($sqlRoom);
        $stmtRoom->execute($paramsRoom);
        $roomConflict = $stmtRoom->fetch();

        if ($roomConflict) {
            $conflicts[] = "TRÙNG PHÒNG HỌC: Phòng {$room} vào Thứ {$dayOfWeek} ({$shift}) đã được xếp cho giảng viên {$roomConflict['teacher_name']} (Môn: {$roomConflict['subject_name']})!";
        }

        // 2. Kiểm tra TRÙNG GIẢNG VIÊN (Teacher Conflict trên toàn bộ cơ sở)
        $sqlTeacher = "SELECT s.*, b.branch_name 
                       FROM schedules s 
                       JOIN branches b ON s.branch_id = b.id 
                       WHERE s.teacher_id = ? AND s.day_of_week = ? AND s.shift_or_periods = ?";
        $paramsTeacher = [$teacherId, $dayOfWeek, $shift];
        if ($excludeScheduleId) {
            $sqlTeacher .= " AND s.id != ?";
            $paramsTeacher[] = $excludeScheduleId;
        }
        $stmtTeacher = $db->prepare($sqlTeacher);
        $stmtTeacher->execute($paramsTeacher);
        $teacherConflict = $stmtTeacher->fetch();

        if ($teacherConflict) {
            $conflicts[] = "TRÙNG LỊCH GIẢNG VIÊN: Giảng viên đã có lịch dạy môn '{$teacherConflict['subject_name']}' tại {$teacherConflict['branch_name']} (Phòng {$teacherConflict['room']}) vào khung giờ này!";
        }

        // 3. Kiểm tra TỐI ƯU HÓA DI CHUYỂN GIỮA CÁC CƠ SỞ
        $sqlOtherShifts = "SELECT s.*, b.branch_name 
                           FROM schedules s 
                           JOIN branches b ON s.branch_id = b.id 
                           WHERE s.teacher_id = ? AND s.day_of_week = ?";
        $paramsOther = [$teacherId, $dayOfWeek];
        if ($excludeScheduleId) {
            $sqlOtherShifts .= " AND s.id != ?";
            $paramsOther[] = $excludeScheduleId;
        }
        $stmtOther = $db->prepare($sqlOtherShifts);
        $stmtOther->execute($paramsOther);
        $otherSchedules = $stmtOther->fetchAll();

        $shiftInfo = self::SHIFTS[$shift] ?? null;

        foreach ($otherSchedules as $sch) {
            if ((int)$sch['branch_id'] !== $branchId) {
                $schShiftInfo = self::SHIFTS[$sch['shift_or_periods']] ?? null;
                if ($shiftInfo && $schShiftInfo && $shiftInfo['session'] === $schShiftInfo['session']) {
                    $warnings[] = "XUNG ĐỘT DI CHUYỂN TRONG BUỔI: Giảng viên có ca khác ({$sch['shift_or_periods']}) tại {$sch['branch_name']}. Việc di chuyển giữa 2 cơ sở trong cùng 1 buổi là không khả thi!";
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
        $score = 10; // Điểm sàn cơ bản

        // Kiểm tra khớp từ khóa
        foreach (self::SUBJECT_EXPERTISE_MAP as $keyword => $expertises) {
            if (str_contains($subjectLower, $keyword)) {
                foreach ($expertises as $exp) {
                    if (str_contains($expLower, mb_strtolower($exp, 'UTF-8'))) {
                        return 80; // Trùng khớp chuyên môn trực tiếp
                    }
                }
            }
        }

        // Kiểm tra tương đồng từ ngữ trực tiếp
        if (str_contains($expLower, $subjectLower) || str_contains($subjectLower, $expLower)) {
            return 90;
        }

        return $score;
    }
}

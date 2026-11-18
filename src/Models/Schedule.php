<?php

namespace App\Models;

use App\Core\Model;
use App\Services\ScheduleOptimizerService;
use PDO;

class Schedule extends Model
{
    public static function getAll(array $filters = []): array
    {
        $sql = "SELECT s.*, 
                       t.full_name AS teacher_name, t.email AS teacher_email, t.phone AS teacher_phone, t.expertise AS teacher_expertise,
                       b.branch_name, b.address AS branch_address
                FROM schedules s
                JOIN teachers t ON s.teacher_id = t.id
                JOIN branches b ON s.branch_id = b.id
                WHERE 1=1";
        
        $params = [];

        if (!empty($filters['branch_id'])) {
            $sql .= " AND s.branch_id = ?";
            $params[] = $filters['branch_id'];
        }

        if (!empty($filters['teacher_id'])) {
            $sql .= " AND s.teacher_id = ?";
            $params[] = $filters['teacher_id'];
        }

        if (!empty($filters['class_type'])) {
            $sql .= " AND s.class_type = ?";
            $params[] = $filters['class_type'];
        }

        if (!empty($filters['session_time'])) {
            $sql .= " AND s.session_time = ?";
            $params[] = $filters['session_time'];
        }

        if (!empty($filters['day_of_week'])) {
            $sql .= " AND s.day_of_week = ?";
            $params[] = $filters['day_of_week'];
        }

        if (!empty($filters['keyword'])) {
            $sql .= " AND (s.subject_name LIKE ? OR s.room LIKE ? OR t.full_name LIKE ?)";
            $keyword = "%{$filters['keyword']}%";
            $params[] = $keyword;
            $params[] = $keyword;
            $params[] = $keyword;
        }

        $sql .= " ORDER BY s.day_of_week ASC, s.period_start ASC, s.room ASC";

        $stmt = self::db()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $stmt = self::db()->prepare("SELECT s.*, 
                                            t.full_name AS teacher_name, t.email AS teacher_email, t.expertise AS teacher_expertise,
                                            b.branch_name, b.address AS branch_address
                                     FROM schedules s
                                     JOIN teachers t ON s.teacher_id = t.id
                                     JOIN branches b ON s.branch_id = b.id
                                     WHERE s.id = ?");
        $stmt->execute([$id]);
        $schedule = $stmt->fetch();
        return $schedule ?: null;
    }

    public static function create(array $data): int
    {
        $shift = $data['shift_or_periods'];
        $shiftInfo = ScheduleOptimizerService::SHIFTS[$shift] ?? null;

        $sessionTime = $shiftInfo['session'] ?? self::detectSessionTime($shift);
        $classType = $data['class_type'] ?? ($shiftInfo['type'] ?? 'theory');
        $start = $data['period_start'] ?? ($shiftInfo['start'] ?? 1);
        $end = $data['period_end'] ?? ($shiftInfo['end'] ?? 3);

        $stmt = self::db()->prepare("INSERT INTO schedules 
            (teacher_id, branch_id, subject_name, room, day_of_week, shift_or_periods, class_type, period_start, period_end, session_time, notes) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->execute([
            $data['teacher_id'],
            $data['branch_id'],
            $data['subject_name'],
            $data['room'],
            $data['day_of_week'],
            $shift,
            $classType,
            $start,
            $end,
            $sessionTime,
            $data['notes'] ?? null
        ]);

        return (int)self::db()->lastInsertId();
    }

    public static function update(int $id, array $data): bool
    {
        $shift = $data['shift_or_periods'];
        $shiftInfo = ScheduleOptimizerService::SHIFTS[$shift] ?? null;

        $sessionTime = $shiftInfo['session'] ?? self::detectSessionTime($shift);
        $classType = $data['class_type'] ?? ($shiftInfo['type'] ?? 'theory');
        $start = $data['period_start'] ?? ($shiftInfo['start'] ?? 1);
        $end = $data['period_end'] ?? ($shiftInfo['end'] ?? 3);

        $stmt = self::db()->prepare("UPDATE schedules SET 
            teacher_id = ?, 
            branch_id = ?, 
            subject_name = ?, 
            room = ?, 
            day_of_week = ?, 
            shift_or_periods = ?, 
            class_type = ?,
            period_start = ?,
            period_end = ?,
            session_time = ?, 
            notes = ? 
            WHERE id = ?");

        return $stmt->execute([
            $data['teacher_id'],
            $data['branch_id'],
            $data['subject_name'],
            $data['room'],
            $data['day_of_week'],
            $shift,
            $classType,
            $start,
            $end,
            $sessionTime,
            $data['notes'] ?? null,
            $id
        ]);
    }

    public static function delete(int $id): bool
    {
        $stmt = self::db()->prepare("DELETE FROM schedules WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function getByTeacher(int $teacherId): array
    {
        $stmt = self::db()->prepare("SELECT s.*, b.branch_name, b.address AS branch_address 
                                     FROM schedules s 
                                     JOIN branches b ON s.branch_id = b.id 
                                     WHERE s.teacher_id = ? 
                                     ORDER BY s.day_of_week ASC, s.period_start ASC");
        $stmt->execute([$teacherId]);
        return $stmt->fetchAll();
    }

    public static function getByBranch(int $branchId): array
    {
        $stmt = self::db()->prepare("SELECT s.*, t.full_name AS teacher_name 
                                     FROM schedules s 
                                     JOIN teachers t ON s.teacher_id = t.id 
                                     WHERE s.branch_id = ? 
                                     ORDER BY s.day_of_week ASC, s.period_start ASC");
        $stmt->execute([$branchId]);
        return $stmt->fetchAll();
    }

    public static function count(): int
    {
        return (int)self::db()->query("SELECT COUNT(*) FROM schedules")->fetchColumn();
    }

    public static function detectSessionTime(string $shift): string
    {
        if (stripos($shift, 'Sáng') !== false) {
            return 'morning';
        }
        if (stripos($shift, 'Chiều') !== false) {
            return 'afternoon';
        }
        return 'evening';
    }
}

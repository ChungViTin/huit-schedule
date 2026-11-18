<?php

namespace App\Models;

use App\Core\Model;
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

        $sql .= " ORDER BY s.day_of_week ASC, s.shift_or_periods ASC, s.room ASC";

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
        $sessionTime = self::detectSessionTime($data['shift_or_periods']);

        $stmt = self::db()->prepare("INSERT INTO schedules 
            (teacher_id, branch_id, subject_name, room, day_of_week, shift_or_periods, session_time, notes) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->execute([
            $data['teacher_id'],
            $data['branch_id'],
            $data['subject_name'],
            $data['room'],
            $data['day_of_week'],
            $data['shift_or_periods'],
            $sessionTime,
            $data['notes'] ?? null
        ]);

        return (int)self::db()->lastInsertId();
    }

    public static function update(int $id, array $data): bool
    {
        $sessionTime = self::detectSessionTime($data['shift_or_periods']);

        $stmt = self::db()->prepare("UPDATE schedules SET 
            teacher_id = ?, 
            branch_id = ?, 
            subject_name = ?, 
            room = ?, 
            day_of_week = ?, 
            shift_or_periods = ?, 
            session_time = ?, 
            notes = ? 
            WHERE id = ?");

        return $stmt->execute([
            $data['teacher_id'],
            $data['branch_id'],
            $data['subject_name'],
            $data['room'],
            $data['day_of_week'],
            $data['shift_or_periods'],
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
                                     ORDER BY s.day_of_week ASC, s.shift_or_periods ASC");
        $stmt->execute([$teacherId]);
        return $stmt->fetchAll();
    }

    public static function getByBranch(int $branchId): array
    {
        $stmt = self::db()->prepare("SELECT s.*, t.full_name AS teacher_name 
                                     FROM schedules s 
                                     JOIN teachers t ON s.teacher_id = t.id 
                                     WHERE s.branch_id = ? 
                                     ORDER BY s.day_of_week ASC, s.shift_or_periods ASC");
        $stmt->execute([$branchId]);
        return $stmt->fetchAll();
    }

    public static function count(): int
    {
        return (int)self::db()->query("SELECT COUNT(*) FROM schedules")->fetchColumn();
    }

    public static function detectSessionTime(string $shift): string
    {
        if (isset(\App\Services\ScheduleOptimizerService::SHIFTS[$shift]['session'])) {
            return \App\Services\ScheduleOptimizerService::SHIFTS[$shift]['session'];
        }
        if (stripos($shift, 'Sáng') !== false || stripos($shift, 'Tiết 1') !== false || stripos($shift, 'Tiết 4') !== false) {
            return 'morning';
        }
        if (stripos($shift, 'Chiều') !== false || stripos($shift, 'Tiết 7') !== false || stripos($shift, 'Tiết 10') !== false) {
            return 'afternoon';
        }
        return 'evening';
    }
}

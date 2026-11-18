<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Teacher extends Model
{
    public static function getAll(): array
    {
        $stmt = self::db()->query("SELECT t.*, COUNT(s.id) as schedule_count 
                                   FROM teachers t 
                                   LEFT JOIN schedules s ON t.id = s.teacher_id 
                                   GROUP BY t.id 
                                   ORDER BY t.full_name ASC");
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $stmt = self::db()->prepare("SELECT * FROM teachers WHERE id = ?");
        $stmt->execute([$id]);
        $teacher = $stmt->fetch();
        return $teacher ?: null;
    }

    public static function findByEmail(string $email): ?array
    {
        $stmt = self::db()->prepare("SELECT * FROM teachers WHERE email = ?");
        $stmt->execute([$email]);
        $teacher = $stmt->fetch();
        return $teacher ?: null;
    }

    public static function create(array $data): int
    {
        $password = !empty($data['password']) 
            ? password_hash($data['password'], PASSWORD_BCRYPT) 
            : password_hash('123456', PASSWORD_BCRYPT);

        $stmt = self::db()->prepare("INSERT INTO teachers (full_name, email, phone, expertise, password) 
                                   VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['full_name'],
            $data['email'],
            $data['phone'],
            $data['expertise'],
            $password
        ]);
        return (int)self::db()->lastInsertId();
    }

    public static function update(int $id, array $data): bool
    {
        if (!empty($data['password'])) {
            $hashed = password_hash($data['password'], PASSWORD_BCRYPT);
            $stmt = self::db()->prepare("UPDATE teachers SET full_name = ?, email = ?, phone = ?, expertise = ?, password = ? WHERE id = ?");
            return $stmt->execute([$data['full_name'], $data['email'], $data['phone'], $data['expertise'], $hashed, $id]);
        }

        $stmt = self::db()->prepare("UPDATE teachers SET full_name = ?, email = ?, phone = ?, expertise = ? WHERE id = ?");
        return $stmt->execute([$data['full_name'], $data['email'], $data['phone'], $data['expertise'], $id]);
    }

    public static function delete(int $id): bool
    {
        $stmt = self::db()->prepare("DELETE FROM teachers WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function count(): int
    {
        return (int)self::db()->query("SELECT COUNT(*) FROM teachers")->fetchColumn();
    }

    public static function getDistinctExpertise(): array
    {
        $stmt = self::db()->query("SELECT DISTINCT expertise FROM teachers WHERE expertise IS NOT NULL AND expertise != '' ORDER BY expertise ASC");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function getByExpertise(string $expertise): array
    {
        $stmt = self::db()->prepare("SELECT * FROM teachers WHERE expertise LIKE ? ORDER BY full_name ASC");
        $stmt->execute(['%' . $expertise . '%']);
        return $stmt->fetchAll();
    }
}

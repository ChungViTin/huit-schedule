<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Branch extends Model
{
    public static function getAll(): array
    {
        $stmt = self::db()->query("SELECT b.*, COUNT(s.id) as schedule_count 
                                   FROM branches b 
                                   LEFT JOIN schedules s ON b.id = s.branch_id 
                                   GROUP BY b.id 
                                   ORDER BY b.id ASC");
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $stmt = self::db()->prepare("SELECT * FROM branches WHERE id = ?");
        $stmt->execute([$id]);
        $branch = $stmt->fetch();
        return $branch ?: null;
    }

    public static function create(array $data): int
    {
        $stmt = self::db()->prepare("INSERT INTO branches (branch_name, address) VALUES (?, ?)");
        $stmt->execute([$data['branch_name'], $data['address']]);
        return (int)self::db()->lastInsertId();
    }

    public static function update(int $id, array $data): bool
    {
        $stmt = self::db()->prepare("UPDATE branches SET branch_name = ?, address = ? WHERE id = ?");
        return $stmt->execute([$data['branch_name'], $data['address'], $id]);
    }

    public static function delete(int $id): bool
    {
        $stmt = self::db()->prepare("DELETE FROM branches WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function count(): int
    {
        return (int)self::db()->query("SELECT COUNT(*) FROM branches")->fetchColumn();
    }
}

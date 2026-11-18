<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Admin extends Model
{
    public static function findByUsernameOrEmail(string $login): ?array
    {
        $stmt = self::db()->prepare("SELECT * FROM admins WHERE username = ? OR email = ?");
        $stmt->execute([$login, $login]);
        $admin = $stmt->fetch();
        return $admin ?: null;
    }

    public static function find(int $id): ?array
    {
        $stmt = self::db()->prepare("SELECT * FROM admins WHERE id = ?");
        $stmt->execute([$id]);
        $admin = $stmt->fetch();
        return $admin ?: null;
    }

    public static function create(array $data): int
    {
        $hashed = password_hash($data['password'], PASSWORD_BCRYPT);
        $stmt = self::db()->prepare("INSERT INTO admins (username, email, password, full_name, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['username'],
            $data['email'],
            $hashed,
            $data['full_name'],
            $data['role'] ?? 'admin'
        ]);
        return (int)self::db()->lastInsertId();
    }
}

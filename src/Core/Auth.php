<?php

namespace App\Core;

class Auth
{
    public static function initSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function check(): bool
    {
        self::initSession();
        return isset($_SESSION['user']);
    }

    public static function user(): ?array
    {
        self::initSession();
        return $_SESSION['user'] ?? null;
    }

    public static function role(): ?string
    {
        self::initSession();
        return $_SESSION['user']['role'] ?? null;
    }

    public static function isAdmin(): bool
    {
        return self::role() === 'admin';
    }

    public static function isTeacher(): bool
    {
        return self::role() === 'teacher';
    }

    public static function login(array $user): void
    {
        self::initSession();
        $_SESSION['user'] = $user;
    }

    public static function logout(): void
    {
        self::initSession();
        unset($_SESSION['user']);
        session_destroy();
    }

    public static function requireAdmin(): void
    {
        self::initSession();
        if (!self::check() || !self::isAdmin()) {
            $_SESSION['flash_error'] = 'Vui lòng đăng nhập với quyền Quản trị viên!';
            header('Location: /login');
            exit;
        }
    }

    public static function requireTeacher(): void
    {
        self::initSession();
        if (!self::check() || !self::isTeacher()) {
            $_SESSION['flash_error'] = 'Vui lòng đăng nhập tài khoản Giảng viên!';
            header('Location: /teacher-login');
            exit;
        }
    }
}

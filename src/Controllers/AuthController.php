<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Admin;
use App\Models\Teacher;

class AuthController extends Controller
{
    public function showLogin(): void
    {
        if (Auth::check()) {
            if (Auth::isAdmin()) {
                $this->redirect('/dashboard');
            } else {
                $this->redirect('/portal');
            }
        }
        $this->render('auth/login', [], 'auth');
    }

    public function login(): void
    {
        $login = trim($_POST['login'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($login) || empty($password)) {
            $this->setFlash('error', 'Vui lòng nhập đầy đủ tài khoản và mật khẩu!');
            $this->redirect('/login');
        }

        $admin = Admin::findByUsernameOrEmail($login);

        if ($admin && password_verify($password, $admin['password'])) {
            Auth::login([
                'id' => $admin['id'],
                'username' => $admin['username'],
                'full_name' => $admin['full_name'],
                'email' => $admin['email'],
                'role' => 'admin'
            ]);
            $this->setFlash('success', 'Đăng nhập thành công! Chào mừng bạn đến với HUIT Schedule Hub.');
            $this->redirect('/dashboard');
        }

        $this->setFlash('error', 'Tài khoản hoặc mật khẩu không chính xác!');
        $this->redirect('/login');
    }

    public function showTeacherLogin(): void
    {
        if (Auth::check()) {
            if (Auth::isTeacher()) {
                $this->redirect('/portal');
            } else {
                $this->redirect('/dashboard');
            }
        }
        $this->render('auth/teacher-login', [], 'auth');
    }

    public function teacherLogin(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $this->setFlash('error', 'Vui lòng nhập email và mật khẩu!');
            $this->redirect('/teacher-login');
        }

        $teacher = Teacher::findByEmail($email);

        if ($teacher && password_verify($password, $teacher['password'])) {
            Auth::login([
                'id' => $teacher['id'],
                'full_name' => $teacher['full_name'],
                'email' => $teacher['email'],
                'phone' => $teacher['phone'],
                'expertise' => $teacher['expertise'],
                'role' => 'teacher'
            ]);
            $this->setFlash('success', "Chào Thầy/Cô {$teacher['full_name']}! Chúc Thầy/Cô có ngày giảng dạy hiệu quả.");
            $this->redirect('/portal');
        }

        $this->setFlash('error', 'Email hoặc mật khẩu giảng viên không chính xác!');
        $this->redirect('/teacher-login');
    }

    public function logout(): void
    {
        Auth::logout();
        $this->redirect('/login');
    }
}

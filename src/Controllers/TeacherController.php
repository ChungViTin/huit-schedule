<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Teacher;

class TeacherController extends Controller
{
    public function index(): void
    {
        Auth::requireAdmin();

        $teachers = Teacher::getAll();
        $this->render('teachers/index', [
            'teachers' => $teachers,
            'user' => Auth::user()
        ]);
    }

    public function create(): void
    {
        Auth::requireAdmin();

        $this->render('teachers/create', [
            'user' => Auth::user()
        ]);
    }

    public function store(): void
    {
        Auth::requireAdmin();

        $fullName = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $expertise = trim($_POST['expertise'] ?? '');
        $password = $_POST['password'] ?? '123456';

        if (empty($fullName) || empty($email) || empty($phone) || empty($expertise)) {
            $this->setFlash('error', 'Vui lòng điền đầy đủ các thông tin bắt buộc (*)!');
            $this->redirect('/teachers/create');
        }

        if (Teacher::findByEmail($email)) {
            $this->setFlash('error', "Email [{$email}] đã tồn tại trong hệ thống!");
            $this->redirect('/teachers/create');
        }

        Teacher::create([
            'full_name' => $fullName,
            'email' => $email,
            'phone' => $phone,
            'expertise' => $expertise,
            'password' => $password
        ]);

        $this->setFlash('success', 'Thêm giảng viên thành công!');
        $this->redirect('/teachers');
    }

    public function edit(string $id): void
    {
        Auth::requireAdmin();

        $teacher = Teacher::find((int)$id);
        if (!$teacher) {
            $this->setFlash('error', 'Giảng viên không tồn tại!');
            $this->redirect('/teachers');
        }

        $this->render('teachers/edit', [
            'teacher' => $teacher,
            'user' => Auth::user()
        ]);
    }

    public function update(string $id): void
    {
        Auth::requireAdmin();

        $teacherId = (int)$id;
        $fullName = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $expertise = trim($_POST['expertise'] ?? '');
        $password = $_POST['password'] ?? null;

        if (empty($fullName) || empty($email) || empty($phone) || empty($expertise)) {
            $this->setFlash('error', 'Vui lòng điền đầy đủ các thông tin bắt buộc (*)!');
            $this->redirect("/teachers/{$teacherId}/edit");
        }

        $existing = Teacher::findByEmail($email);
        if ($existing && (int)$existing['id'] !== $teacherId) {
            $this->setFlash('error', "Email [{$email}] đã được giảng viên khác sử dụng!");
            $this->redirect("/teachers/{$teacherId}/edit");
        }

        $updateData = [
            'full_name' => $fullName,
            'email' => $email,
            'phone' => $phone,
            'expertise' => $expertise
        ];
        if (!empty($password)) {
            $updateData['password'] = $password;
        }

        Teacher::update($teacherId, $updateData);

        $this->setFlash('success', 'Cập nhật thông tin giảng viên thành công!');
        $this->redirect('/teachers');
    }

    public function delete(string $id): void
    {
        Auth::requireAdmin();

        Teacher::delete((int)$id);
        $this->setFlash('success', 'Đã xóa giảng viên thành công!');
        $this->redirect('/teachers');
    }
}

<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Branch;
use App\Models\Schedule;
use App\Models\Teacher;
use App\Services\ScheduleOptimizerService;

class ScheduleController extends Controller
{
    public function index(): void
    {
        Auth::requireAdmin();

        $branchId = isset($_GET['branch_id']) && $_GET['branch_id'] !== '' ? (int)$_GET['branch_id'] : null;
        $teacherId = isset($_GET['teacher_id']) && $_GET['teacher_id'] !== '' ? (int)$_GET['teacher_id'] : null;
        $dayOfWeek = isset($_GET['day_of_week']) && $_GET['day_of_week'] !== '' ? (int)$_GET['day_of_week'] : null;
        $classType = trim($_GET['class_type'] ?? '');
        $keyword = trim($_GET['keyword'] ?? '');

        $filters = [];
        if ($branchId) $filters['branch_id'] = $branchId;
        if ($teacherId) $filters['teacher_id'] = $teacherId;
        if ($dayOfWeek) $filters['day_of_week'] = $dayOfWeek;
        if (!empty($classType)) $filters['class_type'] = $classType;
        if (!empty($keyword)) $filters['keyword'] = $keyword;

        $schedules = Schedule::getAll($filters);
        $branches = Branch::getAll();
        $teachers = Teacher::getAll();

        $this->render('schedules/index', [
            'schedules' => $schedules,
            'branches' => $branches,
            'teachers' => $teachers,
            'filters' => [
                'branch_id' => $branchId,
                'teacher_id' => $teacherId,
                'day_of_week' => $dayOfWeek,
                'class_type' => $classType,
                'keyword' => $keyword
            ],
            'user' => Auth::user()
        ]);
    }

    public function create(): void
    {
        Auth::requireAdmin();

        $branches = Branch::getAll();
        $teachers = Teacher::getAll();
        $shifts = array_keys(ScheduleOptimizerService::SHIFTS);

        $this->render('schedules/create', [
            'branches' => $branches,
            'teachers' => $teachers,
            'shifts' => $shifts,
            'shiftDetails' => ScheduleOptimizerService::SHIFTS,
            'user' => Auth::user()
        ]);
    }

    public function store(): void
    {
        Auth::requireAdmin();

        $teacherId = (int)($_POST['teacher_id'] ?? 0);
        $branchId = (int)($_POST['branch_id'] ?? 0);
        $subjectName = trim($_POST['subject_name'] ?? '');
        $room = trim($_POST['room'] ?? '');
        $dayOfWeek = (int)($_POST['day_of_week'] ?? 0);
        $shiftOrPeriods = trim($_POST['shift_or_periods'] ?? '');
        $notes = trim($_POST['notes'] ?? '');

        if (!$teacherId || !$branchId || empty($subjectName) || empty($room) || !$dayOfWeek || empty($shiftOrPeriods)) {
            $this->setFlash('error', 'Vui lòng điền đầy đủ các thông tin bắt buộc (*)!');
            $this->redirect('/schedules/create');
        }

        // Kiểm tra xung đột thông minh
        $conflictCheck = ScheduleOptimizerService::checkConflicts(
            $teacherId,
            $branchId,
            $room,
            $dayOfWeek,
            $shiftOrPeriods
        );

        if ($conflictCheck['has_conflict']) {
            $errorMsg = implode("<br>", $conflictCheck['conflicts']);
            $this->setFlash('error', $errorMsg);
            $this->redirect('/schedules/create');
        }

        Schedule::create([
            'teacher_id' => $teacherId,
            'branch_id' => $branchId,
            'subject_name' => $subjectName,
            'room' => $room,
            'day_of_week' => $dayOfWeek,
            'shift_or_periods' => $shiftOrPeriods,
            'notes' => $notes
        ]);

        $successMsg = 'Thêm lịch dạy thành công!';
        if ($conflictCheck['has_warning']) {
            $successMsg .= ' Lưu ý: ' . implode(" | ", $conflictCheck['warnings']);
        }

        $this->setFlash('success', $successMsg);
        $this->redirect('/schedules');
    }

    public function edit(string $id): void
    {
        Auth::requireAdmin();

        $schedule = Schedule::find((int)$id);
        if (!$schedule) {
            $this->setFlash('error', 'Lịch dạy không tồn tại!');
            $this->redirect('/schedules');
        }

        $branches = Branch::getAll();
        $teachers = Teacher::getAll();
        $shifts = array_keys(ScheduleOptimizerService::SHIFTS);

        $this->render('schedules/edit', [
            'schedule' => $schedule,
            'branches' => $branches,
            'teachers' => $teachers,
            'shifts' => $shifts,
            'shiftDetails' => ScheduleOptimizerService::SHIFTS,
            'user' => Auth::user()
        ]);
    }

    public function update(string $id): void
    {
        Auth::requireAdmin();

        $scheduleId = (int)$id;
        $teacherId = (int)($_POST['teacher_id'] ?? 0);
        $branchId = (int)($_POST['branch_id'] ?? 0);
        $subjectName = trim($_POST['subject_name'] ?? '');
        $room = trim($_POST['room'] ?? '');
        $dayOfWeek = (int)($_POST['day_of_week'] ?? 0);
        $shiftOrPeriods = trim($_POST['shift_or_periods'] ?? '');
        $notes = trim($_POST['notes'] ?? '');

        if (!$teacherId || !$branchId || empty($subjectName) || empty($room) || !$dayOfWeek || empty($shiftOrPeriods)) {
            $this->setFlash('error', 'Vui lòng điền đầy đủ các thông tin bắt buộc (*)!');
            $this->redirect("/schedules/{$scheduleId}/edit");
        }

        // Kiểm tra xung đột trừ chính bản ghi đang sửa
        $conflictCheck = ScheduleOptimizerService::checkConflicts(
            $teacherId,
            $branchId,
            $room,
            $dayOfWeek,
            $shiftOrPeriods,
            $scheduleId
        );

        if ($conflictCheck['has_conflict']) {
            $errorMsg = implode("<br>", $conflictCheck['conflicts']);
            $this->setFlash('error', $errorMsg);
            $this->redirect("/schedules/{$scheduleId}/edit");
        }

        Schedule::update($scheduleId, [
            'teacher_id' => $teacherId,
            'branch_id' => $branchId,
            'subject_name' => $subjectName,
            'room' => $room,
            'day_of_week' => $dayOfWeek,
            'shift_or_periods' => $shiftOrPeriods,
            'notes' => $notes
        ]);

        $successMsg = 'Cập nhật lịch dạy thành công!';
        if ($conflictCheck['has_warning']) {
            $successMsg .= ' Lưu ý: ' . implode(" | ", $conflictCheck['warnings']);
        }

        $this->setFlash('success', $successMsg);
        $this->redirect('/schedules');
    }

    public function delete(string $id): void
    {
        Auth::requireAdmin();

        Schedule::delete((int)$id);
        $this->setFlash('success', 'Đã xóa lịch dạy thành công!');
        $this->redirect('/schedules');
    }
}

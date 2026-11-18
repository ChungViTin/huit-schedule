<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Branch;
use App\Models\Schedule;
use App\Models\Teacher;
use App\Services\ScheduleOptimizerService;

class DashboardController extends Controller
{
    /**
     * TRANG CHỦ DASHBOARD: Tổng quan, Thống kê, Sơ đồ và Biểu đồ phân bổ thông minh
     */
    public function index(): void
    {
        Auth::requireAdmin();

        $branches = Branch::getAll();
        $teachers = Teacher::getAll();
        $schedules = Schedule::getAll();

        $totalBranches = count($branches);
        $totalTeachers = count($teachers);
        $totalSchedules = count($schedules);

        // 1. Phân bổ theo Cơ sở (Dùng cho Biểu đồ Cột / Bar Chart)
        $branchChartLabels = [];
        $branchChartData = [];
        foreach ($branches as $b) {
            $branchChartLabels[] = $b['branch_name'];
            $count = count(array_filter($schedules, fn($s) => (int)$s['branch_id'] === (int)$b['id']));
            $branchChartData[] = $count;
        }

        // 2. Phân bổ theo Buổi học (Sáng / Chiều / Tối - Dùng cho Donut Chart)
        $sessionCount = ['morning' => 0, 'afternoon' => 0, 'evening' => 0];
        $typeCount = ['practice' => 0, 'theory' => 0];

        foreach ($schedules as $s) {
            $st = $s['session_time'] ?? Schedule::detectSessionTime($s['shift_or_periods']);
            if (isset($sessionCount[$st])) {
                $sessionCount[$st]++;
            } else {
                $sessionCount['morning']++;
            }

            // Phân loại thực hành vs lý thuyết
            $isPractice = stripos($s['subject_name'], 'thực hành') !== false 
                       || stripos($s['subject_name'], 'lab') !== false
                       || stripos($s['subject_name'], 'web') !== false
                       || stripos($s['subject_name'], 'vi sinh') !== false;
            if ($isPractice) {
                $typeCount['practice']++;
            } else {
                $typeCount['theory']++;
            }
        }

        // 3. Phân bổ theo Thứ trong tuần (Thứ 2 đến Thứ 7, CN)
        $dayOfWeekDistribution = [2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0];
        foreach ($schedules as $s) {
            $d = (int)$s['day_of_week'];
            if (isset($dayOfWeekDistribution[$d])) {
                $dayOfWeekDistribution[$d]++;
            }
        }

        // 4. Danh sách các ca học tiêu biểu gần đây
        $recentSchedules = array_slice($schedules, 0, 6);

        // 5. Thống kê giảng viên có nhiều ca dạy nhất (Top 5)
        usort($teachers, fn($a, $b) => (int)$b['schedule_count'] <=> (int)$a['schedule_count']);
        $topTeachers = array_slice($teachers, 0, 5);

        $this->render('dashboard/index', [
            'branches' => $branches,
            'teachers' => $teachers,
            'totalBranches' => $totalBranches,
            'totalTeachers' => $totalTeachers,
            'totalSchedules' => $totalSchedules,
            'branchChartLabels' => $branchChartLabels,
            'branchChartData' => $branchChartData,
            'sessionCount' => $sessionCount,
            'typeCount' => $typeCount,
            'dayOfWeekDistribution' => $dayOfWeekDistribution,
            'recentSchedules' => $recentSchedules,
            'topTeachers' => $topTeachers,
            'user' => Auth::user()
        ]);
    }

    /**
     * TRANG LỊCH THEO TUẦN RIÊNG BIỆT: Ma trận Thời khóa biểu tuần theo chuẩn Ảnh 3
     */
    public function weekly(): void
    {
        Auth::requireAdmin();

        $selectedBranchId = isset($_GET['branch_id']) && $_GET['branch_id'] !== '' ? (int)$_GET['branch_id'] : null;
        $selectedTeacherId = isset($_GET['teacher_id']) && $_GET['teacher_id'] !== '' ? (int)$_GET['teacher_id'] : null;

        $branches = Branch::getAll();
        $teachers = Teacher::getAll();

        // Lấy danh sách lịch theo bộ lọc
        $filters = [];
        if ($selectedBranchId) {
            $filters['branch_id'] = $selectedBranchId;
        }
        if ($selectedTeacherId) {
            $filters['teacher_id'] = $selectedTeacherId;
        }

        $schedules = Schedule::getAll($filters);

        // Xây dựng ma trận lịch tuần
        $timetableGrid = [];
        $shifts = array_keys(ScheduleOptimizerService::SHIFTS);

        for ($day = 2; $day <= 8; $day++) {
            foreach ($shifts as $shift) {
                $timetableGrid[$day][$shift] = [];
            }
        }

        foreach ($schedules as $s) {
            $day = (int)$s['day_of_week'];
            $shift = $s['shift_or_periods'];
            if (!isset($timetableGrid[$day][$shift])) {
                $timetableGrid[$day][$shift] = [];
            }
            $timetableGrid[$day][$shift][] = $s;
        }

        $totalSchedules = count($schedules);

        $this->render('dashboard/weekly', [
            'branches' => $branches,
            'teachers' => $teachers,
            'selectedBranchId' => $selectedBranchId,
            'selectedTeacherId' => $selectedTeacherId,
            'timetableGrid' => $timetableGrid,
            'shifts' => $shifts,
            'shiftDetails' => ScheduleOptimizerService::SHIFTS,
            'totalSchedules' => $totalSchedules,
            'user' => Auth::user()
        ]);
    }
}

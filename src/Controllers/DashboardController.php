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
     * TRANG CHỦ DASHBOARD: Thống kê, Sơ đồ với các COMBOBOX lọc đa chiều
     */
    public function index(): void
    {
        Auth::requireAdmin();

        $selectedBranchId = isset($_GET['branch_id']) && $_GET['branch_id'] !== '' ? (int)$_GET['branch_id'] : null;
        $selectedTeacherId = isset($_GET['teacher_id']) && $_GET['teacher_id'] !== '' ? (int)$_GET['teacher_id'] : null;
        $selectedClassType = trim($_GET['class_type'] ?? '');
        $selectedSessionTime = trim($_GET['session_time'] ?? '');
        $selectedDayOfWeek = isset($_GET['day_of_week']) && $_GET['day_of_week'] !== '' ? (int)$_GET['day_of_week'] : null;

        $branches = Branch::getAll();
        $teachers = Teacher::getAll();

        // Xây dựng bộ lọc cho Schedule::getAll
        $filters = [];
        if ($selectedBranchId) $filters['branch_id'] = $selectedBranchId;
        if ($selectedTeacherId) $filters['teacher_id'] = $selectedTeacherId;
        if ($selectedClassType) $filters['class_type'] = $selectedClassType;
        if ($selectedSessionTime) $filters['session_time'] = $selectedSessionTime;
        if ($selectedDayOfWeek) $filters['day_of_week'] = $selectedDayOfWeek;

        $schedules = Schedule::getAll($filters);

        $totalBranches = count($branches);
        $totalTeachers = count($teachers);
        $totalSchedules = count($schedules);

        // 1. Phân bổ theo Cơ sở (Chart.js Bar Chart)
        $branchChartLabels = [];
        $branchChartData = [];
        foreach ($branches as $b) {
            $branchChartLabels[] = $b['branch_name'];
            $count = count(array_filter($schedules, fn($s) => (int)$s['branch_id'] === (int)$b['id']));
            $branchChartData[] = $count;
        }

        // 2. Phân bổ theo Buổi học (Chart.js Donut Chart)
        $sessionCount = ['morning' => 0, 'afternoon' => 0, 'evening' => 0];
        $typeCount = ['practice' => 0, 'theory' => 0];

        foreach ($schedules as $s) {
            $st = $s['session_time'] ?? Schedule::detectSessionTime($s['shift_or_periods']);
            if (isset($sessionCount[$st])) {
                $sessionCount[$st]++;
            } else {
                $sessionCount['morning']++;
            }

            if (($s['class_type'] ?? '') === 'practice') {
                $typeCount['practice']++;
            } else {
                $typeCount['theory']++;
            }
        }

        // 3. Phân bổ theo Thứ trong tuần (Chart.js Line Chart)
        $dayOfWeekDistribution = [2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0];
        foreach ($schedules as $s) {
            $d = (int)$s['day_of_week'];
            if (isset($dayOfWeekDistribution[$d])) {
                $dayOfWeekDistribution[$d]++;
            }
        }

        // 4. Danh sách các ca học gần đây
        $recentSchedules = array_slice($schedules, 0, 6);

        // 5. Thống kê top giảng viên
        usort($teachers, fn($a, $b) => (int)$b['schedule_count'] <=> (int)$a['schedule_count']);
        $topTeachers = array_slice($teachers, 0, 5);

        $this->render('dashboard/index', [
            'branches' => $branches,
            'teachers' => $teachers,
            'filters' => [
                'branch_id' => $selectedBranchId,
                'teacher_id' => $selectedTeacherId,
                'class_type' => $selectedClassType,
                'session_time' => $selectedSessionTime,
                'day_of_week' => $selectedDayOfWeek,
            ],
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
        $selectedClassType = trim($_GET['class_type'] ?? '');

        $branches = Branch::getAll();
        $teachers = Teacher::getAll();

        $filters = [];
        if ($selectedBranchId) $filters['branch_id'] = $selectedBranchId;
        if ($selectedTeacherId) $filters['teacher_id'] = $selectedTeacherId;
        if ($selectedClassType) $filters['class_type'] = $selectedClassType;

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
            if (isset($timetableGrid[$day][$shift])) {
                $timetableGrid[$day][$shift][] = $s;
            }
        }

        $totalSchedules = count($schedules);

        $this->render('dashboard/weekly', [
            'branches' => $branches,
            'teachers' => $teachers,
            'selectedBranchId' => $selectedBranchId,
            'selectedTeacherId' => $selectedTeacherId,
            'selectedClassType' => $selectedClassType,
            'timetableGrid' => $timetableGrid,
            'shifts' => $shifts,
            'shiftDetails' => ScheduleOptimizerService::SHIFTS,
            'totalSchedules' => $totalSchedules,
            'user' => Auth::user()
        ]);
    }
}

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

        $selectedBranchId = isset($_GET['branch_id']) && $_GET['branch_id'] !== '' ? (int)$_GET['branch_id'] : null;
        $selectedType = isset($_GET['type']) && $_GET['type'] !== '' ? trim($_GET['type']) : null;
        $selectedSemester = isset($_GET['semester']) && $_GET['semester'] !== '' ? trim($_GET['semester']) : 'HK2_2026_2027';
        $selectedDay = isset($_GET['day_of_week']) && $_GET['day_of_week'] !== '' ? (int)$_GET['day_of_week'] : null;

        $branches = Branch::getAll();
        $teachers = Teacher::getAll();

        // 1. Lọc theo các tiêu chí từ Combo Box
        $filters = [];
        if ($selectedBranchId) {
            $filters['branch_id'] = $selectedBranchId;
        }
        if ($selectedDay) {
            $filters['day_of_week'] = $selectedDay;
        }

        $schedules = Schedule::getAll($filters);

        // Lọc theo Loại hình Ca học: Lý thuyết (3 tiết) vs Thực hành (5 tiết)
        if ($selectedType) {
            $schedules = array_values(array_filter($schedules, function($s) use ($selectedType) {
                $shiftInfo = ScheduleOptimizerService::SHIFTS[$s['shift_or_periods']] ?? null;
                $isPractice = ($shiftInfo['type'] ?? '') === 'practice'
                           || stripos($s['shift_or_periods'], 'thực hành') !== false
                           || stripos($s['subject_name'], 'thực hành') !== false
                           || stripos($s['subject_name'], 'lab') !== false;
                return $selectedType === 'practice' ? $isPractice : !$isPractice;
            }));
        }

        // Lọc / Giả lập theo Học kỳ
        if ($selectedSemester === 'HK1_2026_2027') {
            $schedules = array_slice($schedules, 0, (int)ceil(count($schedules) * 0.65));
        } elseif ($selectedSemester === 'HK_HE_2026_2027') {
            $schedules = array_values(array_filter($schedules, function($s) {
                return (int)$s['id'] % 2 === 0;
            }));
        }

        $totalBranches = count($branches);
        $totalTeachers = count($teachers);
        $totalSchedules = count($schedules);

        // 2. Phân bổ theo Cơ sở (Dùng cho Biểu đồ Cột / Bar Chart)
        $branchChartLabels = [];
        $branchChartData = [];
        foreach ($branches as $b) {
            $branchChartLabels[] = $b['branch_name'];
            $count = count(array_filter($schedules, fn($s) => (int)$s['branch_id'] === (int)$b['id']));
            $branchChartData[] = $count;
        }

        // 3. Phân bổ theo Buổi học (Sáng / Chiều / Tối - Dùng cho Donut Chart)
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
            $shiftInfo = ScheduleOptimizerService::SHIFTS[$s['shift_or_periods']] ?? null;
            $isPractice = ($shiftInfo['type'] ?? '') === 'practice'
                       || stripos($s['shift_or_periods'], 'thực hành') !== false 
                       || stripos($s['subject_name'], 'thực hành') !== false 
                       || stripos($s['subject_name'], 'lab') !== false;

            if ($isPractice) {
                $typeCount['practice']++;
            } else {
                $typeCount['theory']++;
            }
        }

        // 4. Phân bổ theo Thứ trong tuần (Thứ 2 đến Thứ 7, CN)
        $dayOfWeekDistribution = [2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0];
        foreach ($schedules as $s) {
            $d = (int)$s['day_of_week'];
            if (isset($dayOfWeekDistribution[$d])) {
                $dayOfWeekDistribution[$d]++;
            }
        }

        // 5. Danh sách các ca học tiêu biểu gần đây
        $recentSchedules = array_slice($schedules, 0, 6);

        // 6. Thống kê giảng viên có nhiều ca dạy nhất (Top 5 - tính động theo bộ lọc)
        $teacherCounts = [];
        foreach ($schedules as $s) {
            $tId = (int)$s['teacher_id'];
            $teacherCounts[$tId] = ($teacherCounts[$tId] ?? 0) + 1;
        }
        $teacherList = [];
        foreach ($teachers as $t) {
            $tId = (int)$t['id'];
            $cnt = $teacherCounts[$tId] ?? 0;
            $teacherList[] = array_merge($t, ['schedule_count' => $cnt]);
        }
        usort($teacherList, fn($a, $b) => (int)$b['schedule_count'] <=> (int)$a['schedule_count']);
        $topTeachers = array_slice($teacherList, 0, 5);

        $this->render('dashboard/index', [
            'branches' => $branches,
            'teachers' => $teachers,
            'totalBranches' => $totalBranches,
            'totalTeachers' => $totalTeachers,
            'totalSchedules' => $totalSchedules,
            'selectedBranchId' => $selectedBranchId,
            'selectedType' => $selectedType,
            'selectedSemester' => $selectedSemester,
            'selectedDay' => $selectedDay,
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

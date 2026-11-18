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
    public function index(): void
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

        // Xây dựng ma trận lịch tuần: [day_of_week][shift] => [schedules...]
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

        // Thống kê phân bổ theo từng cơ sở
        $branchDistribution = [];
        foreach ($branches as $branch) {
            $branchId = (int)$branch['id'];
            $count = count(array_filter($schedules, fn($item) => (int)$item['branch_id'] === $branchId));
            $branchDistribution[] = [
                'name' => $branch['branch_name'],
                'count' => $count
            ];
        }

        $totalBranches = count($branches);
        $totalTeachers = count($teachers);
        $totalSchedules = Schedule::count();

        $this->render('dashboard/index', [
            'branches' => $branches,
            'teachers' => $teachers,
            'selectedBranchId' => $selectedBranchId,
            'selectedTeacherId' => $selectedTeacherId,
            'timetableGrid' => $timetableGrid,
            'shifts' => $shifts,
            'shiftDetails' => ScheduleOptimizerService::SHIFTS,
            'branchDistribution' => $branchDistribution,
            'totalBranches' => $totalBranches,
            'totalTeachers' => $totalTeachers,
            'totalSchedules' => $totalSchedules,
            'user' => Auth::user()
        ]);
    }
}

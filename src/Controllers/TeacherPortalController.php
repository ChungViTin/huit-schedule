<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Schedule;
use App\Models\Teacher;
use App\Services\ScheduleOptimizerService;

class TeacherPortalController extends Controller
{
    public function index(): void
    {
        Auth::requireTeacher();
        $user = Auth::user();
        $teacherId = (int)$user['id'];

        $teacher = Teacher::find($teacherId);
        $schedules = Schedule::getByTeacher($teacherId);

        // Xây dựng ma trận lịch tuần của giảng viên
        $shifts = array_keys(ScheduleOptimizerService::SHIFTS);
        $timetableGrid = [];
        for ($day = 2; $day <= 8; $day++) {
            foreach ($shifts as $shift) {
                $timetableGrid[$day][$shift] = [];
            }
        }

        // Kiểm tra xem có ngày nào GV phải di chuyển đa cơ sở không
        $travelAlertsByDay = [];

        $schedulesByDay = [];
        foreach ($schedules as $s) {
            $day = (int)$s['day_of_week'];
            $shift = $s['shift_or_periods'];
            if (!isset($timetableGrid[$day][$shift])) {
                $timetableGrid[$day][$shift] = [];
            }
            $timetableGrid[$day][$shift][] = $s;
            $schedulesByDay[$day][] = $s;
        }

        for ($day = 2; $day <= 8; $day++) {
            if (!empty($schedulesByDay[$day])) {
                $branchesOnDay = [];
                foreach ($schedulesByDay[$day] as $sch) {
                    $branchesOnDay[$sch['branch_name']] = true;
                }
                if (count($branchesOnDay) > 1) {
                    $branchList = implode(', ', array_keys($branchesOnDay));
                    $travelAlertsByDay[$day] = "Cần di chuyển giữa các cơ sở trong ngày: {$branchList}";
                }
            }
        }

        $viewMode = $_GET['view'] ?? 'week'; // week hoặc list

        $this->render('portal/index', [
            'teacher' => $teacher,
            'schedules' => $schedules,
            'timetableGrid' => $timetableGrid,
            'shifts' => $shifts,
            'shiftDetails' => ScheduleOptimizerService::SHIFTS,
            'travelAlertsByDay' => $travelAlertsByDay,
            'viewMode' => $viewMode,
            'user' => $user
        ], 'portal');
    }
}

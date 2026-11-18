<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\ScheduleOptimizerService;
use App\Models\Branch;

class ApiController extends Controller
{
    public function suggestTeachers(): void
    {
        $subjectName = trim($_GET['subject_name'] ?? '');
        $dayOfWeek = (int)($_GET['day_of_week'] ?? 2);
        $shift = trim($_GET['shift'] ?? '');
        $branchId = (int)($_GET['branch_id'] ?? 0);

        if (empty($shift) || !$branchId) {
            $this->json([
                'success' => false,
                'message' => 'Vui lòng chọn cơ sở và ca học để nhận gợi ý.',
                'data' => []
            ]);
        }

        $suggestions = ScheduleOptimizerService::suggestTeachers($subjectName, $dayOfWeek, $shift, $branchId);

        $this->json([
            'success' => true,
            'data' => $suggestions
        ]);
    }

    public function checkConflicts(): void
    {
        $teacherId = (int)($_GET['teacher_id'] ?? 0);
        $branchId = (int)($_GET['branch_id'] ?? 0);
        $room = trim($_GET['room'] ?? '');
        $dayOfWeek = (int)($_GET['day_of_week'] ?? 0);
        $shift = trim($_GET['shift'] ?? '');
        $excludeId = isset($_GET['exclude_id']) && $_GET['exclude_id'] !== '' ? (int)$_GET['exclude_id'] : null;

        if (!$teacherId || !$branchId || empty($room) || !$dayOfWeek || empty($shift)) {
            $this->json([
                'success' => true,
                'is_valid' => true,
                'has_conflict' => false,
                'conflicts' => [],
                'has_warning' => false,
                'warnings' => []
            ]);
        }

        $result = ScheduleOptimizerService::checkConflicts(
            $teacherId,
            $branchId,
            $room,
            $dayOfWeek,
            $shift,
            $excludeId
        );

        $this->json(array_merge(['success' => true], $result));
    }
}

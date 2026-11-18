<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\Core\Auth;
use App\Core\Router;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\ScheduleController;
use App\Controllers\TeacherController;
use App\Controllers\BranchController;
use App\Controllers\TeacherPortalController;
use App\Controllers\ApiController;
use Dotenv\Dotenv;

// Nạp biến môi trường .env
$rootPath = dirname(__DIR__);
if (file_exists($rootPath . '/.env')) {
    $dotenv = Dotenv::createImmutable($rootPath);
    $dotenv->safeLoad();
}

Auth::initSession();

$router = new Router();

// Trang chủ điều hướng thông minh
$router->get('/', [AuthController::class, 'showLogin']);

// Authentication
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/teacher-login', [AuthController::class, 'showTeacherLogin']);
$router->post('/teacher-login', [AuthController::class, 'teacherLogin']);
$router->get('/logout', [AuthController::class, 'logout']);

// Admin Dashboard & Schedules
$router->get('/dashboard', [DashboardController::class, 'index']);

// Schedules CRUD
$router->get('/schedules', [ScheduleController::class, 'index']);
$router->get('/schedules/create', [ScheduleController::class, 'create']);
$router->post('/schedules', [ScheduleController::class, 'store']);
$router->get('/schedules/{id}/edit', [ScheduleController::class, 'edit']);
$router->post('/schedules/{id}/edit', [ScheduleController::class, 'update']);
$router->post('/schedules/{id}/delete', [ScheduleController::class, 'delete']);

// Teachers CRUD
$router->get('/teachers', [TeacherController::class, 'index']);
$router->get('/teachers/create', [TeacherController::class, 'create']);
$router->post('/teachers', [TeacherController::class, 'store']);
$router->get('/teachers/{id}/edit', [TeacherController::class, 'edit']);
$router->post('/teachers/{id}/edit', [TeacherController::class, 'update']);
$router->post('/teachers/{id}/delete', [TeacherController::class, 'delete']);

// Branches CRUD
$router->get('/branches', [BranchController::class, 'index']);
$router->get('/branches/create', [BranchController::class, 'create']);
$router->post('/branches', [BranchController::class, 'store']);
$router->get('/branches/{id}/edit', [BranchController::class, 'edit']);
$router->post('/branches/{id}/edit', [BranchController::class, 'update']);
$router->post('/branches/{id}/delete', [BranchController::class, 'delete']);

// Teacher Portal
$router->get('/portal', [TeacherPortalController::class, 'index']);

// APIs
$router->get('/api/suggest-teachers', [ApiController::class, 'suggestTeachers']);
$router->get('/api/check-conflicts', [ApiController::class, 'checkConflicts']);

$router->dispatch();

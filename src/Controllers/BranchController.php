<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Branch;

class BranchController extends Controller
{
    public function index(): void
    {
        Auth::requireAdmin();

        $branches = Branch::getAll();
        $this->render('branches/index', [
            'branches' => $branches,
            'user' => Auth::user()
        ]);
    }

    public function create(): void
    {
        Auth::requireAdmin();

        $this->render('branches/create', [
            'user' => Auth::user()
        ]);
    }

    public function store(): void
    {
        Auth::requireAdmin();

        $branchName = trim($_POST['branch_name'] ?? '');
        $address = trim($_POST['address'] ?? '');

        if (empty($branchName) || empty($address)) {
            $this->setFlash('error', 'Vui lòng điền tên cơ sở và địa chỉ!');
            $this->redirect('/branches/create');
        }

        Branch::create([
            'branch_name' => $branchName,
            'address' => $address
        ]);

        $this->setFlash('success', 'Thêm cơ sở mới thành công!');
        $this->redirect('/branches');
    }

    public function edit(string $id): void
    {
        Auth::requireAdmin();

        $branch = Branch::find((int)$id);
        if (!$branch) {
            $this->setFlash('error', 'Cơ sở không tồn tại!');
            $this->redirect('/branches');
        }

        $this->render('branches/edit', [
            'branch' => $branch,
            'user' => Auth::user()
        ]);
    }

    public function update(string $id): void
    {
        Auth::requireAdmin();

        $branchId = (int)$id;
        $branchName = trim($_POST['branch_name'] ?? '');
        $address = trim($_POST['address'] ?? '');

        if (empty($branchName) || empty($address)) {
            $this->setFlash('error', 'Vui lòng điền tên cơ sở và địa chỉ!');
            $this->redirect("/branches/{$branchId}/edit");
        }

        Branch::update($branchId, [
            'branch_name' => $branchName,
            'address' => $address
        ]);

        $this->setFlash('success', 'Cập nhật cơ sở thành công!');
        $this->redirect('/branches');
    }

    public function delete(string $id): void
    {
        Auth::requireAdmin();

        Branch::delete((int)$id);
        $this->setFlash('success', 'Đã xóa cơ sở thành công!');
        $this->redirect('/branches');
    }
}

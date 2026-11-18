<?php $pageTitle = 'Đăng nhập Quản trị viên - HUIT Schedule Hub'; ?>

<!-- Switch role tabs -->
<div class="flex p-1 bg-slate-100 rounded-xl mb-6">
    <a href="/login" class="flex-1 text-center py-2 text-xs font-semibold rounded-lg bg-white shadow-sm text-huit-blue flex items-center justify-center space-x-1">
        <i class="ti ti-shield"></i>
        <span>Phòng Đào Tạo</span>
    </a>
    <a href="/teacher-login" class="flex-1 text-center py-2 text-xs font-medium rounded-lg text-slate-500 hover:text-slate-800 transition flex items-center justify-center space-x-1">
        <i class="ti ti-school"></i>
        <span>Giảng Viên</span>
    </a>
</div>

<h2 class="text-xl font-bold text-slate-800 text-center mb-1">Cổng Quản Trị Đào Tạo</h2>
<p class="text-xs text-slate-500 text-center mb-6">Dành cho cán bộ quản lý phân lịch giảng dạy</p>

<form action="/login" method="POST" class="space-y-4">
    <div>
        <label for="login" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Tài khoản / Email</label>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                <i class="ti ti-user"></i>
            </span>
            <input type="text" id="login" name="login" required 
                placeholder="admin hoặc admin@huit.edu.vn" 
                class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-huit-blue focus:bg-white transition">
        </div>
    </div>

    <div>
        <label for="password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Mật khẩu</label>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                <i class="ti ti-lock"></i>
            </span>
            <input type="password" id="password" name="password" required 
                placeholder="••••••••" 
                class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-huit-blue focus:bg-white transition">
        </div>
    </div>

    <button type="submit" 
        class="w-full py-2.5 px-4 bg-huit-blue hover:bg-huit-dark text-white font-semibold rounded-xl shadow-md shadow-blue-900/20 hover:shadow-lg transition flex items-center justify-center space-x-2">
        <span>Đăng nhập Quản trị</span>
        <i class="ti ti-arrow-right"></i>
    </button>
</form>

<div class="mt-6 pt-4 border-t border-slate-100 text-center">
    <div class="bg-blue-50/70 p-3 rounded-xl text-xs text-slate-600 text-left">
        <p class="font-semibold text-huit-blue mb-1">Tài khoản demo Admin:</p>
        <p>• Username: <code class="bg-white px-1.5 py-0.5 rounded border border-blue-200 font-mono text-huit-blue">admin</code></p>
        <p class="mt-1">• Mật khẩu: <code class="bg-white px-1.5 py-0.5 rounded border border-blue-200 font-mono text-huit-blue">admin123</code></p>
    </div>
</div>

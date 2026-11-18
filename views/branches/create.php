<?php
$pageTitle = 'Thêm Cơ Sở Đào Tạo - HUIT Schedule Hub';
?>

<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center space-x-2 text-xs text-slate-500 mb-1">
                <a href="/branches" class="hover:underline">Cơ sở</a>
                <span>/</span>
                <span class="text-slate-800 font-semibold">Thêm mới</span>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight flex items-center space-x-2">
                <i class="ti ti-building-plus text-huit-blue"></i>
                <span>Thêm Cơ Sở Đào Tạo Mới</span>
            </h1>
        </div>
        <a href="/branches" class="inline-flex items-center space-x-1 text-xs text-slate-600 hover:text-slate-900 bg-white border border-slate-200 px-3 py-2 rounded-xl transition">
            <i class="ti ti-arrow-left"></i>
            <span>Quay lại</span>
        </a>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <form action="/branches" method="POST" class="space-y-4">
            
            <div>
                <label for="branch_name" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Tên Cơ Sở <span class="text-red-500">*</span></label>
                <input type="text" id="branch_name" name="branch_name" required placeholder="Ví dụ: Cơ sở chính Lê Trọng Tấn, Trung tâm Thí nghiệm..." class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-blue">
            </div>

            <div>
                <label for="address" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Địa Chỉ <span class="text-red-500">*</span></label>
                <input type="text" id="address" name="address" required placeholder="Ví dụ: 140 Lê Trọng Tấn, P. Tây Thạnh, Q. Tân Phú, TP.HCM" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-huit-blue">
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="/branches" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-medium text-slate-600 hover:bg-slate-50 transition">Hủy bỏ</a>
                <button type="submit" class="px-6 py-2.5 bg-huit-blue hover:bg-huit-dark text-white text-xs font-bold rounded-xl shadow-md transition flex items-center space-x-1.5">
                    <i class="ti ti-check"></i>
                    <span>Lưu Cơ Sở</span>
                </button>
            </div>

        </form>
    </div>

</div>

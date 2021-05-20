<div class="border-bottom pb-4">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'suppliers.index' ? 'active' : '' }}"
                href="{{ route('suppliers.index') }}">Thông tin chung</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'suppliers.edit' ? 'active' : '' }}"
                href="{{ route('suppliers.edit') }}">Cập nhật thông tin</a>
        </li>
        <li class="nav-item"
            href="{{ route('suppliers.changePassword') }}">
            <a class="nav-link  {{ Route::currentRouteName() == 'suppliers.changePassword' ? 'active' : '' }}" href="{{ route('suppliers.changePassword') }}">Đổi mật khẩu</a>
        </li>
    </ul>
</div>

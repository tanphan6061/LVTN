<div class="border-bottom pb-4">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active {{ Route::currentRouteName() == 'suppliers.index' ? 'active' : '' }}"
                href="{{ route('suppliers.index') }}">Đơn chưa xác nhận</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'suppliers.edit' ? 'active' : '' }}"
                href="{{ route('suppliers.edit') }}">Đơn đang giao</a>
        </li>
        <li class="nav-item"
            href="{{ route('suppliers.changePassword') }}">
            <a class="nav-link  {{ Route::currentRouteName() == 'suppliers.changePassword' ? 'active' : '' }}" href="{{ route('suppliers.changePassword') }}">Đơn đã giao</a>
        </li>
        <li class="nav-item"
            href="{{ route('suppliers.changePassword') }}">
            <a class="nav-link  {{ Route::currentRouteName() == 'suppliers.changePassword' ? 'active' : '' }}" href="{{ route('suppliers.changePassword') }}">Đơn đã huỷ</a>
        </li>
    </ul>
</div>

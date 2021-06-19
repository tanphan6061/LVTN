<div class="border-bottom pb-4">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link {{ request()->query('type') == 'processing' ? 'active' : '' }}"
                href="{{ route('orders.index', ['type' => 'processing']) }}">Đơn chưa xác nhận</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->query('type') == 'shipping' ? 'active' : '' }}"
                href="{{ route('orders.index', ['type' => 'shipping']) }}">Đơn đang giao</a>
        </li>
        <li class="nav-item">
            <a class="nav-link  {{ request()->query('type') == 'delivered' ? 'active' : '' }}"
                href="{{ route('orders.index', ['type' => 'delivered']) }}">Đơn đã giao</a>
        </li>
        <li class="nav-item">
            <a class="nav-link  {{ request()->query('type') == 'cancel' ? 'active' : '' }}"
                href="{{ route('orders.index', ['type' => 'cancel']) }}">Đơn đã huỷ</a>
        </li>
    </ul>
</div>

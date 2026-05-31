@php
    $user = auth()->user();
    $roleLabels = [
        'admin' => 'مدیر مجموعه',
        'website_manager' => 'مدیر وبسایت',
        'staff' => 'پرسنل',
        'customer' => 'مشتری',
    ];
@endphp
<header class="app-topbar">
    <div class="d-flex align-items-center gap-3">
        <button class="btn btn-outline-primary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
            <i class="bi bi-list"></i>
        </button>
        <div>
            <div class="fw-bold text-dark">@yield('title', 'پنل پشتیبانی جهش')</div>
            <div class="small text-muted">سامانه رسمی پشتیبانی و امور مالی پروژه‌ها</div>
        </div>
    </div>

    <div class="d-flex align-items-center gap-3">
        <div class="d-none d-md-block text-start">
            <div class="fw-bold">{{ $user->name }}</div>
            <div class="small text-muted">{{ $roleLabels[$user->role] ?? $user->role }}</div>
        </div>
        <span class="user-avatar">{{ mb_substr($user->name, 0, 1) }}</span>
        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button class="btn btn-outline-danger btn-sm"><i class="bi bi-box-arrow-right ms-1"></i> خروج</button>
        </form>
    </div>
</header>

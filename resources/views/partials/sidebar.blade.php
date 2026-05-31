@php($user = auth()->user())
<div class="d-flex align-items-center gap-3 mb-4">
    <span class="brand-mark">ج</span>
    <div>
        <div class="sidebar-title">جهش</div>
        <div class="sidebar-subtitle">پنل پشتیبانی</div>
    </div>
</div>

<div class="sidebar-section-title">عمومی</div>
<nav>
    <a class="sidebar-link" href="{{ route('dashboard') }}"><i class="bi bi-grid-1x2"></i><span>داشبورد</span></a>
    <a class="sidebar-link" href="{{ route('tickets.index') }}"><i class="bi bi-ticket-detailed"></i><span>تیکت‌ها</span></a>

    @if($user->role === 'customer')
        <a class="sidebar-link" href="{{ route('tickets.create') }}"><i class="bi bi-plus-circle"></i><span>ثبت تیکت</span></a>
        <a class="sidebar-link" href="{{ route('customer.payments.index') }}"><i class="bi bi-credit-card"></i><span>پرداخت‌های من</span></a>
    @endif

    @if(in_array($user->role, ['admin', 'website_manager']))
        <div class="sidebar-section-title">مدیریت</div>
        @if($user->role === 'admin')
            <a class="sidebar-link" href="{{ route('admin.customers.index') }}"><i class="bi bi-people"></i><span>مشتریان</span></a>
            <a class="sidebar-link" href="{{ route('admin.users.index') }}"><i class="bi bi-person-badge"></i><span>کاربران / پرسنل</span></a>
        @endif
        <a class="sidebar-link" href="{{ route('admin.projects.index') }}"><i class="bi bi-folder2-open"></i><span>پروژه‌ها</span></a>
        <a class="sidebar-link" href="{{ route('admin.payments.index') }}"><i class="bi bi-cash-stack"></i><span>پرداخت‌ها</span></a>
        <a class="sidebar-link" href="{{ route('admin.payments.debtors') }}"><i class="bi bi-clipboard-data"></i><span>گزارش بدهکارها</span></a>
    @endif
</nav>

<div class="sidebar-user-card">
    <div class="small text-white-50 mb-1">کاربر فعال</div>
    <div class="fw-bold">{{ $user->name }}</div>
    <div class="small text-white-50">{{ $user->phone }}</div>
</div>

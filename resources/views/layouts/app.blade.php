<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'پنل پشتیبانی جهش')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/jalalidatepicker/dist/jalalidatepicker.min.css">

    <style>
        :root {
            --jahesh-primary: #1f3a5f;
            --jahesh-primary-dark: #14263f;
            --jahesh-secondary: #64748b;
            --jahesh-surface: #ffffff;
            --jahesh-muted: #64748b;
            --jahesh-bg: #f6f8fb;
            --jahesh-dark: #111827;
        }

        body {
            min-height: 100vh;
            background: var(--jahesh-bg);
            color: #1e293b;
            font-family: Tahoma, Arial, sans-serif;
        }

        .auth-shell {
            min-height: 100vh;
        }

        .sidebar {
            min-height: 100vh;
            background: #ffffff;
            border-left: 1px solid #e5e7eb;
            box-shadow: none;
            position: sticky;
            top: 0;
        }

        .brand-mark {
            width: 46px;
            height: 46px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            background: var(--jahesh-primary);
            box-shadow: none;
            color: #fff;
            font-weight: 800;
        }

        .sidebar .nav-link {
            color: #475569;
            border: 1px solid transparent;
            border-radius: 14px;
            padding: 11px 14px;
            margin-bottom: 8px;
            transition: all .18s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: var(--jahesh-primary);
            background: #f1f5f9;
            border-color: #e2e8f0;
            transform: translateX(-2px);
        }

        .content-shell {
            min-height: 100vh;
        }

        .page-header {
            border-radius: 20px;
            padding: 24px;
            background: #ffffff;
            color: var(--jahesh-dark);
            border: 1px solid #e5e7eb;
            box-shadow: none;
            margin-bottom: 24px;
        }

        .page-header .text-muted,
        .page-header p {
            color: var(--jahesh-muted) !important;
        }

        .card {
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            box-shadow: none;
            background: #ffffff;
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(148, 163, 184, .16);
            padding: 18px 22px;
            border-radius: 22px 22px 0 0 !important;
        }

        .stat-card {
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            width: 120px;
            height: 120px;
            left: -42px;
            top: -42px;
            border-radius: 999px;
            background: rgba(37, 99, 235, .1);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            background: rgba(37, 99, 235, .12);
            color: var(--jahesh-primary);
            font-size: 1.35rem;
        }

        .form-control,
        .form-select {
            border-radius: 14px;
            border-color: #dbe3ef;
            padding: 11px 13px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--jahesh-primary);
            box-shadow: 0 0 0 .22rem rgba(37, 99, 235, .12);
        }

        .btn {
            border-radius: 13px;
            padding: 9px 15px;
            font-weight: 600;
        }

        .btn-primary {
            background: var(--jahesh-primary);
            border-color: var(--jahesh-primary);
            box-shadow: none;
        }

        .btn-primary:hover {
            filter: brightness(.97);
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            color: #475569;
            font-size: .86rem;
            font-weight: 700;
            background: #f8fafc;
            border-bottom: 0;
            padding: 14px 12px;
        }

        .table tbody td {
            padding: 15px 12px;
            vertical-align: middle;
            border-color: #edf2f7;
        }

        .table-hover tbody tr:hover {
            --bs-table-hover-bg: rgba(37, 99, 235, .045);
        }

        .badge {
            border-radius: 999px;
            padding: .52rem .72rem;
        }

        .badge-priority-high {
            background: #dc3545;
        }

        .badge-priority-medium {
            background: #ffc107;
            color: #111;
        }

        .badge-priority-low {
            background: #198754;
        }

        .empty-state {
            padding: 34px;
            text-align: center;
            color: var(--jahesh-muted);
        }

        .empty-state-icon {
            width: 62px;
            height: 62px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 22px;
            background: #eff6ff;
            color: var(--jahesh-primary);
            font-size: 1.8rem;
            margin-bottom: 12px;
        }

        .jalali-date {
            direction: ltr;
            text-align: right;
        }

        .login-hero {
            background: linear-gradient(135deg, #1f3a5f, #334155);
            border-radius: 30px;
            color: #fff;
            min-height: 520px;
            overflow: hidden;
            position: relative;
        }

        .login-hero::after {
            content: '';
            position: absolute;
            inset: auto -80px -100px auto;
            width: 260px;
            height: 260px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .16);
        }

        @media (max-width: 767.98px) {
            .sidebar {
                min-height: auto;
                position: static;
            }

            .content-shell {
                min-height: auto;
            }
        }
    </style>
</head>
<body>

<div class="container-fluid px-0">
    <div class="row g-0 auth-shell">
        @auth
            <aside class="col-md-3 col-lg-2 sidebar p-3 p-lg-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <span class="brand-mark">ج</span>
                    <div>
                        <h5 class="text-dark mb-0">جهش</h5>
                        <small class="text-muted">پنل پشتیبانی</small>
                    </div>
                </div>

                <nav class="nav flex-column">
                    <a class="nav-link" href="{{ route('dashboard') }}">داشبورد</a>
                    <a class="nav-link" href="{{ route('tickets.index') }}">تیکت‌ها</a>

                    @if(auth()->user()->role === 'customer')
                        <a class="nav-link" href="{{ route('tickets.create') }}">ثبت تیکت</a>
                        <a class="nav-link" href="{{ route('customer.payments.index') }}">پرداخت‌های من</a>
                    @endif

                    @if(in_array(auth()->user()->role, ['admin', 'website_manager']))
                        <hr class="text-muted my-3">
                        @if(auth()->user()->role === 'admin')
                            <a class="nav-link" href="{{ route('admin.customers.index') }}">مشتریان</a>
                            <a class="nav-link" href="{{ route('admin.users.index') }}">کاربران / پرسنل</a>
                        @endif
                        <a class="nav-link" href="{{ route('admin.projects.index') }}">پروژه‌ها</a>
                        <a class="nav-link" href="{{ route('admin.payments.index') }}">پرداخت‌ها</a>
                        <a class="nav-link" href="{{ route('admin.payments.debtors') }}">گزارش بدهکارها</a>
                    @endif
                </nav>

                <div class="card bg-light border-0 text-dark mt-4 p-3">
                    <div class="small text-muted">کاربر وارد شده</div>
                    <div class="fw-bold">{{ auth()->user()->name }}</div>
                    <div class="small text-muted">{{ auth()->user()->phone }}</div>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="mt-3">
                    @csrf
                    <button class="btn btn-danger w-100">خروج</button>
                </form>
            </aside>
        @endauth

        <main class="@auth col-md-9 col-lg-10 @else col-12 @endauth content-shell p-3 p-md-4 p-xl-5">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-4">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm rounded-4">{{ session('error') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger border-0 shadow-sm rounded-4">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<script src="https://unpkg.com/jalalidatepicker/dist/jalalidatepicker.min.js"></script>
<script>
    if (window.jalaliDatepicker) {
        jalaliDatepicker.startWatch({
            selector: '[data-jdp]',
            autoShow: true,
            autoHide: true,
            persianDigits: true,
            format: 'YYYY/MM/DD'
        });
    }
</script>
</body>
</html>

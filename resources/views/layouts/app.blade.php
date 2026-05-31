<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'پنل پشتیبانی جهش')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/jalalidatepicker/dist/jalalidatepicker.min.css">

    <style>
        body {
            background: #f5f7fb;
            font-family: Tahoma, Arial, sans-serif;
        }

        .sidebar {
            min-height: 100vh;
            background: #111827;
        }

        .sidebar a {
            color: #d1d5db;
            text-decoration: none;
            display: block;
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 5px;
        }

        .sidebar a:hover {
            background: #1f2937;
            color: #fff;
        }

        .card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 8px 22px rgba(15, 23, 42, .06);
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

        .jalali-date {
            direction: ltr;
            text-align: right;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">

        @auth
            <div class="col-md-3 col-lg-2 sidebar p-3">
                <h5 class="text-white mb-4">جهش</h5>

                <a href="{{ route('dashboard') }}">داشبورد</a>
                <a href="{{ route('tickets.index') }}">تیکت‌ها</a>

                @if(auth()->user()->role === 'customer')
                    <a href="{{ route('tickets.create') }}">ثبت تیکت</a>
                    <a href="{{ route('customer.payments.index') }}">پرداخت‌های من</a>
                @endif

                @if(auth()->user()->role === 'admin')
                    <hr class="text-secondary">
                    <a href="{{ route('admin.customers.index') }}">مشتریان</a>
                    <a href="{{ route('admin.projects.index') }}">پروژه‌ها</a>
                    <a href="{{ route('admin.users.index') }}">کاربران / پرسنل</a>
                    <a href="{{ route('admin.payments.index') }}">پرداخت‌ها</a>
                    <a href="{{ route('admin.payments.debtors') }}">گزارش بدهکارها</a>
                @endif

                <form action="{{ route('logout') }}" method="POST" class="mt-4">
                    @csrf
                    <button class="btn btn-danger w-100">خروج</button>
                </form>
            </div>
        @endauth

        <main class="@auth col-md-9 col-lg-10 @else col-12 @endauth p-4">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
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
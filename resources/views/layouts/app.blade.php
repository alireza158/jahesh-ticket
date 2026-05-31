<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'پنل پشتیبانی جهش')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/jalalidatepicker/dist/jalalidatepicker.min.css">
    <link rel="stylesheet" href="{{ asset('css/app-custom.css') }}">
</head>
<body>
@auth
    <div class="app-shell">
        <aside class="app-sidebar d-none d-lg-block">
            @include('partials.sidebar')
        </aside>

        <div class="offcanvas offcanvas-end app-mobile-sidebar" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
            <div class="offcanvas-header border-bottom border-white border-opacity-10">
                <h5 class="offcanvas-title" id="mobileSidebarLabel">منوی پنل جهش</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="بستن"></button>
            </div>
            <div class="offcanvas-body">
                @include('partials.sidebar')
            </div>
        </div>

        <div class="app-main">
            @include('partials.header')
            <main class="app-content">
                @include('partials.alerts')
                @yield('content')
            </main>
        </div>
    </div>
@else
    <main class="min-vh-100">
        @include('partials.alerts')
        @yield('content')
    </main>
@endauth

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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

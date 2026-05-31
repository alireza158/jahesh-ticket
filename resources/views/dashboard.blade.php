@extends('layouts.app')

@section('title', 'داشبورد')

@section('content')
<div class="page-header d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
    <div>
        <h3 class="fw-bold mb-2">داشبورد</h3>
        <p class="mb-0">خلاصه وضعیت تیکت‌ها، مشتریان و پرداخت‌های سامانه جهش</p>
    </div>
    <div class="badge bg-white text-primary fs-6 px-3 py-2">{{ auth()->user()->name }}</div>
</div>

<div class="row g-4">
    @if(isset($customersCount))
        <div class="col-md-6 col-xl-3">
            <div class="card stat-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">مشتریان</p>
                        <h2 class="fw-bold mb-0">{{ $customersCount }}</h2>
                    </div>
                    <span class="stat-icon">👥</span>
                </div>
            </div>
        </div>
    @endif

    <div class="col-md-6 col-xl-3">
        <div class="card stat-card p-4 h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-1">کل تیکت‌ها</p>
                    <h2 class="fw-bold mb-0">{{ $ticketsCount ?? 0 }}</h2>
                </div>
                <span class="stat-icon">🎫</span>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card stat-card p-4 h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-1">تیکت‌های باز</p>
                    <h2 class="fw-bold mb-0">{{ $openTickets ?? 0 }}</h2>
                </div>
                <span class="stat-icon">🟢</span>
            </div>
        </div>
    </div>

    @if(isset($pendingPayments))
        <div class="col-md-6 col-xl-3">
            <div class="card stat-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">پرداخت‌های در انتظار</p>
                        <h2 class="fw-bold mb-0">{{ $pendingPayments }}</h2>
                    </div>
                    <span class="stat-icon">💳</span>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

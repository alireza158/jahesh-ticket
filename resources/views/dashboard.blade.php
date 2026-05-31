@extends('layouts.app')

@section('title', 'داشبورد')

@section('content')
<div class="page-header d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
    <div>
        <h3 class="fw-bold mb-2">داشبورد</h3>
        <p class="mb-0">خلاصه وضعیت تیکت‌ها، پروژه‌ها و پرداخت‌های سامانه جهش</p>
    </div>
    <div class="badge bg-primary-subtle text-primary fs-6 px-3 py-2">{{ auth()->user()->name }}</div>
</div>

<div class="row g-4">
    @if(isset($customersCount))
        <div class="col-md-6 col-xl-3">
            <div class="card stat-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">مشتریان</p>
                        <h2 class="fw-bold mb-0">{{ $customersCount }}</h2>
                        <small class="text-muted">کل مشتریان ثبت‌شده</small>
                    </div>
                    <span class="stat-icon"><i class="bi bi-people"></i></span>
                </div>
            </div>
        </div>
    @endif

    @if(isset($projectsCount))
        <div class="col-md-6 col-xl-3">
            <div class="card stat-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">پروژه‌ها</p>
                        <h2 class="fw-bold mb-0">{{ $projectsCount }}</h2>
                        <small class="text-muted">پروژه‌های قابل پیگیری</small>
                    </div>
                    <span class="stat-icon"><i class="bi bi-folder2-open"></i></span>
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
                    <small class="text-muted">همه درخواست‌های ثبت‌شده</small>
                </div>
                <span class="stat-icon"><i class="bi bi-ticket-detailed"></i></span>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card stat-card p-4 h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-1">تیکت‌های باز</p>
                    <h2 class="fw-bold mb-0">{{ $openTickets ?? 0 }}</h2>
                    <small class="text-muted">نیازمند پیگیری</small>
                </div>
                <span class="stat-icon"><i class="bi bi-check-circle"></i></span>
            </div>
        </div>
    </div>

    @if(isset($closedTickets))
        <div class="col-md-6 col-xl-3">
            <div class="card stat-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">تیکت‌های بسته</p>
                        <h2 class="fw-bold mb-0">{{ $closedTickets }}</h2>
                        <small class="text-muted">درخواست‌های تکمیل‌شده</small>
                    </div>
                    <span class="stat-icon"><i class="bi bi-check2-circle"></i></span>
                </div>
            </div>
        </div>
    @endif

    @if(isset($answeredTickets))
        <div class="col-md-6 col-xl-3">
            <div class="card stat-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">پاسخ داده‌شده</p>
                        <h2 class="fw-bold mb-0">{{ $answeredTickets }}</h2>
                        <small class="text-muted">تیکت‌های پاسخ داده‌شده</small>
                    </div>
                    <span class="stat-icon"><i class="bi bi-reply"></i></span>
                </div>
            </div>
        </div>
    @endif

    @if(isset($pendingPayments))
        <div class="col-md-6 col-xl-3">
            <div class="card stat-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">پرداخت‌های در انتظار</p>
                        <h2 class="fw-bold mb-0">{{ $pendingPayments }}</h2>
                        <small class="text-muted">رسیدهای نیازمند بررسی</small>
                    </div>
                    <span class="stat-icon"><i class="bi bi-credit-card"></i></span>
                </div>
            </div>
        </div>
    @endif

    @if(isset($approvedPaymentsAmount))
        <div class="col-md-6 col-xl-3">
            <div class="card stat-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">پرداخت تاییدشده</p>
                        <h4 class="fw-bold mb-0">{{ \App\Support\Currency::toman($approvedPaymentsAmount) }}</h4>
                        <small class="text-muted">جمع پرداخت‌های تایید شده</small>
                    </div>
                    <span class="stat-icon"><i class="bi bi-cash-stack"></i></span>
                </div>
            </div>
        </div>
    @endif

    @if(isset($remainingDebt))
        <div class="col-md-6 col-xl-3">
            <div class="card stat-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">مانده بدهی</p>
                        <h4 class="fw-bold text-danger mb-0">{{ \App\Support\Currency::toman($remainingDebt) }}</h4>
                        <small class="text-muted">جمع بدهی پروژه‌ها</small>
                    </div>
                    <span class="stat-icon"><i class="bi bi-exclamation-circle"></i></span>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

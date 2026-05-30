@extends('layouts.app')

@section('title', 'داشبورد')

@section('content')
<h4 class="mb-4">داشبورد</h4>

<div class="row g-3">
    @if(isset($customersCount))
        <div class="col-md-3">
            <div class="card p-3">
                <h6>مشتریان</h6>
                <h3>{{ $customersCount }}</h3>
            </div>
        </div>
    @endif

    <div class="col-md-3">
        <div class="card p-3">
            <h6>کل تیکت‌ها</h6>
            <h3>{{ $ticketsCount ?? 0 }}</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3">
            <h6>تیکت‌های باز</h6>
            <h3>{{ $openTickets ?? 0 }}</h3>
        </div>
    </div>

    @if(isset($pendingPayments))
        <div class="col-md-3">
            <div class="card p-3">
                <h6>پرداخت‌های در انتظار</h6>
                <h3>{{ $pendingPayments }}</h3>
            </div>
        </div>
    @endif
</div>
@endsection
@extends('layouts.app')

@section('title', 'جزئیات پروژه')

@section('content')
@php
    $paymentStatusLabels = [
        'pending' => 'در انتظار تایید',
        'approved' => 'تایید شده',
        'rejected' => 'رد شده',
    ];
    $paymentStatusClasses = [
        'pending' => 'bg-warning-subtle text-warning',
        'approved' => 'bg-success-subtle text-success',
        'rejected' => 'bg-danger-subtle text-danger',
    ];
@endphp
<div class="page-header d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
    <div>
        <h3 class="fw-bold mb-2">{{ $project->title }}</h3>
        <p class="mb-0">مشتری: {{ $project->customer?->name ?? '-' }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.payments.create', ['project_id' => $project->id]) }}" class="btn btn-primary">ثبت پرداخت</a>
        <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-outline-secondary">ویرایش پروژه</a>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6 col-xl-3"><div class="card p-4 h-100"><div class="text-muted mb-2">هزینه اولیه</div><h4 class="fw-bold mb-0">{{ number_format($project->initial_fee) }} تومان</h4></div></div>
    <div class="col-md-6 col-xl-3"><div class="card p-4 h-100"><div class="text-muted mb-2">هزینه ماهانه</div><h4 class="fw-bold mb-0">{{ number_format($project->monthly_fee) }} تومان</h4></div></div>
    <div class="col-md-6 col-xl-3"><div class="card p-4 h-100"><div class="text-muted mb-2">مانده بدهی</div><h4 class="fw-bold text-danger mb-0">{{ number_format($project->remainingDebt()) }} تومان</h4></div></div>
    <div class="col-md-6 col-xl-3"><div class="card p-4 h-100"><div class="text-muted mb-2">بستانکاری</div><h4 class="fw-bold text-success mb-0">{{ number_format($project->creditBalance()) }} تومان</h4></div></div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header"><h5 class="mb-0 fw-bold">مشخصات پروژه</h5></div>
            <div class="card-body p-4">
                <dl class="row mb-0 gy-3">
                    <dt class="col-5 text-muted">مشتری</dt><dd class="col-7 mb-0">{{ $project->customer?->name ?? '-' }}</dd>
                    <dt class="col-5 text-muted">وضعیت</dt><dd class="col-7 mb-0">{{ ['active' => 'فعال', 'inactive' => 'غیرفعال', 'completed' => 'تمام‌شده'][$project->status] ?? $project->status }}</dd>
                    <dt class="col-5 text-muted">بدهکاری دستی</dt><dd class="col-7 mb-0">{{ number_format($project->debt_adjustment) }} تومان</dd>
                    <dt class="col-5 text-muted">بستانکاری دستی</dt><dd class="col-7 mb-0">{{ number_format($project->credit_adjustment) }} تومان</dd>
                    <dt class="col-12 text-muted">یادداشت مالی</dt><dd class="col-12 mb-0">{{ $project->finance_note ?: '-' }}</dd>
                    <dt class="col-12 text-muted">توضیحات</dt><dd class="col-12 mb-0 lh-lg">{{ $project->description ?: '-' }}</dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">پرداخت‌های ثبت‌شده پروژه</h5>
                <span class="badge bg-primary-subtle text-primary">{{ $project->payments->count() }} پرداخت</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>مبلغ</th>
                            <th>ماه</th>
                            <th>تاریخ</th>
                            <th>وضعیت</th>
                            <th>رسید</th>
                            <th>ثبت/تایید توسط</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($project->payments as $payment)
                            <tr>
                                <td class="fw-semibold">{{ number_format($payment->amount) }} تومان</td>
                                <td>{{ $payment->payment_month ?? '-' }}</td>
                                <td>{{ \App\Support\JalaliDate::format($payment->paid_at, 'Y/m/d') }}</td>
                                <td><span class="badge {{ $paymentStatusClasses[$payment->status] ?? 'bg-secondary-subtle text-secondary' }}">{{ $paymentStatusLabels[$payment->status] ?? $payment->status }}</span></td>
                                <td>
                                    @if($payment->receipt_path)
                                        <a href="{{ asset('storage/'.$payment->receipt_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">رسید</a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $payment->approvedBy?->name ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6"><div class="empty-state"><div class="empty-state-icon">💳</div><div>هنوز پرداختی برای این پروژه ثبت نشده است.</div></div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

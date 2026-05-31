@extends('layouts.app')

@section('title', 'پرداخت‌های مشتریان')

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
        <h3 class="fw-bold mb-2">پرداخت‌های مشتریان</h3>
        <p class="mb-0">بررسی رسیدها، تایید یا رد پرداخت‌های ماهانه مشتریان</p>
    </div>
    <a href="{{ route('admin.payments.debtors') }}" class="btn btn-light text-primary">📌 گزارش بدهکارها</a>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">لیست پرداخت‌ها</h5>
        <span class="badge bg-primary-subtle text-primary">{{ $payments->total() }} پرداخت</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>مشتری</th>
                    <th>پروژه</th>
                    <th>مبلغ</th>
                    <th>ماه</th>
                    <th>وضعیت</th>
                    <th>رسید</th>
                    <th class="text-end">عملیات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td class="fw-semibold">{{ $payment->customer->name }}</td>
                        <td>{{ $payment->project?->title ?? '-' }}</td>
                        <td>{{ number_format($payment->amount) }} تومان</td>
                        <td>{{ $payment->payment_month ?? '-' }}</td>
                        <td><span class="badge {{ $paymentStatusClasses[$payment->status] ?? 'bg-secondary-subtle text-secondary' }}">{{ $paymentStatusLabels[$payment->status] ?? $payment->status }}</span></td>
                        <td>
                            @if($payment->receipt_path)
                                <a href="{{ asset('storage/'.$payment->receipt_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">مشاهده رسید</a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-end">
                            @if($payment->status === 'pending')
                                <form method="POST" action="{{ route('admin.payments.approve', $payment) }}" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-success">تایید</button>
                                </form>
                                <form method="POST" action="{{ route('admin.payments.reject', $payment) }}" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="admin_note" value="پرداخت تایید نشد">
                                    <button class="btn btn-sm btn-outline-danger">رد</button>
                                </form>
                            @else
                                <span class="text-muted">انجام شده</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7"><div class="empty-state"><div class="empty-state-icon">💳</div><div>هنوز پرداختی ثبت نشده است.</div></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-transparent border-0 pt-0 px-4 pb-4">{{ $payments->links() }}</div>
</div>
@endsection

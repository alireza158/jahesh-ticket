@extends('layouts.app')

@section('title', 'پرداخت‌های من')

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
        <h3 class="fw-bold mb-2">پرداخت‌های من</h3>
        <p class="mb-0">رسید پرداخت‌های ماهانه خود را ثبت و وضعیت تایید آن را پیگیری کنید.</p>
    </div>
    <a href="{{ route('customer.payments.create') }}" class="btn btn-light text-primary">➕ ثبت پرداخت</a>
</div>

<div class="card">
    <div class="card-header"><h5 class="mb-0 fw-bold">سوابق پرداخت</h5></div>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>پروژه</th>
                    <th>مبلغ</th>
                    <th>ماه</th>
                    <th>تاریخ پرداخت</th>
                    <th>وضعیت</th>
                    <th>رسید</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td class="fw-semibold">{{ $payment->project?->title ?? '-' }}</td>
                        <td>{{ number_format($payment->amount) }} تومان</td>
                        <td>{{ $payment->payment_month ?? '-' }}</td>
                        <td>{{ \App\Support\JalaliDate::format($payment->paid_at, 'Y/m/d') }}</td>
                        <td><span class="badge {{ $paymentStatusClasses[$payment->status] ?? 'bg-secondary-subtle text-secondary' }}">{{ $paymentStatusLabels[$payment->status] ?? $payment->status }}</span></td>
                        <td>
                            @if($payment->receipt_path)
                                <a href="{{ asset('storage/'.$payment->receipt_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">مشاهده رسید</a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6"><div class="empty-state"><div class="empty-state-icon">💳</div><div>هنوز پرداختی ثبت نکرده‌اید.</div></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-transparent border-0 pt-0 px-4 pb-4">{{ $payments->links() }}</div>
</div>
@endsection

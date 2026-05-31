@extends('layouts.app')

@section('content')
@php
    $paymentStatusLabels = [
        'pending' => 'در انتظار تایید',
        'approved' => 'تایید شده',
        'rejected' => 'رد شده',
    ];
@endphp
<div class="d-flex justify-content-between mb-3">
    <h4>پرداخت‌های من</h4>
    <a href="{{ route('customer.payments.create') }}" class="btn btn-primary">ثبت پرداخت</a>
</div>

<div class="card p-3">
    <table class="table">
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
            @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->project?->title ?? '-' }}</td>
                    <td>{{ number_format($payment->amount) }} تومان</td>
                    <td>{{ $payment->payment_month }}</td>
                    <td>{{ \App\Support\JalaliDate::format($payment->paid_at, 'Y/m/d') }}</td>
                    <td>{{ $paymentStatusLabels[$payment->status] ?? $payment->status }}</td>
                    <td>
                        @if($payment->receipt_path)
                            <a href="{{ asset('storage/'.$payment->receipt_path) }}" target="_blank">
                                مشاهده رسید
                            </a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $payments->links() }}
</div>
@endsection
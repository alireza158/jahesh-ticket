@extends('layouts.app')

@section('content')
<h4 class="mb-3">پرداخت‌های مشتریان</h4>

<div class="card p-3">
    <table class="table">
        <thead>
            <tr>
                <th>مشتری</th>
                <th>پروژه</th>
                <th>مبلغ</th>
                <th>ماه</th>
                <th>وضعیت</th>
                <th>رسید</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->customer->name }}</td>
                    <td>{{ $payment->project?->title ?? '-' }}</td>
                    <td>{{ number_format($payment->amount) }} تومان</td>
                    <td>{{ $payment->payment_month }}</td>
                    <td>{{ $payment->status }}</td>
                    <td>
                        @if($payment->receipt_path)
                            <a href="{{ asset('storage/'.$payment->receipt_path) }}" target="_blank">
                                رسید
                            </a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($payment->status === 'pending')
                            <form method="POST" action="{{ route('admin.payments.approve', $payment) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-success">تایید</button>
                            </form>

                            <form method="POST" action="{{ route('admin.payments.reject', $payment) }}" class="d-inline">
                                @csrf
                                <input type="hidden" name="admin_note" value="پرداخت تایید نشد">
                                <button class="btn btn-sm btn-danger">رد</button>
                            </form>
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
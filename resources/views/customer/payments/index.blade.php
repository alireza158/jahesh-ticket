@extends('layouts.app')

@section('title', 'پرداخت‌های من')

@section('content')

<div class="page-header d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
    <div>
        <h3 class="fw-bold mb-2">پرداخت‌های من</h3>
        <p class="mb-0">رسید پرداخت‌های ماهانه خود را ثبت و وضعیت تایید آن را پیگیری کنید.</p>
    </div>
    <a href="{{ route('customer.payments.create') }}" class="btn btn-primary">ثبت پرداخت</a>
</div>
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card p-4 h-100">
            <div class="text-muted mb-2">مانده بدهی کل پروژه‌ها</div>
            <h3 class="fw-bold text-danger mb-0">{{ number_format($remainingDebt) }} تومان</h3>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-4 h-100">
            <div class="text-muted mb-2">بستانکاری کل</div>
            <h3 class="fw-bold text-success mb-0">{{ number_format($creditBalance) }} تومان</h3>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header"><h5 class="mb-0 fw-bold">مانده هر پروژه</h5></div>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>پروژه</th>
                    <th>هزینه اولیه</th>
                    <th>هزینه ماهانه</th>
                    <th>مانده بدهی</th>
                    <th>بستانکاری</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                    <tr>
                        <td class="fw-semibold">{{ $project->title }}</td>
                        <td>{{ number_format($project->initial_fee) }} تومان</td>
                        <td>{{ number_format($project->monthly_fee) }} تومان</td>
                        <td><span class="badge bg-danger-subtle text-danger">{{ number_format($project->remainingDebt()) }} تومان</span></td>
                        <td><span class="badge bg-success-subtle text-success">{{ number_format($project->creditBalance()) }} تومان</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
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
                        <td>@include('partials.status-badge', ['status' => $payment->status])</td>
                        <td>
                            @if($payment->receipt_path)
                                <a href="{{ asset('storage/'.$payment->receipt_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">مشاهده رسید</a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6"><div class="empty-state"><div class="empty-state-icon"><i class="bi bi-credit-card"></i></div><div>هنوز پرداختی ثبت نکرده‌اید.</div></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-transparent border-0 pt-0 px-4 pb-4">{{ $payments->links() }}</div>
</div>
@endsection

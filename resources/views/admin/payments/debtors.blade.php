@extends('layouts.app')

@section('title', 'گزارش مشتریان بدهکار')

@section('content')
<div class="page-header d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
    <div>
        <h3 class="fw-bold mb-2">گزارش مشتریان بدهکار</h3>
        <p class="mb-0">مشتریانی که پروژه فعال دارند اما پرداخت تاییدشده ماه جاری برای آن‌ها ثبت نشده است.</p>
    </div>
    <div class="badge bg-white text-primary fs-6 px-3 py-2">ماه بررسی: {{ $currentMonth }}</div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">لیست بدهکارها</h5>
        <span class="badge bg-danger-subtle text-danger">{{ $customers->total() }} مشتری</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>نام مشتری</th>
                    <th>شرکت</th>
                    <th>تلفن</th>
                    <th>پروژه‌های فعال</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr>
                        <td class="fw-semibold">{{ $customer->name }}</td>
                        <td>{{ $customer->company_name ?? '-' }}</td>
                        <td>{{ $customer->phone ?? '-' }}</td>
                        <td>
                            @foreach($customer->projects as $project)
                                @if($project->status === 'active')
                                    <span class="badge bg-primary-subtle text-primary mb-1">{{ $project->title }}</span>
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4"><div class="empty-state"><div class="empty-state-icon">✅</div><div>برای این ماه مشتری بدهکار پیدا نشد.</div></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-transparent border-0 pt-0 px-4 pb-4">{{ $customers->links() }}</div>
</div>
@endsection

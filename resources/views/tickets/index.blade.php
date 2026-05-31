@extends('layouts.app')

@section('title', 'تیکت‌ها')

@section('content')
@php
    $statusLabels = [
        'open' => 'باز',
        'in_progress' => 'در حال بررسی',
        'waiting_customer' => 'در انتظار مشتری',
        'answered' => 'پاسخ داده شده',
        'closed' => 'بسته شده',
    ];
    $statusClasses = [
        'open' => 'bg-primary-subtle text-primary',
        'in_progress' => 'bg-info-subtle text-info',
        'waiting_customer' => 'bg-warning-subtle text-warning',
        'answered' => 'bg-success-subtle text-success',
        'closed' => 'bg-secondary-subtle text-secondary',
    ];
@endphp
<div class="page-header d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
    <div>
        <h3 class="fw-bold mb-2">تیکت‌ها</h3>
        <p class="mb-0">مشاهده، پیگیری و مدیریت درخواست‌های پشتیبانی</p>
    </div>
    @if(auth()->user()->role === 'customer')
        <a href="{{ route('tickets.create') }}" class="btn btn-light text-primary">➕ ثبت تیکت جدید</a>
    @endif
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">لیست تیکت‌ها</h5>
        <span class="badge bg-primary-subtle text-primary">{{ $tickets->total() }} تیکت</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>عنوان</th>
                    <th>مشتری</th>
                    <th>پروژه</th>
                    <th>اولویت</th>
                    <th>وضعیت</th>
                    <th>ارجاع به</th>
                    <th>تاریخ</th>
                    <th class="text-end">عملیات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $ticket)
                    <tr>
                        <td class="fw-semibold">{{ $ticket->title }}</td>
                        <td>{{ $ticket->customer->name }}</td>
                        <td>{{ $ticket->project?->title ?? '-' }}</td>
                        <td>
                            @if($ticket->priority === 'high')
                                <span class="badge badge-priority-high">زیاد</span>
                            @elseif($ticket->priority === 'medium')
                                <span class="badge badge-priority-medium">متوسط</span>
                            @else
                                <span class="badge badge-priority-low">کم</span>
                            @endif
                        </td>
                        <td><span class="badge {{ $statusClasses[$ticket->status] ?? 'bg-secondary-subtle text-secondary' }}">{{ $statusLabels[$ticket->status] ?? $ticket->status }}</span></td>
                        <td>{{ $ticket->assignedStaff?->name ?? '-' }}</td>
                        <td>{{ \App\Support\JalaliDate::format($ticket->created_at, 'Y/m/d') }}</td>
                        <td class="text-end">
                            <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-sm btn-outline-primary">مشاهده</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8"><div class="empty-state"><div class="empty-state-icon">🎫</div><div>هنوز تیکتی ثبت نشده است.</div></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-transparent border-0 pt-0 px-4 pb-4">{{ $tickets->links() }}</div>
</div>
@endsection

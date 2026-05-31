@extends('layouts.app')

@section('title', 'تیکت‌ها')

@section('content')
<div class="page-header d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
    <div>
        <h3 class="fw-bold mb-2">تیکت‌ها</h3>
        <p class="mb-0">مشاهده، پیگیری و مدیریت درخواست‌های پشتیبانی</p>
    </div>
    @if(auth()->user()->role === 'customer')
        <a href="{{ route('tickets.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle ms-1"></i> ثبت تیکت جدید</a>
    @endif
</div>

@include('partials.search-box', ['placeholder' => 'عنوان تیکت، مشتری، پروژه یا پرسنل را جستجو کنید...', 'value' => $search ?? ''])

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
                        <td>@include('partials.priority-badge', ['priority' => $ticket->priority])</td>
                        <td>@include('partials.status-badge', ['status' => $ticket->status])</td>
                        <td>{{ $ticket->assignedStaff?->name ?? '-' }}</td>
                        <td>{{ \App\Support\JalaliDate::format($ticket->created_at, 'Y/m/d') }}</td>
                        <td class="text-end">
                            <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye ms-1"></i> مشاهده</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="bi bi-ticket-detailed"></i></div>
                                <div class="fw-bold">هنوز تیکتی ثبت نشده است</div>
                                <div class="small mt-1">بعد از ثبت تیکت، وضعیت و پاسخ‌ها اینجا نمایش داده می‌شود.</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-transparent border-0 pt-0 px-4 pb-4">{{ $tickets->links() }}</div>
</div>
@endsection

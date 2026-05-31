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
@endphp
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>تیکت‌ها</h4>

    @if(auth()->user()->role === 'customer')
        <a href="{{ route('tickets.create') }}" class="btn btn-primary">ثبت تیکت جدید</a>
    @endif
</div>

<div class="card p-3">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>عنوان</th>
                    <th>مشتری</th>
                    <th>پروژه</th>
                    <th>اولویت</th>
                    <th>وضعیت</th>
                    <th>ارجاع به</th>
                    <th>تاریخ</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->title }}</td>
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
                        <td>{{ $statusLabels[$ticket->status] ?? $ticket->status }}</td>
                        <td>{{ $ticket->assignedStaff?->name ?? '-' }}</td>
                        <td>{{ \App\Support\JalaliDate::format($ticket->created_at, 'Y/m/d') }}</td>
                        <td>
                            <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-sm btn-outline-primary">
                                مشاهده
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $tickets->links() }}
</div>
@endsection
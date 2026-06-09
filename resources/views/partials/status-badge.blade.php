@props(['status', 'type' => null])
@php
    $labels = [
        'open' => 'باز',
        'in_progress' => $type === 'task' ? 'در حال انجام' : 'در حال بررسی',
        'waiting_customer' => 'در انتظار مشتری',
        'answered' => 'پاسخ داده شده',
        'closed' => 'بسته شده',
        'pending' => $type === 'task' ? 'انجام نشده' : 'در انتظار تایید',
        'done' => 'انجام شده',
        'approved' => 'تایید شده',
        'rejected' => 'رد شده',
    ];
    $class = $type === 'task' ? "badge-status-task-{$status}" : "badge-status-{$status}";
@endphp
<span class="badge {{ $class }}">{{ $labels[$status] ?? $status }}</span>

@props(['status'])
@php
    $labels = [
        'open' => 'باز',
        'in_progress' => 'در حال بررسی',
        'waiting_customer' => 'در انتظار مشتری',
        'answered' => 'پاسخ داده شده',
        'closed' => 'بسته شده',
        'pending' => 'در انتظار تایید',
        'approved' => 'تایید شده',
        'rejected' => 'رد شده',
    ];
@endphp
<span class="badge badge-status-{{ $status }}">{{ $labels[$status] ?? $status }}</span>

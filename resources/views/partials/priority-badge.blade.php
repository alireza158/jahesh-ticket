@props(['priority'])
@php
    $labels = [
        'high' => 'زیاد',
        'medium' => 'متوسط',
        'low' => 'کم',
    ];
@endphp
<span class="badge badge-priority-{{ $priority }}">{{ $labels[$priority] ?? $priority }}</span>

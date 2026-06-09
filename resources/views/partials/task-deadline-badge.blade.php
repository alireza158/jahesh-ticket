@props(['task'])
@php
    $deadline = $task->deadline;
@endphp
@if($task->status === 'done')
    <span class="badge bg-success-subtle text-success">تکمیل شده</span>
@elseif(!$deadline)
    <span class="badge bg-secondary-subtle text-secondary">بدون ددلاین</span>
@elseif($deadline->isPast() && !$deadline->isToday())
    <span class="badge bg-danger-subtle text-danger">عقب افتاده</span>
@elseif($deadline->isToday())
    <span class="badge bg-warning-subtle text-warning">امروز</span>
@else
    <span class="badge bg-info-subtle text-info">در زمان مناسب</span>
@endif

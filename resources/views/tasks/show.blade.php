@extends('layouts.app')

@section('title', 'جزئیات تسک')

@section('content')
@php($canManage = in_array(auth()->user()->role, ['admin', 'website_manager']))
<div class="page-header d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
    <div>
        <h3 class="fw-bold mb-2">{{ $task->title }}</h3>
        <p class="mb-0">پروژه: {{ $task->project?->title ?? '-' }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">بازگشت به تسک‌ها</a>
        @if($canManage)
            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary">ویرایش تسک</a>
        @endif
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0 fw-bold">مشخصات تسک</h5></div>
            <div class="card-body p-4">
                <dl class="row mb-0 gy-3">
                    <dt class="col-5 text-muted">پروژه</dt><dd class="col-7 mb-0">{{ $task->project?->title ?? '-' }}</dd>
                    <dt class="col-5 text-muted">مشتری پروژه</dt><dd class="col-7 mb-0">{{ $task->project?->customer?->name ?? '-' }}</dd>
                    <dt class="col-5 text-muted">سازنده</dt><dd class="col-7 mb-0">{{ $task->creator?->name ?? '-' }}</dd>
                    <dt class="col-5 text-muted">مسئول</dt><dd class="col-7 mb-0">{{ $task->assignedUser?->name ?? '-' }}</dd>
                    <dt class="col-5 text-muted">وضعیت</dt><dd class="col-7 mb-0">@include('partials.status-badge', ['status' => $task->status, 'type' => 'task'])</dd>
                    <dt class="col-5 text-muted">اولویت</dt><dd class="col-7 mb-0">@include('partials.priority-badge', ['priority' => $task->priority])</dd>
                    <dt class="col-5 text-muted">ددلاین</dt><dd class="col-7 mb-0">{{ \App\Support\JalaliDate::format($task->deadline, 'Y/m/d') }}</dd>
                    <dt class="col-5 text-muted">وضعیت ددلاین</dt><dd class="col-7 mb-0">@include('partials.task-deadline-badge', ['task' => $task])</dd>
                    <dt class="col-5 text-muted">تاریخ تکمیل</dt><dd class="col-7 mb-0">{{ \App\Support\JalaliDate::format($task->completed_at, 'Y/m/d H:i') }}</dd>
                    <dt class="col-12 text-muted">توضیحات</dt><dd class="col-12 mb-0 lh-lg">{{ $task->description ?: '-' }}</dd>
                </dl>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h5 class="mb-0 fw-bold">تغییر وضعیت</h5></div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('tasks.status', $task) }}">
                    @csrf
                    <label class="form-label fw-semibold">وضعیت جدید</label>
                    <select name="status" class="form-select" required>
                        <option value="pending" @selected($task->status === 'pending')>انجام نشده</option>
                        <option value="in_progress" @selected($task->status === 'in_progress')>در حال انجام</option>
                        <option value="done" @selected($task->status === 'done')>انجام شده</option>
                    </select>
                    <button class="btn btn-primary w-100 mt-3">ثبت وضعیت</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">یادداشت‌ها</h5>
                <span class="badge bg-primary-subtle text-primary">{{ $task->notes->count() }} یادداشت</span>
            </div>
            <div class="card-body p-4 task-note-timeline">
                @forelse($task->notes as $note)
                    <div class="task-note-card">
                        <div class="d-flex justify-content-between gap-3 mb-2">
                            <div class="fw-bold"><i class="bi bi-person-circle ms-1"></i>{{ $note->user?->name ?? '-' }}</div>
                            <small class="text-muted">{{ \App\Support\JalaliDate::format($note->created_at, 'Y/m/d H:i') }}</small>
                        </div>
                        <div class="lh-lg">{{ $note->note }}</div>
                    </div>
                @empty
                    <div class="empty-state"><div class="empty-state-icon"><i class="bi bi-chat-left-text"></i></div><div>هنوز یادداشتی برای این تسک ثبت نشده است.</div></div>
                @endforelse
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h5 class="mb-0 fw-bold">ثبت یادداشت جدید</h5></div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('tasks.notes.store', $task) }}">
                    @csrf
                    <label class="form-label fw-semibold">متن یادداشت</label>
                    <textarea name="note" class="form-control" rows="4" required>{{ old('note') }}</textarea>
                    <button class="btn btn-primary mt-3">ثبت یادداشت</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

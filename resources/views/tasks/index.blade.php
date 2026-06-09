@extends('layouts.app')

@section('title', 'تسک‌ها')

@section('content')
<div class="page-header d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
    <div>
        <h3 class="fw-bold mb-2">تسک‌ها</h3>
        <p class="mb-0">برنامه‌ریزی، ارجاع و پیگیری تسک‌های پروژه‌های جهش</p>
    </div>
    @if(in_array(auth()->user()->role, ['admin', 'website_manager']))
        <a href="{{ route('tasks.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle ms-1"></i>ایجاد تسک</a>
    @endif
</div>

@include('partials.search-box', ['placeholder' => 'عنوان تسک، پروژه یا نام پرسنل را جستجو کنید...', 'value' => $search ?? ''])

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">لیست تسک‌ها</h5>
        <span class="badge bg-primary-subtle text-primary">{{ $tasks->total() }} تسک</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>عنوان</th>
                    <th>پروژه</th>
                    <th>ارجاع شده به</th>
                    <th>اولویت</th>
                    <th>وضعیت</th>
                    <th>ددلاین</th>
                    <th>وضعیت ددلاین</th>
                    <th class="text-end">عملیات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $task)
                    <tr>
                        <td class="fw-semibold">{{ $task->title }}</td>
                        <td>{{ $task->project?->title ?? '-' }}</td>
                        <td>{{ $task->assignedUser?->name ?? '-' }}</td>
                        <td>@include('partials.priority-badge', ['priority' => $task->priority])</td>
                        <td>@include('partials.status-badge', ['status' => $task->status, 'type' => 'task'])</td>
                        <td>{{ \App\Support\JalaliDate::format($task->deadline, 'Y/m/d') }}</td>
                        <td>@include('partials.task-deadline-badge', ['task' => $task])</td>
                        <td class="text-end">
                            <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-outline-primary">جزئیات</a>
                            @if(in_array(auth()->user()->role, ['admin', 'website_manager']))
                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-secondary">ویرایش</a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('تسک حذف شود؟')">حذف</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8"><div class="empty-state"><div class="empty-state-icon"><i class="bi bi-list-task"></i></div><div>هنوز تسکی ثبت نشده است.</div></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-transparent border-0 pt-0 px-4 pb-4">{{ $tasks->links() }}</div>
</div>
@endsection

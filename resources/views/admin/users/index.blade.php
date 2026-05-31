@extends('layouts.app')

@section('title', 'کاربران و پرسنل')

@section('content')
@php
    $roleLabels = [
        'admin' => 'مدیر مجموعه',
        'website_manager' => 'مدیر وبسایت',
        'staff' => 'پرسنل',
        'customer' => 'مشتری',
    ];
@endphp
<div class="page-header d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
    <div>
        <h3 class="fw-bold mb-2">کاربران و پرسنل</h3>
        <p class="mb-0">ساخت اکانت مشتری، تعریف مدیر وبسایت و پرسنل پشتیبانی</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-light text-primary">➕ افزودن کاربر</a>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">لیست کاربران</h5>
        <span class="badge bg-primary-subtle text-primary">{{ $users->total() }} کاربر</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>نام</th>
                    <th>شماره تماس</th>
                    <th>نقش</th>
                    <th>مشتری</th>
                    <th class="text-end">عملیات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td class="fw-semibold">{{ $user->name }}</td>
                        <td>{{ $user->phone }}</td>
                        <td><span class="badge bg-dark-subtle text-dark">{{ $roleLabels[$user->role] ?? $user->role }}</span></td>
                        <td>{{ $user->customer?->name ?? '-' }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-warning">ویرایش</a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('حذف شود؟')">حذف</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5"><div class="empty-state"><div class="empty-state-icon">🧑‍💼</div><div>هنوز کاربری ثبت نشده است.</div></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-transparent border-0 pt-0 px-4 pb-4">{{ $users->links() }}</div>
</div>
@endsection

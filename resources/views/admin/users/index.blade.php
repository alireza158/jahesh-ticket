@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>کاربران و پرسنل</h4>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">افزودن کاربر</a>
</div>

<div class="card p-3">
    <table class="table">
        <thead>
            <tr>
                <th>نام</th>
                <th>ایمیل</th>
                <th>نقش</th>
                <th>مشتری</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->customer?->name ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">ویرایش</a>

                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('حذف شود؟')">
                                حذف
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $users->links() }}
</div>
@endsection
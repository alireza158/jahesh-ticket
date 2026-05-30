@extends('layouts.app')

@section('content')
<h4 class="mb-3">افزودن کاربر / پرسنل / اکانت مشتری</h4>

<div class="card p-4">
    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">نام</label>
            <input name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">ایمیل</label>
            <input name="email" type="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">شماره تماس</label>
            <input name="phone" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">نقش</label>
            <select name="role" class="form-select" required>
                <option value="admin">مدیر مجموعه</option>
                <option value="website_manager">مدیر وبسایت</option>
                <option value="staff">پرسنل</option>
                <option value="customer">مشتری</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">اگر نقش مشتری است، مشتری را انتخاب کن</label>
            <select name="customer_id" class="form-select">
                <option value="">انتخاب نشده</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">رمز عبور</label>
            <input name="password" type="password" class="form-control" required>
        </div>

        <button class="btn btn-primary">ثبت کاربر</button>
    </form>
</div>
@endsection
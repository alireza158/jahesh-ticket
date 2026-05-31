@extends('layouts.app')

@section('content')
<h4 class="mb-3">ویرایش کاربر / پرسنل / اکانت مشتری</h4>

<div class="card p-4">
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">نام</label>
            <input name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">ایمیل</label>
            <input name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">شماره تماس</label>
            <input name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">نقش</label>
            <select name="role" class="form-select" required>
                <option value="admin" @selected(old('role', $user->role) === 'admin')>مدیر مجموعه</option>
                <option value="website_manager" @selected(old('role', $user->role) === 'website_manager')>مدیر وبسایت</option>
                <option value="staff" @selected(old('role', $user->role) === 'staff')>پرسنل</option>
                <option value="customer" @selected(old('role', $user->role) === 'customer')>مشتری</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">اگر نقش مشتری است، مشتری را انتخاب کن</label>
            <select name="customer_id" class="form-select">
                <option value="">انتخاب نشده</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" @selected(old('customer_id', $user->customer_id) == $customer->id)>{{ $customer->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">رمز عبور جدید</label>
            <input name="password" type="password" class="form-control">
            <div class="form-text">اگر نمی‌خواهید رمز تغییر کند، این فیلد را خالی بگذارید.</div>
        </div>

        <button class="btn btn-primary">ذخیره تغییرات</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">بازگشت</a>
    </form>
</div>
@endsection

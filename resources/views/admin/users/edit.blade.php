@extends('layouts.app')

@section('title', 'ویرایش کاربر')

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-2">ویرایش کاربر / پرسنل / اکانت مشتری</h3>
    <p class="mb-0">اطلاعات حساب {{ $user->name }} را بروزرسانی کنید.</p>
</div>

<div class="card">
    <div class="card-header"><h5 class="mb-0 fw-bold">فرم ویرایش کاربر</h5></div>
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">نام</label>
                    <input name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">شماره تماس / نام کاربری</label>
                    <input name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">نقش</label>
                    <select name="role" class="form-select" required>
                        <option value="admin" @selected(old('role', $user->role) === 'admin')>مدیر مجموعه</option>
                        <option value="website_manager" @selected(old('role', $user->role) === 'website_manager')>مدیر وبسایت</option>
                        <option value="staff" @selected(old('role', $user->role) === 'staff')>پرسنل</option>
                        <option value="customer" @selected(old('role', $user->role) === 'customer')>مشتری</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">اگر نقش مشتری است، مشتری را انتخاب کن</label>
                    <select name="customer_id" class="form-select">
                        <option value="">انتخاب نشده</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" @selected(old('customer_id', $user->customer_id) == $customer->id)>{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">رمز عبور جدید</label>
                    <input name="password" type="password" class="form-control">
                    <div class="form-text">اگر نمی‌خواهید رمز تغییر کند، این فیلد را خالی بگذارید.</div>
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button class="btn btn-primary">ذخیره تغییرات</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">بازگشت</a>
            </div>
        </form>
    </div>
</div>
@endsection

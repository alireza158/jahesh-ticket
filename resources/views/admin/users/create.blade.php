@extends('layouts.app')

@section('title', 'افزودن کاربر')

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-2">افزودن کاربر / پرسنل / اکانت مشتری</h3>
    <p class="mb-0">نقش کاربر را تعیین کنید؛ برای نقش مشتری حتماً مشتری مرتبط را انتخاب کنید.</p>
</div>

<div class="card">
    <div class="card-header"><h5 class="mb-0 fw-bold">فرم ثبت کاربر</h5></div>
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">نام</label>
                    <input name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">ایمیل</label>
                    <input name="email" type="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">شماره تماس</label>
                    <input name="phone" class="form-control" value="{{ old('phone') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">نقش</label>
                    <select name="role" class="form-select" required>
                        <option value="admin" @selected(old('role') === 'admin')>مدیر مجموعه</option>
                        <option value="website_manager" @selected(old('role') === 'website_manager')>مدیر وبسایت</option>
                        <option value="staff" @selected(old('role') === 'staff')>پرسنل</option>
                        <option value="customer" @selected(old('role') === 'customer')>مشتری</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">اگر نقش مشتری است، مشتری را انتخاب کن</label>
                    <select name="customer_id" class="form-select">
                        <option value="">انتخاب نشده</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" @selected(old('customer_id') == $customer->id)>{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">رمز عبور</label>
                    <input name="password" type="password" class="form-control" required>
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button class="btn btn-primary">ثبت کاربر</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">بازگشت</a>
            </div>
        </form>
    </div>
</div>
@endsection

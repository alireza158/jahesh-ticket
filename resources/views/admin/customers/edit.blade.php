@extends('layouts.app')

@section('title', 'ویرایش مشتری')

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-2">ویرایش مشتری</h3>
    <p class="mb-0">اطلاعات {{ $customer->name }} را بروزرسانی کنید.</p>
</div>

<div class="card">
    <div class="card-header"><h5 class="mb-0 fw-bold">فرم ویرایش مشتری</h5></div>
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.customers.update', $customer) }}">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">نام مشتری</label>
                    <input name="name" class="form-control" value="{{ old('name', $customer->name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">نام شرکت</label>
                    <input name="company_name" class="form-control" value="{{ old('company_name', $customer->company_name) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">شماره تماس / نام کاربری</label>
                    <input name="phone" class="form-control" value="{{ old('phone', $customer->phone) }}" required>
                    <div class="form-text">اکانت مشتری هم با این شماره بروزرسانی می‌شود.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">رمز جدید اکانت مشتری</label>
                    <input name="account_password" type="password" class="form-control" placeholder="برای عدم تغییر خالی بگذارید">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">آدرس</label>
                    <textarea name="address" class="form-control" rows="3">{{ old('address', $customer->address) }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">وضعیت</label>
                    <select name="status" class="form-select">
                        <option value="active" @selected(old('status', $customer->status) === 'active')>فعال</option>
                        <option value="inactive" @selected(old('status', $customer->status) === 'inactive')>غیرفعال</option>
                    </select>
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button class="btn btn-primary">ذخیره تغییرات</button>
                <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">بازگشت</a>
            </div>
        </form>
    </div>
</div>
@endsection

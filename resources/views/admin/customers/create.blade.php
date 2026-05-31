@extends('layouts.app')

@section('title', 'افزودن مشتری')

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-2">افزودن مشتری</h3>
    <p class="mb-0">اطلاعات مشتری و شرکت را وارد کنید تا بتوانید پروژه و اکانت مشتری بسازید.</p>
</div>

<div class="card">
    <div class="card-header"><h5 class="mb-0 fw-bold">فرم ثبت مشتری</h5></div>
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.customers.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">نام مشتری</label>
                    <input name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">نام شرکت</label>
                    <input name="company_name" class="form-control" value="{{ old('company_name') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">شماره تماس / نام کاربری</label>
                    <input name="phone" class="form-control" value="{{ old('phone') }}" placeholder="09120000000" required>
                    <div class="form-text">اکانت مشتری با همین شماره ساخته می‌شود.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">رمز اولیه اکانت</label>
                    <input name="account_password" type="password" class="form-control" placeholder="پیش‌فرض: 12345678">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">آدرس</label>
                    <textarea name="address" class="form-control" rows="3">{{ old('address') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">وضعیت</label>
                    <select name="status" class="form-select">
                        <option value="active" @selected(old('status', 'active') === 'active')>فعال</option>
                        <option value="inactive" @selected(old('status') === 'inactive')>غیرفعال</option>
                    </select>
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button class="btn btn-primary">ثبت مشتری</button>
                <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">بازگشت</a>
            </div>
        </form>
    </div>
</div>
@endsection

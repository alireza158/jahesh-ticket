@extends('layouts.app')

@section('content')
<h4 class="mb-3">ویرایش مشتری</h4>

<div class="card p-4">
    <form method="POST" action="{{ route('admin.customers.update', $customer) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">نام مشتری</label>
            <input name="name" class="form-control" value="{{ old('name', $customer->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">نام شرکت</label>
            <input name="company_name" class="form-control" value="{{ old('company_name', $customer->company_name) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">ایمیل</label>
            <input name="email" type="email" class="form-control" value="{{ old('email', $customer->email) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">تلفن</label>
            <input name="phone" class="form-control" value="{{ old('phone', $customer->phone) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">آدرس</label>
            <textarea name="address" class="form-control">{{ old('address', $customer->address) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">وضعیت</label>
            <select name="status" class="form-select">
                <option value="active" @selected(old('status', $customer->status) === 'active')>فعال</option>
                <option value="inactive" @selected(old('status', $customer->status) === 'inactive')>غیرفعال</option>
            </select>
        </div>

        <button class="btn btn-primary">ذخیره تغییرات</button>
        <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">بازگشت</a>
    </form>
</div>
@endsection

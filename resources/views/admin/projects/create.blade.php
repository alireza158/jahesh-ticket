@extends('layouts.app')

@section('title', 'افزودن پروژه')

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-2">افزودن پروژه</h3>
    <p class="mb-0">مشخصات پروژه، هزینه اولیه، هزینه ماهانه و مانده‌های مالی را ثبت کنید.</p>
</div>

<div class="card">
    <div class="card-header"><h5 class="mb-0 fw-bold">فرم ثبت پروژه</h5></div>
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.projects.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">مشتری</label>
                    <select name="customer_id" class="form-select" required>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" @selected(old('customer_id') == $customer->id)>{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">عنوان پروژه</label>
                    <input name="title" class="form-control" value="{{ old('title') }}" required>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">توضیحات</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                </div>
                <div class="col-md-6 col-xl-3">
                    <label class="form-label fw-semibold">هزینه اولیه</label>
                    <input name="initial_fee" type="number" class="form-control" value="{{ old('initial_fee', 0) }}">
                </div>
                <div class="col-md-6 col-xl-3">
                    <label class="form-label fw-semibold">هزینه ماهانه</label>
                    <input name="monthly_fee" type="number" class="form-control" value="{{ old('monthly_fee', 0) }}">
                </div>
                <div class="col-md-6 col-xl-3">
                    <label class="form-label fw-semibold">بدهکاری دستی</label>
                    <input name="debt_adjustment" type="number" class="form-control" value="{{ old('debt_adjustment', 0) }}">
                </div>
                <div class="col-md-6 col-xl-3">
                    <label class="form-label fw-semibold">بستانکاری دستی</label>
                    <input name="credit_adjustment" type="number" class="form-control" value="{{ old('credit_adjustment', 0) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">وضعیت</label>
                    <select name="status" class="form-select">
                        <option value="active" @selected(old('status', 'active') === 'active')>فعال</option>
                        <option value="inactive" @selected(old('status') === 'inactive')>غیرفعال</option>
                        <option value="completed" @selected(old('status') === 'completed')>تمام‌شده</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">یادداشت مالی</label>
                    <input name="finance_note" class="form-control" value="{{ old('finance_note') }}" placeholder="توضیح بدهکاری/بستانکاری">
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button class="btn btn-primary">ثبت پروژه</button>
                <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">بازگشت</a>
            </div>
        </form>
    </div>
</div>
@endsection

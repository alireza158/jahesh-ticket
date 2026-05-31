@extends('layouts.app')

@section('title', 'ویرایش پروژه')

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-2">ویرایش پروژه</h3>
    <p class="mb-0">اطلاعات پروژه {{ $project->title }} را بروزرسانی کنید.</p>
</div>

<div class="card">
    <div class="card-header"><h5 class="mb-0 fw-bold">فرم ویرایش پروژه</h5></div>
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.projects.update', $project) }}">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">مشتری</label>
                    <select name="customer_id" class="form-select" required>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" @selected(old('customer_id', $project->customer_id) == $customer->id)>{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">عنوان پروژه</label>
                    <input name="title" class="form-control" value="{{ old('title', $project->title) }}" required>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">توضیحات</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description', $project->description) }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">هزینه ماهانه</label>
                    <input name="monthly_fee" type="number" class="form-control" value="{{ old('monthly_fee', $project->monthly_fee) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">وضعیت</label>
                    <select name="status" class="form-select">
                        <option value="active" @selected(old('status', $project->status) === 'active')>فعال</option>
                        <option value="inactive" @selected(old('status', $project->status) === 'inactive')>غیرفعال</option>
                        <option value="completed" @selected(old('status', $project->status) === 'completed')>تمام‌شده</option>
                    </select>
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button class="btn btn-primary">ذخیره تغییرات</button>
                <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">بازگشت</a>
            </div>
        </form>
    </div>
</div>
@endsection

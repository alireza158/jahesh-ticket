@extends('layouts.app')

@section('content')
<h4 class="mb-3">ویرایش پروژه</h4>

<div class="card p-4">
    <form method="POST" action="{{ route('admin.projects.update', $project) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">مشتری</label>
            <select name="customer_id" class="form-select" required>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" @selected(old('customer_id', $project->customer_id) == $customer->id)>{{ $customer->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">عنوان پروژه</label>
            <input name="title" class="form-control" value="{{ old('title', $project->title) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">توضیحات</label>
            <textarea name="description" class="form-control">{{ old('description', $project->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">هزینه ماهانه</label>
            <input name="monthly_fee" type="number" class="form-control" value="{{ old('monthly_fee', $project->monthly_fee) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">وضعیت</label>
            <select name="status" class="form-select">
                <option value="active" @selected(old('status', $project->status) === 'active')>فعال</option>
                <option value="inactive" @selected(old('status', $project->status) === 'inactive')>غیرفعال</option>
                <option value="completed" @selected(old('status', $project->status) === 'completed')>تمام‌شده</option>
            </select>
        </div>

        <button class="btn btn-primary">ذخیره تغییرات</button>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">بازگشت</a>
    </form>
</div>
@endsection

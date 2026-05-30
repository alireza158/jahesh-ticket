@extends('layouts.app')

@section('content')
<h4 class="mb-3">افزودن پروژه</h4>

<div class="card p-4">
    <form method="POST" action="{{ route('admin.projects.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">مشتری</label>
            <select name="customer_id" class="form-select" required>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">عنوان پروژه</label>
            <input name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">توضیحات</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">هزینه ماهانه</label>
            <input name="monthly_fee" type="number" class="form-control" value="0">
        </div>

        <div class="mb-3">
            <label class="form-label">وضعیت</label>
            <select name="status" class="form-select">
                <option value="active">فعال</option>
                <option value="inactive">غیرفعال</option>
                <option value="completed">تمام‌شده</option>
            </select>
        </div>

        <button class="btn btn-primary">ثبت پروژه</button>
    </form>
</div>
@endsection
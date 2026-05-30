@extends('layouts.app')

@section('content')
<h4 class="mb-3">افزودن مشتری</h4>

<div class="card p-4">
    <form method="POST" action="{{ route('admin.customers.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">نام مشتری</label>
            <input name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">نام شرکت</label>
            <input name="company_name" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">ایمیل</label>
            <input name="email" type="email" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">تلفن</label>
            <input name="phone" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">آدرس</label>
            <textarea name="address" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">وضعیت</label>
            <select name="status" class="form-select">
                <option value="active">فعال</option>
                <option value="inactive">غیرفعال</option>
            </select>
        </div>

        <button class="btn btn-primary">ثبت مشتری</button>
    </form>
</div>
@endsection
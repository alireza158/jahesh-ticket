@extends('layouts.app')

@section('title', 'ثبت پرداخت پروژه')

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-2">ثبت پرداخت پروژه</h3>
    <p class="mb-0">مدیر اصلی و مدیر وبسایت می‌توانند پرداخت پروژه را مستقیم ثبت کنند.</p>
</div>

<div class="card">
    <div class="card-header"><h5 class="mb-0 fw-bold">فرم ثبت پرداخت</h5></div>
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.payments.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">پروژه</label>
                    <select name="project_id" class="form-select" required>
                        <option value="">انتخاب پروژه</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" @selected(old('project_id', $selectedProject?->id) == $project->id)>
                                {{ $project->title }} - {{ $project->customer?->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">مبلغ</label>
                    <input name="amount" type="number" class="form-control" value="{{ old('amount') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">ماه پرداخت</label>
                    <input name="payment_month" class="form-control" value="{{ old('payment_month', \App\Support\JalaliDate::nowMonth()) }}" placeholder="1405/03">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">تاریخ پرداخت</label>
                    <input name="paid_at_jalali" class="form-control jalali-date" data-jdp value="{{ old('paid_at_jalali') }}" placeholder="1405/03/10">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">وضعیت</label>
                    <select name="status" class="form-select" required>
                        <option value="approved" @selected(old('status', 'approved') === 'approved')>تایید شده</option>
                        <option value="pending" @selected(old('status') === 'pending')>در انتظار تایید</option>
                        <option value="rejected" @selected(old('status') === 'rejected')>رد شده</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">رسید پرداخت</label>
                    <input name="receipt" type="file" class="form-control">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">یادداشت مدیر</label>
                    <textarea name="admin_note" class="form-control" rows="3">{{ old('admin_note') }}</textarea>
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button class="btn btn-primary">ثبت پرداخت</button>
                <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary">بازگشت</a>
            </div>
        </form>
    </div>
</div>
@endsection

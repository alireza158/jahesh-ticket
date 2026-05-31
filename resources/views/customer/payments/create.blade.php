@extends('layouts.app')

@section('title', 'ثبت پرداخت')

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-2">ثبت پرداخت</h3>
    <p class="mb-0">اطلاعات پرداخت ماهانه و رسید خود را بارگذاری کنید تا مدیر تایید کند.</p>
</div>

<div class="card">
    <div class="card-header"><h5 class="mb-0 fw-bold">فرم ثبت پرداخت</h5></div>
    <div class="card-body p-4">
        <form method="POST" action="{{ route('customer.payments.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">پروژه</label>
                    <select name="project_id" class="form-select">
                        <option value="">بدون پروژه</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" @selected(old('project_id') == $project->id)>{{ $project->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">مبلغ</label>
                    <input name="amount" type="number" class="form-control" value="{{ old('amount') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">ماه پرداخت</label>
                    <input name="payment_month" class="form-control" placeholder="مثلا 1403/02" value="{{ old('payment_month', \App\Support\JalaliDate::nowMonth()) }}">
                    <div class="form-text">ماه پرداخت بر اساس تقویم شمسی ذخیره می‌شود.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">تاریخ پرداخت</label>
                    <input name="paid_at_jalali" class="form-control jalali-date" data-jdp placeholder="1403/02/15" value="{{ old('paid_at_jalali') }}">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">رسید پرداخت</label>
                    <input name="receipt" type="file" class="form-control">
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button class="btn btn-primary">ثبت پرداخت</button>
                <a href="{{ route('customer.payments.index') }}" class="btn btn-outline-secondary">بازگشت</a>
            </div>
        </form>
    </div>
</div>
@endsection

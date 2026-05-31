@extends('layouts.app')

@section('content')
<h4 class="mb-3">ثبت پرداخت</h4>

<div class="card p-4">
    <form method="POST" action="{{ route('customer.payments.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">پروژه</label>
            <select name="project_id" class="form-select">
                <option value="">بدون پروژه</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">مبلغ</label>
            <input name="amount" type="number" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">ماه پرداخت</label>
            <input name="payment_month" class="form-control" placeholder="مثلا 1403/02" value="{{ old('payment_month', \App\Support\JalaliDate::nowMonth()) }}">
            <div class="form-text">ماه پرداخت بر اساس تقویم شمسی ذخیره می‌شود.</div>
        </div>

        <div class="mb-3">
            <label class="form-label">تاریخ پرداخت</label>
            <input name="paid_at_jalali" class="form-control jalali-date" data-jdp placeholder="1403/02/15" value="{{ old('paid_at_jalali') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">رسید پرداخت</label>
            <input name="receipt" type="file" class="form-control">
        </div>

        <button class="btn btn-primary">ثبت پرداخت</button>
    </form>
</div>
@endsection
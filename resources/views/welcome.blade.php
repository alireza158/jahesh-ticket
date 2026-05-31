@extends('layouts.app')

@section('title', 'سامانه پشتیبانی جهش')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="page-header text-center">
                <span class="brand-mark mx-auto mb-3">ج</span>
                <h1 class="fw-bold mb-3">سامانه ثبت و مدیریت تیکت جهش</h1>
                <p class="fs-5 mb-4">پنل یکپارچه ثبت تیکت، ارجاع به پرسنل، مدیریت پرداخت و گزارش بدهکارها</p>
                <a href="{{ route('login') }}" class="btn btn-light text-primary px-4 py-3">ورود به پنل</a>
            </div>
        </div>
    </div>
</div>
@endsection

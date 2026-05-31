@extends('layouts.app')

@section('title', 'ورود')

@section('content')
<div class="container py-4 py-lg-5">
    <div class="row justify-content-center align-items-center g-4">
        <div class="col-lg-6 d-none d-lg-block">
            <div class="login-hero p-5 d-flex flex-column justify-content-between shadow-lg">
                <div>
                    <span class="brand-mark mb-4">ج</span>
                    <h1 class="fw-bold mb-3">سامانه پشتیبانی جهش</h1>
                    <p class="fs-5 opacity-75 mb-0">ثبت، پیگیری و مدیریت تیکت‌های پشتیبانی مشتریان با پنل اختصاصی مدیر، پرسنل و مشتری.</p>
                </div>
                <div class="row g-3 position-relative">
                    <div class="col-6">
                        <div class="bg-white bg-opacity-10 rounded-4 p-3">
                            <div class="fs-3">🎫</div>
                            <div class="fw-bold mt-2">مدیریت تیکت</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-white bg-opacity-10 rounded-4 p-3">
                            <div class="fs-3">💳</div>
                            <div class="fw-bold mt-2">پیگیری پرداخت</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-lg-5 col-xl-4">
            <div class="card p-4 p-lg-5">
                <div class="text-center mb-4">
                    <span class="brand-mark mx-auto mb-3">ج</span>
                    <h4 class="fw-bold mb-1">ورود به پنل جهش</h4>
                    <p class="text-muted mb-0">شماره تماس و رمز عبور خود را وارد کنید</p>
                </div>

                <form method="POST" action="{{ route('login.submit') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">شماره تماس</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="09111111111" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">رمز عبور</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>

                    <div class="form-check mb-4">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label for="remember" class="form-check-label">مرا به خاطر بسپار</label>
                    </div>

                    <button class="btn btn-primary w-100 py-3">ورود به سامانه</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

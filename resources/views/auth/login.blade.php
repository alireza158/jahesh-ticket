@extends('layouts.app')

@section('title', 'ورود')

@section('content')
<div class="login-page min-vh-100 d-flex align-items-center justify-content-center px-3">
    <div class="login-box">

        <div class="text-center mb-4">
            <div class="login-logo mx-auto mb-3">
                ج
            </div>

            <h4 class="fw-bold mb-2">ورود به سامانه</h4>
            <p class="text-muted mb-0">پنل پشتیبانی جهش</p>
        </div>

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">شماره تماس</label>
                <input
                    type="text"
                    name="phone"
                    class="form-control"
                    value="{{ old('phone') }}"
                    placeholder="09111111111"
                    required
                >

                @error('phone')
                    <div class="text-danger small mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">رمز عبور</label>
                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="رمز عبور"
                    required
                >

                @error('password')
                    <div class="text-danger small mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-check mb-4">
                <input
                    type="checkbox"
                    name="remember"
                    class="form-check-input"
                    id="remember"
                >
                <label for="remember" class="form-check-label">
                    مرا به خاطر بسپار
                </label>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-3">
                ورود
            </button>
        </form>

    </div>
</div>
@endsection
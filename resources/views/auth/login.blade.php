@extends('layouts.app')

@section('title', 'ورود')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="col-md-5 col-lg-4">
        <div class="card p-4">
            <h4 class="mb-4 text-center">ورود به پنل جهش</h4>

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">ایمیل</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">رمز عبور</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label for="remember" class="form-check-label">مرا به خاطر بسپار</label>
                </div>

                <button class="btn btn-primary w-100">ورود</button>
            </form>
        </div>
    </div>
</div>
@endsection
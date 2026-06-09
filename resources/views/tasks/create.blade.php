@extends('layouts.app')

@section('title', 'ایجاد تسک')

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-2">ایجاد تسک جدید</h3>
    <p class="mb-0">تسک را به یک پروژه و پرسنل مسئول متصل کنید و ددلاین پیگیری را مشخص کنید.</p>
</div>

<div class="card">
    <div class="card-header"><h5 class="mb-0 fw-bold">فرم ایجاد تسک</h5></div>
    <div class="card-body p-4">
        <form method="POST" action="{{ route('tasks.store') }}">
            @csrf
            @include('tasks._form')
            <div class="d-flex gap-2 mt-4">
                <button class="btn btn-primary">ثبت تسک</button>
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">بازگشت</a>
            </div>
        </form>
    </div>
</div>
@endsection

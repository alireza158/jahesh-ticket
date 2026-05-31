@extends('layouts.app')

@section('title', 'ثبت تیکت')

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-2">ثبت تیکت جدید</h3>
    <p class="mb-0">درخواست پشتیبانی خود را با اولویت، شماره تماس و فایل پیوست ثبت کنید.</p>
</div>

<div class="card">
    <div class="card-header"><h5 class="mb-0 fw-bold">فرم ثبت تیکت</h5></div>
    <div class="card-body p-4">
        <form method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data">
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
                    <label class="form-label fw-semibold">عنوان تیکت</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">توضیحات</label>
                    <textarea name="description" class="form-control" rows="6" required>{{ old('description') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">شماره تماس</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', auth()->user()->phone) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">اولویت</label>
                    <select name="priority" class="form-select" required>
                        <option value="high" @selected(old('priority') === 'high')>زیاد</option>
                        <option value="medium" @selected(old('priority', 'medium') === 'medium')>متوسط</option>
                        <option value="low" @selected(old('priority') === 'low')>کم</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">فایل پیوست</label>
                    <input type="file" name="attachment" class="form-control">
                    <div class="form-text">حداکثر حجم فایل ۵ مگابایت است.</div>
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button class="btn btn-primary">ثبت تیکت</button>
                <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary">بازگشت</a>
            </div>
        </form>
    </div>
</div>
@endsection

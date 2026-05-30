@extends('layouts.app')

@section('title', 'ثبت تیکت')

@section('content')
<h4 class="mb-3">ثبت تیکت جدید</h4>

<div class="card p-4">
    <form method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data">
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
            <label class="form-label">عنوان تیکت</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">توضیحات</label>
            <textarea name="description" class="form-control" rows="5" required>{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">شماره تماس</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', auth()->user()->phone) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">اولویت</label>
            <select name="priority" class="form-select" required>
                <option value="high">زیاد</option>
                <option value="medium" selected>متوسط</option>
                <option value="low">کم</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">فایل پیوست</label>
            <input type="file" name="attachment" class="form-control">
        </div>

        <button class="btn btn-primary">ثبت تیکت</button>
    </form>
</div>
@endsection
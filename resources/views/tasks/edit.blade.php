@extends('layouts.app')

@section('title', 'ویرایش تسک')

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-2">ویرایش تسک</h3>
    <p class="mb-0">فقط مدیر مجموعه و مدیر وبسایت امکان ویرایش کامل تسک را دارند.</p>
</div>

<div class="card">
    <div class="card-header"><h5 class="mb-0 fw-bold">فرم ویرایش تسک</h5></div>
    <div class="card-body p-4">
        <form method="POST" action="{{ route('tasks.update', $task) }}">
            @csrf
            @method('PUT')
            @include('tasks._form', ['task' => $task])
            <div class="d-flex gap-2 mt-4">
                <button class="btn btn-primary">ذخیره تغییرات</button>
                <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-secondary">بازگشت</a>
            </div>
        </form>
    </div>
</div>
@endsection

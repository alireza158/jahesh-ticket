@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>پروژه‌ها</h4>
    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">افزودن پروژه</a>
</div>

<div class="card p-3">
    <table class="table">
        <thead>
            <tr>
                <th>عنوان</th>
                <th>مشتری</th>
                <th>هزینه ماهانه</th>
                <th>وضعیت</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($projects as $project)
                <tr>
                    <td>{{ $project->title }}</td>
                    <td>{{ $project->customer->name }}</td>
                    <td>{{ number_format($project->monthly_fee) }} تومان</td>
                    <td>{{ $project->status }}</td>
                    <td>
                        <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-sm btn-warning">
                            ویرایش
                        </a>

                        <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('حذف شود؟')">
                                حذف
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $projects->links() }}
</div>
@endsection
@extends('layouts.app')

@section('content')
<h4 class="mb-3">گزارش مشتریان بدهکار</h4>

<div class="alert alert-info">
    ماه بررسی: {{ $currentMonth }}
</div>

<div class="card p-3">
    <table class="table">
        <thead>
            <tr>
                <th>نام مشتری</th>
                <th>شرکت</th>
                <th>تلفن</th>
                <th>پروژه‌های فعال</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->company_name }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>
                        @foreach($customer->projects as $project)
                            @if($project->status === 'active')
                                <span class="badge bg-primary">{{ $project->title }}</span>
                            @endif
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $customers->links() }}
</div>
@endsection
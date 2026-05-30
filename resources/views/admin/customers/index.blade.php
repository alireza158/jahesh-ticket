@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>مشتریان</h4>
    <a href="{{ route('admin.customers.create') }}" class="btn btn-primary">افزودن مشتری</a>
</div>

<div class="card p-3">
    <table class="table">
        <thead>
            <tr>
                <th>نام</th>
                <th>شرکت</th>
                <th>ایمیل</th>
                <th>تلفن</th>
                <th>وضعیت</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->company_name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->status }}</td>
                    <td>
                        <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-sm btn-warning">
                            ویرایش
                        </a>

                        <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" class="d-inline">
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

    {{ $customers->links() }}
</div>
@endsection
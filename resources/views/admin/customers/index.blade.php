@extends('layouts.app')

@section('title', 'مشتریان')

@section('content')
<div class="page-header d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
    <div>
        <h3 class="fw-bold mb-2">مشتریان</h3>
        <p class="mb-0">مدیریت اطلاعات مشتریان، شرکت‌ها و وضعیت همکاری</p>
    </div>
    <a href="{{ route('admin.customers.create') }}" class="btn btn-primary">افزودن مشتری</a>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">لیست مشتریان</h5>
        <span class="badge bg-primary-subtle text-primary">{{ $customers->total() }} مشتری</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>نام</th>
                    <th>شرکت</th>
                    <th>شماره تماس</th>
                    <th>وضعیت</th>
                    <th class="text-end">عملیات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr>
                        <td class="fw-semibold">{{ $customer->name }}</td>
                        <td>{{ $customer->company_name ?? '-' }}</td>
                        <td>{{ $customer->phone ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $customer->status === 'active' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                                {{ $customer->status === 'active' ? 'فعال' : 'غیرفعال' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-sm btn-outline-warning">ویرایش</a>
                            <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('حذف شود؟')">حذف</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state"><div class="empty-state-icon"><i class="bi bi-people"></i></div><div>هنوز مشتری ثبت نشده است.</div></div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-transparent border-0 pt-0 px-4 pb-4">{{ $customers->links() }}</div>
</div>
@endsection

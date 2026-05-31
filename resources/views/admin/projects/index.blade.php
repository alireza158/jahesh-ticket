@extends('layouts.app')

@section('title', 'پروژه‌ها')

@section('content')
<div class="page-header d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
    <div>
        <h3 class="fw-bold mb-2">پروژه‌ها</h3>
        <p class="mb-0">مدیریت مشخصات، هزینه‌ها، بدهکاری و پرداخت‌های پروژه‌ها</p>
    </div>
    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">افزودن پروژه</a>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">لیست پروژه‌ها</h5>
        <span class="badge bg-primary-subtle text-primary">{{ $projects->total() }} پروژه</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>عنوان</th>
                    <th>مشتری</th>
                    <th>هزینه اولیه</th>
                    <th>هزینه ماهانه</th>
                    <th>مانده بدهی</th>
                    <th>بستانکاری</th>
                    <th>وضعیت</th>
                    <th class="text-end">عملیات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $project)
                    <tr>
                        <td class="fw-semibold">{{ $project->title }}</td>
                        <td>{{ $project->customer?->name ?? '-' }}</td>
                        <td>{{ number_format($project->initial_fee) }} تومان</td>
                        <td>{{ number_format($project->monthly_fee) }} تومان</td>
                        <td><span class="badge bg-danger-subtle text-danger">{{ number_format($project->remainingDebt()) }} تومان</span></td>
                        <td><span class="badge bg-success-subtle text-success">{{ number_format($project->creditBalance()) }} تومان</span></td>
                        <td>
                            @php($projectStatus = ['active' => 'فعال', 'inactive' => 'غیرفعال', 'completed' => 'تمام‌شده'])
                            <span class="badge bg-secondary-subtle text-secondary">{{ $projectStatus[$project->status] ?? $project->status }}</span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-sm btn-outline-primary">جزئیات</a>
                            <a href="{{ route('admin.payments.create', ['project_id' => $project->id]) }}" class="btn btn-sm btn-outline-success">ثبت پرداخت</a>
                            <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-sm btn-outline-secondary">ویرایش</a>
                            @if(auth()->user()->role === 'admin')
                                <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('حذف شود؟')">حذف</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8"><div class="empty-state"><div class="empty-state-icon"><i class="bi bi-folder2-open"></i></div><div>هنوز پروژه‌ای ثبت نشده است.</div></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-transparent border-0 pt-0 px-4 pb-4">{{ $projects->links() }}</div>
</div>
@endsection

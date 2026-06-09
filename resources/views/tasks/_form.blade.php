<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label fw-semibold">پروژه</label>
        <select name="project_id" class="form-select" required>
            <option value="">انتخاب پروژه</option>
            @foreach($projects as $project)
                <option value="{{ $project->id }}" @selected(old('project_id', $task->project_id ?? $selectedProject ?? null) == $project->id)>
                    {{ $project->title }} - {{ $project->customer?->name ?? 'بدون مشتری' }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold">پرسنل مسئول</label>
        <select name="assigned_to" class="form-select" required>
            <option value="">انتخاب پرسنل</option>
            @foreach($staffUsers as $staff)
                <option value="{{ $staff->id }}" @selected(old('assigned_to', $task->assigned_to ?? null) == $staff->id)>{{ $staff->name }} - {{ $staff->phone }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12">
        <label class="form-label fw-semibold">عنوان</label>
        <input name="title" class="form-control" value="{{ old('title', $task->title ?? '') }}" required>
    </div>
    <div class="col-12">
        <label class="form-label fw-semibold">توضیحات</label>
        <textarea name="description" class="form-control" rows="5">{{ old('description', $task->description ?? '') }}</textarea>
    </div>
    <div class="col-md-4">
        <label class="form-label fw-semibold">ددلاین</label>
        <input name="deadline_jalali" class="form-control jalali-date" data-jdp value="{{ old('deadline_jalali', isset($task) ? \App\Support\JalaliDate::format($task->deadline, 'Y/m/d') : '') }}" placeholder="1405/03/20">
    </div>
    <div class="col-md-4">
        <label class="form-label fw-semibold">اولویت</label>
        <select name="priority" class="form-select" required>
            <option value="high" @selected(old('priority', $task->priority ?? 'medium') === 'high')>زیاد</option>
            <option value="medium" @selected(old('priority', $task->priority ?? 'medium') === 'medium')>متوسط</option>
            <option value="low" @selected(old('priority', $task->priority ?? 'medium') === 'low')>کم</option>
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label fw-semibold">وضعیت اولیه</label>
        <select name="status" class="form-select" required>
            <option value="pending" @selected(old('status', $task->status ?? 'pending') === 'pending')>انجام نشده</option>
            <option value="in_progress" @selected(old('status', $task->status ?? 'pending') === 'in_progress')>در حال انجام</option>
            <option value="done" @selected(old('status', $task->status ?? 'pending') === 'done')>انجام شده</option>
        </select>
    </div>
</div>

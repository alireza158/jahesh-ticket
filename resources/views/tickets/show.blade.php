@extends('layouts.app')

@section('title', 'مشاهده تیکت')

@section('content')
<div class="page-header d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
    <div>
        <h3 class="fw-bold mb-2">{{ $ticket->title }}</h3>
        <p class="mb-0">مشتری: {{ $ticket->customer->name }} | پروژه: {{ $ticket->project?->title ?? '-' }}</p>
    </div>
    <div class="d-flex flex-wrap gap-2">
        @include('partials.priority-badge', ['priority' => $ticket->priority])
        @include('partials.status-badge', ['status' => $ticket->status])
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0 fw-bold">جزئیات درخواست</h5>
                @if($ticket->attachment_path)
                    <a href="{{ asset('storage/'.$ticket->attachment_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-paperclip ms-1"></i> دانلود پیوست
                    </a>
                @endif
            </div>
            <div class="card-body p-4">
                <div class="row g-3 mb-4">
                    <div class="col-md-4"><div class="p-3 rounded-4 bg-light"><div class="text-muted small">شماره تماس</div><div class="fw-semibold">{{ $ticket->phone ?? '-' }}</div></div></div>
                    <div class="col-md-4"><div class="p-3 rounded-4 bg-light"><div class="text-muted small">ارجاع به</div><div class="fw-semibold">{{ $ticket->assignedStaff?->name ?? '-' }}</div></div></div>
                    <div class="col-md-4"><div class="p-3 rounded-4 bg-light"><div class="text-muted small">تاریخ ثبت</div><div class="fw-semibold">{{ \App\Support\JalaliDate::format($ticket->created_at, 'Y/m/d H:i') }}</div></div></div>
                </div>
                <p class="lh-lg mb-0">{{ $ticket->description }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h5 class="mb-0 fw-bold">گفتگو و یادداشت‌ها</h5></div>
            <div class="card-body p-4">
                <div class="ticket-thread">
                    @forelse($ticket->replies as $reply)
                        @if($reply->is_internal && auth()->user()->role === 'customer')
                            @continue
                        @endif

                        <div class="ticket-message {{ $reply->is_internal ? 'internal' : '' }}">
                            <div class="ticket-message-avatar">{{ mb_substr($reply->user->name, 0, 1) }}</div>
                            <div class="ticket-message-body">
                                <div class="d-flex flex-wrap justify-content-between gap-2 mb-2">
                                    <div class="fw-bold">{{ $reply->user->name }}</div>
                                    <div class="small text-muted">{{ \App\Support\JalaliDate::format($reply->created_at, 'Y/m/d H:i') }}</div>
                                </div>
                                @if($reply->is_internal)
                                    <span class="badge bg-warning-subtle text-warning mb-2">یادداشت داخلی</span>
                                @endif
                                <p class="mb-2 lh-lg">{{ $reply->message }}</p>
                                @if($reply->attachment_path)
                                    <a href="{{ asset('storage/'.$reply->attachment_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-download ms-1"></i> دانلود فایل
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <div class="empty-state-icon"><i class="bi bi-chat-dots"></i></div>
                            <div class="fw-bold">هنوز پاسخی ثبت نشده است</div>
                        </div>
                    @endforelse
                </div>

                <hr class="my-4">

                <form method="POST" action="{{ route('tickets.reply', $ticket) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">متن پاسخ</label>
                        <textarea name="message" class="form-control" rows="4" placeholder="پاسخ یا یادداشت خود را بنویسید..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">فایل</label>
                        <input type="file" name="attachment" class="form-control">
                    </div>
                    @if(auth()->user()->role !== 'customer')
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_internal" value="1" id="is_internal">
                            <label class="form-check-label" for="is_internal">یادداشت داخلی فقط برای مدیر/پرسنل</label>
                        </div>
                    @endif
                    <button class="btn btn-primary"><i class="bi bi-send ms-1"></i> ارسال پاسخ</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        @if(in_array(auth()->user()->role, ['admin', 'website_manager']))
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0 fw-bold">ارجاع تیکت</h5></div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('tickets.assign', $ticket) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">پرسنل</label>
                            <select name="assigned_to" class="form-select" required>
                                @foreach($staffUsers as $staff)
                                    <option value="{{ $staff->id }}" @selected($ticket->assigned_to === $staff->id)>{{ $staff->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">یادداشت ارجاع</label>
                            <textarea name="note" class="form-control" rows="3" placeholder="توضیح لازم برای پرسنل..."></textarea>
                        </div>
                        <button class="btn btn-success w-100">ارجاع بده</button>
                    </form>
                </div>
            </div>
        @endif

        @if(auth()->user()->role !== 'customer')
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0 fw-bold">تغییر وضعیت</h5></div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('tickets.status', $ticket) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">وضعیت جدید</label>
                            <select name="status" class="form-select">
                                <option value="open" @selected($ticket->status === 'open')>باز</option>
                                <option value="in_progress" @selected($ticket->status === 'in_progress')>در حال بررسی</option>
                                <option value="waiting_customer" @selected($ticket->status === 'waiting_customer')>در انتظار مشتری</option>
                                <option value="answered" @selected($ticket->status === 'answered')>پاسخ داده شده</option>
                                <option value="closed" @selected($ticket->status === 'closed')>بسته شده</option>
                            </select>
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" name="send_sms" value="1" class="form-check-input" id="send_sms">
                            <label for="send_sms" class="form-check-label">پیامک به مشتری ارسال شود</label>
                        </div>
                        <button class="btn btn-warning w-100">ثبت وضعیت</button>
                    </form>
                </div>
            </div>
        @endif

        @if(auth()->user()->role !== 'customer')
            <div class="card">
                <div class="card-header"><h5 class="mb-0 fw-bold">سوابق ارجاع</h5></div>
                <div class="card-body p-4">
                    @forelse($ticket->assignments as $assignment)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="fw-semibold">از {{ $assignment->assignedBy->name }} به {{ $assignment->assignedTo->name }}</div>
                            <small class="text-muted d-block mt-1">{{ $assignment->note ?: 'بدون یادداشت' }}</small>
                        </div>
                    @empty
                        <div class="empty-state py-3"><div class="empty-state-icon"><i class="bi bi-arrow-left-right"></i></div><div>هنوز ارجاعی ثبت نشده است.</div></div>
                    @endforelse
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

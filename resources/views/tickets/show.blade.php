@extends('layouts.app')

@section('title', 'مشاهده تیکت')

@section('content')
<div class="row g-3">
    <div class="col-lg-8">
        <div class="card p-4 mb-3">
            <h4>{{ $ticket->title }}</h4>

            <div class="text-muted mb-3">
                مشتری: {{ $ticket->customer->name }}
                |
                پروژه: {{ $ticket->project?->title ?? '-' }}
                |
                وضعیت: {{ $ticket->status }}
            </div>

            <p>{{ $ticket->description }}</p>

            @if($ticket->attachment_path)
                <a href="{{ asset('storage/'.$ticket->attachment_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                    دانلود فایل پیوست
                </a>
            @endif
        </div>

        <div class="card p-4">
            <h5 class="mb-3">پاسخ‌ها</h5>

            @foreach($ticket->replies as $reply)
                @if($reply->is_internal && auth()->user()->role === 'customer')
                    @continue
                @endif

                <div class="border rounded p-3 mb-3 {{ $reply->is_internal ? 'bg-warning-subtle' : 'bg-light' }}">
                    <strong>{{ $reply->user->name }}</strong>

                    @if($reply->is_internal)
                        <span class="badge bg-warning text-dark">یادداشت داخلی</span>
                    @endif

                    <p class="mt-2 mb-1">{{ $reply->message }}</p>

                    @if($reply->attachment_path)
                        <a href="{{ asset('storage/'.$reply->attachment_path) }}" target="_blank">
                            دانلود فایل
                        </a>
                    @endif

                    <div class="small text-muted mt-2">
                        {{ $reply->created_at->format('Y/m/d H:i') }}
                    </div>
                </div>
            @endforeach

            <hr>

            <form method="POST" action="{{ route('tickets.reply', $ticket) }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">متن پاسخ</label>
                    <textarea name="message" class="form-control" rows="4"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">فایل</label>
                    <input type="file" name="attachment" class="form-control">
                </div>

                @if(auth()->user()->role !== 'customer')
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="is_internal" value="1" id="is_internal">
                        <label class="form-check-label" for="is_internal">
                            یادداشت داخلی فقط برای مدیر/پرسنل
                        </label>
                    </div>
                @endif

                <button class="btn btn-primary">ارسال پاسخ</button>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        @if(in_array(auth()->user()->role, ['admin', 'website_manager']))
            <div class="card p-4 mb-3">
                <h5>ارجاع تیکت</h5>

                <form method="POST" action="{{ route('tickets.assign', $ticket) }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">پرسنل</label>
                        <select name="assigned_to" class="form-select" required>
                            @foreach($staffUsers as $staff)
                                <option value="{{ $staff->id }}" @selected($ticket->assigned_to === $staff->id)>
                                    {{ $staff->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">یادداشت ارجاع</label>
                        <textarea name="note" class="form-control" rows="3"></textarea>
                    </div>

                    <button class="btn btn-success w-100">ارجاع بده</button>
                </form>
            </div>
        @endif

        @if(auth()->user()->role !== 'customer')
            <div class="card p-4 mb-3">
                <h5>تغییر وضعیت</h5>

                <form method="POST" action="{{ route('tickets.status', $ticket) }}">
                    @csrf

                    <div class="mb-3">
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
                        <label for="send_sms" class="form-check-label">
                            پیامک به مشتری ارسال شود
                        </label>
                    </div>

                    <button class="btn btn-warning w-100">ثبت وضعیت</button>
                </form>
            </div>
        @endif

        <div class="card p-4">
            <h5>سوابق ارجاع</h5>

            @foreach($ticket->assignments as $assignment)
                <div class="border-bottom py-2">
                    <div>
                        از {{ $assignment->assignedBy->name }}
                        به {{ $assignment->assignedTo->name }}
                    </div>
                    <small class="text-muted">{{ $assignment->note }}</small>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
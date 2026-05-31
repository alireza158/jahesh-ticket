<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\TicketAssignment;
use App\Models\TicketStatusLog;
use App\Models\User;
use App\Services\SmsService;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $query = Ticket::with(['customer', 'project', 'assignedStaff'])->latest();

        if ($user->role === 'customer') {
            $query->where('customer_id', $user->customer_id);
        }

        if ($user->role === 'staff') {
            $query->where('assigned_to', $user->id);
        }

        $tickets = $query->paginate(15);

        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        $user = auth()->user();

        if ($user->role !== 'customer') {
            abort(403);
        }

        $projects = Project::where('customer_id', $user->customer_id)
            ->where('status', 'active')
            ->get();

        return view('tickets.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->role !== 'customer') {
            abort(403);
        }

        $data = $request->validate([
            'project_id' => ['nullable', 'exists:projects,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'phone' => ['nullable', 'string', 'max:30'],
            'priority' => ['required', 'in:high,medium,low'],
            'attachment' => ['nullable', 'file', 'max:5120'],
        ]);

        $path = null;

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('tickets', 'public');
        }

        Ticket::create([
            'customer_id' => $user->customer_id,
            'project_id' => $data['project_id'] ?? null,
            'created_by' => $user->id,
            'title' => $data['title'],
            'description' => $data['description'],
            'phone' => $data['phone'] ?? $user->phone,
            'priority' => $data['priority'],
            'attachment_path' => $path,
            'status' => 'open',
        ]);

        return redirect()->route('tickets.index')
            ->with('success', 'تیکت شما با موفقیت ثبت شد.');
    }

    public function show(Ticket $ticket)
    {
        $this->authorizeTicketAccess($ticket);

        $ticket->load([
            'customer',
            'project',
            'creator',
            'assignedStaff',
            'replies.user',
            'assignments.assignedBy',
            'assignments.assignedTo',
            'statusLogs'
        ]);

        $staffUsers = User::where('role', 'staff')->get();

        return view('tickets.show', compact('ticket', 'staffUsers'));
    }

    public function reply(Request $request, Ticket $ticket)
    {
        $this->authorizeTicketAccess($ticket);

        $data = $request->validate([
            'message' => ['nullable', 'string'],
            'attachment' => ['nullable', 'file', 'max:5120'],
            'is_internal' => ['nullable', 'boolean'],
        ]);

        if (empty($data['message']) && !$request->hasFile('attachment')) {
            return back()->with('error', 'متن پاسخ یا فایل الزامی است.');
        }

        $user = auth()->user();

        $isInternal = $request->boolean('is_internal');

        if ($user->role === 'customer') {
            $isInternal = false;
        }

        $path = null;

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('ticket-replies', 'public');
        }

        TicketReply::create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'message' => $data['message'] ?? null,
            'attachment_path' => $path,
            'is_internal' => $isInternal,
        ]);

        if (!$isInternal && $user->role !== 'customer') {
            $this->updateStatus($ticket, 'answered');
        }

        return back()->with('success', 'پاسخ ثبت شد.');
    }

    public function assign(Request $request, Ticket $ticket)
    {
        $user = auth()->user();

        if (!in_array($user->role, ['admin', 'website_manager'])) {
            abort(403);
        }

        $data = $request->validate([
            'assigned_to' => ['required', 'exists:users,id'],
            'note' => ['nullable', 'string'],
        ]);

        $staff = User::where('id', $data['assigned_to'])
            ->where('role', 'staff')
            ->firstOrFail();

        $oldStatus = $ticket->status;

        $ticket->update([
            'assigned_to' => $staff->id,
            'status' => 'in_progress',
        ]);

        if ($oldStatus !== 'in_progress') {
            TicketStatusLog::create([
                'ticket_id' => $ticket->id,
                'changed_by' => $user->id,
                'old_status' => $oldStatus,
                'new_status' => 'in_progress',
            ]);
        }

        TicketAssignment::create([
            'ticket_id' => $ticket->id,
            'assigned_by' => $user->id,
            'assigned_to' => $staff->id,
            'note' => $data['note'] ?? null,
        ]);

        return back()->with('success', 'تیکت با موفقیت ارجاع شد.');
    }

    public function changeStatus(Request $request, Ticket $ticket)
    {
        $this->authorizeTicketAccess($ticket);

        $user = auth()->user();

        if ($user->role === 'customer') {
            abort(403);
        }

        $data = $request->validate([
            'status' => ['required', 'in:open,in_progress,waiting_customer,answered,closed'],
            'send_sms' => ['nullable', 'boolean'],
        ]);

        $oldStatus = $ticket->status;

        $ticket->update([
            'status' => $data['status'],
        ]);

        TicketStatusLog::create([
            'ticket_id' => $ticket->id,
            'changed_by' => $user->id,
            'old_status' => $oldStatus,
            'new_status' => $data['status'],
        ]);

        $statusLabels = [
            'open' => 'باز',
            'in_progress' => 'در حال بررسی',
            'waiting_customer' => 'در انتظار مشتری',
            'answered' => 'پاسخ داده شده',
            'closed' => 'بسته شده',
        ];

        if ($request->boolean('send_sms')) {
            $customerUser = User::where('customer_id', $ticket->customer_id)
                ->where('role', 'customer')
                ->first();

            if ($customerUser && $customerUser->phone) {
                app(SmsService::class)->send(
                    $customerUser->phone,
                    "وضعیت تیکت {$ticket->title} به ".($statusLabels[$data['status']] ?? $data['status'])." تغییر کرد."
                );
            }
        }

        return back()->with('success', 'وضعیت تیکت تغییر کرد.');
    }

    private function authorizeTicketAccess(Ticket $ticket): void
    {
        $user = auth()->user();

        if (in_array($user->role, ['admin', 'website_manager'])) {
            return;
        }

        if ($user->role === 'staff' && $ticket->assigned_to === $user->id) {
            return;
        }

        if ($user->role === 'customer' && $ticket->customer_id === $user->customer_id) {
            return;
        }

        abort(403);
    }

    private function updateStatus(Ticket $ticket, string $status): void
    {
        $oldStatus = $ticket->status;

        $ticket->update([
            'status' => $status,
        ]);

        TicketStatusLog::create([
            'ticket_id' => $ticket->id,
            'changed_by' => auth()->id(),
            'old_status' => $oldStatus,
            'new_status' => $status,
        ]);
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\Project;
use App\Support\JalaliDate;
use Illuminate\Http\Request;
use InvalidArgumentException;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['customer', 'project', 'approvedBy'])
            ->latest()
            ->paginate(20);

        return view('admin.payments.index', compact('payments'));
    }

    public function create(Request $request)
    {
        $projects = Project::with('customer')
            ->where('status', 'active')
            ->orderBy('title')
            ->get();

        $selectedProject = $request->filled('project_id')
            ? Project::with('customer')->find($request->integer('project_id'))
            : null;

        return view('admin.payments.create', compact('projects', 'selectedProject'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'amount' => ['required', 'numeric', 'min:1000'],
            'payment_month' => ['nullable', 'string', 'max:50'],
            'paid_at_jalali' => ['nullable', 'string', 'max:20'],
            'receipt' => ['nullable', 'file', 'max:5120'],
            'status' => ['required', 'in:pending,approved,rejected'],
            'admin_note' => ['nullable', 'string'],
        ]);

        $project = Project::findOrFail($data['project_id']);

        try {
            $paidAt = JalaliDate::toGregorianDate($data['paid_at_jalali'] ?? null);
        } catch (InvalidArgumentException $exception) {
            return back()->withErrors(['paid_at_jalali' => $exception->getMessage()])->withInput();
        }

        $path = null;

        if ($request->hasFile('receipt')) {
            $path = $request->file('receipt')->store('receipts', 'public');
        }

        Payment::create([
            'customer_id' => $project->customer_id,
            'project_id' => $project->id,
            'amount' => $data['amount'],
            'payment_month' => $data['payment_month'] ?? JalaliDate::nowMonth(),
            'paid_at' => $paidAt,
            'receipt_path' => $path,
            'status' => $data['status'],
            'admin_note' => $data['admin_note'] ?? null,
            'approved_by' => $data['status'] !== 'pending' ? auth()->id() : null,
        ]);

        return redirect()->route('admin.payments.index')
            ->with('success', 'پرداخت پروژه با موفقیت ثبت شد.');
    }

    public function approve(Payment $payment)
    {
        $payment->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'admin_note' => null,
        ]);

        return back()->with('success', 'پرداخت تایید شد.');
    }

    public function reject(Request $request, Payment $payment)
    {
        $data = $request->validate([
            'admin_note' => ['nullable', 'string'],
        ]);

        $payment->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'admin_note' => $data['admin_note'] ?? null,
        ]);

        return back()->with('success', 'پرداخت رد شد.');
    }

    public function debtors()
    {
        /*
         منطق ساده:
         مشتریانی که پروژه فعال دارند اما در ماه جاری پرداخت تایید شده ندارند.
        */

        $currentMonth = JalaliDate::nowMonth();

        $customers = Customer::whereHas('projects', function ($q) {
                $q->where('status', 'active');
            })
            ->whereDoesntHave('payments', function ($q) use ($currentMonth) {
                $q->where('status', 'approved')
                    ->where('payment_month', $currentMonth);
            })
            ->with('projects.payments')
            ->paginate(20);

        return view('admin.payments.debtors', compact('customers', 'currentMonth'));
    }
}

<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Project;
use App\Support\JalaliDate;
use Illuminate\Http\Request;
use InvalidArgumentException;

class PaymentController extends Controller
{
    public function index()
    {
        $customerId = auth()->user()->customer_id;

        $projects = Project::with('payments')
            ->where('customer_id', $customerId)
            ->get();

        $remainingDebt = $projects->sum(fn (Project $project) => $project->remainingDebt());
        $creditBalance = $projects->sum(fn (Project $project) => $project->creditBalance());

        $payments = Payment::with('project')
            ->where('customer_id', $customerId)
            ->latest()
            ->paginate(15);

        return view('customer.payments.index', compact('payments', 'projects', 'remainingDebt', 'creditBalance'));
    }

    public function create()
    {
        $projects = Project::where('customer_id', auth()->user()->customer_id)->get();

        return view('customer.payments.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'project_id' => ['nullable', 'exists:projects,id'],
            'amount' => ['required', 'numeric', 'min:1000'],
            'payment_month' => ['nullable', 'string', 'max:50'],
            'paid_at_jalali' => ['nullable', 'string', 'max:20'],
            'receipt' => ['nullable', 'file', 'max:5120'],
        ]);

        try {
            $paidAt = JalaliDate::toGregorianDate($data['paid_at_jalali'] ?? null);
        } catch (InvalidArgumentException $exception) {
            return back()->withErrors(['paid_at_jalali' => $exception->getMessage()])->withInput();
        }

        $paymentMonth = $data['payment_month'] ?? JalaliDate::nowMonth();

        $path = null;

        if ($request->hasFile('receipt')) {
            $path = $request->file('receipt')->store('receipts', 'public');
        }

        Payment::create([
            'customer_id' => auth()->user()->customer_id,
            'project_id' => $data['project_id'] ?? null,
            'amount' => $data['amount'],
            'payment_month' => $paymentMonth,
            'paid_at' => $paidAt,
            'receipt_path' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('customer.payments.index')
            ->with('success', 'پرداخت شما ثبت شد و منتظر تایید مدیر است.');
    }
}
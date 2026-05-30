<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Project;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('project')
            ->where('customer_id', auth()->user()->customer_id)
            ->latest()
            ->paginate(15);

        return view('customer.payments.index', compact('payments'));
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
            'paid_at' => ['nullable', 'date'],
            'receipt' => ['nullable', 'file', 'max:5120'],
        ]);

        $path = null;

        if ($request->hasFile('receipt')) {
            $path = $request->file('receipt')->store('receipts', 'public');
        }

        Payment::create([
            'customer_id' => auth()->user()->customer_id,
            'project_id' => $data['project_id'] ?? null,
            'amount' => $data['amount'],
            'payment_month' => $data['payment_month'] ?? null,
            'paid_at' => $data['paid_at'] ?? null,
            'receipt_path' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('customer.payments.index')
            ->with('success', 'پرداخت شما ثبت شد و منتظر تایید مدیر است.');
    }
}
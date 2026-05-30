<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Customer;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['customer', 'project', 'approvedBy'])
            ->latest()
            ->paginate(20);

        return view('admin.payments.index', compact('payments'));
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

        $currentMonth = now()->format('Y-m');

        $customers = Customer::whereHas('projects', function ($q) {
                $q->where('status', 'active');
            })
            ->whereDoesntHave('payments', function ($q) use ($currentMonth) {
                $q->where('status', 'approved')
                    ->where('payment_month', $currentMonth);
            })
            ->with('projects')
            ->paginate(20);

        return view('admin.payments.debtors', compact('customers', 'currentMonth'));
    }
}
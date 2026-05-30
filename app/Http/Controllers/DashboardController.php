<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Customer;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'customer') {
            $ticketsCount = Ticket::where('customer_id', $user->customer_id)->count();
            $openTickets = Ticket::where('customer_id', $user->customer_id)
                ->where('status', '!=', 'closed')
                ->count();

            $pendingPayments = Payment::where('customer_id', $user->customer_id)
                ->where('status', 'pending')
                ->count();

            return view('dashboard', compact(
                'ticketsCount',
                'openTickets',
                'pendingPayments'
            ));
        }

        if ($user->role === 'staff') {
            $ticketsCount = Ticket::where('assigned_to', $user->id)->count();
            $openTickets = Ticket::where('assigned_to', $user->id)
                ->where('status', '!=', 'closed')
                ->count();

            return view('dashboard', compact(
                'ticketsCount',
                'openTickets'
            ));
        }

        $customersCount = Customer::count();
        $ticketsCount = Ticket::count();
        $openTickets = Ticket::where('status', '!=', 'closed')->count();
        $pendingPayments = Payment::where('status', 'pending')->count();

        return view('dashboard', compact(
            'customersCount',
            'ticketsCount',
            'openTickets',
            'pendingPayments'
        ));
    }
}
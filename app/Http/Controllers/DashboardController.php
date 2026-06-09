<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Task;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'customer') {
            $projects = Project::with('payments')
                ->where('customer_id', $user->customer_id)
                ->get();

            $ticketsCount = Ticket::where('customer_id', $user->customer_id)->count();
            $openTickets = Ticket::where('customer_id', $user->customer_id)
                ->where('status', '!=', 'closed')
                ->count();

            $pendingPayments = Payment::where('customer_id', $user->customer_id)
                ->where('status', 'pending')
                ->count();

            $projectsCount = $projects->count();
            $remainingDebt = $projects->sum(fn (Project $project) => $project->remainingDebt());
            $approvedPaymentsAmount = Payment::where('customer_id', $user->customer_id)
                ->where('status', 'approved')
                ->sum('amount');

            return view('dashboard', compact(
                'ticketsCount',
                'openTickets',
                'pendingPayments',
                'projectsCount',
                'remainingDebt',
                'approvedPaymentsAmount'
            ));
        }

        if ($user->role === 'staff') {
            $ticketsCount = Ticket::where('assigned_to', $user->id)->count();
            $openTickets = Ticket::where('assigned_to', $user->id)
                ->where('status', '!=', 'closed')
                ->count();
            $answeredTickets = Ticket::where('assigned_to', $user->id)
                ->where('status', 'answered')
                ->count();

            $myTasksCount = Task::where('assigned_to', $user->id)->count();
            $myPendingTasks = Task::where('assigned_to', $user->id)->where('status', 'pending')->count();
            $myInProgressTasks = Task::where('assigned_to', $user->id)->where('status', 'in_progress')->count();
            $myOverdueTasks = Task::where('assigned_to', $user->id)
                ->where('status', '!=', 'done')
                ->whereDate('deadline', '<', now()->toDateString())
                ->count();

            return view('dashboard', compact(
                'ticketsCount',
                'openTickets',
                'answeredTickets',
                'myTasksCount',
                'myPendingTasks',
                'myInProgressTasks',
                'myOverdueTasks'
            ));
        }

        $projects = Project::with('payments')->get();
        $customersCount = Customer::count();
        $projectsCount = $projects->count();
        $ticketsCount = Ticket::count();
        $openTickets = Ticket::where('status', '!=', 'closed')->count();
        $closedTickets = Ticket::where('status', 'closed')->count();
        $pendingPayments = Payment::where('status', 'pending')->count();
        $approvedPaymentsAmount = Payment::where('status', 'approved')->sum('amount');
        $remainingDebt = $projects->sum(fn (Project $project) => $project->remainingDebt());
        $tasksCount = Task::count();
        $pendingTasks = Task::where('status', 'pending')->count();
        $inProgressTasks = Task::where('status', 'in_progress')->count();
        $overdueTasks = Task::where('status', '!=', 'done')
            ->whereDate('deadline', '<', now()->toDateString())
            ->count();

        return view('dashboard', compact(
            'customersCount',
            'projectsCount',
            'ticketsCount',
            'openTickets',
            'closedTickets',
            'pendingPayments',
            'approvedPaymentsAmount',
            'remainingDebt',
            'tasksCount',
            'pendingTasks',
            'inProgressTasks',
            'overdueTasks'
        ));
    }
}

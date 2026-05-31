<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Customer;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with(['customer', 'payments'])->latest()->paginate(15);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $customers = Customer::where('status', 'active')->get();
        return view('admin.projects.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data = $this->normalizeFinanceDefaults($data);

        Project::create($data);

        return redirect()->route('admin.projects.index')
            ->with('success', 'پروژه ثبت شد.');
    }

    public function show(Project $project)
    {
        $project->load(['customer', 'payments.approvedBy', 'payments.customer']);

        return view('admin.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $customers = Customer::where('status', 'active')->get();
        return view('admin.projects.edit', compact('project', 'customers'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $this->validatedData($request);
        $data = $this->normalizeFinanceDefaults($data);

        $project->update($data);

        return redirect()->route('admin.projects.index')
            ->with('success', 'پروژه ویرایش شد.');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return back()->with('success', 'پروژه حذف شد.');
    }

    private function normalizeFinanceDefaults(array $data): array
    {
        foreach (['initial_fee', 'monthly_fee', 'debt_adjustment', 'credit_adjustment'] as $field) {
            $data[$field] = $data[$field] ?? 0;
        }

        return $data;
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'initial_fee' => ['nullable', 'numeric', 'min:0'],
            'monthly_fee' => ['nullable', 'numeric', 'min:0'],
            'debt_adjustment' => ['nullable', 'numeric', 'min:0'],
            'credit_adjustment' => ['nullable', 'numeric', 'min:0'],
            'finance_note' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive,completed'],
        ]);
    }
}

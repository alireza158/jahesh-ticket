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
        $projects = Project::with('customer')->latest()->paginate(15);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $customers = Customer::where('status', 'active')->get();
        return view('admin.projects.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'monthly_fee' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:active,inactive,completed'],
        ]);

        Project::create($data);

        return redirect()->route('admin.projects.index')
            ->with('success', 'پروژه ثبت شد.');
    }

    public function edit(Project $project)
    {
        $customers = Customer::where('status', 'active')->get();
        return view('admin.projects.edit', compact('project', 'customers'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'monthly_fee' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:active,inactive,completed'],
        ]);

        $project->update($data);

        return redirect()->route('admin.projects.index')
            ->with('success', 'پروژه ویرایش شد.');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return back()->with('success', 'پروژه حذف شد.');
    }
}
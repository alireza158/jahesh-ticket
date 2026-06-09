<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\TaskNote;
use App\Models\User;
use App\Support\JalaliDate;
use Illuminate\Http\Request;
use InvalidArgumentException;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->role === 'customer') {
            abort(403);
        }

        $search = $request->string('q')->toString();

        $query = Task::with(['project', 'assignedUser', 'creator'])->latest();

        if ($user->role === 'staff') {
            $query->where('assigned_to', $user->id);
        }

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('project', function ($query) use ($search) {
                        $query->where('title', 'like', "%{$search}%");
                    })
                    ->orWhereHas('assignedUser', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
            });
        }

        $tasks = $query->paginate(15)->withQueryString();

        return view('tasks.index', compact('tasks', 'search'));
    }

    public function create(Request $request)
    {
        $this->authorizeTaskManagement();

        $projects = Project::with('customer')->orderBy('title')->get();
        $staffUsers = User::where('role', 'staff')->orderBy('name')->get();
        $selectedProject = $request->integer('project_id') ?: null;

        return view('tasks.create', compact('projects', 'staffUsers', 'selectedProject'));
    }

    public function store(Request $request)
    {
        $this->authorizeTaskManagement();

        $data = $this->validatedTaskData($request);
        $deadline = $this->normalizeDeadline($data['deadline_jalali'] ?? null, 'deadline_jalali');
        $staff = User::where('id', $data['assigned_to'])->where('role', 'staff')->firstOrFail();

        $completedAt = $data['status'] === 'done' ? now() : null;

        Task::create([
            'project_id' => $data['project_id'],
            'created_by' => auth()->id(),
            'assigned_to' => $staff->id,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'deadline' => $deadline,
            'status' => $data['status'],
            'priority' => $data['priority'],
            'completed_at' => $completedAt,
        ]);

        return redirect()->route('tasks.index')->with('success', 'تسک با موفقیت ثبت شد.');
    }

    public function show(Task $task)
    {
        $this->authorizeTaskAccess($task);

        $task->load(['project.customer', 'creator', 'assignedUser', 'notes.user']);

        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $this->authorizeTaskManagement();

        $task->load(['project', 'assignedUser']);
        $projects = Project::with('customer')->orderBy('title')->get();
        $staffUsers = User::where('role', 'staff')->orderBy('name')->get();

        return view('tasks.edit', compact('task', 'projects', 'staffUsers'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorizeTaskManagement();

        $data = $this->validatedTaskData($request);
        $deadline = $this->normalizeDeadline($data['deadline_jalali'] ?? null, 'deadline_jalali');
        $staff = User::where('id', $data['assigned_to'])->where('role', 'staff')->firstOrFail();

        $task->update([
            'project_id' => $data['project_id'],
            'assigned_to' => $staff->id,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'deadline' => $deadline,
            'status' => $data['status'],
            'priority' => $data['priority'],
            'completed_at' => $data['status'] === 'done' ? ($task->completed_at ?? now()) : null,
        ]);

        return redirect()->route('tasks.show', $task)->with('success', 'تسک با موفقیت ویرایش شد.');
    }

    public function destroy(Task $task)
    {
        $this->authorizeTaskManagement();

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'تسک حذف شد.');
    }

    public function changeStatus(Request $request, Task $task)
    {
        $this->authorizeTaskAccess($task);

        $user = auth()->user();

        if (!in_array($user->role, ['admin', 'website_manager', 'staff'])) {
            abort(403);
        }

        if ($user->role === 'staff' && $task->assigned_to !== $user->id) {
            abort(403);
        }

        $data = $request->validate([
            'status' => ['required', 'in:pending,in_progress,done'],
        ]);

        $task->update([
            'status' => $data['status'],
            'completed_at' => $data['status'] === 'done' ? ($task->completed_at ?? now()) : null,
        ]);

        return back()->with('success', 'وضعیت تسک تغییر کرد.');
    }

    public function storeNote(Request $request, Task $task)
    {
        $this->authorizeTaskAccess($task);

        $user = auth()->user();

        if ($user->role === 'customer') {
            abort(403);
        }

        if ($user->role === 'staff' && $task->assigned_to !== $user->id) {
            abort(403);
        }

        $data = $request->validate([
            'note' => ['required', 'string'],
        ]);

        TaskNote::create([
            'task_id' => $task->id,
            'user_id' => $user->id,
            'note' => $data['note'],
        ]);

        return back()->with('success', 'یادداشت ثبت شد.');
    }

    private function authorizeTaskManagement(): void
    {
        if (!in_array(auth()->user()->role, ['admin', 'website_manager'])) {
            abort(403);
        }
    }

    private function authorizeTaskAccess(Task $task): void
    {
        $user = auth()->user();

        if (in_array($user->role, ['admin', 'website_manager'])) {
            return;
        }

        if ($user->role === 'staff' && $task->assigned_to === $user->id) {
            return;
        }

        abort(403);
    }

    private function validatedTaskData(Request $request): array
    {
        return $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'assigned_to' => ['required', 'exists:users,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'deadline_jalali' => ['nullable', 'string', 'max:20'],
            'status' => ['required', 'in:pending,in_progress,done'],
            'priority' => ['required', 'in:high,medium,low'],
        ]);
    }

    private function normalizeDeadline(?string $deadline, string $field): ?string
    {
        try {
            return JalaliDate::toGregorianDate($deadline);
        } catch (InvalidArgumentException $exception) {
            back()->withErrors([$field => $exception->getMessage()])->withInput()->throwResponse();
        }
    }
}

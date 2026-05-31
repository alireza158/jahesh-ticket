<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('customer')->latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $customers = Customer::where('status', 'active')->get();
        return view('admin.users.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => ['nullable', 'exists:customers,id'],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30', 'unique:users,phone'],
            'role' => ['required', Rule::in(['admin', 'website_manager', 'staff', 'customer'])],
            'password' => ['required', 'min:8'],
        ]);

        if ($data['role'] === 'customer' && empty($data['customer_id'])) {
            return back()->withErrors([
                'customer_id' => 'برای اکانت مشتری باید مشتری انتخاب شود.'
            ])->withInput();
        }

        if ($data['role'] !== 'customer') {
            $data['customer_id'] = null;
        }

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'کاربر با موفقیت ساخته شد.');
    }

    public function edit(User $user)
    {
        $customers = Customer::where('status', 'active')->get();
        return view('admin.users.edit', compact('user', 'customers'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'customer_id' => ['nullable', 'exists:customers,id'],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30', Rule::unique('users', 'phone')->ignore($user->id)],
            'role' => ['required', Rule::in(['admin', 'website_manager', 'staff', 'customer'])],
            'password' => ['nullable', 'min:8'],
        ]);

        if ($data['role'] === 'customer' && empty($data['customer_id'])) {
            return back()->withErrors([
                'customer_id' => 'برای اکانت مشتری باید مشتری انتخاب شود.'
            ])->withInput();
        }

        if ($data['role'] !== 'customer') {
            $data['customer_id'] = null;
        }

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'کاربر ویرایش شد.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'نمی‌توانید حساب خودتان را حذف کنید.');
        }

        $user->delete();

        return back()->with('success', 'کاربر حذف شد.');
    }
}

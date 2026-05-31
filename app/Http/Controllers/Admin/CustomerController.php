<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->paginate(15);
        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30', 'unique:customers,phone', 'unique:users,phone'],
            'address' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
            'account_password' => ['nullable', 'string', 'min:8'],
        ]);

        $accountPassword = $data['account_password'] ?? '12345678';
        unset($data['account_password']);

        $customer = Customer::create($data);

        User::create([
            'customer_id' => $customer->id,
            'name' => $customer->name,
            'phone' => $customer->phone,
            'role' => 'customer',
            'password' => Hash::make($accountPassword),
        ]);

        return redirect()->route('admin.customers.index')
            ->with('success', "مشتری و اکانت ورود او ساخته شد. رمز اولیه: {$accountPassword}");
    }

    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $customerUser = $customer->users()->where('role', 'customer')->first();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'phone' => [
                'required',
                'string',
                'max:30',
                Rule::unique('customers', 'phone')->ignore($customer->id),
                Rule::unique('users', 'phone')->ignore($customerUser?->id),
            ],
            'address' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
            'account_password' => ['nullable', 'string', 'min:8'],
        ]);

        $accountPassword = $data['account_password'] ?? null;
        unset($data['account_password']);

        $customer->update($data);

        $userData = [
            'name' => $customer->name,
            'phone' => $customer->phone,
            'role' => 'customer',
        ];

        if ($accountPassword) {
            $userData['password'] = Hash::make($accountPassword);
        }

        if ($customerUser) {
            $customerUser->update($userData);
        } else {
            User::create($userData + [
                'customer_id' => $customer->id,
                'password' => Hash::make($accountPassword ?? '12345678'),
            ]);
        }

        return redirect()->route('admin.customers.index')
            ->with('success', 'مشتری و اکانت ورود او ویرایش شد.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return back()->with('success', 'مشتری حذف شد.');
    }
}

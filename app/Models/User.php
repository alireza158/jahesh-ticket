<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'customer_id',
        'name',
        'phone',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function assignedTickets()
    {
        return $this->hasMany(Ticket::class, 'assigned_to');
    }

    public function createdTasks()
    {
        return $this->hasMany(Task::class, 'created_by');
    }

    public function assignedTasks()
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isWebsiteManager()
    {
        return $this->role === 'website_manager';
    }

    public function isStaff()
    {
        return $this->role === 'staff';
    }

    public function isCustomer()
    {
        return $this->role === 'customer';
    }
}
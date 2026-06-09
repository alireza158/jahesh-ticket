<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'project_id',
        'created_by',
        'assigned_to',
        'title',
        'description',
        'deadline',
        'status',
        'priority',
        'completed_at',
    ];

    protected $casts = [
        'deadline' => 'date',
        'completed_at' => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function notes()
    {
        return $this->hasMany(TaskNote::class);
    }
}

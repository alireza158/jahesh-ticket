<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'customer_id',
        'title',
        'description',
        'initial_fee',
        'monthly_fee',
        'debt_adjustment',
        'credit_adjustment',
        'finance_note',
        'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function approvedPayments()
    {
        return $this->hasMany(Payment::class)->where('status', 'approved');
    }

    public function billableAmount(): float
    {
        return (float) $this->initial_fee
            + (float) $this->monthly_fee
            + (float) $this->debt_adjustment
            - (float) $this->credit_adjustment;
    }

    public function approvedPaymentsAmount(): float
    {
        if ($this->relationLoaded('payments')) {
            return (float) $this->payments->where('status', 'approved')->sum('amount');
        }

        return (float) $this->approvedPayments()->sum('amount');
    }

    public function remainingDebt(): float
    {
        return max($this->billableAmount() - $this->approvedPaymentsAmount(), 0);
    }

    public function creditBalance(): float
    {
        return max($this->approvedPaymentsAmount() - $this->billableAmount(), 0);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Expense extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = ['description', 'expense_date', 'amount', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

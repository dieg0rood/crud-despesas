<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = ['description', 'expense_date', 'amount', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

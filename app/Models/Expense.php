<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
    	'user_id',
        'expense_category_id',
        'expense_name',
        'amount',
        'date',
        'description',
    ];

    public function expenseCategoryData()
    {
        return $this->belongsTo(ExpenseCategory::class,'expense_category_id');
    }

}

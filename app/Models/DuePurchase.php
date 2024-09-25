<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DuePurchase extends Model
{
    use HasFactory;

    protected $fillable = [
    	'user_id',
    	'purchase_id',
    	'due_amount',
    	'date',
    ];

}

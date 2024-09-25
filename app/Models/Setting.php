<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'company_slogan',
        'mobile',
        'email',
        'address_line_1',
        'address_line_2',
        'facebook',
        'twitter',
        'website',
        'logo_image',
    ];

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyInvoiceProfile extends Model
{
    use HasFactory;

    protected $fillable = [
    	'shop_logo',
        'billing_seal',
        'billing_signature',
        'trade_license',
        'name',
        'company_slogan',
        'tax',
        'tin',
        'currency',
        'currency_symble',
        'mobile',
        'email',
        'address_line_1',
        'address_line_2',
        'billing_terms',
        'facebook',
        'twitter',
        'website',
        'status',
        'invoice_design',
    ];

}
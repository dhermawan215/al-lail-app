<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $fillable = [
        'category_id',
        'financial_post_id',
        'amount',
        'description',
        'transaction_date',
        'created_by',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $fillable = [
        'category_id',
        'financial_post_id',
        'masjid_id',
        'amount',
        'description',
        'transaction_date',
        'created_by',
    ];
    /**
     * relationship to financial post model
     */
    public function transactionToFinancialPost(): BelongsTo
    {
        return $this->belongsTo(FinancialPost::class, 'financial_post_id', 'id');
    }
    /**
     * relationship to category transaction
     */
    public function transactionToCategory(): BelongsTo
    {
        return $this->belongsTo(CategoryTransaction::class, 'category_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FinancialPost extends Model
{
    protected $table = 'financial_posts';
    protected $fillable = ['masjid_id', 'post_name', 'created_by'];
    /**
     * relationship to transaction model
     */
    public function financialPostToTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'financial_post_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryTransaction extends Model
{
    protected $table = 'category_transactions';

    protected $fillable = ['category_name'];
    /**
     * relationship to transaction model
     */
    public function categoryToTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'category_id', 'id');
    }
}

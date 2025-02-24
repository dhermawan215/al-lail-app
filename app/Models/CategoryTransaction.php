<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryTransaction extends Model
{
    protected $table = 'category_transaction';

    protected $fillable = ['category_name'];
}

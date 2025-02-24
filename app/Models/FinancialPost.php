<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialPost extends Model
{
    protected $table = 'financial_posts';
    protected $fillable = ['masjid_id', 'post_name', 'created_by'];
}

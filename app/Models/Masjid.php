<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Masjid extends Model
{
    protected $table = 'masjid';
    protected $fillable = ['name', 'masjid_code', 'slug', 'address', 'phone_masjid', 'image', 'verification_status', 'registered_at'];
}

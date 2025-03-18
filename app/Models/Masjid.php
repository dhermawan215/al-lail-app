<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Masjid extends Model
{
    protected $table = 'masjids';
    protected $fillable = ['name', 'masjid_code', 'slug', 'address', 'phone_masjid', 'image', 'verification_status', 'registered_at'];
    /**
     * relationship to user model
     */
    public function masjidToUsers(): HasOne
    {
        return $this->hasOne(User::class, 'masjid_id', 'id');
    }
    /**
     * relationship masjid to financial post
     */
    public function masjidToFinancial(): HasMany
    {
        return $this->hasMany(FinancialPost::class, 'masjid_id', 'id');
    }
}

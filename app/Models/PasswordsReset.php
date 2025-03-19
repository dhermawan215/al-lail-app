<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordsReset extends Model
{
    protected $table = 'passwords_resets';
    protected $fillable = ['email', 'token', 'expired_at', 'is_used'];
}

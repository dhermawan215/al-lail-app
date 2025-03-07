<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysLog extends Model
{
    protected $table = "sys_logs";
    protected $fillable = ['user_id', 'email', 'ip', 'agent', 'message', 'status', 'info', 'capture_date'];
}

<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\SysLog;

trait SysLogCapture
{
    /**
     * capture user or system log
     * @param array $data
     */
    public function captureLog($data)
    {
        SysLog::create([
            'user_id' => $data['user_id'],
            'email' => $data['email'],
            'ip' => $data['ip'],
            'agent' => $data['agent'],
            'message' => $data['message'],
            'status' => $data['status'],
            'info' => $data['info'],
            'capture_date' => Carbon::now()
        ]);
    }
}

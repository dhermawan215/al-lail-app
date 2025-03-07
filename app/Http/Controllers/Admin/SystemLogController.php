<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SysLog;
use Illuminate\Http\Request;

class SystemLogController extends Controller
{
    protected $url;
    protected $title = 'System Logs';

    public function index()
    {
        return view('admin.log.index', ['title' => $this->title]);
    }

    public function listData(Request $request)
    {
        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 15;
        $globalSearch = $request['search']['value'];
        $query = SysLog::select('id', 'email', 'ip', 'agent', 'message', 'status', 'info', 'capture_date');

        if ($globalSearch) {
            $query->whereAny([
                'email',
                'ip',
                'agent',
                'message',
                'status',
                'info',
                'capture_date',
            ], 'like', '%' . $globalSearch . '%');
        }

        $recordsFiltered = $query->count();
        $resData = $query->skip($offset)
            ->take($limit)
            ->get();
        $recordsTotal = $resData->count();

        $data = [];
        $i = $offset + 1;
        $arr = [];

        foreach ($resData as $key => $value) {
            $data['rnum'] = $i;
            $data['email'] = $value->email;
            $data['ip'] = $value->ip;
            $data['agent'] = $value->agent;
            $data['message'] = $value->message;
            $data['status'] = '<span class="badge badge-danger">' . $value->status . '</span>';
            $data['info'] = '<span class="badge badge-info">' . $value->info . '</span>';
            $data['date'] = $value->capture_date;
            $arr[] = $data;
            $i++;
        }

        return \response()->json([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $arr,
        ]);
    }
}

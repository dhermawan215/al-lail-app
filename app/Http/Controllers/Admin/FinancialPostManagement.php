<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FinancialPost;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FinancialPostManagement extends Controller
{
    protected $url;
    protected $title = 'Financial Post';

    public function index(): View
    {
        return \view('admin.financial-post.index', ['title' => $this->title]);
    }

    public function listData(Request $request)
    {
        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 15;
        $globalSearch = $request['search']['value'];
        $query = FinancialPost::select('id', 'masjid_id', 'post_name', 'created_by')
            ->with('financialToMasjid:id,name');

        if ($globalSearch) {
            $query->whereAny(['post_name', 'created_by',], 'like', '%' . $globalSearch . '%')
                ->orWhereHas('financialToMasjid', function ($q) use ($globalSearch) {
                    $q->where('name', 'like', '%' . $globalSearch . '%');
                });
        }

        $recordsFiltered = $query->count();
        $resData = $query->skip($offset)
            ->take($limit)
            ->latest()
            ->get();
        $recordsTotal = $resData->count();

        $data = [];
        $i = $offset + 1;
        $arr = [];

        foreach ($resData as $key => $value) {
            $data['rnum'] = $i;
            $data['masjid'] = $value->financialToMasjid ? $value->financialToMasjid->name : 'no data';
            $data['post_name'] = $value ? $value->post_name : 'no data';
            $data['created'] = $value ? $value->created_by : 'no data';
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

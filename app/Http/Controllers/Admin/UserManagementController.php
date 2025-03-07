<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserManagementRepo;
use App\Traits\CustomEncrypt;
use App\Traits\SysLogCapture;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    use CustomEncrypt;
    use SysLogCapture;
    protected $url;
    protected $title = 'User Management';
    protected $userRepo;

    public function __construct(UserManagementRepo $userManagementRepo)
    {
        $this->userRepo = $userManagementRepo;
    }

    public function index(): View
    {
        return view('admin.user.index', ['title' => $this->title]);
    }

    public function listData(Request $request)
    {
        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 15;
        $globalSearch = $request['search']['value'];
        $query = User::select('id', 'name', 'email', 'email_verified_at', 'roles', 'is_active');

        if ($globalSearch) {
            $query->whereAny([
                'name',
                'email',
                'roles',
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
            $data['name'] = $value->name;
            $data['email'] = $value->email;
            $data['role'] = $value->roles;
            if (is_null($value->email_verified_at)) {
                $verified = '<span class="badge badge-danger">Not Verified</span>';
            } else {
                $verified = '<span class="badge badge-success">Verified</span>';
            }
            if (0 == $value->is_active || '0' == $value->is_active) {
                $cbx = '';
            } else {
                $cbx = 'checked';
            }
            $data['verified'] = $verified;
            $data['active'] = '<input type="checkbox" class="form-control cbx-active" ' . $cbx . ' data-cbxs=' . $this->encryptData($value->id) . ' >';
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
    /**
     * method for  change activation user
     */
    public function changeUserActive(Request $request)
    {
        $id = $this->decryptData($request->ivwx);
        $active = $request->active;
        try {
            $changeActive = $this->userRepo->changeActive(['id' => $id, 'active' => $active]);
            return \response()->json(['success' => true, 'message' => 'user active change'], 200);
        } catch (\Throwable $th) {
            $dataLog = [
                'user_id' => null,
                'email' => null,
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
                'message' => $th,
                'status' => 'error',
                'info' => 'system',
            ];
            $this->captureLog($dataLog);
            return \response()->json(['success' => false, 'message' => 'error when execute request'], 500);
        }
    }
}

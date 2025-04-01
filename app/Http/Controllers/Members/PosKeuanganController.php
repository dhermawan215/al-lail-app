<?php

namespace App\Http\Controllers\Members;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\FinancialPost;
use App\Traits\CustomEncrypt;
use App\Traits\SysLogCapture;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Repositories\MemberPosKeuanganRepository;

class PosKeuanganController extends Controller
{
    //controllrer for pos keuangan
    use CustomEncrypt;
    use SysLogCapture;
    protected $url;
    protected $title = 'Pos Keuangan';
    protected $memberPosKeuanganRepo;

    public function __construct(MemberPosKeuanganRepository $memberPosKeuanganRepository)
    {
        $this->memberPosKeuanganRepo = $memberPosKeuanganRepository;
    }

    public function index(): View
    {
        return \view('members.pos-keuangan.index', ['title' => $this->title]);
    }
    /**
     * for datatable
     * @return \Illuminate\Http\JsonResponse
     */
    public function listData(Request $request): JsonResponse
    {
        $user = Auth::user();
        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 15;
        $globalSearch = $request['search']['value'];
        $query = FinancialPost::select('id', 'post_name')->where('masjid_id', $user->masjid_id);

        if ($globalSearch) {
            $query->whereAny(['post_name'], 'like', '%' . $globalSearch . '%');
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
            $data['cbox'] = '<input type="checkbox" class="data-menu-cbox" value="' . $this->encryptData($value->id) . '">';
            $data['rnum'] = $i;
            $data['name'] = $value ? $value->post_name : 'no data';
            $data['action'] = '<button class="btn btn-primary btn-sm btn-edit" data-edit="' . $this->encryptData($value->id) . '" data-toggle="modal" data-target="#modal-edit-data">Edit</button>';
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
     * for save data
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'post_name' => 'required',
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }
        try {
            $posKeuangan = $this->memberPosKeuanganRepo->saveData([
                'post_name' => $request->post_name,
                'masjid_id' => $user->masjid_id,
                'created_by' => $user->name,
            ]);
            $this->captureLog([
                'user_id' => $user ? $user->id : null,
                'email' => $user ? $user->email : null,
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
                'message' => 'user: ' . $user->email . '|created post_name: ' . $posKeuangan->post_name . '|masjid id: ' . $posKeuangan->masjid_id,
                'status' => 'success',
                'info' => "['system','user info']"
            ]);
            return \response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
            ], 200);
        } catch (\Throwable $th) {
            $this->captureLog([
                'user_id' => $user ? $user->id : null,
                'email' => $user ? $user->email : null,
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
                'message' => 'user: ' . $user->email . 'was failed created financial post, system error: ' . $th->getMessage(),
                'status' => 'failed',
                'info' => "['system']"
            ]);
            return \response()->json([
                'success' => false,
                'message' => 'Error, silakan coba lagi',
            ], 500);
        }
    }
    /**
     * delete single or multiple data financial post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request): JsonResponse
    {
        $ids = $this->decryptArrayData($request->x_data);

        $user = Auth::user();
        try {
            DB::beginTransaction();
            $this->memberPosKeuanganRepo->deleteData($ids);
            DB::commit();
            $this->captureLog([
                'user_id' => $user ? $user->id : null,
                'email' => $user ? $user->email : null,
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
                'message' => 'user: ' . $user->email . 'delete data financial post, ID: ' . \json_encode(($ids)),
                'status' => 'success',
                'info' => "['system','user info']"
            ]);
            return \response()->json(['success' => true, 'message' => 'deleted'], 200);
        } catch (\Throwable $th) {
            \dd($th);
            DB::rollBack();
            $this->captureLog([
                'user_id' => $user ? $user->id : null,
                'email' => $user ? $user->email : null,
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
                'message' => 'user: ' . $user->email . 'was failed delete data, system error: ' . $th->getMessage(),
                'status' => 'failed',
                'info' => "['system']"
            ]);
            return \response()->json(['success' => false, 'message' => 'error'], 500);
        }
    }
    /**
     * edit data
     * @return JsonResponse
     */
    public function edit(Request $request)
    {
        $query = $this->memberPosKeuanganRepo->findSingleData($this->decryptData($request->btnx));
        $response = [
            'data_x' => $query ? $this->encryptData($query->id) : null,
            'post_name' => $query ? $query->post_name : null,
        ];

        return \response()->json(['success' => true, 'data' => $response], 200);
    }
    /**
     * update single data
     */
    public function update(Request $request)
    {
        $id = $this->decryptData($request->data_xv);
        $validator = Validator::make($request->all(), [
            'post_name' => 'required',
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }
        try {
            $this->memberPosKeuanganRepo->updateSingleData([
                'id' => $id,
                'post_name' => $request->post_name,
            ]);
            return \response()->json(['success' => true, 'message' => 'update berhasil'], 200);
        } catch (\Throwable $th) {
            return \response()->json(['success' => true, 'message' => 'error'], 500);
        }
    }
}

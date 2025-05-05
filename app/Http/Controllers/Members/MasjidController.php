<?php

namespace App\Http\Controllers\Members;

use App\Models\Masjid;
use Illuminate\View\View;
use App\Traits\ImageUpload;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\CustomEncrypt;
use App\Traits\SysLogCapture;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Repositories\MemberMasjidRepository;
use Carbon\Carbon;

class MasjidController extends Controller
{
    //controller for member for management the masjid
    use CustomEncrypt;
    use SysLogCapture;
    use ImageUpload;
    protected $url;
    protected $title = 'Manajemen Masjid';
    protected $membersMasjid;

    public function __construct(MemberMasjidRepository $memberMasjidRepository)
    {
        $this->membersMasjid = $memberMasjidRepository;
    }

    public function index(): View
    {
        return \view('members.masjid.index', ['title' => $this->title]);
    }
    /**
     * method list for datatables
     * @return Illuminate\Http\JsonResponse
     */
    public function listData(Request $request): JsonResponse
    {
        $user = Auth::user();
        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 15;
        $globalSearch = $request['search']['value'];

        $query = Masjid::select('id', 'name', 'masjid_code', 'phone_masjid', 'verification_status')
            ->where('id', $user->masjid_id);

        if ($globalSearch) {
            $query->whereAny([
                'name',
                'masjid_code',
                'phone_masjid',
            ], 'like', '%' . $globalSearch . '%');
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
            $id = $this->encryptData($value->id);
            $data['cbox'] = '<input type="checkbox" class="data-menu-cbox" value="' . $id . '">';
            $data['rnum'] = $i;
            $data['code'] = $value->masjid_code;
            $data['name'] = $value->name;
            $data['phone'] = $value->phone_masjid;
            if (0 == $value->verification_status) {
                $badge = 'badge-danger';
                $btnView = '';
                $btnColor = 'success';
                $valueStatus = 'not verified';
                $valueBtn = 'Verify process';
            } else {
                $btnView = 'disabled';
                $badge = 'badge-success';
                $btnColor = 'secondary';
                $valueBtn = 'verified';
                $valueStatus = 'verified';
            }
            $data['verified'] = '<span class="badge ' . $badge . '">' . $valueStatus . '</span>';
            $data['action'] = '<button class="btn btn-sm btn-info btn-detail"  data-toggle="modal" data-d=' . $id . ' data-target="#modal-detail">Detail</button>
            <button class="btn btn-sm btn-edit btn-primary" data-toggle="modal" data-e=' . $id . ' data-target="#modal-edit-masjid">Edit</button>';
            $arr[] = $data;
            $i++;
        }

        return \response()->json([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $arr,
            'masjidRegistered' => (string) $recordsFiltered,
        ]);
    }
    /**
     * detail of masjid
     * @return Illuminate\Http\JsonResponse
     */
    public function detail(Request $request): JsonResponse
    {
        $result = $this->membersMasjid->getDetailMasjid($this->decryptData($request->dValue));

        $response = [
            'masjid_url' => $result ? \url('') . '/' . $result->slug : null,
            'masjid_code' => $result ? $result->masjid_code : null,
            'verification' => $result->verification_status == 0 ? 'not verified'  : 'verified',
            'user' => $result->masjidToUsers ? $result->masjidToUsers->name : null,
            'masjid_name' => $result ? $result->name : null,
            'phone' => $result ? $result->phone_masjid : null,
            'registered' => $result ? $result->registered_at : null,
            'registered' => $result ? $result->registered_at : null,
            'email' =>  $result->masjidToUsers ? $result->masjidToUsers->email : null,
            'address' => $result ? $result->address : null,
            'image' => $result ? \asset($result->image) : null,
        ];

        return \response()->json(['data' => $response]);
    }
    /**
     * delete single / multiple data masjids
     * @return Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request): JsonResponse
    {
        $ids = $this->decryptArrayData($request->x_data);
        $query = $this->membersMasjid->findMultipleData($ids);
        $dataMasjids = $query->get();
        $user = Auth::user();
        try {
            foreach ($dataMasjids as $key => $value) {
                $this->deleteImage($value->image);
            }
            //delete data
            $query->delete();
            $this->captureLog([
                'user_id' => $user ? $user->id : null,
                'email' => $user ? $user->email : null,
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
                'message' => 'user: ' . $user->email . 'delete data masjid post, ID: ' . \json_encode(($ids)),
                'status' => 'success',
                'info' => "['system','user info']"
            ]);
            return \response()->json(['success' => true, 'message' => 'success'], 200);
        } catch (\Throwable $th) {
            $this->captureLog([
                'user_id' => $user ? $user->id : null,
                'email' => $user ? $user->email : null,
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
                'message' => 'user: ' . $user->email . 'was failed delete masjid data, system error: ' . $th->getMessage(),
                'status' => 'failed',
                'info' => "['system']"
            ]);
            return \response()->json(['success' => false, 'message' => 'error'], 500);
        }
    }
    /**
     * register masjid
     * @return Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'image' => 'nullable|max:1024|mimes:png,jpg',
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }
        $masjidCode = Str::random(5) . date('diss');
        $slug = Str::slug($masjidCode . '-' . $request->name);
        try {
            if ($request->hasFile('image')) {
                $masjidImage = $request->file('image');
                $path = $this->storeImage($masjidImage, 'masjids');
            }
            //save data
            $queryMasjid = $this->membersMasjid->saveData([
                'name' => $request->name,
                'masjid_code' => $masjidCode,
                'slug' => $slug,
                'address' => $request->address,
                'phone_masjid' => $request->phone,
                'image' => !is_null($path) ? $path : null,
                'registered_at' => Carbon::now(),
            ]);
            //update user auth
            $user->update([
                'masjid_id' => $queryMasjid->id,
            ]);
            //log
            $this->captureLog([
                'user_id' => $user ? $user->id : null,
                'email' => $user ? $user->email : null,
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
                'message' => 'user: ' . $user->email . 'registering masjid post, ID: ' . $queryMasjid->id . '|' . $queryMasjid->name,
                'status' => 'success',
                'info' => "['system','user info']"
            ]);
            return \response()->json(['success' => true, 'message' => 'registrasi berhasil'], 200);
        } catch (\Throwable $th) {
            $this->captureLog([
                'user_id' => $user ? $user->id : null,
                'email' => $user ? $user->email : null,
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
                'message' => 'user: ' . $user->email . 'error registration masjid data, system error: ' . $th->getMessage(),
                'status' => 'failed',
                'info' => "['system']"
            ]);
            return \response()->json(['success' => false, 'message' => 'error'], 500);
        }
    }
    /**
     * edit 
     */
    public function edit(Request $request)
    {
        $query = $this->membersMasjid->findSingleData($this->decryptData($request->x_edit));
        $response = [
            'x' => $this->encryptData($query->id),
            'name' => $query ? $query->name : null,
            'phone' => $query ? $query->phone_masjid : null,
            'address' => $query ? $query->address : null,
            'image' => $query ? asset($query->image) : null,
        ];
        return \response()->json(['data' => $response]);
    }
    /**
     * update single data
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'image' => 'nullable|max:1024|mimes:png,jpg',
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }
        $id = $this->decryptData($request->dvalue);
        $query = $this->membersMasjid->findSingleData($id);
        $data = [];
        try {
            $data['name'] = $request->name;
            $data['address'] = $request->address;
            $data['masjid_phone'] = $request->phone;
            if ($request->hasFile('image')) {
                $masjidImage = $request->file('image');
                $unlink = $this->deleteImage($query->image);
                $path = $this->storeImage($masjidImage, 'masjids');
                $data['image'] = $path;
                // if ($unlink) {
                // }
            }
            //update data
            $query->update($data);
            $this->captureLog([
                'user_id' => $user ? $user->id : null,
                'email' => $user ? $user->email : null,
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
                'message' => 'user: ' . $user->email . 'update data masjid post, ID: ' . $query->id . '|' . $query->name,
                'status' => 'success',
                'info' => "['system','user info']"
            ]);
            return \response()->json(['success' => true, 'message' => 'update berhasil'], 200);
        } catch (\Throwable $th) {
            $this->captureLog([
                'user_id' => $user ? $user->id : null,
                'email' => $user ? $user->email : null,
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
                'message' => 'user: ' . $user->email . 'error update masjid data, system error: ' . $th->getMessage(),
                'status' => 'failed',
                'info' => "['system']"
            ]);
            return \response()->json(['success' => false, 'message' => 'error'], 500);
        }
    }
}

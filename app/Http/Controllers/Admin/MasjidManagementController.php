<?php

namespace App\Http\Controllers\Admin;

use App\Models\Masjid;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Traits\CustomEncrypt;
use App\Traits\SysLogCapture;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\MasjidManagementRepository;

class MasjidManagementController extends Controller
{
    use CustomEncrypt,
        SysLogCapture;
    protected $url;
    protected $title = 'Masjid Management';
    protected $masjidRepo;

    public function __construct(MasjidManagementRepository $masjidManagementRepository)
    {
        $this->masjidRepo = $masjidManagementRepository;
    }
    public function index(): View
    {
        return \view('admin.masjid.index', ['title' => $this->title]);
    }
    /**
     * method list for datatables
     */
    public function listData(Request $request): JsonResponse
    {
        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 15;
        $globalSearch = $request['search']['value'];
        $filterVerification = $request['filter_verification'];
        $query = Masjid::select('id', 'name', 'masjid_code', 'phone_masjid', 'verification_status');
        if ('all' != $filterVerification) {
            $query->where('verification_status', $filterVerification);
        }
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
            $data['action'] = '<button class="btn btn-sm btn-' . $btnColor . ' btn-verification" ' . $btnView . ' data-v=' . $id . '>' . $valueBtn . '</button>
            <button class="btn btn-sm btn-info btn-detail"  data-toggle="modal" data-d=' . $id . ' data-target="#modal-detail">Detail</button>';
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
     * method for verifiying data masjid
     */
    public function verifiying(Request $request): JsonResponse
    {
        $user = Auth::user();
        try {
            $this->masjidRepo->verifiedMasjid(['id' => $this->decryptData($request->xvalue)]);
            return \response()->json(['success' => true, 'message' => 'verified success'], 200);
        } catch (\Throwable $th) {
            $this->captureLog([
                'user_id' => $user->id ? $user->id : null,
                'email' => $user->email ? $user->email : \null,
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
                'message' => 'error verified masjid',
                'status' => 'failed',
                'info' => "['system']",
            ]);
            return \response()->json(['success' => false, 'message' => 'error, please try again'], 500);
        }
    }
    /**
     * detail of masjid
     */
    public function detail(Request $request): JsonResponse
    {
        $result = $this->masjidRepo->getDetailMasjid($this->decryptData($request->dValue));
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
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Traits\CustomEncrypt;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Repositories\CategoryTransactionRepository;
use App\Models\CategoryTransaction as ModelsCategoryTransaction;

class CategoryTransactionController extends Controller
{
    use CustomEncrypt;
    protected $url;
    protected $title = 'Category Transaction';
    protected $categoryTrRepo;

    public function __construct(CategoryTransactionRepository $CategoryTransactionRepository)
    {
        $this->categoryTrRepo = $CategoryTransactionRepository;
    }

    public function index(): View
    {
        return view('admin.category-transaction.index', ['title' => $this->title]);
    }
    /**
     * method for handle list datatable
     * @param Request $request 
     */
    public function ListData(Request $request)
    {
        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 15;
        $globalSearch = $request['search']['value'];
        $query = ModelsCategoryTransaction::select('id', 'category_name');

        if ($globalSearch) {
            $query->where('category_name', 'like', '%' . $globalSearch . '%');
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
            $data['cbox'] = '<input type="checkbox" class="data-menu-cbox" value="' . $this->encryptData($value->id) . '">';
            $data['rnum'] = $i;
            $data['name'] = $value->category_name;
            $data['action'] = '<button class="btn btn-sm btn-info btn-edit" data-btn="' . $this->encryptData($value->id) . '" data-toggle="modal" data-target="#modal-edit-data">Edit</button>';
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
     * method handle save data
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required',
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        try {
            $this->categoryTrRepo->saveData($request);
            return \response()->json(['success' => true, 'message' => 'Data has been saved'], 200);
        } catch (\Throwable $th) {
            return \response()->json(['success' => \false, 'message' => 'Error, when try to save'], 500);
        }
    }
    /**
     * method handle edit data
     */
    public function edit(Request $request)
    {
        $id = $this->decryptData($request->btnx);

        try {
            $data = $this->categoryTrRepo->findData($id);
            $response = [
                'data_x' => $this->encryptData($data->id),
                'category_name' => $data->category_name ? $data->category_name : \null,
            ];
            return \response()->json(['success' => true, 'data' => $response], 200);
        } catch (\Throwable $th) {
            return \response()->json(['success' => false], 500);
        }
    }
    /**
     * method handle update data
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required',
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        $id = $this->decryptData($request->data_xv);
        $data = [
            'id' => $id,
            'category_name' => $request->category_name,
        ];

        try {
            $this->categoryTrRepo->updateData($data);
            return \response()->json(['success' => true, 'message' => 'Data has been updated'], 200);
        } catch (\Throwable $th) {
            return \response()->json(['success' => false, 'message' => 'Something went wrong'], 500);
        }
    }
    /**
     * method handle delete data
     */
    public function destroy(Request $request)
    {
        $ids = $this->decryptArrayData($request->x_data);

        try {
            $this->categoryTrRepo->deleteDatas($ids);
            return \response()->json(['success' => true, 'message' => 'Data has been deleted'], 200);
        } catch (\Throwable $th) {
            return \response()->json(['success' => false, 'message' => 'Something went wrong'], 500);
        }
    }
}

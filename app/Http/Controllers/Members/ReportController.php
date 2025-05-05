<?php

namespace App\Http\Controllers\Members;

use App\Models\Masjid;
use Illuminate\View\View;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\FinancialPost;
use App\Traits\CustomEncrypt;
use App\Traits\SysLogCapture;
use App\Models\CategoryTransaction;
use App\Http\Controllers\Controller;
use App\Repositories\ReportRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    use CustomEncrypt;
    use SysLogCapture;
    protected $user;
    protected $title = 'Manajemen Kas Keuangan';
    protected $memberReport;
    //
    public function __construct(ReportRepository $reportRepository)
    {
        $this->user = Auth::user();
        $this->memberReport = $reportRepository;
    }
    public function index(): View
    {
        $categoryTransaction = CategoryTransaction::toBase()->get();
        $financialPost = FinancialPost::where('masjid_id', $this->user->masjid_id)->get();
        $masjid = Masjid::select('name')->where('id', $this->user->masjid_id)->first();
        return \view('members.report.index', [
            'title' => $this->title,
            'masjid' => $masjid ? $masjid->name : null,
            'category' => $categoryTransaction,
            'financial' => $financialPost,
        ]);
    }

    public function listData(Request $request)
    {
        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 15;
        $globalSearch = $request['search']['value'];

        $query = Transaction::with(['transactionToFinancialPost:id,post_name', 'transactionToCategory', 'transactionToUser:id,name'])->where('masjid_id', $this->user->masjid_id);
        //query searching by category and financial post
        $categoryTransaction = $request->category_transaction;
        $financialPost = $request->financial_post;

        $startDatePeriod = $request->start_date_filter;
        $endDatePeriod = $request->end_date_filter;
        $query->when($categoryTransaction, function ($q) use ($categoryTransaction) {
            $q->where('category_id', $categoryTransaction);
        })->when($financialPost, function ($q) use ($financialPost) {
            $q->where('financial_post_id', $financialPost);
        })->when($startDatePeriod, function ($q) use ($startDatePeriod, $endDatePeriod) {
            $q->whereBetween('transaction_date', [$startDatePeriod, $endDatePeriod]);
        });
        //global search
        if ($globalSearch) {
            $query->whereAny(['amount', 'description', 'transaction_date'], 'like', '%' . $globalSearch . '%');
        }
        //for sum data base on datatable
        $sumQuery = clone $query;
        $summary = [
            'expense' => (clone $sumQuery)->where('category_id', 1)->sum('amount'),
            'income' => (clone $sumQuery)->where('category_id', 2)->sum('amount'),
        ];

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
            $data['category'] = $value->transactionToCategory ? $value->transactionToCategory->category_name : \null;
            $data['financial'] = $value->transactionToFinancialPost ? $value->transactionToFinancialPost->post_name : \null;
            $data['date'] = \date('Y-m-d', \strtotime($value->transaction_date));
            $data['description'] = $value->description;
            $data['amout'] = 'Rp.' . \number_format($value->amount, '0', ',', '.');
            $data['created'] = $value->transactionToUser ? $value->transactionToUser->name : null;
            $data['action'] = '<button id="btn-edit" data-toggle="modal" data-target="#modal-edit-data" data-edit="' . $id . '" class="btn btn-sm btn-info btn-edit">Edit</button>';
            $arr[] = $data;
            $i++;
        }

        return \response()->json([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $arr,
            'summary' => $summary,
        ]);
    }
    /**
     * list for select 2 category
     */
    public function listIncomeOutcome(Request $request)
    {
        $data = [];
        $resultCount = 20;
        $perPage = $request->page;
        $offset = ($perPage - 1) * $resultCount;
        $product = CategoryTransaction::select('id', 'category_name');

        if ($request->search) {
            $product->where('category_name', 'like', '%' . $request->search . '%');
        }

        $resData = $product->skip($offset)
            ->take($resultCount)->get();
        $recordsTotal = $resData->count();

        if ($resData->isEmpty()) {
            $data['id'] = 0;
            $data['text'] = 'empty';
            $arr[] = $data;
        }

        foreach ($resData as $key => $value) {
            $data['id'] = $value->id;
            $data['text'] = $value->category_name;
            $arr[] = $data;
        }

        return \response()->json(['success' => \true, 'items' => $arr, 'recordsTotal' => $recordsTotal]);
    }
    /**
     * list for financial post
     */
    public function listFinancialPost(Request $request)
    {
        $data = [];
        $resultCount = 20;
        $perPage = $request->page;
        $offset = ($perPage - 1) * $resultCount;
        $financialPost = FinancialPost::select('id', 'post_name')->where('masjid_id', $this->user->masjid_id);

        if ($request->search) {
            $financialPost->where('post_name', 'like', '%' . $request->search . '%');
        }

        $resData = $financialPost->skip($offset)
            ->take($resultCount)->get();
        $recordsTotal = $resData->count();

        if ($resData->isEmpty()) {
            $data['id'] = 0;
            $data['text'] = 'empty';
            $arr[] = $data;
        }

        foreach ($resData as $key => $value) {
            $data['id'] = $value->id;
            $data['text'] = $value->post_name;
            $arr[] = $data;
        }

        $responses = [
            'items' => $arr,
            'recordsTotal' => $recordsTotal
        ];

        return \response()->json(['success' => \true, 'items' => $arr, 'recordsTotal' => $recordsTotal]);
    }
    /**
     * save the data
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required',
            'description' => 'required',
            'amount' => 'required',
            'transaction_date' => 'required',
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        try {
            $createReport = $this->memberReport->saveReport([
                'category' => $request->category,
                'financial' => $request->category,
                'description' => $request->description,
                'amount' => $request->amount,
                'transaction_date' => $request->transaction_date,
                'masjid' => $this->user->masjid_id,
                'created' => $this->user->id,
            ]);

            $this->captureLog([
                'user_id' => $this->user ? $this->user->id : null,
                'email' => $this->user ? $this->user->email : null,
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
                'message' => 'user: ' . $this->user->email . '|insert report: ' . $createReport->transaction_date . ',amount:' . $createReport->amount,
                'status' => 'success',
                'info' => "['system','user info']"
            ]);
            return \response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
            ], 200);
        } catch (\Throwable $th) {
            $this->captureLog([
                'user_id' => $this->user ? $this->user->id : null,
                'email' => $this->user ? $this->user->email : null,
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
                'message' => 'user: ' . $this->user->email . '|failed insert data' . $th->getMessage(),
                'status' => 'failed',
                'info' => "['system']"
            ]);
            return \response()->json([
                'success' => false,
                'message' => 'Error, please try again',
            ], 500);
        }
    }
    /**
     * edit data
     */
    public function edit(Request $request)
    {
        $id = $this->decryptData($request->vx);

        $data = $this->memberReport->getSingleData($id);

        $response = [
            'xc' => $data->id ? $this->encryptData($data->id) : null,
            'description' => $data->description ? $data->description : null,
            'amount' => $data->amount ? $data->amount : null,
            'transaction_date' => $data->transaction_date ? $data->transaction_date : null
        ];

        return \response()->json(['success' => true, 'data' => $response]);
    }
    /**
     * update the data
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'amount' => 'required',
            'transaction_date' => 'required',
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }
        $id = $this->decryptData($request->data_xv);
        try {
            $getDataReport = $this->memberReport->getSingleData($id);
            $dataForUpdate = [
                'description' => $request->description,
                'amount' => $request->amount,
                'transaction_date' => $request->transaction_date,
            ];
            $this->memberReport->updateSingleReport($getDataReport, $dataForUpdate);

            $this->captureLog([
                'user_id' => $this->user ? $this->user->id : null,
                'email' => $this->user ? $this->user->email : null,
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
                'message' => 'user: ' . $this->user->email . '|edit report: id(' . $getDataReport->id . '),amount:' . $request->amount . 'date' . $request->transaction_date,
                'status' => 'success',
                'info' => "['system','user info']"
            ]);
            return \response()->json([
                'success' => true,
                'message' => 'Data berhasil di update',
            ], 200);
        } catch (\Throwable $th) {

            $this->captureLog([
                'user_id' => $this->user ? $this->user->id : null,
                'email' => $this->user ? $this->user->email : null,
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
                'message' => 'user: ' . $this->user->email . '|failed update data' . $th->getMessage(),
                'status' => 'failed',
                'info' => "['system']"
            ]);
            return \response()->json([
                'success' => false,
                'message' => 'Error, please try again',
            ], 500);
        }
    }
}

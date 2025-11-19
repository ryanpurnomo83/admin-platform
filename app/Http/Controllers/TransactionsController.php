<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Transactions;
use Idev\EasyAdmin\app\Helpers\Validation;
use Illuminate\Support\Facades\Validator;
use Idev\EasyAdmin\app\Models\Role;
use Illuminate\Support\Facades\DB;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;
use Illuminate\Http\Request;
use Throwable;

class TransactionsController extends DefaultController
{
    protected $modelClass = Transactions::class;
    protected $title = "Transactions";
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Transactions';
        $this->generalUri = 'transactions';
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true], 
                    ['name' => 'Trans Code', 'column' => 'transaction_code', 'order' => true],
                    ['name' => 'Product', 'column' => 'product_name', 'order' => true],
                    ['name' => 'Qty', 'column' => 'quantity', 'order' => true],
                    ['name' => 'Total', 'column' => 'total_price_rupiah', 'order' => true, 'formatter' => function($value, $row) {
                        return $row->total_price_rupiah;
                    }],
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => [''],
            'headers' => [ 
            ]
        ];
    }

    protected function defaultDataQuery()
    {
        $orderBy = request('order') ?? 'id';
        $orderState = request('order_state') ?? 'DESC';
        $search = request('search');

        if ($orderBy === 'total_price_rupiah') {
            $orderBy = 'total_price';
        }

        $query = $this->modelClass::query()
            ->when($search, function($q) use ($search) {
                foreach ($this->tableHeaders as $key => $th) {
                    $column = $th['column'];
                    if ($column === 'total_price_rupiah') $column = 'total_price';
                    if ($key == 0) {
                        $q->where($column, 'LIKE', "%$search%");
                    } else {
                        $q->orWhere($column, 'LIKE', "%$search%");
                    }
                }
            })
            ->orderBy($orderBy, $orderState);

        return $query;
    }

    protected function fields($mode = "create", $id = '-')
    {
        $edit = null;
        if ($id != '-') {
            $edit = $this->modelClass::where('id', $id)->first();
        }

        $options = [];
        $transactions = $this->modelClass::all();
        foreach ($transactions as $tx) {
            $options[] = [
                'value' => $tx->product_name, // bisa juga $product->id jika ingin simpan ID
                'text'  => $tx->product_name,
            ];
        }

        $fields = [
            [
                'type' => 'select',
                'label' => 'Product Name',
                'name' => 'product_name',
                'class' => 'col-md-12 my-2',
                'value'   => (isset($edit)) ? $edit->product_name : '', // value default
                'options' => $options,
            ],
            [
                'type' => 'text',
                'label' => 'Quantity',
                'name' => 'quantity',
                'class' => 'col-md-12 my-2',
                'value' => (isset($edit)) ? $edit->quantity : ''
            ],
        ];
        
        return $fields;
    }

    public function edit($id)
    {
        $data['fields'] = $this->fields('edit', $id);
        $transaction = $this->modelClass::find($id);
        $data['edit_fields'] = [
            [
                'type' => 'text',
                'label' => 'Product Name',
                'name' => 'product_name',
                'value' => $transaction->product_name
            ],
            [
                'type' => 'number',
                'label' => 'Quantity',
                'name' => 'quantity',
                'value' => $transaction->quantity
            ],
        ];

        return $data;   
    }

    public function store(Request $request)
    {

        $rules = $this->rules();
        $name = $request->name;
        $access = $request->access;

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messageErrors = (new Validation)->modify($validator, $rules);

            return response()->json([
                'status' => false,
                'alert' => 'danger',
                'message' => 'Required Form',
                'validation_errors' => $messageErrors,
            ], 200);
        }

        DB::beginTransaction();

        try {
            $insert = new Role();
            $insert->name = $name;
            $insert->access = $access ?? "[]";
            $insert->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'alert' => 'success',
                'message' => 'Data Was Created Successfully',
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    protected function rules($id = null)
    {
        $rules = [
        ];

        return $rules;
    }

    public function update(Request $request, $id)
    {  
        $productName = $request->product_name;
        $quantity = $request->quantity;
        
        DB::beginTransaction();
        $rules = $this->rules($id);

        try {
            $change = Transactions::where('id', $id)->first();
            $change->product_name = $productName;
            $change->quantity = $quantity;
            $change->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'alert' => 'success',
                'message' => 'Data Was Updated Successfully',
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

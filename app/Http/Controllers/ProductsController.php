<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Products;
use App\Models\Transactions;
use Idev\EasyAdmin\app\Helpers\Validation;
use Illuminate\Support\Facades\Validator;
use Idev\EasyAdmin\app\Models\Role;
use Illuminate\Support\Facades\DB;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;
use Illuminate\Http\Request;
use Throwable;

class ProductsController extends DefaultController
{
    protected $modelClass = Products::class;
    protected $title = "Products";
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Products';
        $this->generalUri = 'products';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true], 
                    ['name' => 'Products Code', 'column' => 'code', 'order' => true],
                    ['name' => 'Name', 'column' => 'name', 'order' => true],
                    ['name' => 'Description', 'column' => 'description', 'order' => true],
                    ['name' => 'Price', 'column' => 'price', 'order' => true],
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => [''],
            'headers' => [ 
            ]
        ];
    }


    protected function fields($mode = "create", $id = '-')
    {
        $edit = null;
        if ($id != '-') {
            $edit = $this->modelClass::where('id', $id)->first();
        }

        $options = [];
        $products = $this->modelClass::all();
        foreach ($products as $prdct) {
            $options[] = [
                'value' => $prdct->name, // bisa juga $product->id jika ingin simpan ID
                'text'  => $prdct->name,
            ];
        }

        $fields = [
            [
                'type' => 'select',
                'label' => 'Product Name',
                'name' => 'product_name',
                'class' => 'col-md-12 my-2',
                'value'   => (isset($edit)) ? $edit->name : '', // value default
                'options' => $options,
            ],
            [
                'type' => 'textarea',
                'label' => 'Description',
                'name' => 'description',
                'class' => 'col-md-12 my-2',
                'value' => (isset($edit)) ? $edit->description : ''
            ],
            [
                'type' => 'number',
                'label' => 'Price',
                'name' => 'price',
                'value' => (isset($edit)) ? $edit->price : ''
            ],
        ];
        
        return $fields;
    }

    public function edit($id)
    {
        $data['fields'] = $this->fields('edit', $id);
        $products = $this->modelClass::find($id);
        $data['edit_fields'] = [
            [
                'type' => 'select',
                'label' => 'Product Name',
                'name' => 'product_name',
                'value' => $products->name
            ],
            [
                'type' => 'textarea',
                'label' => 'Quantity',
                'name' => 'quantity',
                'value' => $products->description
            ],
            [
                'type' => 'number',
                'label' => 'Quantity',
                'name' => 'quantity',
                'value' => $products->price
            ],
        ];

        return $data;   
    }

    /*
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
        */

    protected function rules($id = null)
    {
        $rules = [
        ];

        return $rules;
    }

    
    public function update(Request $request, $id)
    {
        $productName = $request->product_name;
        $description = $request->description;
        $price = $request->price;

        DB::beginTransaction();

        try {
            $change = Products::where('id', $id)->first();
            $change->name = $productName;
            $change->description = $description;
            $change->price = $price;
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

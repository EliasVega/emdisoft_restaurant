<?php

namespace App\Http\Controllers;

use App\Models\Branch_product;
use App\Http\Requests\StoreBranchProductRequest;
use App\Http\Requests\UpdateBranchProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class BranchProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $user = Auth::user()->role_id;
        if (request()->ajax($request)) {
            if ($user == 1 || $user == 2) {
                $branchProducts = Branch_product::get();
            } else {
                $branchProducts = Branch_product::where('branch_id', Auth::user()->branch_id)->get();
            }
            return DataTables::of($branchProducts)

            ->addIndexColumn()
            ->addColumn('idProduct', function (Branch_product $branchProduct) {
                return $branchProduct->product->id;
            })

            ->addColumn('code', function (Branch_product $branchProduct) {
                return $branchProduct->product->code;
            })
            ->addColumn('nameProduct', function (Branch_product $branchProduct) {
                return $branchProduct->product->name;
            })
            ->addColumn('price', function (Branch_product $branchProduct) {
                return number_format($branchProduct->product->price, 2);
            })
            ->addColumn('status', function (Branch_product $branchProduct) {
                return $branchProduct->product->status;
            })
            ->editColumn('created_at', function(Branch_product $branchProduct){
                return $branchProduct->created_at->format('yy-m-d: h:m');
            })
            ->addColumn('btn', 'admin/branch_product/actions')
            ->rawcolumns(['btn'])
            ->make(true);
        }
        return view('admin.branch_product.index');
        /*
        if (request()->ajax()) {
            //Mostrar los productos de una sucursal especifica
            $branchProducts = Branch_product::from('branch_products AS bp')
            ->join('branches AS bra', 'bp.branch_id', '=', 'bra.id')
            ->join('products AS pro', 'bp.product_id', '=', 'pro.id')
            ->select('pro.id', 'pro.code', 'pro.name', 'pro.price', 'bp.stock', 'bp.order_product', 'pro.status')
            ->where('bra.id', '=', Auth::user()->branch_id)
            ->where('pro.status', '=', 'activo')
            ->get();

            return DataTables::of($branchProducts)
            ->toJson();
        }
        return view('admin.branch_product.index');*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBranchProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBranchProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Branch_product  $Branch_product
     * @return \Illuminate\Http\Response
     */
    public function show(Branch_product $Branch_product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Branch_product  $Branch_product
     * @return \Illuminate\Http\Response
     */
    public function edit(Branch_product $Branch_product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBranchProductRequest  $request
     * @param  \App\Models\Branch_product  $Branch_product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBranchProductRequest $request, Branch_product $Branch_product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Branch_product  $Branch_product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch_product $Branch_product)
    {
        //
    }
}

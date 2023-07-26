<?php

namespace App\Http\Controllers;

use App\Models\Product_branch;
use App\Http\Requests\StoreProductBranchRequest;
use App\Http\Requests\UpdateProductBranchRequest;
use App\Models\Branch;
use App\Models\Branch_product;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductBranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $product_branches = Product_branch::from('product_branches AS pb')
            ->join('users AS use', 'pb.user_id', '=', 'use.id')
            ->join('products AS pro', 'pb.product_id', '=', 'pro.id')
            ->join('branches AS bra', 'pb.branch_id', '=', 'bra.id')
            ->join('branches AS branch', 'pb.origin_branch_id', '=', 'branch.id')
            ->select('pb.id', 'pb.quantity', 'pro.name AS nameP', 'bra.name AS nameB', 'pb.created_at', 'branch.name AS origin_branch', 'use.name')
            ->get();

            return datatables()
            ->of($product_branches)
            ->editColumn('created_at', function(Product_branch $product_branch){
                return $product_branch->created_at->format('yy-m-d: h:m');
            })
            ->addColumn('edit', 'admin/product_branch/actions')
            ->rawcolumns(['edit'])
            ->toJson();
        }
        return view('admin.product_branch.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $branch = Branch::select('name')->where('id', '=', $request->session()->get('branch'))->first();
        $branches = Branch::select('id', 'name')->where('id', '!=', $request->session()->get('branch'))->get();
        $branch_products = Branch_product::from('branch_products AS bp')
        ->join('products AS pro', 'bp.product_id', '=', 'pro.id')
        ->join('branches AS bra', 'bp.branch_id', '=', 'bra.id')
        ->select('bp.id', 'pro.name', 'bp.stock', 'pro.id AS idP')
        ->where('bp.branch_id', '=', $request->session()->get('branch'))
        ->where('bp.stock', '>', 0)
        ->get();

        return view("admin.product_branch.create", compact('branches', 'branch_products', 'branch'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductBranchRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductBranchRequest $request)
    {
        //metodo traslado de productos
        $transfer = new Transfer();
        $transfer->user_id = Auth::user()->id;
        $transfer->branch_id = $request->branch_id[0];
        $transfer->origin_branch_id = $request->session()->get('branch');
        $transfer->save();

        try{
            $branch = Branch::select('id')->where('id', '=', $request->session()->get('branch'))->first();
            $branch_id = $request->branch_id[0];
            $product_id = $request->idP;
            $quantity = $request->quantity;
            $origin_branch_id = $branch->id;
            $cont = 0;

            //Methodo para asignar productos a la sucursal
            while($cont < count($product_id)){
                $product_branch = new Product_branch();
                $product_branch->user_id = Auth::user()->id;
                $product_branch->branch_id = $branch_id;
                $product_branch->transfer_id = $transfer->id;
                $product_branch->product_id = $product_id[$cont];
                $product_branch->quantity = $quantity[$cont];
                $product_branch->origin_branch_id = $origin_branch_id;
                $product_branch->save();

                $branch_products = Branch_product::where('product_id', '=', $product_branch->product_id)
                ->where('branch_id', '=', $product_branch->branch_id)
                ->first();

                //methodo para actualizar el stock de la sucursal si existe el producto
                if (isset($branch_products)) {
                    $id = $branch_products->id;
                    $stock = $branch_products->stock + $product_branch->quantity;
                    $branch_product = Branch_product::findOrFail($id);
                    $branch_product->stock = $stock;
                    $branch_product->update();
                } else {
                    //metodo para crear el producto en la sucursal y asignar stock
                    $branch_product = new Branch_product();
                    $branch_product->branch_id = $product_branch->branch_id;
                    $branch_product->product_id = $product_branch->product_id;
                    $branch_product->stock = $product_branch->quantity;
                    $branch_product->order_product = 0;
                    $branch_product->save();
                }

                $branchPro = Branch_product::where('product_id', '=', $product_branch->product_id)
                ->where('branch_id', '=', $product_branch->origin_branch_id)
                ->first();

                $ids = $branchPro->id;
                $stock = $branchPro->stock - $product_branch->quantity;

                $branch_product = Branch_product::findOrFail($ids);
                $branch_product->stock = $stock;
                $branch_product->update();

                $cont++;
            }
            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
        }
        return redirect('transfer')->with('success', 'traslado creado Satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product_branch  $product_branch
     * @return \Illuminate\Http\Response
     */
    public function show(Product_branch $product_branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product_branch  $product_branch
     * @return \Illuminate\Http\Response
     */
    public function edit(Product_branch $product_branch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductBranchRequest  $request
     * @param  \App\Models\Product_branch  $product_branch
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductBranchRequest $request, Product_branch $product_branch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product_branch  $product_branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product_branch $product_branch)
    {
        //
    }
}

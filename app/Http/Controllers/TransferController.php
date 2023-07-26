<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use App\Http\Requests\StoreTransferRequest;
use App\Http\Requests\UpdateTransferRequest;
use App\Models\Branch;
use App\Models\Branch_product;
use App\Models\Product_branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();
            if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {
                //Consulta para mostrar Transfers a administradores y superadmin
                $transfers = Transfer::from('transfers AS tra')
                ->join('users AS use', 'tra.user_id', '=', 'use.id')
                ->join('branches AS bra', 'tra.branch_id', '=', 'bra.id')
                ->join('branches AS branch', 'tra.origin_branch_id', '=', 'branch.id')
                ->select('tra.id', 'branch.name AS origin_branch', 'bra.name AS branch', 'tra.created_at', 'use.name')
                ->get();
            } else {
                //Consulta para mostrar transfer a roles 3 -4 -5
                $transfers = Transfer::from('transfers AS tra')
                ->join('users AS use', 'tra.user_id', '=', 'use.id')
                ->join('branches AS bra', 'tra.branch_id', '=', 'bra.id')
                ->join('branches AS branch', 'tra.origin_branch_id', '=', 'branch.id')
                ->select('tra.id', 'branch.name AS origin_branch', 'bra.name AS branch', 'tra.created_at', 'use.name')
                ->where('tra.user_id', Auth::user()->id)
                ->get();
            }

            return datatables()
            ->of($transfers)
            ->editColumn('created_at', function(Transfer $transfer){
                return $transfer->created_at->format('yy-m-d: h:m');
            })
            ->addColumn('btn', 'admin/transfer/actions')
            ->rawcolumns(['btn'])
            ->toJson();
        }
        return view('admin.transfer.index');
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

        return view("admin.transfer.create", compact('branches', 'branch_products', 'branch'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransferRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransferRequest $request)
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
     * @param  \App\Models\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transfers = transfer::from('transfers AS tra')
            ->join('users AS use', 'tra.user_id', '=', 'use.id')
            ->join('branches AS bra', 'tra.branch_id', '=', 'bra.id')
            ->join('branches AS branch', 'tra.origin_branch_id', '=', 'branch.id')
            ->select('tra.id', 'branch.name AS origin_branch', 'bra.name AS branch', 'tra.created_at', 'use.name')
            ->where('tra.id', '=', $id)
            ->first();
        $product_branches = Product_branch::from('product_branches AS pb')
            ->join('users AS use', 'pb.user_id', '=', 'use.id')
            ->join('products AS pro', 'pb.product_id', '=', 'pro.id')
            ->join('transfers AS tra', 'pb.transfer_id', '=', 'tra.id')
            ->join('branches AS bra', 'pb.branch_id', '=', 'bra.id')
            ->join('branches AS branch', 'pb.origin_branch_id', '=', 'branch.id')
            ->select('pb.id', 'pb.quantity', 'pb.branch_id', 'pro.name AS nameP', 'bra.name AS nameB', 'pb.created_at', 'branch.name AS origin_branch', 'use.name', 'tra.id AS idT')
            ->where('tra.id', '=', $id)
            ->get();

            return view('admin.transfer.show', compact('product_branches', 'transfers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function edit(Transfer $transfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransferRequest  $request
     * @param  \App\Models\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransferRequest $request, Transfer $transfer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transfer $transfer)
    {
        //
    }
}

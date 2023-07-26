<?php

namespace App\Http\Controllers;

use App\Models\Ncpurchase;
use App\Http\Requests\StoreNcpurchaseRequest;
use App\Http\Requests\UpdateNcpurchaseRequest;
use App\Models\Branch_product;
use App\Models\Kardex;
use App\Models\Ncpurchase_product;
use App\Models\Nd_discrepancy;
use App\Models\Product;
use App\Models\Product_purchase;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class NcpurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            //Muestra todas las compras de la empresa
            $ncpurchases = Ncpurchase::get();

            return DataTables::of($ncpurchases)
            ->addIndexColumn()
            ->addColumn('document', function (Ncpurchase $ncpurchase) {
                return $ncpurchase->purchase->id;
            })
            ->addColumn('supplier', function (Ncpurchase $ncpurchase) {
                return $ncpurchase->supplier->name;
            })
            ->addColumn('user', function (Ncpurchase $ncpurchase) {
                return $ncpurchase->user->name;
            })
            ->addColumn('branch', function (Ncpurchase $ncpurchase) {
                return $ncpurchase->branch->name;
            })
            ->editColumn('created_at', function(Ncpurchase $ncpurchase){
                return $ncpurchase->created_at->format('yy-m-d: h:m');
            })
            ->addColumn('btn', 'admin/ncpurchase/actions')
            ->rawColumns(['btn'])
            ->make(true);
        }
        return view('admin.ncpurchase.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $proba = $request->session()->get('purchase');
        $purchases = Purchase::where('id', '=', $request->session()->get('purchase'))->first();
        dd($purchases);
        if ($purchases->status == 'credit_note') {
            return redirect("ncpurchase")->with('warning', 'Esta Compra ya tiene una Nota Credito');
        }

        $productPurchases = Product_purchase::where('purchase_id', '=', $request->session()->get('purchase'))->get();
        $products = Product::get();
        $discrepancies = Nd_discrepancy::where('id', '!=', 4)->get();

        return view('admin.ncpurchase.create', compact('purchases', 'products', 'productPurchases', 'discrepancies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNcpurchaseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNcpurchaseRequest $request)
    {
        try{
            DB::beginTransaction();
            $purchase = Purchase::where('id', $request->purchase_id)->first();
            //crear tabla nota debito venta
            $ncpurchase = new Ncpurchase();
            $ncpurchase->purchase          = $purchase->document;
            $ncpurchase->user_id           = Auth::user()->id;
            $ncpurchase->branch_id         = Auth::user()->branch_id;
            $ncpurchase->purchase_id       = $purchase->id;
            $ncpurchase->supplier_id       = $request->supplier_id;
            $ncpurchase->nd_discrepancy_id = $request->nc_discrepancy_id;
            $ncpurchase->voucher_type_id   = 10;
            $ncpurchase->total             = $request->total;
            $ncpurchase->total_iva         = $request->total_iva;
            $ncpurchase->total_pay         = $request->total_pay;
            $ncpurchase->pay               = 0;
            $ncpurchase->balance           = $request->total_pay;
            $ncpurchase->save();

            $products_purchase = Product_purchase::where('purchase_id', $purchase)->get();
            /*
            foreach ($invoice_products as $ip) {
                $id = $ip->product_id;
                $quantity = $ip->quantity;
                $products = Product::findOrFail($id);
                $stock = $products->stock;
                $products->stock = $stock + $quantity;
                $products->update();
                $branch_product = Branch_product::where('branch_id', $branch)->where('product_id', $id)->first();
                $stk = $branch_product->stock;
                $stky = $stk + $quantity;
                $branch_product->stock = $stky;
                $branch_product->update();
            }*/

            $product_id     = $request->product_id;
            $quantity       = $request->quantity;
            $price          = $request->price;
            //$stock          = $request->stock;
            //$invo = $request->session()->get('invoice');


            $cont = 0;

            while($cont < count($product_id)){

                //crear registro tabla ndinvoice_products
                $ncpurchase_product = new Ncpurchase_product();
                $ncpurchase_product->ncpurchase_id = $ncpurchase->id;
                $ncpurchase_product->product_id = $product_id[$cont];
                $ncpurchase_product->quantity = $quantity[$cont];
                $ncpurchase_product->price = $price[$cont];
                $ncpurchase_product->save();
                /*
                //calcular valores para registro kardex
                $products = Product::from('products as pro')
                ->join('categories as cat', 'pro.category_id', 'cat.id')
                ->select('pro.id', 'pro.price', 'pro.stock', 'cat.utility')
                ->where('pro.id', '=', $ndinvoice_product->product_id)
                ->first();

                //Calcular el valor para actualizar Branch_products
                $branch_products = Branch_product::from('branch_Products AS bp')
                ->join('products AS pro', 'bp.product_id', '=', 'pro.id')
                ->join('branches AS bra', 'bp.branch_id', '=', 'bra.id')
                ->select('bp.id', 'bp.product_id', 'bp.branch_id', 'bp.stock', 'pro.id AS idP', 'bra.id')
                ->where('bp.product_id', '=', $ndinvoice_product->product_id)
                ->where('bp.branch_id', '=', $ndinvoice->branch_id)
                ->first();
                $id = $branch_products->idP;
                $prestock = $branch_products->stock;
                $stock = $prestock - $ndinvoice_product->quantity;
                //Actualizar tabla Branch Products
                $branch_product = Branch_product::where('branch_id', $ndinvoice->branch_id)->where('product_id', $ndinvoice_product->product_id)->first();
                $branch_product->stock = $stock;
                $branch_product->update();

                $id = $products->id;
                $stockardex = $products->stock;
                //crear registro en la tabla kardex
                $kardex = new Kardex();
                $kardex->product_id = $id;
                $kardex->branch_id  = $ndinvoice->branch_id;
                $kardex->operation  = 'ND_VENTA';
                $kardex->number     = $ndinvoice->id;
                $kardex->quantity   = $quantity[$cont];
                $kardex->stock      = $stockardex;
                $kardex->save();*/

                $cont++;

            }
            /*
            $boxy = Sale_box::where('user_id', '=', $ndinvoice->user_id)->where('status', '=', 'ABIERTA')->first();*/
            /*$invoicy = Invoice::where('id', '=', $request->session()->get('invoice'))->first();
            $total_pay = $invoicy->total_pay;*/
            /*$sale = $boxy->sale;
            $tpv = $ndinvoice->total_pay;
            $ninv = $sale + $tpv;

            $saleBox = Sale_box::findOrFail($boxy->id);
            $saleBox->sale = $ninv;
            $saleBox->update();*/

            $purchase = Purchase::findOrFail($purchase->id);
            $purchase->status = 'credit_note';
            $purchase->update();



            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
        }
        return redirect('ncpurchase');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ncpurchase  $ncpurchase
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ncpurchases = Ncpurchase::from('ncpurchases AS ncp')
        ->join('users as use', 'ncp.user_id', 'use.id')
        ->join('purchases as pur', 'ncp.purchase_id', 'pur.id')
        ->join('branches AS bra', 'ncp.branch_id', '=', 'bra.id')
        ->join('suppliers AS sup', 'ncp.supplier_id', '=', 'sup.id')
        ->select('ncp.id', 'ncp.purchase', 'ncp.total', 'ncp.total_iva', 'ncp.total_pay', 'ncp.created_at', 'use.name', 'bra.name as nameB', 'sup.name as nameS', 'pur.purchase')
        ->where('ncp.id', '=', $id)
        ->first();

        /*mostrar detalles*/
        $ncpurchase_products = Ncpurchase_product::from('ncpurchase_products AS np')
        ->join('products AS pro', 'np.product_id', '=', 'pro.id')
        ->join('ncpurchases as ncp', 'np.ncpurchase_id', 'ncp.id')
        ->join('suppliers AS sup', 'ncp.supplier_id', '=', 'sup.id')
        ->select('np.quantity', 'np.price', 'ncp.total', 'ncp.total_iva', 'ncp.total_pay', 'pro.name')
        ->where('np.ncpurchase_id', '=', $id)
        ->get();

        return view('admin.ncpurchase.show', compact('ncpurchases', 'ncpurchase_products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ncpurchase  $ncpurchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Ncpurchase $ncpurchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNcpurchaseRequest  $request
     * @param  \App\Models\Ncpurchase  $ncpurchase
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNcpurchaseRequest $request, Ncpurchase $ncpurchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ncpurchase  $ncpurchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ncpurchase $ncpurchase)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Ndpurchase;
use App\Http\Requests\StoreNdpurchaseRequest;
use App\Http\Requests\UpdateNdpurchaseRequest;
use App\Models\Branch_product;
use App\Models\Kardex;
use App\Models\Nc_discrepancy;
use App\Models\Ncpurchase_product;
use App\Models\Ndpurchase_product;
use App\Models\Pay_purchase;
use App\Models\Pay_purchase_payment_method;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Product_purchase;
use App\Models\Purchase;
use App\Models\Sale_box;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class NdpurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if (request()->ajax()) {
            if ($user->role_id == 1 || $user->role_id == 2) {
                $ndpurchases = Ndpurchase::get();
            } else {
                $ndpurchases = Ndpurchase::where('branch_id', $user->branch_id)->where('user_id', $user->id)->get();
            }
            return DataTables::of($ndpurchases)
            ->addIndexColumn()
            ->addColumn('customer', function (Ndpurchase $ndpurchase) {
                return $ndpurchase->supplier->name;
            })
            ->addColumn('branch', function (Ndpurchase $ndpurchase) {
                return $ndpurchase->branch->name;
            })
            ->editColumn('created_at', function(Ndpurchase $ndpurchase){
                return $ndpurchase->created_at->format('yy-m-d: h:m');
            })
            ->addColumn('btn', 'admin/ndpurchase/actions')
            ->rawColumns(['btn'])
            ->make(true);
        }
        return view('admin.ndpurchase.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNdpurchaseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNdpurchaseRequest $request)
    {

        try{
            DB::beginTransaction();

            $pur = $request->purchase_id;
            $purchase = Purchase::findOrFail($pur);
            $branch = $purchase->branch_id;
            $pay = $purchase->pay;
            $payCash = 0;
            $payPurchase = Pay_purchase::where('purchase_id', $purchase->id)->get();
            foreach ($payPurchase as $key => $value) {
                $payCash += Pay_purchase_payment_method::where('pay_purchase_id', $value->id)->where('payment_method_id', 10)->sum('payment');
            }
            $reverse = $request->reverse;
            $reversePay = $pay - $payCash;

            $date1 = Carbon::now()->toDateString();
            $date2 = Purchase::find($purchase->id)->created_at->toDateString();
            if ($date1 == $date2) {
                $sale_box = Sale_box::where('user_id', '=', $purchase->user_id)->where('status', '=', 'open')->first();
                $sale_box->purchase -= $purchase->total_pay;
                $sale_box->out_purchase -= $pay;
                $sale_box->out_purchase_cash -= $payCash;
                $sale_box->out_total -= $purchase->pay;
                $sale_box->update();

                if ($pay > 0 && $reverse == 0) {

                    $payment = new Payment();
                    $payment->user_id = Auth::user()->id;
                    $payment->branch_id = $branch;
                    $payment->supplier_id = $purchase->supplier_id;
                    $payment->origin = 'Factura de Compra' . '-'. $purchase->id;
                    $payment->destination = null;
                    $payment->pay = $pay;
                    $payment->balance = $pay;
                    $payment->note = 'por eliminacion de compra';
                    $payment->save();

                    $sale_box = Sale_box::where('user_id', '=', $payment->user_id)->where('status', '=', 'open')->first();
                    $sale_box->out_payment += $payment->pay;
                    $sale_box->update();

                } elseif ($pay > 0 && $reverse == 1) {

                    if ($reversePay > 0) {
                        $payment = new Payment();
                        $payment->user_id = Auth::user()->id;
                        $payment->branch_id = $branch;
                        $payment->supplier_id = $purchase->supplier_id;
                        $payment->origin = 'Factura de Compra' . '-'. $purchase->id;
                        $payment->destination = null;
                        $payment->pay = $reversePay;
                        $payment->balance = $reversePay;
                        $payment->note = 'por eliminacion de compra' . '-' . $payCash . 'Ingresado a caja';
                        $payment->save();

                        $sale_box = Sale_box::where('user_id', '=', $payment->user_id)->where('status', '=', 'open')->first();
                        $sale_box->out_payment += $payment->pay;
                        $sale_box->departure -= $payCash;
                        $sale_box->update();
                    } else {
                        $sale_box = Sale_box::where('user_id', '=', $purchase->user_id)->where('status', '=', 'open')->first();
                        $sale_box->departure -= $payCash;
                        $sale_box->update();
                    }
                }

            } else {
                $payment = new Payment();
                $payment->user_id = Auth::user()->id;
                $payment->branch_id = $branch;
                $payment->supplier_id = $purchase->supplier_id;
                $payment->origin = 'Factura de Compra' . '-'. $purchase->id;
                $payment->destination = null;
                $payment->pay = $pay;
                $payment->balance = $pay;
                $payment->note = 'por eliminacion de compra';
                $payment->save();

                $sale_box = Sale_box::where('user_id', '=', $purchase->user_id)->where('status', '=', 'open')->first();
                if ($reverse == 1) {
                    $sale_box->out_payment += $pay;
                }
                $sale_box->update();
            }


            $payPurchase = Pay_purchase::where('purchase_id', $purchase->id)->get();
            foreach ($payPurchase as $key => $value) {
                $value->status = 'payment';
                $value->update();
            }
            //Registrar tabla Nota Credito
            $ndpurchase = new Ndpurchase();
            $ndpurchase->purchase = $purchase->document;
            $ndpurchase->user_id = Auth::user()->id;
            $ndpurchase->branch_id = $branch;
            $ndpurchase->purchase_id = $purchase->id;
            $ndpurchase->supplier_id = $purchase->supplier_id;
            $ndpurchase->nc_discrepancy_id = 2;
            $ndpurchase->voucher_type_id = 11;
            $ndpurchase->total = $purchase->total;
            $ndpurchase->total_iva = $purchase->total_iva;
            $ndpurchase->total_pay = $purchase->total_pay;
            $ndpurchase->save();

            $sale_box = Sale_box::where('user_id', '=', $purchase->user_id)->where('status', '=', 'open')->first();
            $sale_box->ndpurchase += $ndpurchase->total_pay;
            $sale_box->update();

            //Seleccionar los productos de la compra
            $productPurchases = Product_purchase::where('purchase_id', $purchase->id)->get();
            foreach ($productPurchases as $pp) {
                $id = $pp->product_id;
                $quantity = $pp->quantity;
                $price = $pp->price;
                $branch_product = Branch_product::where('branch_id', $branch)->where('product_id', $id)->first();
                $branch_product->stock -= $quantity;
                $branch_product->update();

                $ndpurchaseProduct = new Ndpurchase_product();
                $ndpurchaseProduct->ndpurchase_id = $ndpurchase->id;
                $ndpurchaseProduct->product_id = $id;
                $ndpurchaseProduct->quantity = $quantity;
                $ndpurchaseProduct->price = $pp->price;
                $ndpurchaseProduct->save();

                $product = Product::findOrFail($id);
                //actualizando la tabla products
                $product->stock -= $quantity;
                $product->update();

                //Actualizar Kardex
                $kardex = new Kardex();
                $kardex->product_id = $id;
                $kardex->branch_id = $branch;
                $kardex->operation = 'nd_compra';
                $kardex->number = $ndpurchase->id;
                $kardex->quantity = $quantity;
                $kardex->stock = $product->stock;
                $kardex->save();
            }

            //actualizando campo status de la factura
            $purchase->total = 0;
            $purchase->total_iva = 0;
            $purchase->total_pay = 0;
            $purchase->pay = 0;
            $purchase->balance = 0;
            $purchase->status = 'debit_note';
            $purchase->note = 'Compra eliminada con nota Debito #' . '-' . $ndpurchase->id;
            $purchase->update();

            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
        }
        if ($pay > 0 && $reverse == 0) {
            Alert::success('Compra','Eliminada Satisfactoriamente. Con creacion de anticipo de Proveedor');
            return redirect('purchase');

        } elseif ($pay > 0 && $reverse == 1) {
            Alert::success('Compra','Eliminada Satisfactoriamente. Con creacion de anticipo de Proveedor');
            return redirect('purchase');
        }else {
            return redirect("purchase")->with('success', 'Compra Eliminada Satisfactoriamente, ingreso efectivo a caja');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ndpurchase  $ndpurchase
     * @return \Illuminate\Http\Response
     */
    public function show(Ndpurchase $ndpurchase)
    {
        $ndpurchaseProducts = Ndpurchase_product::where('ndpurchase_id', $ndpurchase->id)->get();
        return view('admin.ndpurchase.show', compact('ndpurchase', 'ndpurchaseProducts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ndpurchase  $ndpurchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Ndpurchase $ndpurchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNdpurchaseRequest  $request
     * @param  \App\Models\Ndpurchase  $ndpurchase
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNdpurchaseRequest $request, Ndpurchase $ndpurchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ndpurchase  $ndpurchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ndpurchase $ndpurchase)
    {
        //
    }
}

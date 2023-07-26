<?php

namespace App\Http\Controllers;

use App\Models\Ndinvoice;
use App\Http\Requests\StoreNdinvoiceRequest;
use App\Http\Requests\UpdateNdinvoiceRequest;
use App\Models\Bank;
use App\Models\Branch_product;
use App\Models\Card;
use App\Models\Invoice;
use App\Models\Invoice_product;
use App\Models\Kardex;
use App\Models\Nd_discrepancy;
use App\Models\Ndinvoice_product;
use App\Models\Pay_event;
use App\Models\pay_ndinvoice;
use App\Models\pay_ndinvoice_Payment_method;
use App\Models\Payment_form;
use App\Models\Payment_method;
use App\Models\Product;
use App\Models\Product_branch;
use App\Models\Sale_box;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NdinvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $ndinvoices = Ndinvoice::with('customer')->get();

            return datatables()
            ->of($ndinvoices)
            ->addIndexColumn()
            ->addColumn('customer', function ($ndinvoices) {
                return $ndinvoices->customer->name;
            })
            ->editColumn('created_at', function($ncinvoices){
                return $ncinvoices->created_at->format('yy-m-d');
            })
            ->addColumn('edit', 'admin/ndinvoice/actions')
            ->rawcolumns(['edit'])
            ->make(true);
        }
        return view('admin.ndinvoice.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $branch = $request->session()->get('branch');

        $payment_forms = Payment_form::get();
        $payment_methods = Payment_method::get();
        $banks = Bank::get();
        $cards = Card::get();

        $invoices = Invoice::where('id', $request->session()->get('invoice'))->first();
        /*
        $invoices = Invoice::from('invoices AS inv')
        ->join('customers AS cus', 'inv.customer_id', 'cus.id')
        ->select('inv.id', 'inv.customer_id', 'cus.name', 'inv.status')
        ->where('inv.id', '=', $request->session()->get('invoice'))->first();*/
        if ($invoices->status != 'ACTIVE') {
            return redirect("invoice")->with('warning', 'Esta Compra ya tiene una Nota Debito o Credito');
        }

        $invoice_products = Invoice_product::from('invoice_products AS ip')
        ->join('invoices AS inv', 'ip.invoice_id', '=', 'inv.id')
        ->join('products AS pro', 'ip.product_id', '=', 'pro.id')
        ->join('categories AS cat', 'pro.category_id', '=', 'cat.id')
        ->select('pro.id', 'ip.invoice_id', 'ip.product_id', 'ip.quantity', 'ip.price', 'pro.name', 'pro.stock', 'inv.id AS idI', 'cat.iva')
        ->where('ip.invoice_id', '=', $request->session()->get('invoice'))->get();

        $products = Product::from('products AS pro')
        ->join('invoice_products AS ip', 'ip.product_id', '=', 'pro.id')
        ->select('pro.id', 'pro.name', 'ip.price')->get();

        $discrepancies = Nd_discrepancy::get();

        return view('admin.ndinvoice.create', compact('invoices', 'products', 'invoice_products', 'discrepancies', 'payment_forms', 'payment_methods', 'banks', 'cards'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNdinvoiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNdinvoiceRequest $request)
    {
        try{
            DB::beginTransaction();

            $pay = $request->pay;
            $invoice = $request->session()->get('invoice');
            $branch = $request->session()->get('branch');

            //variables que vienen en el request
            $product_id     = $request->product_id;
            $quantity       = $request->quantity;
            $price          = $request->price;
            $iva            = $request->iva;
            $pay            = $request->pay;
            $cont = 0;

            //crear tabla nota debito venta
            $ndinvoice = new Ndinvoice();
            $ndinvoice->user_id           = Auth::user()->id;
            $ndinvoice->branch_id         = $branch;
            $ndinvoice->invoice_id        = $invoice;
            $ndinvoice->customer_id       = $request->customer_id;
            $ndinvoice->nd_discrepancy_id = $request->nd_discrepancy_id;
            $ndinvoice->payment_method_id = $request->payment_method_id;
            $ndinvoice->payment_form_id   = $request->payment_form_id;
            $ndinvoice->voucher_type_id   = 6;
            $ndinvoice->total             = $request->total;
            $ndinvoice->total_iva         = $request->total_iva;
            $ndinvoice->total_pay         = $request->total_pay;
            $ndinvoice->pay               = $pay;
            $ndinvoice->balance           = $request->total_pay;
            $ndinvoice->save();
            if($pay > 0){

                $pay_ndinvoice                    = new Pay_ndinvoice();
                $pay_ndinvoice->pay               = $pay;
                $pay_ndinvoice->balance_ndinvoice = $ndinvoice->balance - $pay;
                $pay_ndinvoice->user_id           = $ndinvoice->user_id;
                $pay_ndinvoice->branch_id         = $ndinvoice->branch_id;
                $pay_ndinvoice->invoice_id        = $ndinvoice->invoice_id;

                $pay_ndinvoice->save();

                $pay_ndinvoice_Pay_method                     = new Pay_ndinvoice_payment_method();
                $pay_ndinvoice_Pay_method->pay_ndinvoice_id   = $pay_ndinvoice->id;
                $pay_ndinvoice_Pay_method->payment_method_id  = $request->payment_method_id;
                $pay_ndinvoice_Pay_method->bank_id            = $request->bank_id;
                $pay_ndinvoice_Pay_method->card_id            = $request->card_id;
                $pay_ndinvoice_Pay_method->payment            = $request->pay;
                $pay_ndinvoice_Pay_method->transaction        = $request->transaction;
                $pay_ndinvoice_Pay_method->save();


                $mp = $request->payment_method_id;

                $boxy = Sale_box::where('user_id', '=', $ndinvoice->user_id)->where('status', '=', 'ABIERTA')->first();
                $in_ndinvoice      = $boxy->in_ndinvoice + $pay;
                $in_ndinvoice_cash = $boxy->in_ndinvoice_cash;
                $in_pay_cash     = $boxy->in_pay_cash;
                $in_pay          = $boxy->in_pay + $pay;
                $cash            = $boxy->cash;
                $out             = $boxy->out_cash;
                if($mp == 1){
                    $in_ndinvoice_cash += $pay;
                    $in_pay_cash       += $pay;
                    $cash              += $pay;
                }
                $totale = $cash - $out;

                $sale_box = Sale_box::findOrFail($boxy->id);
                $sale_box->in_ndinvoice_cash = $in_ndinvoice_cash;
                $sale_box->in_ndinvoice      = $in_ndinvoice;
                $sale_box->in_pay_cash       = $in_pay_cash;
                $sale_box->in_pay            = $in_pay;
                $sale_box->cash              = $cash;
                $sale_box->total             = $totale;
                $sale_box->update();
            }

            while($cont < count($product_id)){

                //crear registro tabla ndinvoice_products
                $ndinvoice_product = new Ndinvoice_product();
                $ndinvoice_product->ndinvoice_id = $ndinvoice->id;
                $ndinvoice_product->product_id   = $product_id[$cont];
                $ndinvoice_product->quantity     = $quantity[$cont];
                $ndinvoice_product->price        = $price[$cont];
                $ndinvoice_product->save();

                $cont++;
            }
            $boxy = Sale_box::where('user_id', '=', $ndinvoice->user_id)->where('status', '=', 'ABIERTA')->first();
            $inv  = $boxy->sale;
            $tpv  = $ndinvoice->total_pay;
            $ninv = $inv + $tpv;

            $sale_box = Sale_box::findOrFail($boxy->id);
            $sale_box->invoice = $ninv;
            $sale_box->update();

            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
        }
        return redirect('ndinvoice');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ndinvoice  $ndinvoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ndinvoices = Ndinvoice::from('ndinvoices AS nd')
        ->join('users as use', 'nd.user_id', 'use.id')
        ->join('branches AS bra', 'nd.branch_id', '=', 'bra.id')
        ->join('customers AS cus', 'nd.customer_id', '=', 'cus.id')
        ->join('invoices as inv', 'nd.invoice_id', '=', 'inv.id')
        ->select('nd.id', 'nd.total', 'nd.total_iva', 'nd.total_pay', 'nd.created_at', 'bra.name as nameB', 'cus.name as nameC', 'inv.invoice as nf', 'use.name')
        ->where('nd.id', '=', $id)->first();

        /*mostrar detalles*/
        $ndinvoice_products = Ndinvoice_product::from('ndinvoice_products AS np')
        ->join('products AS pro', 'np.product_id', '=', 'pro.id')
        ->join('ndinvoices AS ndi', 'np.ndinvoice_id', '=', 'ndi.id')
        ->select('np.quantity', 'np.price', 'ndi.total', 'ndi.total_iva', 'ndi.total_pay', 'pro.name')
        ->where('np.ndinvoice_id', '=', $id)
        ->get();

        return view('admin.ndinvoice.show', compact('ndinvoices', 'ndinvoice_products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ndinvoice  $ndinvoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Ndinvoice $ndinvoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNdinvoiceRequest  $request
     * @param  \App\Models\Ndinvoice  $ndinvoice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNdinvoiceRequest $request, Ndinvoice $ndinvoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ndinvoice  $ndinvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ndinvoice $ndinvoice)
    {
        //
    }
}

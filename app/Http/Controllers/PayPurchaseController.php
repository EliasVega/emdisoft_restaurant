<?php

namespace App\Http\Controllers;

use App\Models\Pay_purchase;
use App\Http\Requests\StorePay_purchaseRequest;
use App\Http\Requests\UpdatePay_purchaseRequest;
use App\Models\Bank;
use App\Models\Card;
use App\Models\Company;
use App\Models\Discharge_receipt;
use App\Models\Pay_purchase_payment_method;
use App\Models\Payment;
use App\Models\Payment_method;
use App\Models\Purchase;
use App\Models\Sale_box;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PayPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($request->ajax()) {
            //Muestra todas las Pagos a gastos de la empresa
            if ($user->role_id == 1 || $user->role_id == 2) {

                //Consulta para mostrar pagos a gastos a administradores y superadmin
                $payPurchases = Pay_purchase::get();
            } else {
                //Consulta para mostrar Pagos a gastos a roles 3 -4 -5
                $payPurchases = Pay_purchase::where('branch_id', $user->branch_id)->where('user_id', $user->id)->get();
            }

            return DataTables::of($payPurchases)

            ->addIndexColumn()
            ->addColumn('document', function (Pay_purchase $payPurchase) {
                return $payPurchase->purchase->document;
            })
            ->addColumn('purchase', function (Pay_purchase $payPurchase) {
                return $payPurchase->purchase->id;
            })
            ->addColumn('supplier', function (Pay_purchase $payPurchase) {
                return $payPurchase->purchase->supplier->name;
            })
            ->addColumn('branch', function (Pay_purchase $payPurchase) {
                return $payPurchase->branch->name;
            })
            ->addColumn('user', function (Pay_purchase $payPurchase) {
                return $payPurchase->user->name;
            })
            ->addColumn('totalPay', function (Pay_purchase $payPurchase) {
                return $payPurchase->purchase->total_pay;
            })
            ->editColumn('created_at', function(Pay_purchase $payPurchase){
                return $payPurchase->created_at->format('yy-m-d: h:m');
            })
            ->addColumn('btn', 'admin/pay_purchase/actions')
            ->rawColumns(['btn'])
            ->make(true);
        }
        return view('admin.pay_purchase.index');

    }

    public function detailPay(Request $request)
    {
        $user = Auth::user();
        if ($request->ajax()) {
            //Muestra todas las Pagos a gastos de la empresa
            if ($user->role_id == 1 || $user->role_id == 2) {

                //Consulta para mostrar pagos a gastos a administradores y superadmin
                $detailPays = Pay_purchase_payment_method::get();
            } else {
                //Consulta para mostrar Pagos a gastos a roles 3 -4 -5
                $detailPays = Pay_purchase_payment_method::where('branch_id', $user->branch_id)->where('user_id', $user->id)->get();
            }

            return DataTables::of($detailPays)

            ->addIndexColumn()

            ->addColumn('paymentMethod', function (Pay_purchase_payment_method $pppm) {
                return $pppm->paymentMethod->name;
            })
            ->addColumn('bank', function (Pay_purchase_payment_method $pppm) {
                return $pppm->bank->name;
            })
            ->addColumn('card', function (Pay_purchase_payment_method $pppm) {
                return $pppm->card->name;
            })
            ->addColumn('payment_id', function (Pay_purchase_payment_method $pppm) {
                $paymen = $pppm->payment_id;
                if ($paymen) {
                    return $pppm->payment_id;
                } else {
                    return 'N/A';
                }

            })
            ->editColumn('created_at', function(Pay_purchase_payment_method $pppm){
                return $pppm->created_at->format('yy-m-d: h:m');
            })
            ->make(true);
        }
        return view('admin.pay_purchase.detail_pay');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $banks = Bank::get();
        $payment_methods = Payment_method::get();
        $cards = Card::get();
        $purchase = Purchase::where('id', '=', $request->session()->get('purchase'))->first();
        $payments = Payment::where('status', '!=', 'aplicado')->where('supplier_id', $purchase->supplier->id)->get();

        return view('admin.pay_purchase.create', compact('purchase', 'banks', 'payment_methods', 'cards', 'payments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePay_purchaseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePay_purchaseRequest $request)
    {
        try{
            DB::beginTransaction();
            $user = Auth::user();
            $purchase = purchase::where('id', '=', $request->session()->get('purchase'))->first();
            $balance = $purchase->balance;
            $total = $request->total;

            $pay_purchase = new Pay_purchase();
            $pay_purchase->user_id = $user->id;
            $pay_purchase->branch_id = $user->branch_id;
            $pay_purchase->purchase_id = $purchase->id;
            $pay_purchase->pay = $total;
            $pay_purchase->balance_purchase = $balance - $total;
            $pay_purchase->save();

            $cont = 0;
            $payment_method = $request->payment_method_id;
            $bank = $request->bank_id;
            $card = $request->card_id;
            $payment_id = $request->payment_id;
            $pay = $request->pay;
            $transaction = $request->transaction;
            $payu = $request->payment;
            if ($payu != 0) {
                $payment = Payment::findOrFail( $request->payment_id);
                $payu_total = $payment->balance - $payu;

                $payment->destination = $purchase->id;
                if ($payu_total == 0) {
                    $payment->status = 'aplicado';
                } else {
                    $payment->status = 'parcial';
                }
                $payment->balance = $payu_total;
                $payment->update();
            }

            while($cont < count($payment_method)){
                $paymentLine = $request->pay[$cont];
                $pay_purchase_payment_method = new Pay_purchase_payment_method();
                $pay_purchase_payment_method->pay_purchase_id = $pay_purchase->id;
                $pay_purchase_payment_method->payment_method_id = $payment_method[$cont];
                $pay_purchase_payment_method->bank_id = $bank[$cont];
                $pay_purchase_payment_method->card_id = $card[$cont];
                if (isset($payment_id[$cont])){
                    $pay_purchase_payment_method->payment_id = $payment_id[$cont];
                }
                $pay_purchase_payment_method->payment = $pay[$cont];
                $pay_purchase_payment_method->transaction = $transaction[$cont];
                $pay_purchase_payment_method->save();

                $mp = $payment_method[$cont];

                $sale_box = Sale_box::where('user_id', '=', $user->id)
                ->where('status', '=', 'open')
                ->first();
                if($mp == 10){
                    $sale_box->out_purchase_cash += $paymentLine;
                    $sale_box->departure += $paymentLine;
                }

                //$sale_box = Sale_box::findOrFail($boxy->id);
                $sale_box->out_purchase += $paymentLine;
                $sale_box->out_total += $paymentLine;
                $sale_box->update();

                $cont++;
            }

            $purchas = purchase::findOrFail($purchase->id);
            $purchas->pay += $total;
            $purchas->balance -= $total;
            $purchas->update();

            $pay_purchases = Pay_purchase::findOrFail($pay_purchase->id);
            $pay_purchases->balance_purchase = $balance-$total;
            $pay_purchases->update();

            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
        }
        return redirect('pay_purchase');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pay_purchase  $pay_purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Pay_purchase $pay_purchase)
    {
        $payPurchase = Pay_purchase::where('id', $pay_purchase->id)->first();
        $payPurchase_paymentMethods = Pay_purchase_payment_method::where('pay_purchase_id', $payPurchase->id)->get();

        return view('admin.pay_purchase.show', compact('payPurchase', 'payPurchase_paymentMethods'));
    }

    public function pdf_pay_purchase(Request $request, $id)
    {
        $payPurchase = Pay_purchase::findOrFail($id);
        $company = Company::where('id', 1)->first();
        $user = auth::user();
        $payPurchase_PaymentMethods = Pay_purchase_payment_method::where('pay_purchase_id', $payPurchase->id)->get();

        $pdfPayPurchase = "ABONO-". $payPurchase->id;
        $logo = './imagenes/logos'.$company->logo;
        $view = \view('admin.pay_purchase.pdf', compact('payPurchase_PaymentMethods', 'company', 'logo', 'user', 'payPurchase'));
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        //$pdf->setPaper ( 'A7' , 'landscape' );

        return $pdf->stream('vista-pdf', "$pdfPayPurchase.pdf");
        //return $pdf->download("$invoicepdf.pdf");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pay_purchase  $pay_purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Pay_purchase $pay_purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePay_purchaseRequest  $request
     * @param  \App\Models\Pay_purchase  $pay_purchase
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePay_purchaseRequest $request, Pay_purchase $pay_purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pay_purchase  $pay_purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pay_purchase $pay_purchase)
    {
        //
    }
}

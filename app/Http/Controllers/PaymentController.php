<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\Bank;
use App\Models\Card;
use App\Models\Company;
use App\Models\Payment_method;
use App\Models\Payment_payment_method;
use App\Models\Sale_box;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user()->role_id;
        if (request()->ajax()) {
            if ($user == 1 || $user == 2) {
                $payments = Payment::get();
            } else {
                $payments = Payment::where('user_id', Auth::user()->id)->get();
            }
            return DataTables::of($payments)
            ->addIndexColumn()
            ->addColumn('pay', function (Payment $payment) {
                return $payment->pay;
            })
            ->addColumn('balance', function (Payment $payment) {
                return $payment->balance;
            })
            ->addColumn('supplier', function (Payment $payment) {
                return $payment->supplier->name;
            })
            ->addColumn('branch', function (Payment $payment) {
                return $payment->branch->name;
            })
            ->addColumn('user', function (Payment $payment) {
                return $payment->user->name;
            })
            ->editColumn('created_at', function(Payment $payment){
                return $payment->created_at->format('yy-m-d: h:m');
            })

            ->addColumn('btn', 'admin/payment/actions')
            ->rawcolumns(['btn'])
            ->make(true);
        }
        return view('admin.payment.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $sale_box = Sale_box::where('user_id', Auth::user()->id)->first();
        if(is_null($sale_box)){
            return redirect("branch")->with('warning', 'Debes tener una caja Abierta para realizar esta operacion');
        }
        $banks = Bank::get();
        $paymentMethods = Payment_method::get();
        $cards = Card::get();
        $suppliers = Supplier::get();

        $payments = Payment::get();

        return view('admin.payment.create', compact('payments', 'suppliers', 'banks', 'paymentMethods', 'cards'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePaymentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaymentRequest $request)
    {
        $user = Auth::user();
            $payment = new Payment();
            $payment->user_id = $user->id;
            $payment->branch_id = $user->branch_id;
            $payment->supplier_id = $request->supplier_id;
            $payment->origin = 'Abonos con medios de pago';
            $payment->destination = null;
            $payment->pay = 0;
            $payment->balance = 0;
            $payment->note = $request->note;
            $payment->save();

            $cont = 0;
            $payment_method = $request->payment_method_id;
            $bank = $request->bank_id;
            $card = $request->card_id;
            $pay = $request->pay;
            $transaction = $request->transaction;
            $payu = 0;

            while($cont < count($pay)){
                $paymentLine = $pay[$cont];

                $payment_payment_method = new Payment_payment_method();
                $payment_payment_method->payment_id = $payment->id;
                $payment_payment_method->payment_method_id = $payment_method[$cont];
                $payment_payment_method->bank_id = $bank[$cont];
                $payment_payment_method->card_id = $card[$cont];
                $payment_payment_method->payment = $paymentLine;
                $payment_payment_method->transaction = $transaction[$cont];
                $payment_payment_method->save();

                $payu = $payu + $paymentLine;

                $mp = $payment_method[$cont];
                $sale_box = Sale_box::where('user_id', $user->id)
                ->where('status', '=', 'open')
                ->first();
                if($mp == 10){
                    $sale_box->out_payment_cash += $paymentLine;
                    $sale_box->departure += $paymentLine;
                }
                $sale_box->out_payment += $paymentLine;
                $sale_box->out_total += $paymentLine;
                $sale_box->update();

                $cont++;
            }
            $payments = Payment::findOrFail($payment->id);
            $payments->pay = $payu;
            $payments->balance = $payu;
            $payments->update();

        return redirect('payment');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        $payments = Payment::where('id', $payment->id)->first();
        $paymentPaymentMethods = Payment_payment_method::from('payment_payment_methods AS pp')
        ->join('payments AS pay', 'pp.payment_id', '=', 'pay.id')
        ->join('payment_methods AS pm', 'pp.payment_method_id', '=', 'pm.id')
        ->join('banks AS ban', 'pp.bank_id', '=', 'ban.id')
        ->join('cards AS car', 'pp.card_id', '=', 'car.id')
        ->select('pay.id', 'pm.name AS nameM', 'ban.name AS nameB', 'car.name AS nameT', 'pp.transaction', 'pp.payment')
        ->where('pay.id', '=', $payment->id)
        ->get();

        return view('admin.payment.show', compact('payments', 'paymentPaymentMethods'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        $sale_box = Sale_box::where('user_id', Auth::user()->id)->first();
        if(is_null($sale_box)){
            return redirect("branch")->with('warning', 'Debes tener una caja Abierta para realizar esta operacion');
        }
        $banks = Bank::get();
        $paymentMethods = Payment_method::get();
        $cards = Card::get();
        $suppliers = Supplier::get();

        $paymentPaymentMethods = Payment_payment_method::from('payment_payment_methods AS pp')
        ->join('payments AS pay', 'pp.payment_id', '=', 'pay.id')
        ->join('payment_methods AS pm', 'pp.payment_method_id', '=', 'pm.id')
        ->join('banks AS ban', 'pp.bank_id', '=', 'ban.id')
        ->join('cards AS car', 'pp.card_id', '=', 'car.id')
        ->select('pay.id', 'pm.id as idM', 'pm.name AS nameM', 'ban.id as idB', 'ban.name AS nameB', 'car.id as idC', 'car.name AS nameC', 'pp.transaction', 'pp.payment')
        ->where('pay.id', '=', $payment->id)
        ->get();

        return view('admin.payment.edit', compact('payment', 'paymentPaymentMethods', 'suppliers', 'banks', 'paymentMethods', 'cards'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePaymentRequest  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
    public function paymentPdf(Request $request, $id)
    {
        $payment = Payment::where('id', $id)->first();
        $company = Company::where('id', 1)->first();
        $user = auth::user();
        $paymentPaymentMethods = Payment_payment_method::where('payment_id', $id)->get();
        /*
        $paymentPaymentMethods = payment_payment_method::from('payment_payment_methods as ap')
        ->join('payment_methods as pm', 'pp.payment_method_id', 'pm.id')
        ->join('payments as adv', 'ap.payment_id', 'adv.id')
        ->select('pm.name', 'ap.transaction', 'ap.payment')
        ->where('ap.payment_id', $id)
        ->get();*/
        $paymentpdf = "ADV-". $payment->id;
        $logo = './imagenes/logos'.$company->logo;
        $view = \view('admin.payment.pdf', compact('paymentPaymentMethods', 'company', 'logo', 'payment', 'user'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        //$pdf->setPaper ( 'A7' , 'landscape' );

        return $pdf->stream('vista-pdf', "$paymentpdf.pdf");
        //return $pdf->download("$invoicepdf.pdf");
    }
}

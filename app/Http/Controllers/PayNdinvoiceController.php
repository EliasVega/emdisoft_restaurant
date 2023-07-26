<?php

namespace App\Http\Controllers;

use App\Models\Pay_ndinvoice;
use App\Http\Requests\StorePay_ndinvoiceRequest;
use App\Http\Requests\UpdatePay_ndinvoiceRequest;
use App\Models\Bank;
use App\Models\Card;
use App\Models\Ndinvoice;
use App\Models\Pay_event;
use App\Models\Pay_ndinvoice_payment_method;
use App\Models\Payment_method;
use App\Models\Sale_box;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PayNdinvoiceController extends Controller
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
                $pay_ndinvoices = Pay_ndinvoice::get();
                /*
                $pay_ndinvoices = Pay_ndinvoice::from('pay_invoices AS pay')
                ->join('users AS use', 'pay.user_id', '=', 'use.id')
                ->join('branches AS bra', 'pay.branch_id', '=', 'bra.id')
                ->join('invoices AS inv', 'pay.invoice_id', 'inv.id')
                ->join('customers AS cus', 'inv.customer_id', 'cus.id')
                ->select('pay.id', 'pay.pay', 'use.name', 'bra.name as nameB', 'inv.id AS idI', 'inv.balance', 'inv.totalPay', 'cus.name as nameC', 'pay.created_at')
                ->get();*/
            } else {
                $pay_ndinvoices = Pay_ndinvoice::get('user_id', Auth::user()->id);
                /*
                $pay_ndinvoices = Pay_ndinvoice::from('pay_invoices AS pay')
                ->join('users AS use', 'pay.user_id', '=', 'use.id')
                ->join('branches AS bra', 'pay.branch_id', '=', 'bra.id')
                ->join('invoices AS inv', 'pay.invoice_id', 'inv.id')
                ->join('customers AS cus', 'inv.customer_id', 'cus.id')
                ->select('pay.id', 'pay.pay', 'use.name', 'bra.name as nameB', 'inv.id AS idI', 'inv.balance', 'inv.totalPay', 'cus.name as nameC', 'pay.created_at')
                ->where('pay.user_id', '=', Auth::user()->id)
                ->get();*/
            }

            return datatables()
            ->of($pay_ndinvoices)
            ->editColumn('created_at', function(Pay_ndinvoice $pay){
                return $pay->created_at->format('yy-m-d: h:m');
            })
            ->addColumn('btn', 'admin/pay_ndinvoice/actions')
            ->rawcolumns(['btn'])
            ->toJson();
        }
        return view('admin.pay_ndinvoice.index');
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
        $ndinvoices = Ndinvoice::where('id', $request->session()->get('ndinvoice'))->first();

        return view('admin.pay_ndinvoice.create', compact('ndinvoices', 'banks', 'payment_methods', 'cards'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePay_ndinvoiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePay_ndinvoiceRequest $request)
    {
        try{
            DB::beginTransaction();

            $ndinvoice = Ndinvoice::where('id', '=', $request->session()->get('ndinvoice'))->first();
            $balance = $ndinvoice->balance;

            $pay_ndinvoice = new Pay_ndinvoice();
            $pay_ndinvoice->user_id         = Auth::user()->id;
            $pay_ndinvoice->branch_id       = $request->session()->get('branch');
            $pay_ndinvoice->ndinvoice_id    = $ndinvoice->id;
            $pay_ndinvoice->pay             = 0;
            $pay_ndinvoice->balance_ndinvoice = 0;
            $pay_ndinvoice->save();

            $cont = 0;
            $payment_method = $request->payment_method_id;
            $bank           = $request->bank_id;
            $card           = $request->card_id;
            $pay            = $request->pay;
            $transaction    = $request->transaction;
            $payu           = 0;

            while($cont < count($payment_method)){
                $pay = $pay[$cont];

                $pay_ndinvoice_payment_method = new Pay_ndinvoice_payment_method();
                $pay_ndinvoice_payment_method->pay_ndinvoice_id   = $pay_ndinvoice->id;
                $pay_ndinvoice_payment_method->payment_method_id  = $payment_method[$cont];
                $pay_ndinvoice_payment_method->bank_id            = $bank[$cont];
                $pay_ndinvoice_payment_method->card_id            = $card[$cont];
                $pay_ndinvoice_payment_method->payEvent_id        = null;
                $pay_ndinvoice_payment_method->payment            = $pay;
                $pay_ndinvoice_payment_method->transaction        = $transaction[$cont];
                $pay_ndinvoice_payment_method->save();

                $payu = $payu + $pay;

                $mp = $request->payment_method_id;

                $boxy = Sale_box::where('user_id', '=', Auth::user()->id)
                ->where('status', '=', 'ABIERTA')
                ->first();
                $in_pay = $boxy->in_pay + $pay;
                $in_pay_cash = $boxy->in_pay_cash;
                $cash = $boxy->cash;
                if($mp == 1){
                    $in_pay_cash += $pay;
                    $cash += $pay;
                }

                $sale_box = Sale_box::findOrFail($boxy->id);
                $sale_box->in_pay_cash = $in_pay_cash;
                $sale_box->in_pay = $in_pay;
                $sale_box->cash = $cash;
                $sale_box->update();

                $cont++;
            }

            $balance = $balance-$payu;

            $ndinvoic = Ndinvoice::findOrFail($ndinvoice->id);
            $ndinvoic->balance = $balance;
            if ($balance == 0) {
                $ndinvoic->status = 'CANCELADA';
            }
            $ndinvoic->update();

            $pay_ndinvoices = Pay_ndinvoice::findOrFail($pay_ndinvoice->id);
            $pay_ndinvoices->pay = $payu;
            $pay_ndinvoices->balance_ndinvoice = $ndinvoice->balance;
            $pay_ndinvoices->update();

            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
        }
        return redirect('pay_ndinvoice');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pay_ndinvoice  $pay_ndinvoice
     * @return \Illuminate\Http\Response
     */
    public function show(Pay_ndinvoice $pay_ndinvoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pay_ndinvoice  $pay_ndinvoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Pay_ndinvoice $pay_ndinvoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePay_ndinvoiceRequest  $request
     * @param  \App\Models\Pay_ndinvoice  $pay_ndinvoice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePay_ndinvoiceRequest $request, Pay_ndinvoice $pay_ndinvoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pay_ndinvoice  $pay_ndinvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pay_ndinvoice $pay_ndinvoice)
    {
        //
    }
}

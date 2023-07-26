<?php

namespace App\Http\Controllers;

use App\Models\pay_ncinvoice;
use App\Http\Requests\Storepay_ncinvoiceRequest;
use App\Http\Requests\Updatepay_ncinvoiceRequest;
use App\Models\Bank;
use App\Models\Card;
use App\Models\Cash_out;
use App\Models\Ncinvoice;
use App\Models\Pay_ncinvoice_payment_method;
use App\Models\Payment_method;
use App\Models\Sale_box;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PayNcinvoiceController extends Controller
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
                $pay_ncinvoices = Pay_ncinvoice::get();
                /*
                $pay_ncinvoices = Pay_ncinvoice::from('pay_invoices AS pay')
                ->join('users AS use', 'pay.user_id', '=', 'use.id')
                ->join('branches AS bra', 'pay.branch_id', '=', 'bra.id')
                ->join('invoices AS inv', 'pay.invoice_id', 'inv.id')
                ->join('customers AS cus', 'inv.customer_id', 'cus.id')
                ->select('pay.id', 'pay.pay', 'use.name', 'bra.name as nameB', 'inv.id AS idI', 'inv.balance', 'inv.totalPay', 'cus.name as nameC', 'pay.created_at')
                ->get();*/
            } else {
                $pay_ncinvoices = Pay_ncinvoice::get('user_id', Auth::user()->id);
                /*
                $pay_ncinvoices = Pay_ncinvoice::from('pay_invoices AS pay')
                ->join('users AS use', 'pay.user_id', '=', 'use.id')
                ->join('branches AS bra', 'pay.branch_id', '=', 'bra.id')
                ->join('invoices AS inv', 'pay.invoice_id', 'inv.id')
                ->join('customers AS cus', 'inv.customer_id', 'cus.id')
                ->select('pay.id', 'pay.pay', 'use.name', 'bra.name as nameB', 'inv.id AS idI', 'inv.balance', 'inv.totalPay', 'cus.name as nameC', 'pay.created_at')
                ->where('pay.user_id', '=', Auth::user()->id)
                ->get();*/
            }

            return datatables()
            ->of($pay_ncinvoices)
            ->editColumn('created_at', function(Pay_ncinvoice $pay){
                return $pay->created_at->format('yy-m-d: h:m');
            })
            ->addColumn('btn', 'admin/pay_ncinvoice/actions')
            ->rawcolumns(['btn'])
            ->toJson();
        }
        return view('admin.pay_ncinvoice.index');
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
        $ncinvoices = Ncinvoice::where('id', $request->session()->get('ncinvoice'))->first();

        return view('admin.pay_ncinvoice.create', compact('ncinvoices', 'banks', 'payment_methods', 'cards'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Storepay_ncinvoiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storepay_ncinvoiceRequest $request)
    {
        try{
            DB::beginTransaction();

            $users = Auth::user()->id;
            $box_open = Sale_box::where('user_id', '=', $users)->where('status', '=', 'ABIERTA')->first();
            $ncinvoice = Ncinvoice::where('id', '=', $request->session()->get('ncinvoice'))->first();
            $balance = $ncinvoice->balance;

            $pay_ncinvoice = new Pay_ncinvoice();
            $pay_ncinvoice->user_id         = Auth::user()->id;
            $pay_ncinvoice->branch_id       = Auth::user()->branch_id;
            $pay_ncinvoice->ncinvoice_id    = $ncinvoice->id;
            $pay_ncinvoice->pay             = 0;
            $pay_ncinvoice->balance_ncinvoice = 0;
            $pay_ncinvoice->save();

            $cont = 0;
            $payment_method = $request->payment_method_id;
            $bank           = $request->bank_id;
            $card           = $request->card_id;
            $pay            = $request->pay;
            $transaction    = $request->transaction;
            $payu           = 0;

            while($cont < count($payment_method)){
                $pay = $pay[$cont];

                $pay_ncinvoice_payment_method = new Pay_ncinvoice_payment_method();
                $pay_ncinvoice_payment_method->pay_ncinvoice_id   = $pay_ncinvoice->id;
                $pay_ncinvoice_payment_method->payment_method_id  = $payment_method[$cont];
                $pay_ncinvoice_payment_method->bank_id            = $bank[$cont];
                $pay_ncinvoice_payment_method->card_id            = $card[$cont];
                $pay_ncinvoice_payment_method->payment_id         = null;
                $pay_ncinvoice_payment_method->payment            = $pay;
                $pay_ncinvoice_payment_method->transaction        = $transaction[$cont];
                $pay_ncinvoice_payment_method->save();

                $cont++;
            }

            $id = $box_open->id;
            $cash_out = new Cash_out();
            $cash_out->user_id     = $users;
            $cash_out->sale_box_id = $id;
            $cash_out->branch_id   = $request->session()->get('branch');
            $cash_out->admin_id    = $request->admin_id;
            $cash_out->payment     = $pay;
            $cash_out->reason      = 'Pago a Nota Credito #' . $ncinvoice->id;
            $cash_out->admin       = $request->admin;
            $cash_out->save();

            $boxy = Sale_box::findOrFail($id);
            $out = $boxy->out_cash + $pay;

            $sale_box = Sale_box::findOrFail($id);
            $sale_box->out_cash = $out;
            $sale_box->update();

            $balance = $balance-$payu;

            $ncinvoic = Ncinvoice::findOrFail($ncinvoice->id);
            $ncinvoic->balance = $balance;
            if ($balance == 0) {
                $ncinvoic->status = 'CANCELADA';
            }
            $ncinvoic->update();

            $pay_ncinvoices = Pay_ncinvoice::findOrFail($pay_ncinvoice->id);
            $pay_ncinvoices->pay = $payu;
            $pay_ncinvoices->balance_ncinvoice = $ncinvoice->balance;
            $pay_ncinvoices->update();

            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
        }
        return redirect('pay_ncinvoice');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pay_ncinvoice  $pay_ncinvoice
     * @return \Illuminate\Http\Response
     */
    public function show(pay_ncinvoice $pay_ncinvoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pay_ncinvoice  $pay_ncinvoice
     * @return \Illuminate\Http\Response
     */
    public function edit(pay_ncinvoice $pay_ncinvoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updatepay_ncinvoiceRequest  $request
     * @param  \App\Models\pay_ncinvoice  $pay_ncinvoice
     * @return \Illuminate\Http\Response
     */
    public function update(Updatepay_ncinvoiceRequest $request, pay_ncinvoice $pay_ncinvoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pay_ncinvoice  $pay_ncinvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(pay_ncinvoice $pay_ncinvoice)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Advance;
use App\Http\Requests\StoreAdvanceRequest;
use App\Http\Requests\UpdateAdvanceRequest;
use App\Models\Advance_payment_method;
use App\Models\Bank;
use App\Models\Card;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Payment_method;
use App\Models\Sale_box;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class AdvanceController extends Controller
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
                $advances = Advance::get();
            } else {
                $advances = Advance::where('user_id', Auth::user()->id)->get();
            }
            return DataTables::of($advances)
            ->addIndexColumn()
            ->addColumn('pay', function (Advance $advance) {
                return number_format($advance->pay, 2);
            })
            ->addColumn('balance', function (Advance $advance) {
                return number_format($advance->balance, 2);
            })
            ->addColumn('customer', function (Advance $advance) {
                return $advance->customer->name;
            })
            ->addColumn('branch', function (Advance $advance) {
                return $advance->branch->name;
            })
            ->addColumn('user', function (Advance $advance) {
                return $advance->user->name;
            })
            ->editColumn('created_at', function(Advance $advance){
                return $advance->created_at->format('yy-m-d: h:m');
            })

            ->addColumn('btn', 'admin/advance/actions')
            ->rawcolumns(['btn'])
            ->make(true);
        }
        return view('admin.advance.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $banks = Bank::get();
        $paymentMethods = Payment_method::get();
        $cards = Card::get();
        $customers = Customer::get();

        $advances = Advance::get();

        return view('admin.advance.create', compact('advances', 'customers', 'banks', 'paymentMethods', 'cards'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAdvanceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdvanceRequest $request)
    {
            $advance = new Advance();
            $advance->user_id    = Auth::user()->id;
            $advance->branch_id  = Auth::user()->branch_id;
            $advance->customer_id = $request->customer_id;
            $advance->origin = 'Anticipo con medio de pago';
            $advance->destination = null;
            $advance->pay        = 0;
            $advance->balance = 0;
            $advance->note = $request->note;
            $advance->save();

            $cont = 0;
            $payment_method = $request->payment_method_id;
            $bank           = $request->bank_id;
            $card           = $request->card_id;
            $pay            = $request->pay;
            $transaction    = $request->transaction;
            $payu           = 0;

            while($cont < count($pay)){
                $paymentLine = $pay[$cont];

                $advance_payment_method = new Advance_payment_method();
                $advance_payment_method->advance_id      = $advance->id;
                $advance_payment_method->payment_method_id  = $payment_method[$cont];
                $advance_payment_method->bank_id            = $bank[$cont];
                $advance_payment_method->card_id            = $card[$cont];
                $advance_payment_method->payment            = $paymentLine;
                $advance_payment_method->transaction        = $transaction[$cont];
                $advance_payment_method->save();

                $payu = $payu + $paymentLine;

                $mp = $payment_method[$cont];

                $sale_box = Sale_box::where('user_id', '=', Auth::user()->id)->where('status', '=', 'open')->first();
                if($mp == 10){
                    $sale_box->in_advance_cash += $paymentLine;
                    $sale_box->cash += $paymentLine;
                }
                $sale_box->in_advance += $paymentLine;
                $sale_box->in_total += $paymentLine;
                $sale_box->update();

                $cont++;
            }
            $advances = Advance::findOrFail($advance->id);
            $advances->pay = $payu;
            $advances->balance = $payu;
            $advances->update();

        return redirect('advance');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Advance  $advance
     * @return \Illuminate\Http\Response
     */
    public function show(Advance $advance)
    {
        $advance = Advance::where('id', $advance->id)->first();
        $advancePaymentMethods = Advance_payment_method::from('advance_payment_methods AS ap')
        ->join('advances AS adv', 'ap.advance_id', '=', 'adv.id')
        ->join('payment_methods AS pm', 'ap.payment_method_id', '=', 'pm.id')
        ->join('banks AS ban', 'ap.bank_id', '=', 'ban.id')
        ->join('cards AS car', 'ap.card_id', '=', 'car.id')
        ->select('adv.id', 'pm.name AS nameM', 'ban.name AS nameB', 'car.name AS nameT', 'ap.transaction', 'ap.payment')
        ->where('adv.id', '=', $advance->id)
        ->get();

        return view('admin.advance.show', compact('advance', 'advancePaymentMethods'));
    }

    public function advancePdf(Request $request, $id)
    {
        $advance = Advance::where('id', $id)->first();
        $company = Company::where('id', 1)->first();
        $user = auth::user();
        $advancePaymentMethods = Advance_payment_method::where('advance_id', $id)->get();
        $advancepdf = "ADV-". $advance->id;
        $logo = './imagenes/logos'.$company->logo;
        $view = \view('admin.advance.pdf', compact('advancePaymentMethods', 'company', 'logo', 'advance', 'user'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        //$pdf->setPaper ( 'A7' , 'landscape' );

        return $pdf->stream('vista-pdf', "$advancepdf.pdf");
        //return $pdf->download("$invoicepdf.pdf");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Advance  $advance
     * @return \Illuminate\Http\Response
     */
    public function edit(Advance $advance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAdvanceRequest  $request
     * @param  \App\Models\Advance  $advance
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdvanceRequest $request, Advance $advance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Advance  $advance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Advance $advance)
    {
        //
    }
}

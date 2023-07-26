<?php

namespace App\Http\Controllers;

use App\Models\Pay_order;
use App\Http\Requests\StorePayorderRequest;
use App\Http\Requests\UpdatePayorderRequest;
use App\Models\Advance;
use App\Models\Bank;
use App\Models\Card;
use App\Models\Cash_receipt;
use App\Models\Company;
use App\Models\Order;
use App\Models\Payment_method;
use App\Models\Pay_order_payment_method;
use App\Models\Sale_box;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Yajra\DataTables\DataTables;

class PayorderController extends Controller
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
                $payOrders = Pay_order::get();
            } else {
                //Consulta para mostrar Pagos a gastos a roles 3 -4 -5
                $payOrders = Pay_order::where('branch_id', $user->branch_id)->where('user_id', $user->id)->get();
            }

            return DataTables::of($payOrders)
            ->addIndexColumn()
            ->addColumn('order', function (Pay_order $payOrder) {
                return $payOrder->order->id;
            })
            ->addColumn('customer', function (Pay_order $payOrder) {
                return $payOrder->order->customer->name;
            })
            ->addColumn('branch', function (Pay_order $payOrder) {
                return $payOrder->branch->name;
            })
            ->addColumn('user', function (Pay_order $payOrder) {
                return $payOrder->user->name;
            })
            ->addColumn('totalPay', function (Pay_order $payOrder) {
                return $payOrder->order->total_pay;
            })

            ->editColumn('created_at', function(Pay_order $payOrder){
                return $payOrder->created_at->format('yy-m-d: h:m');
            })
            ->addColumn('btn', 'admin/pay_order/actions')
            ->rawColumns(['btn'])
            ->make(true);
        }
        return view('admin.pay_order.index');
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
        $advances = Advance::where('status', '=', 'pendiente');
        $orders = Order::where('id', $request->session()->get('order'))->first();

        return view('admin.pay_order.create', compact('orders', 'banks', 'payment_methods', 'cards', 'advances'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePayorderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePayorderRequest $request, Order $order)
    {

        try{
            DB::beginTransaction();
            $user = Auth::user();
            $order = Order::where('id', $request->session()->get('order'))->first();
            $balance = $order->balance;
            $total = $request->total;

            $pay_order = new Pay_order();
            $pay_order->user_id = $user->id;
            $pay_order->branch_id = $user->branch_id;
            $pay_order->order_id = $order->id;
            $pay_order->pay = $total;
            $pay_order->balance_order = 0;
            $pay_order->save();

            $cont = 0;
            $payment_method = $request->payment_method_id;
            $bank = $request->bank_id;
            $card = $request->card_id;
            $advance_id = $request->advance_id;
            $transaction = $request->transaction;
            $adv = $request->advance;

            if ($adv != 0) {
                $advance = Advance::findOrFail( $request->advance_id);
                $adv_total = $advance->balance - $adv;

                $advance->destination = $order->id;
                if ($adv_total == 0) {
                    $advance->status = 'aplicado';
                } else {
                    $advance->status = 'parcial';
                }
                $advance->balance = $adv_total;
                $advance->update();
            }


            while($cont < count($payment_method)){

                //$id = $order->id;
                $pay = $request->pay[$cont];
                $pay_order_payment_method = new Pay_order_payment_method();
                $pay_order_payment_method->pay_order_id = $pay_order->id;
                $pay_order_payment_method->payment_method_id = $payment_method[$cont];
                $pay_order_payment_method->bank_id = $bank[$cont];
                $pay_order_payment_method->card_id = $card[$cont];
                if (isset($advance_id[$cont])){
                    $pay_order_payment_method->advance_id = $advance_id[$cont];
                }
                $pay_order_payment_method->payment = $pay;
                $pay_order_payment_method->transaction = $transaction[$cont];
                $pay_order_payment_method->save();

                $mp = $request->payment_method_id[$cont];

                $sale_box = Sale_box::where('user_id', '=', $user->id)
                ->where('status', '=', 'open')
                ->first();
                if($mp == 10){
                    $sale_box->in_order_cash += $pay;
                    $sale_box->cash += $pay;
                }
                $sale_box->in_order += $pay;
                $sale_box->in_total = $pay;
                $sale_box->update();

                $cont++;
            }
            $order = Order::findOrFail($order->id);
            $order->pay += $total;
            $order->balance = $balance-$total;
            $order->update();

            $pay_orders = Pay_order::findOrFail($pay_order->id);
            $pay_orders->balance_order = $balance-$total;
            $pay_orders->update();

            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
        }
        return redirect()->route('pay_order.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pay_order  $pay_order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payOrder = Pay_order::where('id', $id)->first();
        $payOrder_paymentMethods = Pay_order_payment_method::where('pay_order_id', $id)->get();

        return view('admin.pay_order.show', compact('payOrder', 'payOrder_paymentMethods'));
    }

    public function pdfPayOrder(Request $request, $id)
    {
        $payOrder = Pay_order::findOrFail($id);
        $company = Company::where('id', 1)->first();
        $user = auth::user();
        $payOrder_PaymentMethods = Pay_order_payment_method::where('pay_order_id', $payOrder->id)->get();

        $pdfPayOrder = "ABONO-". $payOrder->id;
        $logo = './imagenes/logos'.$company->logo;
        $view = \view('admin.pay_order.pdf', compact('payOrder_PaymentMethods', 'company', 'logo', 'user', 'payOrder'));
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        //$pdf->setPaper ( 'A7' , 'landscape' );

        return $pdf->stream('vista-pdf', "$pdfPayOrder.pdf");
        //return $pdf->download("$invoicepdf.pdf");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pay_order  $pay_order
     * @return \Illuminate\Http\Response
     */
    public function edit(Pay_order $pay_order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePayorderRequest  $request
     * @param  \App\Models\Payorder  $payorder
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePayorderRequest $request, Pay_order $pay_order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payorder  $payorder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pay_order $pay_order)
    {
        //
    }
}

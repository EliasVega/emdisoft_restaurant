<?php

namespace App\Http\Controllers;

use App\Models\Pay_invoice;
use App\Http\Requests\StorePayinvoiceRequest;
use App\Http\Requests\UpdatePayinvoiceRequest;
use App\Models\Advance;
use App\Models\Bank;
use App\Models\Card;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Pay_invoice_payment_method;
use App\Models\Payment_method;
use App\Models\Sale_box;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PayinvoiceController extends Controller
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
                $payInvoices = Pay_invoice::get();
            } else {
                //Consulta para mostrar Pagos a gastos a roles 3 -4 -5
                $payInvoices = Pay_invoice::where('branch_id', $user->branch_id)->where('user_id', $user->id)->get();
            }

            return DataTables::of($payInvoices)

            ->addIndexColumn()
            ->addColumn('document', function (Pay_invoice $pay_invoice) {
                return $pay_invoice->invoice->document;
            })
            ->addColumn('invoice', function (Pay_invoice $pay_invoice) {
                return $pay_invoice->invoice->id;
            })
            ->addColumn('customer', function (Pay_invoice $pay_invoice) {
                return $pay_invoice->invoice->customer->name;
            })
            ->addColumn('branch', function (Pay_invoice $pay_invoice) {
                return $pay_invoice->branch->name;
            })
            ->addColumn('user', function (Pay_invoice $pay_invoice) {
                return $pay_invoice->user->name;
            })
            ->addColumn('totalPay', function (Pay_invoice $pay_invoice) {
                return $pay_invoice->invoice->total_pay;
            })

            ->editColumn('created_at', function(Pay_invoice $pay_invoice){
                return $pay_invoice->created_at->format('yy-m-d: h:m');
            })
            ->addColumn('btn', 'admin/pay_invoice/actions')
            ->rawColumns(['btn'])
            ->make(true);
        }
        return view('admin.pay_invoice.index');
    }

    public function detailPay(Request $request)
    {
        $user = Auth::user();
        if ($request->ajax()) {
            //Muestra todas las Pagos a gastos de la empresa
            if ($user->role_id == 1 || $user->role_id == 2) {

                //Consulta para mostrar pagos a gastos a administradores y superadmin
                $detailPays = Pay_invoice_payment_method::get();
            } else {
                //Consulta para mostrar Pagos a gastos a roles 3 -4 -5
                $detailPays = Pay_invoice_payment_method::where('branch_id', $user->branch_id)->where('user_id', $user->id)->get();
            }

            return DataTables::of($detailPays)

            ->addIndexColumn()

            ->addColumn('paymentMethod', function (Pay_invoice_payment_method $pppm) {
                return $pppm->paymentMethod->name;
            })
            ->addColumn('bank', function (Pay_invoice_payment_method $pppm) {
                return $pppm->bank->name;
            })
            ->addColumn('card', function (Pay_invoice_payment_method $pppm) {
                return $pppm->card->name;
            })
            ->addColumn('payment_id', function (Pay_invoice_payment_method $pppm) {
                $paymen = $pppm->payment_id;
                if ($paymen) {
                    return $pppm->payment_id;
                } else {
                    return 'N/A';
                }

            })
            ->editColumn('created_at', function(Pay_invoice_payment_method $pppm){
                return $pppm->created_at->format('yy-m-d: h:m');
            })
            ->make(true);
        }
        return view('admin.pay_invoice.detail_pay');

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
        $invoice = Invoice::where('id', $request->session()->get('invoice'))->first();
        $custom = $invoice->customer->id;
        $advances = Advance::where('status', '!=', 'aplicado')->where('customer_id', $custom)->get();

        return view('admin.pay_invoice.create', compact('invoice', 'banks', 'payment_methods', 'cards', 'advances'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePayinvoiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePayinvoiceRequest $request)
    {
        try{
            DB::beginTransaction();
            $user = Auth::user();
            $invoice = Invoice::where('id', '=', $request->session()->get('invoice'))->first();
            $balance = $invoice->balance;
            $total = $request->total;

            $pay_invoice = new Pay_invoice();
            $pay_invoice->user_id = $user->id;
            $pay_invoice->branch_id = $user->branch_id;
            $pay_invoice->invoice_id = $invoice->id;
            $pay_invoice->pay = $total;
            $pay_invoice->balance_invoice = $balance - $total;
            $pay_invoice->save();

            $cont = 0;
            $payment_method = $request->payment_method_id;
            $bank = $request->bank_id;
            $card = $request->card_id;
            $advance_id = $request->advance_id;
            $pay = $request->pay;
            $transaction = $request->transaction;
            $adv = $request->advance;

            if ($adv != 0) {

                $advance = Advance::findOrFail( $request->advance_id);
                $adv_total = $advance->balance - $adv;

                $advance->destination = $invoice->id;
                if ($adv_total == 0) {
                    $advance->status = 'aplicado';
                } else {
                    $advance->status = 'parcial';
                }
                $advance->balance = $adv_total;
                $advance->update();
            }

            while($cont < count($payment_method)){
                $pay = $request->pay[$cont];
                $pay_invoice_payment_method = new Pay_invoice_payment_method();
                $pay_invoice_payment_method->pay_invoice_id = $pay_invoice->id;
                $pay_invoice_payment_method->payment_method_id = $payment_method[$cont];
                $pay_invoice_payment_method->bank_id = $bank[$cont];
                $pay_invoice_payment_method->card_id = $card[$cont];
                if (isset($advance_id[$cont])){
                    $pay_invoice_payment_method->advance_id = $advance_id[$cont];
                }
                $pay_invoice_payment_method->payment = $pay;
                $pay_invoice_payment_method->transaction = $transaction[$cont];
                $pay_invoice_payment_method->save();

                $mp = $payment_method[$cont];
                $sale_box = Sale_box::where('user_id', $user->id)->where('status', 'open')->first();
                if($mp == 10){
                    $sale_box->in_invoice_cash += $pay;
                    $sale_box->cash += $pay;
                }
                $sale_box->in_invoice += $pay;
                $sale_box->in_total += $pay;
                $sale_box->update();

                $cont++;
            }
            $invoic = Invoice::findOrFail($invoice->id);
            $invoic->pay += $total;
            $invoic->balance -= $total;
            $invoic->update();

            $pay_invoices = Pay_invoice::findOrFail($pay_invoice->id);
            $pay_invoices->balance_invoice = $balance-$total;
            $pay_invoices->update();

            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
        }
        return redirect('pay_invoice');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pay_invoice  $pay_invoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payInvoice = Pay_invoice::where('id', $id)->first();
        $pay_invoice_payment_methods = Pay_invoice_payment_method::where('pay_invoice_id', $payInvoice->id)->get();

        return view('admin.pay_invoice.show', compact('payInvoice', 'pay_invoice_payment_methods'));
    }

    public function pdf_pay_invoice(Request $request, $id)
    {
        $payInvoice = Pay_invoice::findOrFail($id);
        $company = Company::where('id', 1)->first();
        $user = auth::user();
        $payInvoice_PaymentMethods = Pay_invoice_payment_method::where('pay_invoice_id', $payInvoice->id)->get();

        $pdfPayInvoice = "ABONO-". $payInvoice->id;
        $logo = './imagenes/logos'.$company->logo;
        $view = \view('admin.pay_invoice.pdf', compact('payInvoice_PaymentMethods', 'company', 'logo', 'user', 'payInvoice'));
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        //$pdf->setPaper ( 'A7' , 'landscape' );

        return $pdf->stream('vista-pdf', "$pdfPayInvoice.pdf");
        //return $pdf->download("$invoicepdf.pdf");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pay_invoice  $pay_invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Pay_invoice $pay_invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePayinvoiceRequest  $request
     * @param  \App\Models\Pay_invoice  $pay_invoice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePayinvoiceRequest $request, Pay_invoice $pay_invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pay_invoice  $pay_invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pay_invoice $pay_invoice)
    {
        //
    }

    public function pdf_payinvoice(Request $request, $id)
    {
        $payInvoice = Pay_invoice::findOrFail($id);
        $company = Company::where('id', 1)->first();
        $user = auth::user();
        $pay_invoice_payment_methods = Pay_invoice_payment_method::where('pay_invoice_id', $payInvoice->id)->get();

        $pdfPayInvoice = "FACT-". $payInvoice->id;
        $logo = './imagenes/logos'.$company->logo;
        $view = \view('admin.pay_invoice.pdf', compact('payInvoice_paymentMethods', 'company', 'logo', 'cashReceipt', 'user'));
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        //$pdf->setPaper ( 'A7' , 'landscape' );

        return $pdf->stream('vista-pdf', "$pdfPayInvoice.pdf");
        //return $pdf->download("$invoicepdf.pdf");
    }
}

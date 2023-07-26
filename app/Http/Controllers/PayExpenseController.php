<?php

namespace App\Http\Controllers;

use App\Models\Pay_expense;
use App\Http\Requests\StorePay_expenseRequest;
use App\Http\Requests\UpdatePay_expenseRequest;
use App\Models\Bank;
use App\Models\Card;
use App\Models\Company;
use App\Models\Expense;
use App\Models\Pay_expense_payment_method;
use App\Models\Payment;
use App\Models\Payment_method;
use App\Models\Sale_box;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PayExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($request->ajax()) {
            //Muestra todas las Pagos a gastos de la empresa
            if ($user->role_id == 1 || $user->role_id == 2) {

                //Consulta para mostrar pagos a gastos a administradores y superadmin
                $payExpenses = Pay_expense::get();
            } else {
                //Consulta para mostrar Pagos a gastos a roles 3 -4 -5
                $payExpenses = Pay_expense::where('branch_id', $user->branch_id)->where('user_id', $user->id)->get();
            }

            return DataTables::of($payExpenses)

            ->addIndexColumn()
            ->addColumn('document', function (Pay_expense $payExpense) {
                return $payExpense->expense->document;
            })
            ->addColumn('expense', function (Pay_expense $payExpense) {
                return $payExpense->expense->id;
            })
            ->addColumn('supplier', function (Pay_expense $payExpense) {
                return $payExpense->expense->supplier->name;
            })
            ->addColumn('branch', function (Pay_expense $payExpense) {
                return $payExpense->branch->name;
            })
            ->addColumn('user', function (Pay_expense $payExpense) {
                return $payExpense->user->name;
            })
            ->addColumn('totalPay', function (Pay_expense $payExpense) {
                return $payExpense->expense->total_pay;
            })
            ->editColumn('created_at', function(Pay_expense $payExpense){
                return $payExpense->created_at->format('yy-m-d: h:m');
            })
            ->addColumn('btn', 'admin/pay_expense/actions')
            ->rawColumns(['btn'])
            ->make(true);
        }
        return view('admin.pay_expense.index');
    }
    public function detailPay(Request $request)
    {
        $user = Auth::user();
        if ($request->ajax()) {
            //Muestra todas las Pagos a gastos de la empresa
            if ($user->role_id == 1 || $user->role_id == 2) {

                //Consulta para mostrar pagos a gastos a administradores y superadmin
                $detailPays = Pay_expense_payment_method::get();
            } else {
                //Consulta para mostrar Pagos a gastos a roles 3 -4 -5
                $detailPays = Pay_expense_payment_method::where('branch_id', $user->branch_id)->where('user_id', $user->id)->get();
            }

            return DataTables::of($detailPays)

            ->addIndexColumn()

            ->addColumn('paymentMethod', function (Pay_expense_payment_method $pppm) {
                return $pppm->paymentMethod->name;
            })
            ->addColumn('bank', function (Pay_expense_payment_method $pppm) {
                return $pppm->bank->name;
            })
            ->addColumn('card', function (Pay_expense_payment_method $pppm) {
                return $pppm->card->name;
            })
            ->addColumn('payment_id', function (Pay_expense_payment_method $pppm) {
                $paymen = $pppm->payment_id;
                if ($paymen) {
                    return $pppm->payment_id;
                } else {
                    return 'N/A';
                }

            })
            ->editColumn('created_at', function(Pay_expense_payment_method $pppm){
                return $pppm->created_at->format('yy-m-d: h:m');
            })
            ->make(true);
        }
        return view('admin.pay_expense.detail_pay');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $banks = Bank::get();
        $payment_methods = Payment_method::get();
        $cards = Card::get();
        $expense = Expense::where('id', '=', $request->session()->get('expense'))->first();
        $payments = Payment::where('status', '!=', 'aplicado')->where('supplier_id', $expense->supplier->id)->get();

        return view('admin.pay_expense.create', compact('expense', 'banks', 'payment_methods', 'cards', 'payments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePay_expenseRequest $request)
    {
        try{
            DB::beginTransaction();
            $user = Auth::user();
            $expense = Expense::where('id', '=', $request->session()->get('expense'))->first();
            $balance = $expense->balance;
            $total = $request->total;

            $pay_expense = new Pay_expense();
            $pay_expense->user_id = $user->id;
            $pay_expense->branch_id = $user->branch_id;
            $pay_expense->expense_id = $expense->id;
            $pay_expense->pay = $total;
            $pay_expense->balance_expense = $balance - $total;
            $pay_expense->save();

            $cont = 0;
            $payment_method = $request->payment_method_id;
            $bank           = $request->bank_id;
            $card           = $request->card_id;
            $payment_id     = $request->payment_id;
            $pay            = $request->pay;
            $transaction    = $request->transaction;
            $payu           = $request->payment;
            if ($payu != 0) {
                $payment = Payment::findOrFail( $request->payment_id);
                $payu_total = $payment->balance - $payu;

                $payment->destination = $expense->id;
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
                $pay_expense_payment_method = new Pay_expense_payment_method();
                $pay_expense_payment_method->pay_expense_id = $pay_expense->id;
                $pay_expense_payment_method->payment_method_id = $payment_method[$cont];
                $pay_expense_payment_method->bank_id = $bank[$cont];
                $pay_expense_payment_method->card_id = $card[$cont];
                if (isset($payment_id[$cont])){
                    $pay_expense_payment_method->payment_id = $payment_id[$cont];
                }
                $pay_expense_payment_method->payment = $pay[$cont];
                $pay_expense_payment_method->transaction = $transaction[$cont];
                $pay_expense_payment_method->save();

                $mp = $request->payment_method_id;

                $sale_box = Sale_box::where('user_id', '=', $user->id)
                ->where('status', '=', 'open')
                ->first();
                if (isset($sale_box)) {
                    if($mp == 10){
                        $sale_box->out_expense_cash += $paymentLine;
                        $sale_box->departure += $paymentLine;
                    }

                    //$sale_box = Sale_box::findOrFail($boxy->id);
                    $sale_box->out_expense += $paymentLine;
                    $sale_box->out_total += $paymentLine;
                    $sale_box->update();
                }

                $cont++;
            }

            $expens = Expense::findOrFail($expense->id);
            $expens->balance = $balance-$total;
            $expens->update();

            $pay_expenses = Pay_expense::findOrFail($pay_expense->id);
            $pay_expenses->balance_expense = $balance-$total;
            $pay_expenses->update();

            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
        }
        return redirect('pay_expense');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pay_expense $pay_expense)
    {
        $payExpense = pay_expense::where('id', $pay_expense->id)->first();
        $payExpense_paymentMethods = Pay_expense_payment_method::where('pay_expense_id', $payExpense->id)->get();

        return view('admin.pay_expense.show', compact('payExpense', 'payExpense_paymentMethods'));
    }

    public function pdfPayExpense(Request $request, $id)
    {
        $payExpense = pay_expense::findOrFail($id);
        $company = Company::where('id', 1)->first();
        $user = auth::user();
        $payExpense_PaymentMethods = Pay_expense_payment_method::where('pay_expense_id', $payExpense->id)->get();

        $pdfPayExpense = "ABONO-". $payExpense->id;
        $logo = './imagenes/logos'.$company->logo;
        $view = \view('admin.pay_expense.pdf', compact('payExpense_PaymentMethods', 'company', 'logo', 'user', 'payExpense'));
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        //$pdf->setPaper ( 'A7' , 'landscape' );

        return $pdf->stream('vista-pdf', "$pdfPayExpense.pdf");
        //return $pdf->download("$invoicepdf.pdf");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pay_expense $pay_expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePay_expenseRequest $request, Pay_expense $pay_expense): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pay_expense $pay_expense)
    {
        //
    }
}

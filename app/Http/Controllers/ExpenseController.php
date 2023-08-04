<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\Card;
use App\Models\Company;
use App\Models\Document;
use App\Models\Expense_service;
use App\Models\Pay_expense;
use App\Models\Pay_expense_payment_method;
use App\Models\Payment_form;
use App\Models\Payment_method;
use App\Models\Sale_box;
use App\Models\Service;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expense = session('expense');
        $user = Auth::user();
        if (request()->ajax()) {
            if ($user->role_id == 1 || $user->role_id == 2) {
                $expenses = Expense::get();
            } else {
                $expenses = Expense::where('branch_id', $user->branch_id)->where('user_id', $user->id)->get();
            }
            //Muestra todas las compras de la empresa
            //$expenses = Expense::get();

            return DataTables::of($expenses)
            ->addIndexColumn()
            ->addColumn('supplier', function (Expense $expense) {
                return $expense->supplier->name;
            })
            ->addColumn('branch', function (Expense $expense) {
                return $expense->branch->name;
            })
            ->editColumn('created_at', function(Expense $expense){
                return $expense->created_at->format('yy-m-d: h:m');
            })
            ->addColumn('btn', 'admin/expense/actions')
            ->rawColumns(['btn'])
            ->make(true);
        }
        return view('admin.expense.index', compact('expense'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $documents = Document::get();
        $suppliers = Supplier::get();
        $payment_forms = Payment_form::get();
        $payment_methods = Payment_method::get();
        $banks = Bank::get();
        $cards = Card::get();
        $branchs = Branch::get();
        $services = Service::get();

        return view('admin.expense.create', compact(
            'documents',
            'suppliers',
            'payment_forms',
            'payment_methods',
            'banks',
            'cards',
            'branchs',
            'services'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseRequest $request)
    {
        //Crea un registro de compras

        $service_id = $request->service_id;
        $quantity   = $request->quantity;
        $price      = $request->price;
        $inc        = $request->inc;
        $pay        = $request->pay;
        $branch     = $request->session()->get('branch');

        $expense = new Expense();
        $expense->user_id     = Auth::user()->id;
        $expense->branch_id   = $branch;
        $expense->supplier_id = $request->supplier_id;
        $expense->payment_form_id = $request->payment_form_id;
        $expense->payment_method_id = $request->payment_method_id;
        $expense->total       = $request->total;
        $expense->total_inc    = $request->total_inc;
        $expense->total_pay    = $request->total_pay;
        $expense->pay           = $request->pay;
        $expense->pay         = $pay;
        $expense->balance     = $request->total_pay - $pay;
        $expense->note    = $request->note;
        $expense->save();

        $sale_box = Sale_box::where('user_id', '=', $expense->user_id)->where('status', '=', 'open')->first();
        $sale_box->expense += $expense->total_pay;
        $sale_box->out_total += $expense->pay;
        $sale_box->update();

        if($pay > 0){

            //si no hay pago anticipado se crea un pago a compra
            $pay_expense                   = new Pay_expense();
            $pay_expense->pay              = $pay;
            $pay_expense->balance_expense = $expense->balance;
            $pay_expense->user_id          = $expense->user_id;
            $pay_expense->branch_id        = $expense->branch_id;
            $pay_expense->expense_id      = $expense->id;
            $pay_expense->save();
            //metodo que registra el pago a compra y el methodo de pago
            $pay_expense_Payment_method                     = new Pay_expense_payment_method();
            $pay_expense_Payment_method->pay_expense_id    = $pay_expense->id;
            $pay_expense_Payment_method->payment_method_id  = $request->payment_method_id;
            $pay_expense_Payment_method->bank_id            = $request->bank_id;
            $pay_expense_Payment_method->card_id            = $request->card_id;
            $pay_expense_Payment_method->payment            = $pay;
            $pay_expense_Payment_method->transaction        = $request->transaction;
            $pay_expense_Payment_method->save();

            $mp = $request->payment_method_id;

            $sale_box = Sale_box::where('user_id', '=', $expense->user_id)->where('status', '=', 'open')->first();
            if($mp == 10){
                $sale_box->out_expense_cash += $pay;
                $sale_box->departure += $pay;
            }
            $sale_box->out_expense += $pay;
            $sale_box->update();

        }

        //Toma el Request del array

        $cont = 0;
        //Ingresa los productos que vienen en el array
        while($cont < count($service_id)){
            $subtotal = $quantity[$cont] * $price[$cont];
            $incsub = $subtotal * $inc[$cont]/100;
            $servid = $service_id[$cont];

            $expense_service = new Expense_service();
            $expense_service->expense_id = $expense->id;
            $expense_service->service_id  = $service_id[$cont];
            $expense_service->quantity    = $quantity[$cont];
            $expense_service->price       = $price[$cont];
            $expense_service->inc         = $inc[$cont];
            $expense_service->subtotal    = $subtotal;
            $expense_service->incsubt     = $incsub;
            $expense_service->save();
            //selecciona el producto que viene del array
            $service = Service::where('id', $expense_service->service_id)->first();


            $cont++;
        }
        session(['expense' => $expense->id]);

        toast('Gasto Registrado satisfactoriamente.','success');
        return redirect('expense');
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        $expenseServices = Expense_service::where('expense_id', $expense->id)->get();

        return view('admin.expense.show', compact('expense', 'expenseServices'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        $suppliers = Supplier::get();
        $payment_forms = Payment_form::get();
        $payment_methods = Payment_method::get();
        $banks = Bank::get();
        $cards = Card::get();
        $branches = Branch::get();
        $services = Service::where('status', 'activo')->get();
        $expenseServices = Expense_service::from('expense_services as es')
        ->join('services as ser', 'es.service_id', 'ser.id')
        ->join('expenses as exp', 'es.expense_id', 'exp.id')
        ->select('ser.id', 'ser.name', 'es.quantity', 'es.price', 'es.inc', 'es.subtotal', 'exp.balance')
        ->where('exp.id', $expense->id)
        ->get();

        $payExpenses = Pay_expense::where('expense_id', $expense->id)->sum('pay');

        return view('admin.expense.edit',
        compact(
            'expense',
            'suppliers',
            'payment_forms',
            'payment_methods',
            'banks',
            'cards',
            'branches',
            'services',
            'expenseServices',
            'payExpenses'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        //llamado a variables
        $service_id = $request->service_id;
        $quantity   = $request->quantity;
        $price      = $request->price;
        $inc        = $request->inc;
        $pay        = $request->pay;
        $total_pay = $request->total_pay;
        //llamado de todos los pagos y pago nuevo para la diferencia
        $payOld = Pay_expense::where('expense_id', $expense->id)->sum('pay');
        $payNew = $pay;
        $payTotal = $payNew + $payOld;
        $date1 = Carbon::now()->toDateString();
        $date2 = Expense::find($expense->id)->created_at->toDateString();

        if ($date1 == $date2) {
            //actualizar la caja
            $sale_box = Sale_box::where('user_id', '=', $expense->user_id)->where('status', '=', 'open')->first();
            $sale_box->expense -= $expense->total_pay;
            $sale_box->update();
        }

        //Actualizando un registro de compras
        $expense->user_id     = Auth::user()->id;
        $expense->branch_id   = Auth::user()->branch_id;
        $expense->supplier_id = $request->supplier_id;
        $expense->payment_form_id = $request->payment_form_id;
        $expense->payment_method_id = $request->payment_method_id;
        $expense->total       = $request->total;
        $expense->total_inc    = $request->total_inc;
        $expense->total_pay    = $request->total_pay;

        if ($payOld > 0 && $pay == 0) {
            $expense->pay = $payOld;
        } elseif ($payOld > 0 && $pay > 0) {
            $expense->pay = $pay + $payOld;
        } elseif ($payOld == 0 && $pay > 0) {
            $expense->pay = $pay;
        } else {
            $expense->pay = $pay;
        }

        if ($payOld > $total_pay) {
            $expense->balance = 0;
        } else {
            $expense->balance = $total_pay - $payTotal;
        }
        $expense->update();

        if ($date1 == $date2) {
            //actualizar la caja
            $sale_box = Sale_box::where('user_id', '=', $expense->user_id)->where('status', 'open')->first();
            $sale_box->expense += $expense->total_pay;
            $sale_box->out_total += $expense->pay;
            $sale_box->update();
        }
        //inicio proceso si hay pagos
        if($payTotal > 0){

            //si no hay pago anticipado se crea un pago a compra
            $pay_expense                   = new Pay_expense();
            $pay_expense->pay              = $pay;
            $pay_expense->balance_expense = $expense->balance;
            $pay_expense->user_id          = $expense->user_id;
            $pay_expense->branch_id        = $expense->branch_id;
            $pay_expense->expense_id      = $expense->id;
            $pay_expense->save();
            //metodo que registra el pago a compra y el methodo de pago
            $pay_expense_Payment_method                     = new Pay_expense_payment_method();
            $pay_expense_Payment_method->pay_expense_id    = $pay_expense->id;
            $pay_expense_Payment_method->payment_method_id  = $request->payment_method_id;
            $pay_expense_Payment_method->bank_id            = $request->bank_id;
            $pay_expense_Payment_method->card_id            = $request->card_id;
            $pay_expense_Payment_method->payment            = $pay;
            $pay_expense_Payment_method->transaction        = $request->transaction;
            $pay_expense_Payment_method->save();

            $mp = $request->payment_method_id;
            //metodo para actualizar la caja
            $sale_box = Sale_box::where('user_id', '=', $expense->user_id)->where('status', '=', 'open')->first();
            if($mp == 10){
                $sale_box->out_expense_cash += $pay;
                $sale_box->departure += $pay;
            }
            $sale_box->out_expense += $pay;
            $sale_box->update();
        }

        $expenseServices = Expense_service::where('expense_id', $expense->id)->get();
        foreach ($expenseServices as $key => $expenseService) {

            $expenseService->quantity    = 0;
            $expenseService->price       = 0;
            $expenseService->inc         = 0;
            $expenseService->subtotal    = 0;
            $expenseService->incsubt     = 0;
            $expenseService->update();

        }

        //Toma el Request del array

        $cont = 0;
        //Ingresa los productos que vienen en el array
        while($cont < count($service_id)){

            $expenseService = Expense_service::where('expense_id', $expense->id)
            ->where('service_id', $service_id[$cont])->first();
            //Inicia proceso actualizacio product expense si no existe
            if (is_null($expenseService)) {
                $subtotal = $quantity[$cont] * $price[$cont];
                $incsub = $subtotal * $inc[$cont]/100;
                $expense_service = new Expense_service();
                $expense_service->expense_id = $expense->id;
                $expense_service->service_id  = $service_id[$cont];
                $expense_service->quantity    = $quantity[$cont];
                $expense_service->price       = $price[$cont];
                $expense_service->inc         = $inc[$cont];
                $expense_service->subtotal    = $subtotal;
                $expense_service->incsubt     = $incsub;
                $expense_service->save();
            } else {
                if ($quantity[$cont] > 0) {

                    $subtotal = $quantity[$cont] * $price[$cont];
                    $incsub = $subtotal * $inc[$cont]/100;

                    if ($expenseService->quantity > 0) {
                        $expenseService->quantity    += $quantity[$cont];
                        $expenseService->price       = $price[$cont];
                        $expenseService->inc         = $inc[$cont];
                        $expenseService->subtotal    += $subtotal;
                        $expenseService->incsubt     += $incsub;
                        $expenseService->update();
                    } else {
                        $expenseService->quantity    = $quantity[$cont];
                        $expenseService->price       = $price[$cont];
                        $expenseService->inc         = $inc[$cont];
                        $expenseService->subtotal    = $subtotal;
                        $expenseService->incsubt     = $incsub;
                        $expenseService->update();
                    }
                }
            }

            $cont++;
        }
        session(['expense' => $expense->id]);
        if ($payOld > $total_pay) {
            Alert::success('Compra','Editada Satisfactoriamente. Con creacion de anticipo de Proveedor');
            return redirect('expense');

        } else {
            return redirect("expense")->with('success', 'Compra Editada Satisfactoriamente');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        //
    }

    public function pdf_payexpense(Request $request, $id)
    {
        $expense = Expense::where('id', $id)->first();
        $company = Company::where('id', 1)->first();
        $user = auth::user();
        $expense_services = Expense_service::where('pay_expense_id', $id)->get();
        $expensepdf = "FACT-". $expense->id;
        $logo = './imagenes/logos'.$company->logo;
        $view = \view('admin.pay_expense.pdf', compact('expense', 'company', 'logo', 'user'))->render();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        //$pdf->setPaper ( 'A7' , 'landscape' );

        return $pdf->stream('vista-pdf', "$expensepdf.pdf");
        //return $pdf->download("$invoicepdf.pdf");
    }

    public function show_pay_expense(Request $request, $id)
     {
        $banks = Bank::get();
        $payment_methods = Payment_method::get();
        $cards = Card::get();
        $expense = Expense::where('id', '=', $request->session()->get('expense'))->first();

        $expense = Expense::findOrFail($id);
        \session()->put('expense', $expense->id, 60 * 24 * 365);
        \session()->put('due_date', $expense->due_date, 60 * 24 *365);
        \session()->put('total', $expense->total, 60 * 24 *365);
        \session()->put('total_inc', $expense->total_inc, 60 * 24 *365);
        \session()->put('total_pay', $expense->total_Pay, 60 * 24 *365);
        \session()->put('status', $expense->status, 60 * 24 *365);

        return view('admin.pay_expense.create', compact('expense', 'banks', 'payment_methods', 'cards'));
     }

    public function expensePdf(Request $request, $id)
    {
        $expense = Expense::findOrFail($id);
        $expense_service = Expense_service::where('expense_id', $id)->get();
        $company = Company::findOrFail(1);
        $logo = './imagenes/logos'.$company->logo;

        $expensepdf = "COMP-". $expense->expense;
        $view = \view('admin.expense.pdf', compact('expense', 'expense_service', 'company', 'logo'));
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        //$pdf->setPaper ( 'A7' , 'landscape' );

        return $pdf->stream('vista-pdf', "$expensepdf.pdf");
        //return $pdf->download("$expensepdf.pdf");
    }

    public function pdfExpense()
    {
        $expenses = session('expense');
        $expense = Expense::findOrFail($expenses);
        session()->forget('expense');
        $expense_service = Expense_service::where('expense_id', $expense->id)->get();
        $company = Company::findOrFail(1);
        $logo = './imagenes/logos'.$company->logo;

        $expensepdf = "COMP-". $expense->expense;
        $view = \view('admin.expense.pdf', compact('expense', 'expense_service', 'company', 'logo'));
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        //$pdf->setPaper ( 'A7' , 'landscape' );

        return $pdf->stream('vista-pdf', "$expensepdf.pdf");
        //return $pdf->download("$expensepdf.pdf");
    }

    public function expensePost(Request $request, $id)
    {
        $expense = Expense::where('id', $id)->first();
        $expense_services = Expense_service::where('expense_id', $id)->get();
        $company = Company::findOrFail(1);
        $days = $expense->created_at->diffInDays($expense->fecven);
        $expensepdf = "FACT-". $expense->document;
        $logo = './imagenes/logos'.$company->logo;
        $view = \view('admin.expense.post', compact('expense', 'expense_services', 'company', 'logo'))->render();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        $pdf->setPaper (array(0,0,226.76,497.64), 'portrait');

        return $pdf->stream('vista-pdf', "$expensepdf.pdf");
        //return $pdf->download("$expensepdf.pdf");
    }

    public function postExpense()
    {
        $expenses = session('expense');
        $expense = Expense::findOrFail($expenses);
        session()->forget('expense');
        $expense_services = Expense_service::where('expense_id', $expense->id)->get();
        $company = Company::findOrFail(1);
        $logo = './imagenes/logos'.$company->logo;

        $expensepdf = "FACT-". $expense->document;
        $view = \view('admin.expense.post', compact('expense', 'expense_services', 'company', 'logo'))->render();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        $pdf->setPaper (array(0,0,226.76,497.64), 'portrait');

        return $pdf->stream('vista-pdf', "$expensepdf.pdf");
        //return $pdf->download("$expensepdf.pdf");
    }
}

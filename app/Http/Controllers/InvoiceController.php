<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\Bank;
use App\Models\Branch_product;
use App\Models\Card;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Document;
use App\Models\Invoice_product;
use App\Models\InvoiceMenu;
use App\Models\Kardex;
use App\Models\Menu;
use App\Models\MenuProduct;
use App\Models\Pay_invoice;
use App\Models\Pay_invoice_payment_method;
use App\Models\Payment_form;
use App\Models\Payment_method;
use App\Models\Product;
use App\Models\RestaurantTable;
use App\Models\Sale_box;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $user = Auth::user();
        if (request()->ajax()) {
            if ($user->role_id == 1 || $user->role_id == 2) {
                $invoices = Invoice::get();
            } else {
                $invoices = Invoice::where('branch_id', $user->branch_id)->where('user_id', $user->id)->get();
            }
            return DataTables::of($invoices)
            ->addIndexColumn()
            ->addColumn('customer', function (Invoice $invoice) {
                return $invoice->customer->name;
            })
            ->addColumn('branch', function (Invoice $invoice) {
                return $invoice->branch->name;
            })
            ->editColumn('created_at', function(Invoice $invoice){
                return $invoice->created_at->format('yy-m-d: h:m');
            })
            ->addColumn('btn', 'admin/invoice/actions')
            ->rawColumns(['btn'])
            ->make(true);
        }
        return view('admin.invoice.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $documents = Document::get();
        $customers = Customer::get();
        $payment_forms = Payment_form::get();
        $payment_methods = Payment_method::get();
        $banks = Bank::get();
        $cards = Card::get();
        $menus = Menu::get();
        $restaurantTables = RestaurantTable::get();
        return view('admin.invoice.create', compact(
            'documents',
            'customers',
            'payment_forms',
            'payment_methods',
            'banks',
            'cards',
            'menus',
            'restaurantTables'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreInvoiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoiceRequest $request)
    {
        try{
            DB::beginTransaction();
            /*$indicator   = Indicator::where('id', '=', 1)->first();
            $number      = $indicator->from;*/
            $inv      = count(Invoice::get());
            $inv ++;

            $menu_id = $request->menu_id;
            $quantity   = $request->quantity;
            $price      = $request->price;
            $iva        = $request->iva;
            $total_pay = $request->total_Pay;

            $invoice                    = new Invoice();
            $invoice->user_id           = Auth::user()->id;
            $invoice->branch_id         = Auth::user()->branch_id;
            $invoice->customer_id       = $request->customer_id;
            $invoice->payment_form_id   = $request->payment_form_id;
            $invoice->payment_method_id = $request->payment_method_id;
            $invoice->restaurant_table_id = $request->restaurant_table_id;
            $invoice->total             = $request->total;
            $invoice->total_iva         = $request->total_iva;
            $invoice->total_pay         = $total_pay;
            $invoice->pay               = $total_pay;
            $invoice->balance           = 0;
            $invoice->save();

            $sale_box = Sale_box::where('user_id', '=', $invoice->user_id)->where('status', '=', 'open')->first();
            $sale_box->invoice += $invoice->total_pay;
            $sale_box->in_total += $invoice->pay;
            $sale_box->update();


            $pay_invoice                  = new Pay_invoice();
            $pay_invoice->pay             = $total_pay;
            $pay_invoice->user_id         = $invoice->user_id;
            $pay_invoice->branch_id       = $invoice->branch_id;
            $pay_invoice->invoice_id      = $invoice->id;
            $pay_invoice->save();

            $pay_invoice_Payment_method  = new Pay_invoice_payment_method();
            $pay_invoice_Payment_method->pay_invoice_id     = $pay_invoice->id;
            $pay_invoice_Payment_method->payment_method_id  = $request->payment_method_id;
            $pay_invoice_Payment_method->bank_id            = $request->bank_id;
            $pay_invoice_Payment_method->card_id            = $request->card_id;
            $pay_invoice_Payment_method->transaction        = $request->transaction;
            $pay_invoice_Payment_method->payment            = $total_pay;
            $pay_invoice_Payment_method->save();

            $mp = $request->payment_method_id;
            //metodo para actualizar la caja
            $sale_box = Sale_box::where('user_id', '=', $invoice->user_id)->where('status', '=', 'open')->first();
            if($mp == 10){
                $sale_box->in_invoice_cash += $total_pay;
                $sale_box->cash += $total_pay;
            }
            $sale_box->in_invoice += $total_pay;
            $sale_box->update();

            $cont = 0;

            while($cont < count($menu_id)){

                $subtotal = $quantity[$cont] * $price[$cont];
                $ivasub   = $subtotal * $iva[$cont]/100;

                $invoiceMenu = new InvoiceMenu();
                $invoiceMenu->invoice_id = $invoice->id;
                $invoiceMenu->menu_id = $menu_id[$cont];
                $invoiceMenu->quantity   = $quantity[$cont];
                $invoiceMenu->price      = $price[$cont];
                $invoiceMenu->iva        = $iva[$cont];
                $invoiceMenu->subtotal   = $subtotal;
                $invoiceMenu->ivasubt    = $ivasub;
                $invoiceMenu->save();

                $menuProducts = MenuProduct::where('menu_id', $menu_id[$cont])->get();
                foreach ($menuProducts as $key => $menuProduct) {
                    $menuProductQuantity = $menuProduct->quantity;
                    $quantityTotal = $menuProductQuantity * $quantity[$cont];
                    $product = Product::findOrFail($menuProduct->product_id);
                    $product->stock -= $quantityTotal;
                    $product->update();

                    $kardex = new Kardex();
                    $kardex->product_id = $product->id;
                    $kardex->branch_id = $invoice->branch_id;
                    $kardex->operation = 'venta';
                    $kardex->number = $invoice->id;
                    $kardex->quantity = $quantityTotal;
                    $kardex->stock = $product->stock;
                    $kardex->save();
                }
                /*
                $invoice_product = new Invoice_product();
                $invoice_product->invoice_id = $invoice->id;
                $invoice_product->product_id = $product_id[$cont];
                $invoice_product->quantity   = $quantity[$cont];
                $invoice_product->price      = $price[$cont];
                $invoice_product->iva        = $iva[$cont];
                $invoice_product->subtotal   = $subtotal;
                $invoice_product->ivasubt    = $ivasub;
                $invoice_product->save();

                //reeplazando trigger
                $product = Product::findOrFail($invoice_product->product_id);
                $product->stock -= $quantity[$cont];
                $product->update();*/

                $cont++;
            }
            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
        }

        //return redirect()->route('post', $invoice->id);
        return redirect('invoice');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {

        /*mostrar detalles*/
        $invoiceMenus = InvoiceMenu::where('invoice_id', $invoice->id)->where('quantity', '>', 0)->get();

        return view('admin.invoice.show', compact('invoice', 'invoiceMenus'));
    }

     public function edit(Invoice $invoice)
    {
        $documents = Document::get();
        $customers = Customer::get();
        $payment_forms = Payment_form::get();
        $payment_methods = Payment_method::get();
        $banks = Bank::get();
        $cards = Card::get();

        $branch_products = Branch_product::from('branch_products as bp')
        ->join('products as pro', 'bp.product_id', 'pro.id')
        ->join('categories as cat', 'pro.category_id', 'cat.id')
        ->select('bp.id', 'bp.branch_id', 'bp.stock', 'pro.id as idP', 'pro.sale_price', 'pro.name', 'cat.iva')
        ->where('bp.branch_id', $invoice->branch->id)
        ->where('bp.stock', '>', 0)
        ->where('pro.status', '=', 'activo')
        ->get();
        $invoiceProducts = Invoice_product::from('invoice_products as ip')
        ->join('products as pro', 'ip.product_id', 'pro.id')
        ->join('invoices as inv', 'ip.invoice_id', 'inv.id')
        ->join('categories as cat', 'pro.category_id', 'cat.id')
        ->select('ip.id', 'ip.quantity', 'ip.price', 'pro.stock', 'pro.id as idP', 'pro.sale_price', 'pro.name', 'cat.iva', 'inv.balance')
        ->where('invoice_id', $invoice->id)
        ->get();

        $payInvoices = Pay_invoice::where('invoice_id', $invoice->id)->sum('pay');

        return view('admin.invoice.edit', compact(
            'invoice',
            'documents',
            'customers',
            'payment_forms',
            'payment_methods',
            'banks',
            'cards',
            'branch_products',
            'invoiceProducts',
            'payInvoices'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInvoiceRequest  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        try{
            DB::beginTransaction();
            //llamado a variables
            $product_id = $request->product_id;
            $quantity   = $request->quantity;
            $price      = $request->price;
            $iva        = $request->iva;
            $pay        = $request->pay;
            $total_pay = $request->total_pay;

            //llamado de todos los pagos y pago nuevo para la diferencia
            $payOld = Pay_invoice::where('invoice_id', $invoice->id)->sum('pay');
            $payNew = $pay;
            $payTotal = $payNew + $payOld;
            $date1 = Carbon::now()->toDateString();
            $date2 = Invoice::find($invoice->id)->created_at->toDateString();
            //actualizar la caja
            if ($date1 == $date2) {
                $sale_box = Sale_box::where('user_id', '=', $invoice->user_id)->where('status', '=', 'open')->first();
                $sale_box->invoice -= $invoice->total_pay;
                $sale_box->update();
            }

            //Actualizando un registro de ventas
            $invoice->user_id           = Auth::user()->id;
            $invoice->branch_id         = Auth::user()->branch_id;
            $invoice->customer_id       = $request->customer_id;
            $invoice->payment_form_id   = $request->payment_form_id;
            $invoice->payment_method_id = $request->payment_method_id;
            $invoice->total             = $request->total;
            $invoice->total_iva         = $request->total_iva;
            $invoice->total_pay         = $total_pay;
            if ($payOld > 0 && $pay == 0) {
                $invoice->pay = $payOld;
            } elseif ($payOld > 0 && $pay > 0) {
                $invoice->pay = $pay + $payOld;
            } elseif ($payOld == 0 && $pay > 0) {
                $invoice->pay = $pay;
            } else {
                $invoice->pay = $pay;
            }
            if ($payOld > $total_pay) {
                $invoice->balance = 0;
            } else {
                $invoice->balance = $total_pay - $payTotal;
            }
            $invoice->update();

            //actualizar la caja
            if ($date1 == $date2) {
                $sale_box = Sale_box::where('user_id', '=', $invoice->user_id)->where('status', '=', 'open')->first();
                $sale_box->invoice += $invoice->total_pay;
                $sale_box->in_total += $pay;
                $sale_box->update();
            }

            //inicio proceso si hay pagos
            if($pay > 0){

                //si no hay pago anticipado se crea un pago a compra
                $pay_invoice = new Pay_invoice();
                $pay_invoice->pay = $pay;
                $pay_invoice->balance_invoice = $invoice->balance - $pay;
                $pay_invoice->user_id = $invoice->user_id;
                $pay_invoice->branch_id = $invoice->branch_id;
                $pay_invoice->invoice_id = $invoice->id;
                $pay_invoice->save();

                //metodo que registra el pago a compra y el methodo de pago
                $pay_invoice_Payment_method = new Pay_invoice_payment_method();
                $pay_invoice_Payment_method->pay_invoice_id = $pay_invoice->id;
                $pay_invoice_Payment_method->payment_method_id = $request->payment_method_id;
                $pay_invoice_Payment_method->bank_id = $request->bank_id;
                $pay_invoice_Payment_method->card_id = $request->card_id;
                $pay_invoice_Payment_method->payment = $pay;
                $pay_invoice_Payment_method->transaction = $request->transaction;
                $pay_invoice_Payment_method->save();

                $mp = $request->payment_method_id;
                //metodo para actualizar la caja
                $sale_box = Sale_box::where('user_id', '=', $invoice->user_id)->where('status', '=', 'open')->first();
                if($mp == 10){
                    $sale_box->in_invoice_cash += $pay;
                    $sale_box->cash += $pay;
                }
                $sale_box->in_invoice += $pay;
                $sale_box->update();

            }

            $invoiceProducts = Invoice_product::where('invoice_id', $invoice->id)->get();
            foreach ($invoiceProducts as $key => $invoiceProduct) {
                //selecciona el producto que viene del array
                $products = Product::where('id', $invoiceProduct->product_id)->first();
                $products->stock += $invoiceProduct->quantity;
                $products->update();

                //selecciona el producto de la sucursal que sea el mismo del array
                $branch_products = Branch_product::where('product_id', '=', $invoiceProduct->product_id)
                ->where('branch_id', '=', $invoice->branch_id)
                ->first();
                $branch_products->stock += $invoiceProduct->quantity;
                $branch_products->update();

                //Actualiza la tabla del Kardex
                $kardex = Kardex::where('operation', 'venta')->where('number', $invoice->document)->first();
                $kardex->quantity -= $invoiceProduct->quantity;
                $kardex->stock += $invoiceProduct->quantity;
                $kardex->update();

                $invoiceProduct->quantity    = 0;
                $invoiceProduct->price       = 0;
                $invoiceProduct->iva         = 0;
                $invoiceProduct->subtotal    = 0;
                $invoiceProduct->ivasubt     = 0;
                $invoiceProduct->update();
            }

            $cont = 0;

            while($cont < count($product_id)){
                $invoiceProduct = Invoice_product::where('invoice_id', $invoice->id)->where('product_id', $product_id[$cont])->first();
                $subtotal = $quantity[$cont] * $price[$cont];
                $ivasub   = $subtotal * $iva[$cont]/100;
                if (is_null($invoiceProduct)) {

                    $invoice_product = new Invoice_product();
                    $invoice_product->invoice_id = $invoice->id;
                    $invoice_product->product_id = $product_id[$cont];
                    $invoice_product->quantity = $quantity[$cont];
                    $invoice_product->price = $price[$cont];
                    $invoice_product->iva = $iva[$cont];
                    $invoice_product->subtotal = $subtotal;
                    $invoice_product->ivasubt = $ivasub;
                    $invoice_product->save();

                    $branch_products = Branch_product::where('product_id', '=', $product_id[$cont])
                    ->where('branch_id', '=', $invoice->branch_id)
                    ->first();
                    $branch_products->stock -= $quantity[$cont];
                    $branch_products->update();

                    $products = Product::findOrFail($product_id[$cont]);
                    $products->stock -= $quantity[$cont];
                    $products->update();

                    $kardex = new Kardex();
                    $kardex->product_id = $products->id;;
                    $kardex->branch_id = $invoice->branch_id;
                    $kardex->operation = 'venta';
                    $kardex->number = $invoice->id;
                    $kardex->quantity = $quantity[$cont];
                    $kardex->stock = $products->stock;
                    $kardex->save();
                } else {
                    $subtotal = $quantity[$cont] * $price[$cont];
                    $ivasub   = $subtotal * $iva[$cont]/100;
                    $item     = $cont + 1;
                    $invoiceProduct->quantity = $quantity[$cont];
                    $invoiceProduct->price = $price[$cont];
                    $invoiceProduct->iva = $iva[$cont];
                    $invoiceProduct->subtotal = $subtotal;
                    $invoiceProduct->ivasubt = $ivasub;
                    $invoiceProduct->update();
                    $item ++;

                    $branch_products = Branch_product::where('product_id', '=', $product_id[$cont])
                    ->where('branch_id', '=', $invoice->branch_id)
                    ->first();
                    $branch_products->stock -= $quantity[$cont];
                    $branch_products->update();

                    $products = Product::findOrFail($product_id[$cont]);
                    $products->stock -= $quantity[$cont];
                    $products->update();

                    $kardex = Kardex::where('operation', 'venta')->where('number', $invoice->document)->first();
                    $kardex->quantity = $quantity[$cont];
                    $kardex->stock -= $quantity[$cont];
                    $kardex->update();
                }
                $cont++;
            }
            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
        }
        return redirect("invoice")->with('success', 'Venta Editada Satisfactoriamente');
    }

    public function show_invoice($id)
     {
        $invoices = Invoice::findOrFail($id);
        \session()->put('invoice', $invoices->id, 60 * 24 * 365);
        \session()->put('company_id', $invoices->company_id, 60 * 24 *365);
        return redirect('admin/invoice/show');
     }

     public function show_pay_invoice($id)
     {

        $invoices = Invoice::findOrFail($id);
        \session()->put('invoice', $invoices->id, 60 * 24 * 365);
        \session()->put('due_date', $invoices->due_date, 60 * 24 *365);
        \session()->put('total', $invoices->total, 60 * 24 *365);
        \session()->put('total_iva', $invoices->total_iva, 60 * 24 *365);
        \session()->put('total_pay', $invoices->total_Pay, 60 * 24 *365);
        \session()->put('status', $invoices->status, 60 * 24 *365);

        return redirect('pay_invoice/create');
     }

    public function show_pdf_invoice(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoiceMenus = InvoiceMenu::where('invoice_id', $id)->where('quantity', '>', 0)->get();
        $company = Company::findOrFail(1);

        $days = $invoice->created_at->diffInDays($invoice->fecven);
        $invoicepdf = "FACT-". $invoice->document;
        $logo = './imagenes/logos'.$company->logo;
        $view = \view('admin.invoice.pdf', compact('invoice', 'days', 'invoiceMenus', 'company', 'logo'));
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        //$pdf->setPaper ( 'A7' , 'landscape' );

        return $pdf->stream('vista-pdf', "$invoicepdf.pdf", ['Attachment' => false]);
        //return $pdf->download("$invoicepdf.pdf");
    }

    public function invoicePdf(Request $request)
    {
        sleep(2);
        $inv      = count(Invoice::get());
        $invoice = Invoice::where('id', $inv)->first();
        $invoiceMenus = InvoiceMenu::where('invoice_id', $invoice->id)->where('quantity', '>', 0)->get();
        $company = Company::findOrFail(1);

        $days = $invoice->created_at->diffInDays($invoice->fecven);
        $invoicepdf = "FACT-". $invoice->document;
        $logo = './imagenes/logos'.$company->logo;
        $view = \view('admin.invoice.pdf', compact('invoice', 'days', 'invoiceMenus_products', 'company', 'logo'));
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        //$pdf->setPaper ( 'A7' , 'landscape' );

        return $pdf->stream('vista-pdf', "$invoicepdf.pdf", ['Attachment' => false]);
        //return $pdf->download("$invoicepdf.pdf");
    }

    public function post(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoiceMenus = InvoiceMenu::where('invoice_id', $id)->where('quantity', '>', 0)->get();
        $company = Company::where('id', 1)->first();

        $days = $invoice->created_at->diffInDays($invoice->fecven);
        $invoicepdf = "FACT-". $invoice->document;
        $logo = './imagenes/logos'.$company->logo;
        $view = \view('admin.invoice.post', compact('invoice', 'days', 'invoiceMenus', 'company', 'logo'))->render();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        $pdf->setPaper (array(0,0,226.76,497.64), 'portrait');

        return $pdf->stream('vista-pdf', "$invoicepdf.pdf");
        //return $pdf->download("$invoicepdf.pdf");
    }

    public function InvoicePost(Request $request)
    {
        sleep(3);
        $inv      = count(Invoice::get());
        $invoice = Invoice::where('id', $inv)->first();
        $invoiceMenus = InvoiceMenu::where('invoice_id', $invoice->id)->where('quantity', '>', 0)->get();
        $company = Company::where('id', 1)->first();

        $days = $invoice->created_at->diffInDays($invoice->fecven);
        $invoicepdf = "FACT-". $invoice->document;
        $logo = './imagenes/logos'.$company->logo;
        $view = \view('admin.invoice.post', compact('invoice', 'days', 'invoiceMenus', 'company', 'logo'))->render();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        $pdf->setPaper (array(0,0,226.76,497.64), 'portrait');

        return $pdf->stream('vista-pdf', "$invoicepdf.pdf");
        //return $pdf->download("$invoicepdf.pdf");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\Branch_product;
use App\Models\Card;
use App\Models\Company;
use App\Models\Document;
use App\Models\Kardex;
use App\Models\Municipality;
use App\Models\Pay_purchase;
use App\Models\Pay_purchase_payment_method;
use App\Models\Payment_form;
use App\Models\Payment_method;
use App\Models\Product;
use App\Models\Product_purchase;
use App\Models\Sale_box;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchase = session('purchase');
        $user = Auth::user();
        if (request()->ajax()) {
            //Muestra todas las compras de la empresa
            if ($user->role_id == 1 || $user->role_id == 2) {

                //Consulta para mostrar Purchase a administradores y superadmin
                $purchases = Purchase::get();
            } else {
                //Consulta para mostrar Purchase a roles 3 -4 -5
                $purchases = Purchase::where('branch_id', 1)->where('user_id', $user->id)->get();
            }

            return DataTables::of($purchases)
            ->addIndexColumn()
            ->addColumn('supplier', function (Purchase $purchase) {
                return $purchase->supplier->name;
            })
            ->addColumn('branch', function (Purchase $purchase) {
                return $purchase->branch->name;
            })
            ->editColumn('created_at', function(Purchase $purchase){
                return $purchase->created_at->format('yy-m-d: h:m');
            })
            ->addColumn('btn', 'admin/purchase/actions')
            ->rawColumns(['btn'])
            ->make(true);
        }
        return view('admin.purchase.index', compact('purchase'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
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
        $products = Product::where('status', 'active')->get();
        return view('admin.purchase.create',
        compact(
            'suppliers',
            'products',
            'documents',
            'suppliers',
            'payment_forms',
            'payment_methods',
            'banks',
            'cards',
            'branchs',
            'products'
        ));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorepurchaseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePurchaseRequest $request)
    {
        //llamado a variables
        $product_id = $request->product_id;
        $quantity   = $request->quantity;
        $price      = $request->price;
        $inc        = $request->inc;
        $pay        = $request->pay;

        //Crea un registro de compras
        $purchase = new Purchase();
        $purchase->user_id     = Auth::user()->id;
        $purchase->branch_id   = 1;
        $purchase->supplier_id = $request->supplier_id;
        $purchase->payment_form_id = $request->payment_form_id;
        $purchase->payment_method_id = $request->payment_method_id;
        $purchase->total       = $request->total;
        $purchase->total_inc    = $request->total_inc;
        $purchase->total_pay    = $request->total_pay;
        $purchase->pay         = $request->total_pay;
        $purchase->balance     = 0;
        $purchase->save();

        $sale_box = Sale_box::where('user_id', '=', $purchase->user_id)->where('status', '=', 'open')->first();

        $sale_box->purchase += $purchase->total_pay;
        $sale_box->out_total += $purchase->pay;
        $sale_box->update();
        //inicio proceso si hay pagos
        if($pay > 0){

            //si no hay pago anticipado se crea un pago a compra
            $pay_purchase                   = new Pay_purchase();
            $pay_purchase->pay              = $pay;
            $pay_purchase->balance_purchase = $purchase->balance;
            $pay_purchase->user_id          = $purchase->user_id;
            $pay_purchase->branch_id        = $purchase->branch_id;
            $pay_purchase->purchase_id      = $purchase->id;
            $pay_purchase->save();
            //metodo que registra el pago a compra y el methodo de pago
            $pay_purchase_Payment_method                     = new Pay_purchase_payment_method();
            $pay_purchase_Payment_method->pay_purchase_id    = $pay_purchase->id;
            $pay_purchase_Payment_method->payment_method_id  = $request->payment_method_id;
            $pay_purchase_Payment_method->bank_id            = $request->bank_id;
            $pay_purchase_Payment_method->card_id            = $request->card_id;
            $pay_purchase_Payment_method->transaction        = $request->transaction;
            $pay_purchase_Payment_method->payment            = $pay;
            $pay_purchase_Payment_method->save();

            $mp = $request->payment_method_id;

            $sale_box = Sale_box::where('user_id', '=', $purchase->user_id)->where('status', 'open')->first();
            if($mp == 10){
                $sale_box->out_purchase_cash += $pay;
                $sale_box->departure  += $pay;
            }
            $sale_box->out_purchase += $pay;
            $sale_box->update();
        }

        //Toma el Request del array

        $cont = 0;
        //Ingresa los productos que vienen en el array
        while($cont < count($product_id)){

            $product_purchase = new Product_purchase();
            $product_purchase->purchase_id = $purchase->id;
            $product_purchase->product_id  = $product_id[$cont];
            $product_purchase->quantity    = $quantity[$cont];
            $product_purchase->price       = $price[$cont];
            $product_purchase->inc         = $inc[$cont];
            $product_purchase->subtotal    = $quantity[$cont] * $price[$cont];
            $product_purchase->incsubt     =($quantity[$cont] * $price[$cont] * $inc[$cont])/100;
            $product_purchase->save();
            //selecciona el producto que viene del array
            $products = Product::where('id', $product_purchase->product_id)->first();

            //$id = $products->id;
            //$utility = $products->category->utility;
            $priceProd = $products->price;
            $stockardex = $products->stock;
            //$priceSale = $priceProd + ($priceProd * $utility / 100);
            $priceProduct = (($stockardex * $priceProd) + ($quantity[$cont] * $price[$cont])) / ($stockardex + $quantity[$cont]);
            //Cambia el valor de venta del producto
            //$product = Product::findOrFail($id);
            $products->stock += $quantity[$cont]; //reempazando triguer
            $products->price = $priceProduct;
            //$products->sale_price = $priceSale;
            $products->update();

            //selecciona el producto de la sucursal que sea el mismo del array
            $branch_products = Branch_product::where('product_id', '=', $product_purchase->product_id)
            ->where('branch_id', '=', 1)
            ->first();

            if (isset($branch_products)) {
                $id = $branch_products->id;
                $stock = $branch_products->stock + $product_purchase->quantity;
                $branch_product = Branch_product::findOrFail($id);
                $branch_product->stock = $stock;
                $branch_product->update();
            } else {
                //metodo para crear el producto en la sucursal y asignar stock
                $branch_product = new Branch_product();
                $branch_product->branch_id = 1;
                $branch_product->product_id = $product_purchase->product_id;
                $branch_product->stock = $product_purchase->quantity;
                $branch_product->order_product = 0;
                $branch_product->save();
            }

            //Actualiza la tabla del Kardex
            $kardex = new Kardex();
            $kardex->product_id = $product_id[$cont];
            $kardex->branch_id = 1;
            $kardex->operation = 'compra';
            $kardex->number = $purchase->id;
            $kardex->quantity = $quantity[$cont];
            $kardex->stock = $products->stock;
            $kardex->save();


            $cont++;
        }
        session(['purchase' => $purchase->id]);

        toast('Compra Registrada satisfactoriamente.','success');
        return redirect('purchase');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        $product_purchases = Product_purchase::where('purchase_id', $purchase->id)->where('quantity', '>', 0)->get();
        return view('admin.purchase.show', compact('purchase', 'product_purchases'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        $documents = Document::get();
        $suppliers = Supplier::get();
        $payment_forms = Payment_form::get();
        $payment_methods = Payment_method::get();
        $banks = Bank::get();
        $cards = Card::get();
        $branches = Branch::get();
        $products = Product::where('status', 'activo')->get();
        //$productPurchases = Product_purchase::where('purchase_id', $purchase->id)->get();
        $productPurchases = Product_purchase::from('product_purchases as pp')
        ->join('products as pro', 'pp.product_id', 'pro.id')
        ->join('purchases as pur', 'pp.purchase_id', 'pur.id')
        ->select('pp.id', 'pro.id as idP', 'pro.name', 'pro.stock', 'pp.quantity', 'pp.price', 'pp.inc', 'pp.subtotal')
        ->where('purchase_id', $purchase->id)
        ->get();
        return view('admin.purchase.edit',
        compact(
            'purchase',
            'documents',
            'suppliers',
            'payment_forms',
            'payment_methods',
            'banks',
            'cards',
            'branches',
            'products',
            'productPurchases'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatepurchaseRequest  $request
     * @param  \App\Models\purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatepurchaseRequest $request, purchase $purchase)
    {
        //llamado a variables
        $product_id = $request->product_id;
        $quantity   = $request->quantity;
        $price      = $request->price;
        $inc        = $request->inc;
        $pay        = $request->pay;

        $total_pay = $request->total_pay;
        $payment_method = $request->payment_method_id;

        //llamado de todos los pagos y pago nuevo para la diferencia
        $payOld = Pay_purchase::where('purchase_id', $purchase->id)->sum('pay');
        $payNew = $pay;
        $payTotal = $payNew + $payOld;
        $date1 = Carbon::now()->toDateString();
        $date2 = Purchase::find($purchase->id)->created_at->toDateString();

        //actualizar la caja
        if ($date1 == $date2) {
            $sale_box = Sale_box::where('user_id', '=', $purchase->user_id)->where('status', '=', 'open')->first();
            $sale_box->purchase -= $purchase->total_pay;
            $sale_box->update();
        }

        //Actualizando un registro de compras
        $purchase->user_id     = Auth::user()->id;
        $purchase->payment_form_id = $request->payment_form_id;
        $purchase->payment_method_id = $request->payment_method_id;
        $purchase->total       = $request->total;
        $purchase->total_inc    = $request->total_inc;
        $purchase->total_pay    = $request->total_pay;
        $purchase->pay = $request->total_pay;
        $purchase->balance = 0;
        $purchase->update();

        //actualizar la caja
        if ($date1 == $date2) {
            $sale_box = Sale_box::where('user_id', '=', $purchase->user_id)->where('status', '=', 'open')->first();
            $sale_box->purchase += $purchase->total_pay;
            //$sale_box->out_total += $purchase->total_pay;
            $sale_box->update();
        }
        //inicio proceso si hay pagos
        if($pay > 0){
            $sale_box = Sale_box::where('user_id', '=', $purchase->user_id)->where('status', '=', 'open')->first();
            $payPurchase = Pay_purchase::where('purchase_id', $purchase->id)->first();
            if (isset($payPurchase)) {
                $payPurchase->pay = $pay;
                $payPurchase->balance_purchase = 0;
                $payPurchase->update();

                $payPurchase_paymentMethod = Pay_purchase_payment_method::where('pay_purchase_id', $payPurchase->id)->first();


                $mp = $payPurchase_paymentMethod->payment_method_id;
                //metodo para actualizar la caja
                if($mp == 10){
                    $sale_box->out_purchase_cash -= $payPurchase_paymentMethod->payment;
                    $sale_box->departure -= $payPurchase_paymentMethod->payment;
                }
                $sale_box->out_purchase -= $payPurchase_paymentMethod->payment;
                $sale_box->out_total -= $payPurchase_paymentMethod->payment;
                $sale_box->update();

                $payPurchase_paymentMethod->payment = $pay;
                $payPurchase_paymentMethod->payment_method_id = $payment_method;
                $payPurchase_paymentMethod->update();

                $mp = $payment_method;
                //metodo para actualizar la caja
                if($mp == 10){
                    $sale_box->out_purchase_cash += $payPurchase_paymentMethod->payment;
                    $sale_box->departure += $payPurchase_paymentMethod->payment;
                }
                $sale_box->out_purchase += $payPurchase_paymentMethod->payment;
                $sale_box->out_total += $payPurchase_paymentMethod->payment;
                $sale_box->update();
            } else {
                //si no hay pago anticipado se crea un pago a compra
                $pay_purchase = new Pay_purchase();
                $pay_purchase->pay = $pay;
                $pay_purchase->balance_purchase = $purchase->balance - $pay;
                $pay_purchase->user_id = $purchase->user_id;
                $pay_purchase->branch_id = $purchase->branch_id;
                $pay_purchase->purchase_id = $purchase->id;
                $pay_purchase->save();

                //metodo que registra el pago a compra y el methodo de pago
                $pay_purchase_Payment_method = new Pay_purchase_payment_method();
                $pay_purchase_Payment_method->pay_purchase_id = $pay_purchase->id;
                $pay_purchase_Payment_method->payment_method_id = $request->payment_method_id;
                $pay_purchase_Payment_method->bank_id = $request->bank_id;
                $pay_purchase_Payment_method->card_id = $request->card_id;
                $pay_purchase_Payment_method->payment_id = $request->payment_id;
                $pay_purchase_Payment_method->payment = $pay;
                $pay_purchase_Payment_method->transaction = $request->transaction;
                $pay_purchase_Payment_method->save();

                $mp = $request->payment_method_id;
                //metodo para actualizar la caja
                $sale_box = Sale_box::where('user_id', '=', $purchase->user_id)->where('status', '=', 'open')->first();
                if($mp == 10){
                    $sale_box->out_purchase_cash += $pay;
                    $sale_box->departure += $pay;
                }
                $sale_box->out_purchase += $pay;
                $sale_box->out_total += $pay;
                $sale_box->update();
            }
        }

        $productPurchases = Product_purchase::where('purchase_id', $purchase->id)->get();
        foreach ($productPurchases as $key => $productPurchase) {
            //selecciona el producto que viene del array
            $products = Product::where('id', $productPurchase->product_id)->first();
            //$product = Product::findOrFail($id);
            $products->stock -= $productPurchase->quantity;
            $products->update();

            //selecciona el producto de la sucursal que sea el mismo del array
            $branch_products = Branch_product::where('product_id', '=', $productPurchase->product_id)
            ->where('branch_id', 1)
            ->first();
            $branch_products->stock -= $productPurchase->quantity;
            $branch_products->update();
            //Actualiza la tabla del Kardex
            $kardex = Kardex::where('operation', 'compra')->where('number', $purchase->id)->first();
            $kardex->quantity -= $productPurchase->quantity;
            $kardex->stock -= $productPurchase->quantity;
            $kardex->save();
            //$product_purchase->purchase_id = $purchase->id;
            //$product_purchase->product_id  = $product_id[$cont];
            $productPurchase->quantity    = 0;
            $productPurchase->price       = 0;
            $productPurchase->inc         = 0;
            $productPurchase->subtotal    = 0;
            $productPurchase->incsubt     = 0;
            $productPurchase->update();

        }

        //Toma el Request del array

        $cont = 0;
        //Ingresa los productos que vienen en el array
        while($cont < count($product_id)){
            $productPurchase = Product_purchase::where('purchase_id', $purchase->id)
            ->where('product_id', $product_id[$cont])->first();
            $subtotal = $quantity[$cont] * $price[$cont];
            $incsub   = $subtotal * $inc[$cont]/100;
            //Inicia proceso actualizacio product purchase si no existe
            if (is_null($productPurchase)) {
                $product_purchase = new Product_purchase();
                $product_purchase->purchase_id = $purchase->id;
                $product_purchase->product_id = $product_id[$cont];
                $product_purchase->quantity = $quantity[$cont];
                $product_purchase->price = $price[$cont];
                $product_purchase->inc = $inc[$cont];
                $product_purchase->subtotal = $subtotal;
                $product_purchase->incsubt = $incsub;
                $product_purchase->save();
                //selecciona el producto que viene del array
                $products = Product::where('id', $product_purchase->product_id)->first();

                //$id = $products->id;
                //$utility = $products->category->utility;
                //$priceProduct = $products->price;
                //$stockardex = $products->stock;
                //$priceSale = $priceProduct + ($priceProduct * $utility / 100);
                //Cambia el valor de venta del producto
                //$product = Product::findOrFail($id);
                $products->stock += $quantity[$cont];
                $products->update();

                //selecciona el producto de la sucursal que sea el mismo del array
                $branch_products = Branch_product::where('product_id', '=', $product_purchase->product_id)
                ->where('branch_id', 1)
                ->first();

                if (isset($branch_products)) {
                    $branch_product = Branch_product::findOrFail($branch_products->id);
                    $branch_product->stock += $quantity[$cont];
                    $branch_product->update();
                } else {
                    //metodo para crear el producto en la sucursal y asignar stock
                    $branch_product = new Branch_product();
                    $branch_product->branch_id = 1;
                    $branch_product->product_id = $product_purchase->product_id;
                    $branch_product->stock = $product_purchase->quantity;
                    $branch_product->order_product = 0;
                    $branch_product->save();
                }
                    //Actualiza la tabla del Kardex
                $kardex = new Kardex();
                $kardex->product_id = $product_id[$cont];
                $kardex->branch_id = $purchase->branch_id;
                $kardex->operation = 'compra';
                $kardex->number = $purchase->id;
                $kardex->quantity = $quantity[$cont];
                $kardex->stock += $quantity[$cont];
                $kardex->observation = 'movimiento por compra';
                $kardex->save();
            } else {
                if ($quantity[$cont] > 0) {

                    $subtotal = $quantity[$cont] * $price[$cont];
                    $incsub = $subtotal * $inc[$cont]/100;
                    $productPurchase->quantity = $quantity[$cont];
                    $productPurchase->price = $price[$cont];
                    $productPurchase->inc = $inc[$cont];
                    $productPurchase->subtotal = $subtotal;
                    $productPurchase->incsubt = $incsub;
                    $productPurchase->update();
                }
                //selecciona el producto de la sucursal que sea el mismo del array
                $branch_products = Branch_product::where('product_id', '=', $productPurchase->product_id)
                ->where('branch_id', 1)
                ->first();
                $branch_products->stock +=  $quantity[$cont];
                $branch_products->update();

                //selecciona el producto que viene del array
                $products = Product::findOrFail($product_id[$cont]);

                //$id = $products->id;
                //$utility = $products->category->utility;
                //$priceProduct = $products->price;
                //$priceSale = $priceProduct + ($priceProduct * $utility / 100);
                //Cambia el valor de venta del producto
                //$products->sale_price = $priceSale;
                $products->stock += $quantity[$cont];
                $products->update();


                //Actualiza la tabla del Kardex
                $kardex = Kardex::where('operation', 'compra')->where('number', $purchase->id)->first();
                $kardex->quantity += $quantity[$cont];
                $kardex->stock += $quantity[$cont];
                $kardex->update();
            }

            $cont++;
        }
        session(['purchase' => $purchase->id]);

        toast('Compra Editada satisfactoriamente.','success');
        return redirect('purchase');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $purchase = Purchase::findOrFail($id);
        $purchase->estado = 'credit_note';
        $purchase->save();
        return redirect('purchase');
    }



     public function show_pay_purchase($id)
     {

        $purchase = Purchase::findOrFail($id);
        \session()->put('purchase', $purchase->id, 60 * 24 * 365);
        \session()->put('total', $purchase->total, 60 * 24 *365);
        \session()->put('total_inc', $purchase->total_inc, 60 * 24 *365);
        \session()->put('total_pay', $purchase->total_Pay, 60 * 24 *365);

        return redirect('pay_purchase/create');
     }

    public function purchasePdf(Request $request, $id)
    {
        $purchase = Purchase::findOrFail($id);
        $product_purchases = Product_purchase::where('purchase_id', $id)->where('quantity', '>', 0)->get();
        $company = Company::findOrFail(1);
        $days = $purchase->created_at->diffInDays($purchase->fecven);
        $purchasepdf = "COMP-". $purchase->purchase;
        $logo = './imagenes/logos'.$company->logo;
        $view = \view('admin.purchase.pdf', compact('purchase', 'product_purchases', 'company', 'logo'));
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        //$pdf->setPaper ( 'A7' , 'landscape' );

        return $pdf->stream('vista-pdf', "$purchasepdf.pdf");
        //return $pdf->download("$purchasepdf.pdf");
    }

    public function pdfPurchase(Request $request)
    {
        $purchases = session('purchase');
        $purchase = Purchase::findOrFail($purchases);
        session()->forget('purchase');
        $product_purchases = Product_purchase::where('purchase_id', $purchase->id)->where('quantity', '>', 0)->get();
        $company = Company::findOrFail(1);

        $purchasepdf = "COMP-". $purchase->purchase;
        $logo = './imagenes/logos'.$company->logo;
        $view = \view('admin.purchase.pdf', compact('purchase', 'product_purchases', 'company', 'logo'));
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        //$pdf->setPaper ( 'A7' , 'landscape' );

        return $pdf->stream("$purchasepdf.pdf");
        //return $pdf->stream('vista-pdf', "$purchasepdf.pdf");
        //return $pdf->download("$purchasepdf.pdf");
    }

    public function purchasePost($id)
    {
        $purchase = Purchase::where('id', $id)->first();
        $product_purchases = Product_purchase::where('purchase_id', $id)->where('quantity', '>', 0)->get();
        $company = Company::where('id', 1)->first();
        $purchasepdf = "FACT-". $purchase->document;
        $logo = './imagenes/logos'.$company->logo;
        $view = \view('admin.purchase.post', compact('purchase', 'product_purchases', 'company', 'logo'))->render();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        $pdf->setPaper (array(0,0,226.76,497.64), 'portrait');

        return $pdf->stream('vista-pdf', "$purchasepdf.pdf");
        //return $pdf->download("$purchasepdf.pdf");
    }

    public function postPurchase()
    {
        $purchases = session('purchase');
        $purchase = Purchase::findOrFail($purchases);
        session()->forget('purchase');
        $product_purchases = Product_purchase::where('purchase_id', $purchase->id)->where('quantity', '>', 0)->get();
        $company = Company::where('id', 1)->first();

        $purchasepdf = "FACT-". $purchase->document;
        $logo = './imagenes/logos'.$company->logo;
        $view = \view('admin.purchase.post', compact('purchase', 'product_purchases', 'company', 'logo'))->render();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        $pdf->setPaper (array(0,0,226.76,497.64), 'portrait');
        $pdf->render();
        return $pdf->stream("$purchasepdf.pdf");
        //return $pdf->download("$purchasepdf.pdf");
    }

    public function getMunicipalities(Request $request, $id)
    {
        if($request)
        {
            $municipalities = Municipality::where('department_id', '=', $id)->get();

            return response()->json($municipalities);
        }
    }

    public function pdf_paypurchase(Request $request, $id)
    {
        $purchase = Purchase::where('id', $id)->first();
        $company = Company::where('id', 1)->first();
        $user = auth::user();
        $product_purchases = Product_purchase::from('product_purchases as pp')
        ->join('purchases as pur', 'pp.purchase_id', 'pur.id')
        ->join('products as pro', 'pp.product_id', 'pro.id')
        ->select('pp.quantity', 'pp.price', 'pro.name')
        ->where('pp.pay_invoice_id', $id)
        ->where('quantity', '>', 0)
        ->get();
        $purchasepdf = "FACT-". $purchase->id;
        $logo = './imagenes/logos'.$company->logo;
        $view = \view('admin.pay_purchase.pdf', compact('company', 'logo', 'paypurchase', 'user'))->render();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        //$pdf->setPaper ( 'A7' , 'landscape' );

        return $pdf->stream('vista-pdf', "$purchasepdf.pdf");
        //return $pdf->download("$invoicepdf.pdf");
    }
}

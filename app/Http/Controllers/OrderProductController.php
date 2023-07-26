<?php

namespace App\Http\Controllers;

use App\Models\Order_product;
use App\Http\Requests\StoreOrderProductRequest;
use App\Http\Requests\UpdateOrderProductRequest;
use App\Models\Advance;
use App\Models\Bank;
use App\Models\Branch_product;
use App\Models\Card;
use App\Models\Customer;
use App\Models\Indicator;
use App\Models\Invoice;
use App\Models\Invoice_product;
use App\Models\Kardex;
use App\Models\Order;
use App\Models\Pay_invoice;
use App\Models\Pay_invoice_payment_method;
use App\Models\Payment_form;
use App\Models\Payment_method;
use App\Models\Percentage;
use App\Models\Product;
use App\Models\Sale_box;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $order = Order::where('id', $request->session()->get('order'))->first();
        /*
        $orders = Order::from('orders AS ord')
        ->join('users AS use', 'ord.user_id', 'use.id')
        ->join('branches AS bra', 'ord.branch_id', 'bra.id')
        ->join('customers AS cus', 'ord.customer_id', 'cus.id')
        ->join('payment_forms AS pf', 'ord.payment_form_id', 'pf.id')
        ->join('payment_methods AS pm', 'ord.payment_method_id', 'pm.id')
        ->select('ord.id', 'ord.due_date', 'ord.items', 'ord.total', 'ord.total_iva', 'ord.total_pay', 'ord.pay', 'ord.balance', 'ord.retention', 'ord.status', 'ord.created_at', 'use.name', 'bra.name AS nameB', 'cus.name AS nameC', 'pf.id as idPF', 'pf.name AS namePF', 'pm.name AS namePM')
        ->where('ord.id', '=', $request->session()->get('order'))
        ->first();*/
        //$orderProducts = Order_product::where('order_id', $order->id)->get();

        $orderProducts = Order_product::from('order_products AS op')
        ->join('products AS pro', 'op.product_id', '=', 'pro.id')
        ->join('orders AS ord', 'op.order_id', '=', 'ord.id')
        ->join('percentages as per', 'ord.percentage_id', 'per.id')
        ->select('op.id as id', 'op.quantity', 'op.price', 'op.iva', 'op.subtotal', 'op.ivasubt', 'ord.total', 'ord.total_iva', 'ord.total_pay', 'pro.id as idP', 'pro.name', 'per.percentage', 'ord.balance')
        ->where('op.order_id', '=', $order->id)
        ->get();
        $products = Product::get();
        /*
        $products = Product::from('products AS pro')
        ->join('categories AS cat', 'pro.category_id', '=', 'cat.id')
        ->select('pro.id', 'pro.name', 'pro.sale_price', 'pro.stock', 'cat.iva')
        ->where('pro.status', '=', 'ACTIVO')
        ->get();*/
        $customers = Customer::get();
        $percentages = Percentage::get();
        $paymentForms = Payment_form::get();
        $paymentMethods = Payment_method::get();
        $banks = Bank::get();
        $cards = Card::get();
        $advances = Advance::where('status', '!=', 'aplicado')->get();

        $cont = 0;
        foreach($orderProducts as $orderProduct){
            $product = Product::select('stock')->where('id', '=', $orderProduct->idP)->first();
            if($orderProduct->quantity >= $product->stock){
                $cont ++;
            }
        }

        if ($cont > 0) {
            return redirect('order')->with('warning', 'La venta de algunos productos supera el stock');
        } else {
            return view('admin.order_product.create', compact(
                'order',
                'products',
                'orderProducts',
                'order',
                'customers',
                'percentages',
                'paymentForms',
                'paymentMethods',
                'banks',
                'cards',
                'advances'
            ));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrderProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderProductRequest $request)
    {
        try{
            DB::beginTransaction();
            $order = Order::findOrFail($request->order);
            $orderProducts = Order_product::where('order_id', $order->id)->get();
            $indicator   = Indicator::where('id', '=', 1)->first();
            $number      = $indicator->from;
            $inv      = count(Invoice::get());
            $invoicey  = $number + $inv;
            $invoicey  ++;

            $paymentMethod = $request->payment_method_id;
            $pay = $request->pay;
            $totalpay = $request->totalpay;

            $invoice                    = new Invoice();
            $invoice->user_id           = Auth::user()->id;
            $invoice->branch_id         = $order->branch_id;
            $invoice->customer_id       = $order->customer_id;
            $invoice->payment_form_id   = $request->payment_form_id;
            $invoice->payment_method_id = $request->payment_method_id[0];
            $invoice->percentage_id     = $order->percentage_id;
            $invoice->voucher_type_id   = 1;
            $invoice->document          = $invoicey; //Cuadrar esto para ccolocarle prefix y numero
            $invoice->type_document     = '01';
            $invoice->type_operation    = '10';
            $invoice->due_date          = $request->due_date;
            $invoice->items             = $order->items;
            $invoice->total             = $order->total;
            $invoice->total_iva         = $order->total_iva;
            $invoice->total_pay         = $order->total_pay;
            $invoice->pay               = $order->pay + $totalpay;
            $invoice->balance           = $order->balance - $totalpay;
            $invoice->retention         = $order->retention;
            $invoice->save();
            //$inv = Purchase::whereDay('created_at', '=', date('d'))->sum('total_pay');
            $date1 = Invoice::find($invoice->id)->created_at->toDateString();
            $date2 = Order::find($order->id)->created_at->toDateString();

            $sale_box = Sale_box::where('user_id', '=', $invoice->user_id)->where('status', '=', 'open')->first();
            $sale_box->invoice += $invoice->total_pay;
            if ($date2 == $date1) {
                $sale_box->order -= $order->total_pay;
            } else {
                $sale_box->in_invoice += $invoice->totalpay;
            }
            $sale_box->update();


            if($totalpay > 0){
                $pay_invoice                  = new Pay_invoice();
                $pay_invoice->pay             = $totalpay;
                $pay_invoice->balance_invoice = $invoice->balance - $totalpay;
                $pay_invoice->user_id         = $invoice->user_id;
                $pay_invoice->branch_id       = $invoice->branch_id;
                $pay_invoice->invoice_id      = $invoice->id;
                $pay_invoice->save();
                $adv = $request->advance;

                for ($i=0; $i < count($paymentMethod); $i++) {

                    if ($adv != 0) {
                        //llamado al pago anticipado
                        $advance = Advance::findOrFail( $request->advance_id);
                        //si el Anticipo es utilizado en su totalidad agregar el destino aplicado
                        if ($advance->pay > $advance->balance) {
                            $advance->destination = $advance->destination . '<->' . $invoice->document;
                        } else {
                            $advance->destination = $invoice->document;
                        }
                        //variable si hay saldo en el Anticipado
                        $adv_total = $advance->balance - $adv;
                        //cambiar el status del Anticipado
                        if ($adv_total == 0) {
                            $advance->status = 'aplicado';
                        } else {
                            $advance->status = 'parcial';
                        }
                        $advance->balance = $adv_total;
                        $advance->update();
                        /*
                        $sale_box = Sale_box::where('user_id', '=', $invoice->user_id)->where('status', '=', 'open')->first();
                        $sale_box->in_advance += $pay;
                        $sale_box->update();*/
                    } else {

                        $pay_invoice_Payment_method  = new Pay_invoice_payment_method();
                        $pay_invoice_Payment_method->pay_invoice_id     = $pay_invoice->id;
                        $pay_invoice_Payment_method->payment_method_id  = $paymentMethod[$i];
                        $pay_invoice_Payment_method->bank_id            = $request->bank_id[$i];
                        $pay_invoice_Payment_method->card_id            = $request->card_id[$i];
                        $pay_invoice_Payment_method->advance_id         = $request->advance_id;
                        $pay_invoice_Payment_method->payment            = $request->pay[$i];
                        $pay_invoice_Payment_method->transaction        = $request->transaction[$i];
                        $pay_invoice_Payment_method->save();

                        $mp = $paymentMethod[$i];
                        //metodo para actualizar la caja
                        $sale_box = Sale_box::where('user_id', '=', $invoice->user_id)->where('status', '=', 'open')->first();
                        $in_invoice_cash = $sale_box->in_invoice_cash;
                        $cash            = $sale_box->cash;
                        if($mp == 10){
                            $in_invoice_cash += $pay[$i];
                            $cash            += $pay[$i];
                        }
                        $sale_box->in_invoice_cash = $in_invoice_cash;
                        $sale_box->in_invoice      += $pay[$i];
                        $sale_box->cash            = $cash;
                        $sale_box->update();
                    }
                }
            }


            foreach ($orderProducts as $key => $orderProduct) {

                $subtotal = $orderProduct->quantity * $orderProduct->price;
                $ivasub   = $subtotal * $orderProduct->iva/100;
                $product_id   = $orderProduct->product_id;
                $quantity = $orderProduct->quantity;
                $price = $orderProduct->price;

                $invoice_product = new Invoice_product();
                $invoice_product->invoice_id = $invoice->id;
                $invoice_product->product_id = $product_id;
                $invoice_product->quantity   = $quantity;
                $invoice_product->price      = $price;
                $invoice_product->iva        = $orderProduct->iva;
                $invoice_product->subtotal   = $subtotal;
                $invoice_product->ivasubt    = $ivasub;
                $invoice_product->item       = $key + 1;
                $invoice_product->save();

                $branch_product = Branch_product::where('product_id', $product_id)->first();
                $branch_product->stock -= $quantity;
                $branch_product->update();

                //reeplazando trigger
                $product = Product::findOrFail($product_id);
                $product->stock -= $quantity;
                $product->update();

                $kardex = new Kardex();
                $kardex->product_id = $product->id;
                $kardex->branch_id = $invoice->branch_id;
                $kardex->operation = 'venta';
                $kardex->number = $invoice->document;
                $kardex->quantity = $quantity;
                $kardex->stock = $product->stock;
                $kardex->save();
            }
            $order->status = 'facturado';
            $order->update();
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
     * @param  \App\Models\Order_product  $order_product
     * @return \Illuminate\Http\Response
     */
    public function show(Order_product $order_product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order_product  $order_product
     * @return \Illuminate\Http\Response
     */
    public function edit(Order_product $order_product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderProductRequest  $request
     * @param  \App\Models\Order_product  $order_product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderProductRequest $request, Order_product $order_product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order_product  $order_product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order_product $order_product)
    {
        //
    }
}

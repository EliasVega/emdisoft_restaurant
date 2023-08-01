<?php

namespace App\Http\Controllers;

use App\Models\MenuOrder;
use App\Http\Requests\StoreMenuOrderRequest;
use App\Http\Requests\UpdateMenuOrderRequest;
use App\Models\Bank;
use App\Models\Card;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceMenu;
use App\Models\Kardex;
use App\Models\Menu;
use App\Models\MenuProduct;
use App\Models\Order;
use App\Models\Pay_invoice;
use App\Models\Pay_invoice_payment_method;
use App\Models\Payment_form;
use App\Models\Payment_method;
use App\Models\Product;
use App\Models\Sale_box;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MenuOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $order = Order::where('id', $request->session()->get('order'))->first();

        $menuOrders = MenuOrder::from('menu_orders as mo')
        ->join('menus as men', 'mo.menu_id', 'men.id')
        ->join('orders as ord', 'mo.order_id', 'ord.id')
        ->select('mo.id', 'men.id as idM', 'men.name', 'mo.quantity', 'mo.price', 'mo.iva', 'mo.subtotal')
        ->where('order_id', $order->id)
        ->get();
        $menus = Menu::get();
        $customers = Customer::get();
        $payment_forms = Payment_form::get();
        $payment_methods = Payment_method::get();
        $banks = Bank::get();
        $cards = Card::get();

        $cont = 0;
        return view('admin.menu_order.create', compact(
            'order',
            'menus',
            'menuOrders',
            'customers',
            'payment_forms',
            'payment_methods',
            'banks',
            'cards'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMenuOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMenuOrderRequest $request)
    {
        try{
            DB::beginTransaction();
            $order_id = $request->order;
            $order = Order::findOrFail($order_id);
            $menu_id = $request->menu_id;
            $quantity   = $request->quantity;
            $price      = $request->price;
            $iva        = $request->iva;

            $invoice                    = new Invoice();
            $invoice->user_id           = Auth::user()->id;
            $invoice->branch_id         = Auth::user()->branch_id;
            $invoice->customer_id       = $request->customer_id;
            $invoice->payment_form_id   = $request->payment_form_id;
            $invoice->payment_method_id = $request->payment_method_id;
            $invoice->restaurant_table_id = $order->restaurant_table_id;
            $invoice->total             = $order->total;
            $invoice->total_iva         = $order->total_iva;
            $invoice->total_pay         = $order->total_pay;
            $invoice->pay               = $order->total_pay;
            $invoice->balance           = 0;
            $invoice->save();

            $sale_box = Sale_box::where('user_id', '=', $invoice->user_id)->where('status', '=', 'open')->first();
            $sale_box->invoice += $invoice->total_pay;
            $sale_box->in_total += $invoice->total_pay;
            $sale_box->update();


            $pay_invoice                  = new Pay_invoice();
            $pay_invoice->pay             = $order->total_pay;
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
            $pay_invoice_Payment_method->payment            = $order->total_pay;
            $pay_invoice_Payment_method->save();

            $mp = $request->payment_method_id;
            //metodo para actualizar la caja
            $sale_box = Sale_box::where('user_id', '=', $invoice->user_id)->where('status', '=', 'open')->first();
            if($mp == 10){
                $sale_box->in_invoice_cash += $order->total_pay;
                $sale_box->cash += $order->total_pay;
            }
            $sale_box->in_invoice += $order->total_pay;
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
     * @param  \App\Models\MenuOrder  $menuOrder
     * @return \Illuminate\Http\Response
     */
    public function show(MenuOrder $menuOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MenuOrder  $menuOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(MenuOrder $menuOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMenuOrderRequest  $request
     * @param  \App\Models\MenuOrder  $menuOrder
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMenuOrderRequest $request, MenuOrder $menuOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MenuOrder  $menuOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuOrder $menuOrder)
    {
        //
    }
}

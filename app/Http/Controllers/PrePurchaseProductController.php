<?php

namespace App\Http\Controllers;

use App\Models\PrePurchaseProduct;
use App\Http\Requests\StorePrePurchaseProductRequest;
use App\Http\Requests\UpdatePrePurchaseProductRequest;
use App\Models\Advance;
use App\Models\Branch_product;
use App\Models\BranchProduct;
use App\Models\Kardex;
use App\Models\pay;
use App\Models\Pay_purchase;
use App\Models\Pay_purchase_payment_method;
use App\Models\Payment;
use App\Models\PayPaymentMethod;
use App\Models\PrePurchase;
use App\Models\Product;
use App\Models\Product_purchase;
use App\Models\ProductPurchase;
use App\Models\Purchase;
use App\Models\Resolution;
use App\Models\Sale_box;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class PrePurchaseProductController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePrePurchaseProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePrePurchaseProductRequest $request)
    {
        try{
            DB::beginTransaction();
            //llamado a variables
            $prePurchase = PrePurchase::findOrFail($request->prePurchase);
            $product_id = $request->product_id;
            $quantity   = $request->quantity;
            $price      = $request->price;
            $iva        = $request->iva;
            $pay        = $request->pay;
            $totalpay = $request->totalpay;
            $branch = $prePurchase->branch_id;
            $supplier = $prePurchase->supplier_id;
            //Crea un registro de compras
            $purchase = new Purchase();
            $purchase->user_id     = Auth::user()->id;
            $purchase->branch_id   = $branch;
            $purchase->supplier_id = $supplier;
            $purchase->payment_form_id = $request->payment_form_id;
            $purchase->payment_method_id = $request->payment_method_id[0];
            $purchase->percentage_id = $request->percentage_id;
            $purchase->voucher_type_id = 7;
            $purchase->document    = $request->document;
            $purchase->due_date    = $request->due_date;
            $purchase->items       = count($product_id);
            $purchase->total       = $request->total;
            $purchase->total_iva    = $request->total_iva;
            $purchase->total_pay    = $request->total_pay;
            $purchase->status      = 'active';
            $purchase->pay         = $totalpay;
            $purchase->balance     = $request->total_pay - $totalpay;
            $purchase->retention   = $request->retention;
            $purchase->save();

            $sale_box = Sale_box::where('user_id', '=', $purchase->user_id)->where('status', '=', 'open')->first();

            $sale_box->purchase += $purchase->total_pay;
            $sale_box->out_total += $purchase->total_pay;
            $sale_box->update();
            //inicio proceso si hay pagos
            $contp = 0;
            if ($totalpay > 0) {
                # code...

            while($contp < count($pay)){
                if($totalpay > 0){
                    //variable si el pago fue de un pago anticipado
                    $paym = $request->payment;
                    //variable si existe payment method
                    $payPurchase = null;
                    //inicio proceso si hay pago po abono anticipado
                    if ($paym > 0) {
                        //llamado al pago anticipado
                        $payment = Payment::findOrFail( $request->payment_id);
                        //si el pago es utilizado en su totalidad agregar el destino aplicado
                        if ($payment->pay > $payment->balance) {
                            $payment->destination = $payment->destination . '<->' . $purchase->document;
                        } else {
                            $payment->destination = $purchase->document;
                        }
                        //variable si hay saldo en el pago anticipado
                        $paym_total = $payment->balance - $paym;
                        //cambiar el status del pago anticipado
                        if ($paym_total == 0) {
                            $payment->status      = 'aplicado';
                        } else {
                            $payment->status      = 'parcial';
                        }
                        //actualizar el saldo del pago anticipado
                        $payment->balance = $paym_total;
                        $payment->update();
                        $sale_box = Sale_box::where('user_id', '=', $purchase->user_id)->where('status', '=', 'open')->first();
                        $sale_box->out_payment += $pay[$contp];
                        $sale_box->update();

                    } else {
                        //si no hay pago anticipado se crea un pago a compra
                        $pay_purchase                   = new Pay_purchase();
                        $pay_purchase->pay              = $pay[$contp];
                        $pay_purchase->balance_purchase = $purchase->balance;
                        $pay_purchase->user_id          = $purchase->user_id;
                        $pay_purchase->branch_id        = $purchase->branch_id;
                        $pay_purchase->purchase_id      = $purchase->id;
                        $pay_purchase->save();
                        //metodo que registra el pago a compra y el methodo de pago
                        $pay_purchase_Payment_method = new Pay_purchase_payment_method();
                        $pay_purchase_Payment_method->pay_purchase_id    = $pay_purchase->id;
                        $pay_purchase_Payment_method->payment_method_id  = $request->payment_method_id[$contp];
                        $pay_purchase_Payment_method->bank_id            = $request->bank_id[$contp];
                        $pay_purchase_Payment_method->card_id            = $request->card_id[$contp];
                        $pay_purchase_Payment_method->payment_id         = $request->payment_id;
                        $pay_purchase_Payment_method->payment            = $pay[$contp];
                        $pay_purchase_Payment_method->transaction        = $request->transaction[$contp];
                        $pay_purchase_Payment_method->save();

                        $mp = $request->payment_method_id[$contp];

                        $sale_box = Sale_box::where('user_id', '=', $purchase->user_id)->where('status', '=', 'open')->first();
                        $out_purchase_cash = $sale_box->out_purchase_cash;
                        if($mp == 10){
                            $out_purchase_cash += $pay[$contp];
                            $sale_box->departure  += $pay[$contp];
                        }
                        $sale_box->out_purchase_cash = $out_purchase_cash;
                        $sale_box->out_purchase += $pay[$contp];
                        $sale_box->update();
                    }
                }
                $contp++;
            }
        }

            //Toma el Request del array

            $cont = 0;
            //Ingresa los productos que vienen en el array
            while($cont < count($product_id)){

                //$subtotal = $quantity[$cont] * $price[$cont];
                //$ivasub = $subtotal * $iva[$cont]/100;
                $item = $cont + 1;

                $product_purchase = new Product_purchase();
                $product_purchase->purchase_id = $purchase->id;
                $product_purchase->product_id  = $product_id[$cont];
                $product_purchase->quantity    = $quantity[$cont];
                $product_purchase->price       = $price[$cont];
                $product_purchase->iva         = $iva[$cont];
                $product_purchase->subtotal    = $quantity[$cont] * $price[$cont];
                $product_purchase->ivasubt     =($quantity[$cont] * $price[$cont] * $iva[$cont])/100;
                $product_purchase->item        = $item;
                $product_purchase->save();
                //selecciona el producto que viene del array
                $products = Product::where('id', $product_purchase->product_id)->first();

                //$id = $products->id;
                $utility = $products->category->utility;
                $priceProd = $products->price;
                $stockardex = $products->stock;
                $priceSale = $priceProd + ($priceProd * $utility / 100);
                $priceProduct = (($stockardex * $priceProd) + ($quantity[$cont] * $price[$cont])) / ($stockardex + $quantity[$cont]);
                //Cambia el valor de venta del producto
                //$product = Product::findOrFail($id);
                $products->stock += $quantity[$cont]; //reempazando triguer
                $products->price = $priceProduct;
                $products->sale_price = $priceSale;
                $products->update();

                //selecciona el producto de la sucursal que sea el mismo del array
                $branch_products = Branch_product::where('product_id', '=', $product_purchase->product_id)
                ->where('branch_id', '=', $branch)
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
                    $branch_product->branch_id = $branch;
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
                $kardex->stock = $stockardex;
                $kardex->save();


                $cont++;
            }
            $prePurchase->status = 'generated';
            $prePurchase->update();

            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
        }
        return redirect('purchase');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PrePurchaseProduct  $prePurchaseProduct
     * @return \Illuminate\Http\Response
     */
    public function show(PrePurchaseProduct $prePurchaseProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PrePurchaseProduct  $prePurchaseProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(PrePurchaseProduct $prePurchaseProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePrePurchaseProductRequest  $request
     * @param  \App\Models\PrePurchaseProduct  $prePurchaseProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PrePurchaseProduct $prePurchaseProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PrePurchaseProduct  $prePurchaseProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(PrePurchaseProduct $prePurchaseProduct)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Advance;
use App\Models\Bank;
use App\Models\Branch_product;
use App\Models\Card;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Document;
use App\Models\Liability;
use App\Models\Municipality;
use App\Models\Order_product;
use App\Models\Organization;
use App\Models\Payment_form;
use App\Models\Payment_method;
use App\Models\Pay_order;
use App\Models\Pay_order_payment_method;
use App\Models\Percentage;
use App\Models\Regime;
use App\Models\Sale_box;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
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
                $orders = Order::get();
            } else {
                $orders = Order::where('branch_id', $user->branch_id)->where('user_id', $user->id)->get();
            }
            return DataTables::of($orders)
            ->addIndexColumn()
            ->addColumn('customer', function (Order $order) {
                return $order->customer->name;
            })
            ->addColumn('branch', function (Order $order) {
                return $order->branch->name;
            })
            ->editColumn('created_at', function(Order $order){
                return $order->created_at->format('yy-m-d: h:m');
            })
            ->addColumn('btn', 'admin/order/actions')
            ->rawColumns(['btn'])
            ->make(true);
        }/*
        if ($branch->id == 1) {
            return redirect('branch')->with('warning', 'No puede realizar ventas desde Bodega');
        } else {*/
            return view('admin.order.index');
        //}
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $departments = Department::get();
        $municipalities = Municipality::get();
        $documents = Document::get();
        $customers = Customer::get();
        $liabilities = Liability::get();
        $organizations = Organization::get();
        $regimes = Regime::get();
        $payment_forms = Payment_form::get();
        $payment_methods = Payment_method::get();
        $percentages = Percentage::get();
        $banks = Bank::get();
        $cards = Card::get();
        $advances   = Advance::where('status', '!=', 'aplicado')->get();
        $branchProducts = Branch_product::from('branch_products as bp')
        ->join('products as pro', 'bp.product_id', 'pro.id')
        ->join('categories as cat', 'pro.category_id', 'cat.id')
        ->select('bp.id', 'bp.branch_id', 'bp.stock', 'pro.id as idP', 'pro.sale_price', 'pro.name', 'cat.iva')
        ->where('bp.branch_id', Auth::user()->branch_id)
        ->where('bp.stock', '>', 0)
        ->where('pro.status', '=', 'activo')
        ->get();
        return view('admin.order.create', compact(
            'departments',
            'municipalities',
            'documents',
            'customers',
            'liabilities',
            'organizations',
            'regimes',
            'payment_forms',
            'payment_methods',
            'percentages',
            'banks',
            'cards',
            'advances',
            'branchProducts'
        ));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        try{
            DB::beginTransaction();
            //Obteniendo variables
            $product_id   = $request->product_id;
            $quantity     = $request->quantity;
            $price        = $request->price;
            $iva          = $request->iva;
            $idP          = $request->idP;
            $pay          = $request->pay;

            //registro en la tabla Order
            $order                    = new Order();
            $order->user_id           = Auth::user()->id;
            $order->branch_id         = $request->session()->get('branch');
            $order->customer_id       = $request->customer_id;
            $order->payment_form_id   = $request->payment_form_id;
            $order->payment_method_id = $request->payment_method_id;
            $order->percentage_id      = $request->percentage_id[0];
            $order->voucher_type_id   = 18;
            $order->due_date          = $request->due_date;
            $order->items             = count($product_id);
            $order->total             = $request->total;
            $order->total_iva         = $request->total_iva;
            $order->total_pay         = $request->total_pay;
            $order->pay               = $pay;
            $order->balance           = $request->total_pay - $pay;
            $order->retention         = $request->retention;
            $order->save();

            $sale_box = Sale_box::where('user_id', '=', $order->user_id)->where('status', '=', 'open')->first();
            $sale_box->order += $order->total_pay;
            $sale_box->in_total += $order->pay;
            $sale_box->update();

            //si hay Abono registra abono
            if($pay > 0){
                $adv = $request->advance;

                if ($adv != 0) {
                    //llamado al pago anticipado
                    $advance = Advance::findOrFail( $request->advance_id);
                    //si el Anticipo es utilizado en su totalidad agregar el destino aplicado
                    if ($advance->pay > $advance->balance) {
                        $advance->destination = $advance->destination . '<->' . $order->id;
                    } else {
                        $advance->destination = $order->id;
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
                    $sale_box = Sale_box::where('user_id', '=', $order->user_id)->where('status', '=', 'open')->first();
                    $sale_box->in_advance += $pay;
                    $sale_box->update();*/
                } else {
                    //si es un abono nuevo aplica abono pedido
                    $pay_order = new Pay_order();
                    $pay_order->pay = $pay;
                    $pay_order->balance_order = $order->balance;
                    $pay_order->user_id = $order->user_id;
                    $pay_order->branch_id = $order->branch_id;
                    $pay_order->order_id = $order->id;
                    $pay_order->save();
                    //Registrando la tabla de metodos de pago abono pedido
                    $pay_order_Payment_method  = new Pay_order_payment_method();
                    $pay_order_Payment_method->pay_order_id = $pay_order->id;
                    $pay_order_Payment_method->payment_method_id  = $request->payment_method_id;
                    $pay_order_Payment_method->bank_id = $request->bank_id;
                    $pay_order_Payment_method->card_id = $request->card_id;
                    $pay_order_Payment_method->advance_id = $request->advance_id;
                    $pay_order_Payment_method->payment = $request->pay;
                    $pay_order_Payment_method->transaction = $request->transaction;
                    $pay_order_Payment_method->save();

                    $mp = $request->payment_method_id;
                    //metodo para actualizar la caja
                    $sale_box = Sale_box::where('user_id', '=', $order->user_id)->where('status', '=', 'open')->first();
                    if($mp == 10){
                        $sale_box->in_order_cash += $pay;
                        $sale_box->cash += $pay;
                    }
                    $sale_box->in_order += $pay;
                    $sale_box->update();
                }
            }

            $cont = 0;

            while($cont < count($product_id)){
                //registrando la tabla de orders y productos
                $subtotal = $quantity[$cont] * $price[$cont];
                $ivasub   = $subtotal * $iva[$cont]/100;

                $order_product = new Order_product();
                $order_product->order_id   = $order->id;
                $order_product->product_id = $idP[$cont];
                $order_product->quantity   = $quantity[$cont];
                $order_product->price      = $price[$cont];
                $order_product->iva        = $iva[$cont];
                $order_product->subtotal   = $subtotal;
                $order_product->ivasubt    = $ivasub;
                $order_product->save();
                //obteniendo datos de sucursal
                $branch_products = Branch_product::where('product_id', '=', $order_product->product_id)
                ->where('branch_id', '=', $order->branch_id)
                ->first();

                $id = $branch_products->id;
                $order_products = $branch_products->orderProduct + $order_product->quantity;
                //Actualizando la tabla sucursal productos
                $branchPro = Branch_product::findOrFail($id);
                $branchPro->order_product = $order_products;
                $branchPro->update();

                $cont++;
            }

            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
        }
        return redirect('order');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {

        /*mostrar detalles*/
        $orderProducts = Order_product::where('order_id', $order->id)->get();

        return view('admin.order.show', compact('order', 'orderProducts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $departments = Department::get();
        $municipalities = Municipality::get();
        $documents = Document::get();
        $customers = Customer::get();
        $liabilities = Liability::get();
        $organizations = Organization::get();
        $regimes = Regime::get();
        $payment_forms = Payment_form::get();
        $payment_methods = Payment_method::get();
        $percentages = Percentage::get();
        $banks = Bank::get();
        $cards = Card::get();
        $advances   = Advance::where('status', '!=', 'aplicado')->get();

        $branchProducts = Branch_product::from('branch_products as bp')
        ->join('products as pro', 'bp.product_id', 'pro.id')
        ->join('categories as cat', 'pro.category_id', 'cat.id')
        ->select('bp.id', 'bp.branch_id', 'bp.stock', 'pro.id as idP', 'pro.sale_price', 'pro.name', 'cat.iva')
        ->where('bp.branch_id', Auth::user()->branch_id)
        ->where('bp.stock', '>', 0)
        ->where('pro.status', '=', 'activo')
        ->get();
        $orderProducts = Order_product::from('order_products as op')
        ->join('products as pro', 'op.product_id', 'pro.id')
        ->join('orders as ord', 'op.order_id', 'ord.id')
        ->join('percentages as per', 'ord.percentage_id', 'per.id')
        ->select('op.id', 'pro.id as idP', 'pro.name', 'pro.stock', 'op.quantity', 'op.price', 'op.iva', 'op.subtotal', 'per.percentage')
        ->where('order_id', $order->id)
        ->get();
        $payOrders = Pay_order::where('order_id', $order->id)->sum('pay');
        return view('admin.order.edit', compact(
            'order',
            'departments',
            'municipalities',
            'documents',
            'customers',
            'liabilities',
            'organizations',
            'regimes',
            'payment_forms',
            'payment_methods',
            'percentages',
            'banks',
            'cards',
            'advances',
            'branchProducts',
            'orderProducts',
            'payOrders'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderRequest  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        try{
            DB::beginTransaction();
            //llamado a variables
            $idP          = $request->idP;

            $product_id = $request->product_id;
            $quantity   = $request->quantity;
            $price      = $request->price;
            $iva        = $request->iva;
            $pay        = $request->pay;
            $total_pay = $request->total_pay;
            //llamado de todos los pagos y pago nuevo para la diferencia

            $payOld = Pay_order::where('order_id', $order->id)->sum('pay');
            $payNew = $pay;
            $payTotal = $payNew + $payOld;
            $date1 = Carbon::now()->toDateString();
            $date2 = Order::find($order->id)->created_at->toDateString();

            if ($payOld > $total_pay) {

                $advance = new Advance();
                $advance->user_id    = Auth::user()->id;
                $advance->branch_id  = Auth::user()->branch_id;
                $advance->customer_id = $request->customer_id;
                $advance->origin = 'Orden de Pedido' . '-' . $order->id;
                $advance->destination = null;
                $advance->pay = $payOld - $total_pay;
                $advance->balance = $payOld - $total_pay;
                $advance->note = 'diferencia de edicion de Orden de pedido';
                $advance->save();
            }

            //actualizar la caja
            if ($date1 == $date2) {
                $sale_box = Sale_box::where('user_id', '=', $order->user_id)->where('status', 'open')->first();
                $sale_box->order -= $order->total_pay;
                $sale_box->out_total -= $order->total_pay;
                $sale_box->update();
            }

            //registro en la tabla Order
            $order->user_id           = Auth::user()->id;
            $order->customer_id       = $request->customer_id;
            $order->due_date          = $request->due_date;
            $order->items             = count($product_id);
            $order->total             = $request->total;
            $order->total_iva         = $request->total_iva;
            $order->total_pay         = $request->total_pay;
            if ($payOld > 0 && $pay == 0) {
                $order->pay         = $payOld;
            } elseif ($pay > 0 && $payOld == 0) {
                $order->pay         = $pay;
            } else {
                $order->pay         = $payTotal;
            }
            if ($payOld > $total_pay) {
                $order->balance = 0;
            } else {
                $order->balance = $total_pay - $payTotal;
            }
            $order->retention         = $request->retention;
            $order->update();

            //actualizar la caja
            if ($date1 == $date2) {
                $sale_box = Sale_box::where('user_id', '=', $order->user_id)->where('status', 'open')->first();
                $sale_box->order += $order->total_pay;
                $sale_box->out_total += $order->pay;
                $sale_box->update();
            }

            //inicio proceso si hay pagos
            if($pay > 0){
                //variable si el pago fue de un pago anticipado
                $paym = $request->payment;
                //variable si existe payment method
                $payPurchase = null;
                //inicio proceso si hay pago po abono anticipado
                if ($paym > 0) {
                    //llamado al pago anticipado
                    $advance = Advance::findOrFail( $request->advance_id);
                    //si el pago es utilizado en su totalidad agregar el destino aplicado
                    if ($advance->pay > $advance->balance) {
                        $advance->destination = $advance->destination . '<->' . 'OP' . $order->id;
                    } else {
                        $advance->destination = 'OP' . $order->id;
                    }
                    //variable si hay saldo en el pago anticipado
                    $paym_total = $advance->balance - $paym;
                    //cambiar el status del pago anticipado
                    if ($paym_total == 0) {
                        $advance->status      = 'aplicado';
                    } else {
                        $advance->status      = 'parcial';
                    }
                    //actualizar el saldo del pago anticipado
                    $advance->balance = $paym_total;
                    $advance->update();
                } else {
                    //si es un abono nuevo aplica abono pedido
                    $pay_order = new Pay_order();
                    $pay_order->pay = $pay;
                    $pay_order->balance_order = $order->balance;
                    $pay_order->user_id = $order->user_id;
                    $pay_order->branch_id = $order->branch_id;
                    $pay_order->order_id = $order->id;
                    $pay_order->save();
                    //Registrando la tabla de metodos de pago abono pedido
                    $pay_order_Payment_method  = new Pay_order_payment_method();
                    $pay_order_Payment_method->pay_order_id = $pay_order->id;
                    $pay_order_Payment_method->payment_method_id  = $request->payment_method_id;
                    $pay_order_Payment_method->bank_id = $request->bank_id;
                    $pay_order_Payment_method->card_id = $request->card_id;
                    $pay_order_Payment_method->advance_id = $request->advance_id;
                    $pay_order_Payment_method->payment = $request->pay;
                    $pay_order_Payment_method->transaction = $request->transaction;
                    $pay_order_Payment_method->save();

                    $mp = $request->payment_method_id;
                    //metodo para actualizar la caja
                    $sale_box = Sale_box::where('user_id', '=', $order->user_id)->where('status', '=', 'open')->first();
                    if($mp == 10){
                        $sale_box->in_order_cash += $pay;
                        $sale_box->cash += $pay;
                    }
                    $sale_box->in_order += $pay;
                    $sale_box->update();
                }

            }

            $orderProducts = Order_product::where('order_id', $order->id)->get();
            foreach ($orderProducts as $key => $orderProduct) {

                $orderProduct->quantity    = 0;
                $orderProduct->price       = 0;
                $orderProduct->iva         = 0;
                $orderProduct->subtotal    = 0;
                $orderProduct->ivasubt     = 0;
                $orderProduct->update();

            }

            //Toma el Request del array

            $cont = 0;
            //Ingresa los productos que vienen en el array
            while($cont < count($product_id)){

                $orderProduct = Order_product::where('order_id', $order->id)
                ->where('product_id', $product_id[$cont])->first();
                //Inicia proceso actualizacio order product si no existe
                if (is_null($orderProduct)) {
                    $subtotal = $quantity[$cont] * $price[$cont];
                    $ivasub = $subtotal * $iva[$cont]/100;
                    $order_product = new Order_product();
                    $order_product->order_id = $order->id;
                    $order_product->product_id  = $product_id[$cont];
                    $order_product->quantity    = $quantity[$cont];
                    $order_product->price       = $price[$cont];
                    $order_product->iva         = $iva[$cont];
                    $order_product->subtotal    = $subtotal;
                    $order_product->ivasubt     = $ivasub;
                    $order_product->save();
                } else {
                    if ($quantity[$cont] > 0) {
                        $subtotal = $quantity[$cont] * $price[$cont];
                        $ivasub = $subtotal * $iva[$cont]/100;
                        $orderProduct->quantity = $quantity[$cont];
                        $orderProduct->price = $price[$cont];
                        $orderProduct->iva = $iva[$cont];
                        $orderProduct->subtotal = $subtotal;
                        $orderProduct->ivasubt = $ivasub;
                        $orderProduct->update();
                        /*
                        if ($orderProduct->quantity > 0) {
                            $orderProduct->quantity += $quantity[$cont];
                            $orderProduct->price += $price[$cont];
                            $orderProduct->iva += $iva[$cont];
                            $orderProduct->subtotal += $subtotal;
                            $orderProduct->ivasubt += $ivasub;
                            $orderProduct->update();
                        } else {
                            $orderProduct->quantity = $quantity[$cont];
                            $orderProduct->price = $price[$cont];
                            $orderProduct->iva = $iva[$cont];
                            $orderProduct->subtotal = $subtotal;
                            $orderProduct->ivasubt = $ivasub;
                            $orderProduct->update();
                        }*/
                    }
                }

                $cont++;
            }
            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
        }
        if ($payOld > $total_pay) {
            Alert::success('Orden de Pedido','Editado Satisfactoriamente. Con creacion de anticipo de cliente');
            return redirect('order');

        } else {
            return redirect("order")->with('success', 'Orden de Pedido Editado Satisfactoriamente');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function show_invoicy($id)
    {
    $orders = Order::findOrFail($id);
    \session()->put('order', $orders->id, 60 * 24 * 365);
    \session()->put('branch_id', $orders->branch_id, 60 * 24 *365);
    \session()->put('customer_id', $orders->customer_id, 60 * 24 *365);
    \session()->put('payment_form_id', $orders->payment_form_id, 60 * 24 *365);
    \session()->put('payment_method_id', $orders->payment_method_id, 60 * 24 *365);
    \session()->put('retention_id', $orders->retention_id, 60 * 24 *365);
    \session()->put('due_date', $orders->due_date, 60 * 24 *365);
    \session()->put('total', $orders->total, 60 * 24 *365);
    \session()->put('total_iva', $orders->total_iva, 60 * 24 *365);
    \session()->put('total_pay', $orders->total_pay, 60 * 24 *365);
    \session()->put('status', $orders->estado, 60 * 24 *365);
    return redirect('order_product/create');
    }

    public function show_pay_order($id)
    {
    $orders = Order::findOrFail($id);
    \session()->put('order', $orders->id, 60 * 24 * 365);
    \session()->put('total', $orders->total, 60 * 24 *365);
    \session()->put('total_iva', $orders->total_iva, 60 * 24 *365);
    \session()->put('total_pay', $orders->total_Pay, 60 * 24 *365);
    \session()->put('status', $orders->status, 60 * 24 *365);

    return redirect()->route('pay_order.create');
    }

    public function show_pdf_order(Request $request,$id)
    {
        $order = Order::where('id', $id)->first();
        $orderProducts = Order_product::where('order_id', $id)->get();
        $company = Company::where('id', 1)->first();

        $days = $order->created_at->diffInDays($order->due_date);
        $orderpdf = "PEDIDO-". $order->id;
        $logo = './imagenes/logos'.$company->logo;
        $view = \view('admin.order.pdf', compact('order', 'days', 'orderProducts', 'company', 'logo'))->render();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        //$pdf->setPaper ( 'A7' , 'landscape' );

        //return $pdf->download("$orderpdf.pdf");
        return $pdf->stream('vista-pdf', "$orderpdf.pdf");
    }

    public function eliminar($id)
    {
        $order = Order::findOrFail($id);
        if($order->status == 'ANULADO'){
            return redirect("order")->with('warning', 'Pedido Anulado Anteriormente');
        }
        $balance = $order->balance;
        $valor = $order->total_pay;
        $total = $valor - $balance;

        if($balance != $valor){
            $advance = new Advance();
            $advance->origin = $order->id;
            $advance->destination = null;
            $advance->pay = $total;
            $advance->balance = $total;
            $advance->note = 'eliminacion pedido';
            $advance->status = 'pendiente';
            $advance->user_id = Auth::user()->id;
            $advance->branch_id = $order->branch->id;
            $advance->customer_id = $order->customer->id;
            $advance->save();
        }

        $order = Order::findOrFail($id);
        $order->total_pay = 0;
        $order->pay       = 0;
        $order->balance       = 0;
        $order->status      = 'ANULADO';
        $order->save();

        return redirect("order")->with('success', 'Pedido Anulado Satisfactoriamente');
    }

    public function getMunicipalities(Request $request, $id)
    {
        if($request)
        {
            $municipalities = Municipality::where('department_id', '=', $id)->get();

            return response()->json($municipalities);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Company;
use App\Models\Document;
use App\Models\Menu;
use App\Models\MenuOrder;
use App\Models\RestaurantTable;
use App\Models\Sale_box;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
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
        $order = session('order');
        $user = Auth::user();
        if (request()->ajax()) {
            if ($user->role_id == 1 || $user->role_id == 2) {
                $orders = Order::get();
            } else {
                $orders = Order::where('user_id', $user->id)->get();
            }
            return DataTables::of($orders)
            ->addIndexColumn()

            ->addColumn('user', function (Order $order) {
                return $order->user->name;
            })
            ->addColumn('table', function (Order $order) {
                return $order->restaurantTable->name;
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
            return view('admin.order.index', compact('order'));
        //}
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $documents = Document::get();
        $menus = Menu::get();
        $restaurantTables = RestaurantTable::get();
        return view('admin.order.create', compact(
            'documents',
            'restaurantTables',
            'menus'
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
        $table = $request->restaurant_table_id;
        $ordered = Order::where('restaurant_table_id', $table)->where('status', 'pendiente')->first();
        if (isset($ordered)) {
            Alert::success('Error','Esta mesa ya tiene una comanda abierta');
            return redirect('order');
        }
        //Obteniendo variables
        $menu_id   = $request->menu_id;
        $quantity     = $request->quantity;
        $price        = $request->price;
        $inc          = $request->inc;
        $pay          = $request->pay;

        //registro en la tabla Order
        $order                    = new Order();
        $order->user_id           = Auth::user()->id;
        $order->restaurant_table_id = $request->restaurant_table_id;
        $order->total             = $request->total;
        $order->total_inc         = $request->total_inc;
        $order->total_pay         = $request->total_pay;
        $order->status = 'pendiente';
        $order->save();

        $sale_box = Sale_box::where('user_id', '=', $order->user_id)->where('status', '=', 'open')->first();
        $sale_box->order += $order->total_pay;
        $sale_box->in_total += $order->pay;
        $sale_box->update();

        //si hay Abono registra abono

        $cont = 0;

        while($cont < count($menu_id)){
            //registrando la tabla de orders y productos
            $subtotal = $quantity[$cont] * $price[$cont];
            $incsub   = $subtotal * $inc[$cont]/100;

            $menuOrder = new MenuOrder();
            $menuOrder->order_id   = $order->id;
            $menuOrder->menu_id = $menu_id[$cont];
            $menuOrder->quantity   = $quantity[$cont];
            $menuOrder->price      = $price[$cont];
            $menuOrder->inc        = $inc[$cont];
            $menuOrder->subtotal   = $subtotal;
            $menuOrder->incsubt    = $incsub;
            $menuOrder->save();

            $cont++;
        }
        session(['order' => $order->id]);

        toast('Comanda Registrada satisfactoriamente.','success');
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
        $menuOrders = MenuOrder::where('order_id', $order->id)->where('quantity', '>', 0)->get();

        return view('admin.order.show', compact('order', 'menuOrders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $documents = Document::get();
        $restaurantTables = RestaurantTable::get();
        $menus = Menu::get();
        $menuOrders = MenuOrder::from('menu_orders as mo')
        ->join('menus as men', 'mo.menu_id', 'men.id')
        ->join('orders as ord', 'mo.order_id', 'ord.id')
        ->select('mo.id', 'men.id as idM', 'men.name', 'mo.quantity', 'mo.price', 'mo.inc', 'mo.subtotal')
        ->where('order_id', $order->id)
        ->get();
        return view('admin.order.edit', compact(
            'order',
            'documents',
            'restaurantTables',
            'menus',
            'menuOrders',
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
        //llamado a variables
        $menu_id = $request->menu_id;
        $quantity   = $request->quantity;
        $price      = $request->price;
        $inc        = $request->inc;
        //llamado de todos los pagos y pago nuevo para la diferencia

        //actualizar la caja
        $sale_box = Sale_box::where('user_id', '=', $order->user_id)->where('status', 'open')->first();
        $sale_box->order -= $order->total_pay;
        $sale_box->out_total -= $order->total_pay;
        $sale_box->update();

        //registro en la tabla Order
        $order->user_id           = Auth::user()->id;
        $order->restaurant_table_id = $request->restaurant_table_id;
        $order->total             = $request->total;
        $order->total_inc         = $request->total_inc;
        $order->total_pay         = $request->total_pay;
        $order->update();

        //actualizar la caja
        $sale_box = Sale_box::where('user_id', '=', $order->user_id)->where('status', 'open')->first();
        $sale_box->order += $order->total_pay;
        $sale_box->out_total += $order->pay;
        $sale_box->update();

        $menuOrders = MenuOrder::where('order_id', $order->id)->get();
        foreach ($menuOrders as $key => $menuOrder) {

            $menuOrder->quantity    = 0;
            $menuOrder->price       = 0;
            $menuOrder->inc         = 0;
            $menuOrder->subtotal    = 0;
            $menuOrder->incsubt     = 0;
            $menuOrder->edition = false;
            if ($menuOrder->status != 'anulado') {
                $menuOrder->status = 'registrado';
            }
            $menuOrder->update();

        }

        //Toma el Request del array

        $cont = 0;
        //Ingresa los productos que vienen en el array
        while($cont < count($menu_id)){

            $menuOrders = MenuOrder::where('order_id', $order->id)
            ->where('menu_id', $menu_id[$cont])->where('edition', false)->get();

            $subtotal = $quantity[$cont] * $price[$cont];
            $incsub = $subtotal * $inc[$cont]/100;
            //Inicia proceso actualizacio order product si no existe
            if (is_null($menuOrders)) {
                $menuOrder = new MenuOrder();
                $menuOrder->order_id = $order->id;
                $menuOrder->menu_id  = $menu_id[$cont];
                $menuOrder->quantity    = $quantity[$cont];
                $menuOrder->price       = $price[$cont];
                $menuOrder->inc         = $inc[$cont];
                $menuOrder->subtotal    = $subtotal;
                $menuOrder->incsubt     = $incsub;
                $menuOrder->save();
            } else {
                if ($quantity[$cont] > 0) {
                    //$sumOrder = $menuOrders->quantity;
                    for ($i=0; $i < 1; $i++) {
                        foreach ($menuOrders as $menuOrder) {
                            if ($i == 0) {
                                $i++;
                                $menuOrder->quantity = $quantity[$cont];
                                $menuOrder->price = $price[$cont];
                                $menuOrder->inc = $inc[$cont];
                                $menuOrder->subtotal = $subtotal;
                                $menuOrder->incsubt = $incsub;
                                $menuOrder->edition = true;
                                if ($menuOrder->status == 'anulado') {
                                    $menuOrder->status = 'nuevo';
                                }
                                $menuOrder->update();
                            }
                        }
                    }

                    /*
                    if ($sumOrder > 0) {
                        $menuOrder = new MenuOrder();
                        $menuOrder->order_id = $order->id;
                        $menuOrder->menu_id  = $menu_id[$cont];
                        $menuOrder->quantity    = $quantity[$cont];
                        $menuOrder->price       = $price[$cont];
                        $menuOrder->inc         = $inc[$cont];
                        $menuOrder->subtotal    = $subtotal;
                        $menuOrder->incsubt     = $incsub;
                        $menuOrder->save();
                    } else {
                        $menuOrder->quantity += $quantity[$cont];
                        $menuOrder->price = $price[$cont];
                        $menuOrder->inc = $inc[$cont];
                        $menuOrder->subtotal = $subtotal;
                        $menuOrder->incsubt = $incsub;
                        $menuOrder->edition = true;
                        $menuOrder->update();
                    }*/
                }
            }
            $cont++;
        }
        $menuOrders = MenuOrder::where('order_id', $order->id)->get();
        foreach ($menuOrders as $key => $menuOrder) {
            if ($menuOrder->quantity == 0) {
                $menuOrder->status = 'anulado';
                $menuOrder->update();
            }
        }
        session(['order' => $order->id]);

        toast('Comanda Editada satisfactoriamente.','success');
        return redirect('order');
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
    \session()->put('total', $orders->total, 60 * 24 *365);
    \session()->put('total_inc', $orders->total_inc, 60 * 24 *365);
    \session()->put('total_pay', $orders->total_pay, 60 * 24 *365);
    \session()->put('status', $orders->estado, 60 * 24 *365);
    return redirect('menuOrder/create');
    }

    public function orderPdf(Request $request,$id)
    {
        $order = Order::where('id', $id)->first();
        $menuOrders = MenuOrder::where('order_id', $id)->where('quantity', '>', 0)->get();
        $company = Company::where('id', 1)->first();

        $days = $order->created_at->diffInDays($order->due_date);
        $orderpdf = "PEDIDO-". $order->id;
        $logo = './imagenes/logos'.$company->logo;
        $view = \view('admin.order.pdf', compact('order', 'days', 'menuOrders', 'company', 'logo'))->render();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        //$pdf->setPaper ( 'A7' , 'landscape' );

        //return $pdf->download("$orderpdf.pdf");
        return $pdf->stream('vista-pdf', "$orderpdf.pdf");
    }

    public function orderPost(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $menuOrders = MenuOrder::where('order_id', $id)->where('quantity', '>', 0)->get();
        $company = Company::where('id', 1)->first();

        $orderpdf = "FACT-". $order->id;
        $logo = './imagenes/logos'.$company->logo;
        $view = \view('admin.order.post', compact('order', 'menuOrders', 'company', 'logo'))->render();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        $pdf->setPaper (array(0,0,226.76,497.64), 'portrait');

        return $pdf->stream('vista-pdf', "$orderpdf.pdf");
        //return $pdf->download("$orderpdf.pdf");
    }

    public function postOrder(Request $request)
    {
        $orders = session('order');
        $order = Order::findOrFail($orders);
        session()->forget('order');
        $menuOrders = MenuOrder::where('order_id', $order->id)->where('quantity', '>', 0)->get();
        $company = Company::where('id', 1)->first();

        $orderpdf = "FACT-". $order->id;
        $logo = './imagenes/logos'.$company->logo;
        $view = \view('admin.order.post', compact('order', 'menuOrders', 'company', 'logo'))->render();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        $pdf->setPaper (array(0,0,226.76,497.64), 'portrait');

        return $pdf->stream('vista-pdf', "$orderpdf.pdf");
        //return $pdf->download("$orderpdf.pdf");
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

        $order = Order::findOrFail($id);
        $order->total_pay = 0;
        $order->pay       = 0;
        $order->balance       = 0;
        $order->status      = 'anulada';
        $order->save();

        return redirect("order")->with('success', 'Pedido Anulado Satisfactoriamente');
    }
}

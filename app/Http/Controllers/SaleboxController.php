<?php

namespace App\Http\Controllers;

use App\Models\Sale_box;
use App\Http\Requests\StoreSaleboxRequest;
use App\Http\Requests\UpdateSaleboxRequest;
use App\Models\Branch;
use App\Models\Cash_in;
use App\Models\Cash_out;
use App\Models\Company;
use App\Models\Expense;
use App\Models\Verification_code;
use App\Models\Invoice;
use App\Models\InvoiceMenu;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Pay_expense;
use App\Models\Pay_invoice;
use App\Models\Pay_purchase;
use App\Models\Product;
use App\Models\Product_purchase;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class SaleboxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user()->role_id;

        if (request()->ajax()) {
            if ($user == 1 || $user == 2) {
                $sale_boxes = Sale_box::get();
            } else {
                $sale_boxes = Sale_box::where('user_id', Auth::user()->id)->get();
            }
            return DataTables::of($sale_boxes)
            ->addIndexColumn()
            ->addColumn('user', function (Sale_box $saleBox) {
                return $saleBox->user->name;
            })
            ->addColumn('branch', function (Sale_box $saleBox) {
                return $saleBox->branch->name;
            })
            ->addColumn('total', function (Sale_box $saleBox) {
                return $saleBox->cash - $saleBox->departure;
            })
            ->editColumn('created_at', function(Sale_box $saleBox){
                return $saleBox->created_at->format('yy-m-d: h:m');
            })
            ->addColumn('btn', 'admin/sale_box/actions')
            ->rawcolumns(['btn'])
            ->make(true);
        }
        return view('admin.sale_box.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('id', '!=', 1)->get();
        $branches = Branch::get();

        return view("admin.sale_box.create", compact('users', 'branches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSaleboxRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSaleboxRequest $request)
    {
        $comprobation = $request->cash_box;

        if($comprobation < 0){
            toast( 'La cantidad debe ser mayo a 0','warning');
            return redirect("sale_box");//->with('warning', 'Usuario No autorizado para ejercer como administrador');
        }
        $user = Auth::user()->id;
        $branch = Auth::user()->branch_id;
        $open = $request->user_open_id;
        $verify = $request->verification_code_open;
        $verification_code = Verification_code::select('id', 'code')->where('user_id', '=', $open)->first();
        $open_box = Sale_box::where('user_id', '=', $user)->where('status', '=', 'open')->first();

        if($verification_code == null){
            toast( 'Usuario No autorizado para ejercer como administrador','warning');
            return redirect("sale_box");
        }

        if ($verification_code->code != $verify) {
            toast( 'Error en codigo de verificacion','warning');
            return redirect("sale_box");
        } elseif($open_box) {
            toast( 'Usuario ya tiene una Caja Abierta','warning');
            return redirect("sale_box");
        } else {
            $sale_box = new Sale_box();
            $sale_box->cash_box            = $request->cash_box;
            $sale_box->in_cash             = 0;
            $sale_box->in_order_cash       = 0;
            $sale_box->in_order            = 0;
            $sale_box->order               = 0;
            $sale_box->in_invoice_cash     = 0;
            $sale_box->in_invoice          = 0;
            $sale_box->invoice             = 0;
            $sale_box->in_advance_cash     = 0;
            $sale_box->in_advance          = 0;
            $sale_box->in_ndinvoice_cash   = 0;
            $sale_box->in_ndinvoice        = 0;
            $sale_box->ndinvoice           = 0;
            $sale_box->in_ncpurchase_cash  = 0;
            $sale_box->in_ncpurchase       = 0;
            $sale_box->ncpurchase          = 0;
            $sale_box->in_total            = 0;
            $sale_box->out_purchase_cash   = 0;
            $sale_box->out_purchase        = 0;
            $sale_box->purchase            = 0;
            $sale_box->out_expense_cash    = 0;
            $sale_box->out_expense         = 0;
            $sale_box->expense             = 0;
            $sale_box->out_payment_cash    = 0;
            $sale_box->out_payment         = 0;
            $sale_box->out_ncinvoice_cash  = 0;
            $sale_box->out_ncinvoice       = 0;
            $sale_box->ncinvoice           = 0;
            $sale_box->out_ndpurchase_cash = 0;
            $sale_box->out_ndpurchase      = 0;
            $sale_box->ndpurchase          = 0;
            $sale_box->out_total           = 0;
            $sale_box->out_cash            = 0;
            $sale_box->cash                = $request->cash_box;
            $sale_box->departure           = 0;
            $sale_box->verification_code_open  = $request->verification_code_open;
            $sale_box->verification_code_close = null;
            $sale_box->branch_id         = $branch;
            $sale_box->user_id           = $user;
            $sale_box->user_open_id      = $request->user_open_id;
            $sale_box->user_close_id     = $request->user_close_id;
            $sale_box->save();
        }
        return redirect("sale_box")->with('success', 'Caja creada Satisfactoriamente');
    }

    public function show($id)
    {
        $user = Auth::user();
        $sale_box = Sale_box::findOrFail($id);
        $from = $sale_box->created_at;
        $to = $sale_box->updated_at;

        /*if ($user->role_id == 1 || $user->role_id == 2) {
            $produc = [];
            $cont = 0;
            $products = Product::all();
            foreach ($products as $key => $product ) {
                $invoice_products = Invoice_product::from('invoice_products as ip')
                ->join('invoices as inv', 'ip.invoice_id', 'inv.id')
                ->join('products as pro', 'ip.product_id', 'pro.id')
                ->select('pro.id', 'pro.name', 'ip.quantity', 'ip.incsubt', 'ip.subtotal', 'ip.created_at')
                ->whereBetween('ip.created_at', [$from, $to])
                ->where('inv.user_id', $sale_box->user_id)
                ->where('ip.product_id', $product->id)
                ->sum('quantity');

                $inci = Invoice_product::from('invoice_products as ip')
                ->join('invoices as inv', 'ip.invoice_id', 'inv.id')
                ->join('products as pro', 'ip.product_id', 'pro.id')
                ->select('pro.id', 'pro.name', 'ip.quantity', 'ip.incsubt', 'ip.subtotal', 'ip.created_at')
                ->whereBetween('ip.created_at', [$from, $to])
                ->where('inv.user_id', $sale_box->user_id)
                ->where('ip.product_id', $product->id)
                ->sum('incsubt');

                if ($invoice_products) {
                    $produc[$cont] = Product::findOrFail($product->id);
                    $produc[$cont]->stock = $invoice_products;
                    $produc[$cont]->price = $inci;
                    $cont++;
                }
            }

            $productpurc = [];
            $cont = 0;
            //$products = Product::all();
            foreach ($products as $key => $product ) {
                $product_purchases = Product_purchase::from('product_purchases as pp')
                ->join('purchases as pur', 'pp.purchase_id', 'pur.id')
                ->join('products as pro', 'pp.product_id', 'pro.id')
                ->select('pro.id', 'pro.name', 'pp.quantity', 'pp.incsubt', 'pp.subtotal', 'pp.created_at')
                ->whereBetween('pp.created_at', [$from, $to])
                ->where('pur.user_id', $sale_box->user_id)
                ->where('pp.product_id', $product->id)
                ->sum('quantity');

                $incp = Product_purchase::from('product_purchases as pp')
                ->join('purchases as pur', 'pp.purchase_id', 'pur.id')
                ->join('products as pro', 'pp.product_id', 'pro.id')
                ->select('pro.id', 'pro.name', 'pp.quantity', 'pp.incsubt', 'pp.subtotal', 'pp.created_at')
                ->whereBetween('pp.created_at', [$from, $to])
                ->where('pur.user_id', $sale_box->user_id)
                ->where('pp.product_id', $product->id)
                ->sum('incsubt');

                if ($product_purchases) {
                    $productpurc[$cont] = Product::findOrFail($product->id);
                    $productpurc[$cont]->stock = $product_purchases;
                    $productpurc[$cont]->price = $incp;
                    $cont++;
                }
            }

            $invoices = Invoice::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
            $invbalance = Invoice::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('balance');
            $invpay = Invoice::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('pay');

            $orders = Order::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
            $ordbalance = Order::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('balance');
            $ordpay = Order::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('pay');

            $purchases = Purchase::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
            $purbalance = Purchase::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('balance');
            $purpay = Purchase::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('pay');

            $expenses = Expense::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();

            $ncinvoices = Ncinvoice::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
            $ncipay =  Ncinvoice::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('total_pay');

            $ndinvoices = Ndinvoice::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
            $ndipay = Ndinvoice::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('total_pay');

            $pay_orders = Pay_order::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
            $sum_pay_orders = Pay_order::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('pay');
            $pay_invoices = Pay_invoice::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
            $sum_pay_invoices = Pay_invoice::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('pay');
            $pay_purchases = Pay_purchase::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
            $sum_pay_purchases = Pay_purchase::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('pay');
            $payments = Payment::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
            $sum_payments = Payment::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('pay');
            $advances = Advance::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
            $sum_advances = Advance::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('pay');

            //$cash_outs = Cash_out::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
            $sum_pay_cashs = Cash_out::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('payment');
            $cash_outs = Cash_out::from('cash_outs AS cas')
            ->join('sale_boxes AS sai', 'cas.sale_box_id', 'sai.id')
            ->join('users AS use', 'cas.user_id', 'use.id')
            ->join('users AS usa', 'cas.admin_id', 'usa.id')
            ->select('cas.id', 'cas.payment', 'cas.created_at', 'usa.name')
            ->where('cas.user_id', '=', $sale_box->user_id)
            ->whereBetween('cas.created_at', [$from, $to])
            ->get();
        } else {*/

            //seccion de detalle de productos en compra
        $productPurchases = [];//informacion de totales
        $products = Product::get();
        //obteniendo totales por productos de product purchases
        foreach ($products as $key => $product ) {
            //total de productos
            $product_purchase = Product_purchase::from('product_purchases as pp')
            ->join('purchases as pur', 'pp.purchase_id', 'pur.id')
            ->join('products as pro', 'pp.product_id', 'pro.id')
            ->whereBetween('pp.created_at', [$from, $to])
            ->where('pur.user_id', $sale_box->user_id)
            ->where('pp.product_id', $product->id)
            ->sum('quantity');

            //total  de inc por producto
            $incProduct = Product_purchase::from('product_purchases as pp')
            ->join('purchases as pur', 'pp.purchase_id', 'pur.id')
            ->join('products as pro', 'pp.product_id', 'pro.id')
            ->whereBetween('pp.created_at', [$from, $to])
            ->where('pur.user_id', $sale_box->user_id)
            ->where('pp.product_id', $product->id)
            ->sum('incsubt');
            //subtotal por producto
            $subtotalProduct = Product_purchase::from('product_purchases as pp')
            ->join('purchases as pur', 'pp.purchase_id', 'pur.id')
            ->join('products as pro', 'pp.product_id', 'pro.id')
            ->whereBetween('pp.created_at', [$from, $to])
            ->where('pur.user_id', $sale_box->user_id)
            ->where('pp.product_id', $product->id)
            ->sum('subtotal');
            //envienado informacion de totales a travez de este array
            if ($product_purchase) {
                $productPurchases[$key] = Product::findOrFail($product->id);
                $productPurchases[$key]->stock = $product_purchase;
                $productPurchases[$key]->price = $incProduct;
                $productPurchases[$key]->salePrice = $subtotalProduct;
            }
        }
        //suma subtotales de todas las compras
        $sumSubtotalPurchases = Product_purchase::from('product_purchases as pp')
        ->join('purchases as pur', 'pp.purchase_id', 'pur.id')
        ->where('pur.user_id', $sale_box->user_id)
        ->whereBetween('pp.created_at', [$from, $to])
        ->sum('subtotal');

        //suma de total de inc de toda las compras
        $incTotalPurchases = Product_purchase::from('product_purchases as pp')
        ->join('purchases as pur', 'pp.purchase_id', 'pur.id')
        ->where('pur.user_id', $sale_box->user_id)
        ->whereBetween('pp.created_at', [$from, $to])
        ->sum('incsubt');

        //seccion de detalle de productos Vendidos
        $invoiceMenus = [];//informacion de totales
        $menus = Menu::get();
        //obteniendo totales por productos de product purchases
        foreach ($menus as $key => $menu ) {
            //total de productos
            $invoiceMenu = InvoiceMenu::from('invoice_menus as im')
            ->join('invoices as inv', 'im.invoice_id', 'inv.id')
            ->join('menus as men', 'im.menu_id', 'men.id')
            ->whereBetween('im.created_at', [$from, $to])
            ->where('inv.user_id', $sale_box->user_id)
            ->where('im.menu_id', $menu->id)
            ->sum('quantity');

            //total  de inc por producto
            $incMenu = InvoiceMenu::from('invoice_menus as im')
            ->join('invoices as inv', 'im.invoice_id', 'inv.id')
            ->join('menus as men', 'im.menu_id', 'men.id')
            ->whereBetween('im.created_at', [$from, $to])
            ->where('inv.user_id', $sale_box->user_id)
            ->where('im.menu_id', $menu->id)
            ->sum('incsubt');

            //subtotal por
            $subtotalMenu = InvoiceMenu::from('invoice_menus as im')
            ->join('invoices as inv', 'im.invoice_id', 'inv.id')
            ->join('menus as men', 'im.menu_id', 'men.id')
            ->whereBetween('im.created_at', [$from, $to])
            ->where('inv.user_id', $sale_box->user_id)
            ->where('im.menu_id', $menu->id)
            ->sum('subtotal');
            //envienado informacion de totales a travez de este array
            if ($invoiceMenu) {
                $invoiceMenus[$key] = Menu::findOrFail($menu->id);
                $invoiceMenus[$key]->stock = $invoiceMenu;
                $invoiceMenus[$key]->price = $incMenu;
                $invoiceMenus[$key]->salePrice = $subtotalMenu;
            }
        }
        $sumSubtotalInvoices = InvoiceMenu::from('invoice_menus as im')
        ->join('invoices as inv', 'im.invoice_id', 'inv.id')
        ->whereBetween('im.created_at', [$from, $to])
        ->where('inv.user_id', $sale_box->user_id)
        ->sum('subtotal');

        //suma de total de inc de toda las compras
        $incTotalInvoices = InvoiceMenu::from('invoice_menus as im')
        ->join('invoices as inv', 'im.invoice_id', 'inv.id')
        ->whereBetween('im.created_at', [$from, $to])
        ->where('inv.user_id', $sale_box->user_id)
        ->sum('incsubt');

            $invoices = Invoice::where('user_id', $user->id)->whereBetween('created_at', [$from, $to])->get();
            $invbalance = Invoice::where('user_id', $user->id)->whereBetween('created_at', [$from, $to])->sum('balance');
            $invpay = Invoice::where('user_id', $user->id)->whereBetween('created_at', [$from, $to])->sum('pay');

            $orders = Order::where('user_id', $user->id)->whereBetween('created_at', [$from, $to])->get();

            $purchases = Purchase::where('user_id', $user->id)->whereBetween('created_at', [$from, $to])->get();
            $purbalance = Purchase::where('user_id', $user->id)->whereBetween('created_at', [$from, $to])->sum('balance');
            $purpay = Purchase::where('user_id', $user->id)->whereBetween('created_at', [$from, $to])->sum('pay');

            $expenses = Expense::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
            $expbalance = Expense::where('user_id', $user->id)->whereBetween('created_at', [$from, $to])->sum('balance');
            $exppay =  Expense::where('user_id', $user->id)->whereBetween('created_at', [$from, $to])->sum('total_pay');

            $pay_invoices = Pay_invoice::where('user_id', $user->id)->whereBetween('created_at', [$from, $to])->get();
            $sum_pay_invoices = Pay_invoice::where('user_id', $user->id)->whereBetween('created_at', [$from, $to])->sum('pay');

            $pay_purchases = Pay_purchase::where('user_id', $user->id)->whereBetween('created_at', [$from, $to])->get();
            $sum_pay_purchases = Pay_purchase::where('user_id', $user->id)->whereBetween('created_at', [$from, $to])->sum('pay');

            $pay_expenses = Pay_expense::where('user_id', $user->id)->whereBetween('created_at', [$from, $to])->get();
            $sum_pay_expenses = Pay_expense::where('user_id', $user->id)->whereBetween('created_at', [$from, $to])->sum('pay');

            //$cash_outs = Cash_out::where('user_id', $user->id)->whereBetween('created_at', [$from, $to])->get();
            $sum_cash_outs = Cash_out::where('user_id', $user->id)->whereBetween('created_at', [$from, $to])->sum('payment');

            $cashOuts = Cash_out::from('cash_outs AS cas')
            ->join('sale_boxes AS sai', 'cas.sale_box_id', 'sai.id')
            ->join('users AS use', 'cas.user_id', 'use.id')
            ->join('users AS usa', 'cas.admin_id', 'usa.id')
            ->select('cas.id', 'cas.payment', 'cas.created_at', 'usa.name')
            ->where('cas.user_id', '=', $user->id)
            ->whereBetween('cas.created_at', [$from, $to])
            ->get();

            $sum_cash_ins = Cash_in::where('user_id', $user->id)->whereBetween('created_at', [$from, $to])->sum('payment');

            $cashIns = Cash_in::from('cash_ins AS cas')
            ->join('sale_boxes AS sal', 'cas.sale_box_id', 'sal.id')
            ->join('users AS use', 'cas.user_id', 'use.id')
            ->join('users AS usa', 'cas.admin_id', 'usa.id')
            ->select('cas.id', 'cas.payment', 'cas.created_at', 'usa.name')
            ->where('cas.user_id', '=', $user->id)
            ->whereBetween('cas.created_at', [$from, $to])
            ->get();
        //}

        return view('admin.sale_box.show', compact(
            'sale_box',
            'productPurchases',
            'products',
            'invoiceMenus',
            'menus',
            'invoices',
            'invbalance',
            'invpay',

            'orders',

            'purchases',
            'purbalance',
            'purpay',

            'expenses',
            'expbalance',
            'exppay',

            'pay_invoices',
            'sum_pay_invoices',

            'pay_purchases',
            'sum_pay_purchases',

            'pay_expenses',
            'sum_pay_expenses',
            'sum_cash_outs',

            'cashOuts',

            'sum_cash_ins',

            'cashIns',
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale_box  $sale_box
     * @return \Illuminate\Http\Response
     */
    public function show_close($id)
    {
        $users    = Auth::user()->role_id;
        $user     = Auth::user()->id;
        $cause    = Auth::user()->name;
        $sale_box = Sale_box::findOrFail($id);
        $from     = $sale_box->created_at;
        $to       = $sale_box->updated_at;
        //seccion de detalle de productos en compra
        $productPurchases = [];//informacion de totales
        $products = Product::get();
        //obteniendo totales por productos de product purchases
        foreach ($products as $key => $product ) {
            //total de productos
            $product_purchase = Product_purchase::from('product_purchases as pp')
            ->join('purchases as pur', 'pp.purchase_id', 'pur.id')
            ->join('products as pro', 'pp.product_id', 'pro.id')
            ->whereBetween('pp.created_at', [$from, $to])
            ->where('pur.user_id', $sale_box->user_id)
            ->where('pp.product_id', $product->id)
            ->sum('quantity');

            //total  de inc por producto
            $incProduct = Product_purchase::from('product_purchases as pp')
            ->join('purchases as pur', 'pp.purchase_id', 'pur.id')
            ->join('products as pro', 'pp.product_id', 'pro.id')
            ->whereBetween('pp.created_at', [$from, $to])
            ->where('pur.user_id', $sale_box->user_id)
            ->where('pp.product_id', $product->id)
            ->sum('incsubt');
            //subtotal por producto
            $subtotalProduct = Product_purchase::from('product_purchases as pp')
            ->join('purchases as pur', 'pp.purchase_id', 'pur.id')
            ->join('products as pro', 'pp.product_id', 'pro.id')
            ->whereBetween('pp.created_at', [$from, $to])
            ->where('pur.user_id', $sale_box->user_id)
            ->where('pp.product_id', $product->id)
            ->sum('subtotal');
            //envienado informacion de totales a travez de este array
            if ($product_purchase) {
                $productPurchases[$key] = Product::findOrFail($product->id);
                $productPurchases[$key]->stock = $product_purchase;
                $productPurchases[$key]->price = $incProduct;
                $productPurchases[$key]->salePrice = $subtotalProduct;
            }
        }
        //suma subtotales de todas las compras
        $sumSubtotalPurchases = Product_purchase::from('product_purchases as pp')
        ->join('purchases as pur', 'pp.purchase_id', 'pur.id')
        ->where('pur.user_id', $sale_box->user_id)
        ->whereBetween('pp.created_at', [$from, $to])
        ->sum('subtotal');

        //suma de total de inc de toda las compras
        $incTotalPurchases = Product_purchase::from('product_purchases as pp')
        ->join('purchases as pur', 'pp.purchase_id', 'pur.id')
        ->where('pur.user_id', $sale_box->user_id)
        ->whereBetween('pp.created_at', [$from, $to])
        ->sum('incsubt');

        //seccion de detalle de productos Vendidos
        $invoiceMenus = [];//informacion de totales
        $menus = Menu::get();
        //obteniendo totales por productos de product purchases
        foreach ($menus as $key => $menu ) {
            //total de productos
            $invoiceMenu = InvoiceMenu::from('invoice_menus as im')
            ->join('invoices as inv', 'im.invoice_id', 'inv.id')
            ->join('menus as men', 'im.menu_id', 'men.id')
            ->whereBetween('im.created_at', [$from, $to])
            ->where('inv.user_id', $sale_box->user_id)
            ->where('im.menu_id', $menu->id)
            ->sum('quantity');

            //total  de inc por producto
            $incMenu = InvoiceMenu::from('invoice_menus as im')
            ->join('invoices as inv', 'im.invoice_id', 'inv.id')
            ->join('menus as men', 'im.menu_id', 'men.id')
            ->whereBetween('im.created_at', [$from, $to])
            ->where('inv.user_id', $sale_box->user_id)
            ->where('im.menu_id', $menu->id)
            ->sum('incsubt');

            //subtotal por
            $subtotalMenu = InvoiceMenu::from('invoice_menus as im')
            ->join('invoices as inv', 'im.invoice_id', 'inv.id')
            ->join('menus as men', 'im.menu_id', 'men.id')
            ->whereBetween('im.created_at', [$from, $to])
            ->where('inv.user_id', $sale_box->user_id)
            ->where('im.menu_id', $menu->id)
            ->sum('subtotal');
            //envienado informacion de totales a travez de este array
            if ($invoiceMenu) {
                $invoiceMenus[$key] = Menu::findOrFail($menu->id);
                $invoiceMenus[$key]->stock = $invoiceMenu;
                $invoiceMenus[$key]->price = $incMenu;
                $invoiceMenus[$key]->salePrice = $subtotalMenu;
            }
        }
        $sumSubtotalInvoices = InvoiceMenu::from('invoice_menus as im')
        ->join('invoices as inv', 'im.invoice_id', 'inv.id')
        ->whereBetween('im.created_at', [$from, $to])
        ->where('inv.user_id', $sale_box->user_id)
        ->sum('subtotal');

        //suma de total de inc de toda las compras
        $incTotalInvoices = InvoiceMenu::from('invoice_menus as im')
        ->join('invoices as inv', 'im.invoice_id', 'inv.id')
        ->whereBetween('im.created_at', [$from, $to])
        ->where('inv.user_id', $sale_box->user_id)
        ->sum('incsubt');
        /*
        //seccion de detalle de productos Vendidos
        $invoiceProducts = [];//informacion de totales
        //obteniendo totales por productos de product purchases
        foreach ($products as $key => $product ) {
            //total de productos
            $invoice_products = Invoice_product::from('invoice_products as ip')
            ->join('invoices as inv', 'ip.invoice_id', 'inv.id')
            ->join('products as pro', 'ip.product_id', 'pro.id')
            ->whereBetween('ip.created_at', [$from, $to])
            ->where('inv.user_id', $sale_box->user_id)
            ->where('ip.product_id', $product->id)
            ->sum('quantity');

            //total  de inc por producto
            $incProduct = Invoice_product::from('invoice_products as ip')
            ->join('invoices as inv', 'ip.invoice_id', 'inv.id')
            ->join('products as pro', 'ip.product_id', 'pro.id')
            ->whereBetween('ip.created_at', [$from, $to])
            ->where('inv.user_id', $sale_box->user_id)
            ->where('ip.product_id', $product->id)
            ->sum('incsubt');
            //subtotal por producto
            $subtotalProduct = Invoice_product::from('invoice_products as ip')
            ->join('invoices as inv', 'ip.invoice_id', 'inv.id')
            ->join('products as pro', 'ip.product_id', 'pro.id')
            ->whereBetween('ip.created_at', [$from, $to])
            ->where('inv.user_id', $sale_box->user_id)
            ->where('ip.product_id', $product->id)
            ->sum('subtotal');
            //envienado informacion de totales a travez de este array
            if ($invoice_products) {
                $invoiceProducts[$key] = Product::findOrFail($product->id);
                $invoiceProducts[$key]->stock = $invoice_products;
                $invoiceProducts[$key]->price = $incProduct;
                $invoiceProducts[$key]->salePrice = $subtotalProduct;
            }
        }
        //suma subtotales de todas las compras
        $sumSubtotalInvoices = Invoice_product::from('invoice_products as ip')
        ->join('invoices as inv', 'ip.invoice_id', 'inv.id')
        ->whereBetween('ip.created_at', [$from, $to])
        ->where('inv.user_id', $sale_box->user_id)
        ->sum('subtotal');

        //suma de total de inc de toda las compras
        $incTotalInvoices = Invoice_product::from('invoice_products as ip')
        ->join('invoices as inv', 'ip.invoice_id', 'inv.id')
        ->whereBetween('ip.created_at', [$from, $to])
        ->where('inv.user_id', $sale_box->user_id)
        ->sum('incsubt');*/

        $invoices = Invoice::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
        $invoice_balance = Invoice::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('balance');
        $invoice_pay = Invoice::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('pay');
        $pay_invoices = Pay_invoice::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
        $sum_pay_invoices = Pay_invoice::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('pay');

        $orders = Order::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
        //$order_balance = Order::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('balance');
        //$order_pay = Order::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('pay');
        //$pay_orders = Pay_order::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
        //$sum_pay_orders = Pay_order::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('pay');

        $purchases = Purchase::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
        $purchase_balance = Purchase::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('balance');
        $purchase_pay = Purchase::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('pay');
        $pay_purchases = Pay_purchase::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
        $sum_pay_purchases = Pay_purchase::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('pay');

        $expenses = Expense::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
        $expense_balance = Expense::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('balance');
        $expense_pay = Expense::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('pay');
        $pay_expenses = Pay_expense::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
        $sum_pay_expenses = Pay_expense::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('pay');

        //$ncpurchases = Ndpurchase::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
        //$ncpurchaseTotal = Ncpurchase::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('total_pay');

        //$ndpurchases = Ndpurchase::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
        //$ndpurchaseTotal = Ndpurchase::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('total_pay');
        //dd($ndpurchaseTotal);
        //$ncinvoices = Ncinvoice::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
        //$ncinvoiceTotal = Ncinvoice::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('total_pay');

        //$ndinvoices = Ndinvoice::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
        //$ndinvoiceTotal = Ndinvoice::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('total_pay');

        $cash_outs = Cash_out::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
        $sum_pay_cashOuts = Cash_out::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('payment');

        $cash_ins = Cash_in::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
        $sum_pay_cashIns = Cash_in::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('payment');

        //$payments = Payment::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
        //$sum_payments = Payment::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('pay');

        //$advances = Advance::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
        //$sum_advances = Advance::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('pay');


        return view('admin.sale_box.show_close', compact(
            'productPurchases',
            'incTotalPurchases',
            'sumSubtotalPurchases',
            'invoiceMenus',
            'incTotalInvoices',
            'sumSubtotalInvoices',

            'invoices',
            'invoice_balance',
            'invoice_pay',
            'pay_invoices',
            'sum_pay_invoices',

            'orders',

            'purchases',
            'purchase_balance',
            'purchase_pay',
            'pay_purchases',
            'sum_pay_purchases',

            'expenses',
            'expense_balance',
            'expense_pay',
            'pay_expenses',
            'sum_pay_expenses',
            'sale_box',

            'products',

            'cash_outs',
            'sum_pay_cashOuts',

            'cash_ins',
            'sum_pay_cashIns',
        ));
    }


    public function show_pos($id)
    {
        /*
        $user = Auth::user()->id;
        $users = User::findOrFail($user);
        $cause = Auth::user()->name;
        $sale_box = Sale_box::findOrFail($id);
        $from = $sale_box->created_at;
        $to = $sale_box->updated_at;*/

        /*if ($users->role_id == 1 || $users->role_id == 2) {
            $produc = [];
            $cont = 0;
            $products = Product::all();
            foreach ($products as $key => $product ) {
                $invoice_products = Invoice_product::from('invoice_products as ip')
                ->join('invoices as inv', 'ip.invoice_id', 'inv.id')
                ->join('products as pro', 'ip.product_id', 'pro.id')
                ->select('pro.id', 'pro.name', 'ip.quantity', 'ip.incsubt', 'ip.subtotal', 'ip.created_at')
                ->whereBetween('ip.created_at', [$from, $to])
                ->where('inv.user_id', $sale_box->user_id)
                ->where('ip.product_id', $product->id)
                ->sum('quantity');

                $inci = Invoice_product::from('invoice_products as ip')
                ->join('invoices as inv', 'ip.invoice_id', 'inv.id')
                ->join('products as pro', 'ip.product_id', 'pro.id')
                ->select('pro.id', 'pro.name', 'ip.quantity', 'ip.incsubt', 'ip.subtotal', 'ip.created_at')
                ->whereBetween('ip.created_at', [$from, $to])
                ->where('inv.user_id', $sale_box->user_id)
                ->where('ip.product_id', $product->id)
                ->sum('incsubt');

                if ($invoice_products) {
                    $produc[$cont] = Product::findOrFail($product->id);
                    $produc[$cont]->stock = $invoice_products;
                    $produc[$cont]->price = $inci;
                    $cont++;
                }
            }

            $productpurc = [];
            $cont = 0;
            //$products = Product::all();
            foreach ($products as $key => $product ) {
                $product_purchases = Product_purchase::from('product_purchases as pp')
                ->join('purchases as pur', 'pp.purchase_id', 'pur.id')
                ->join('products as pro', 'pp.product_id', 'pro.id')
                ->select('pro.id', 'pro.name', 'pp.quantity', 'pp.incsubt', 'pp.subtotal', 'pp.created_at')
                ->whereBetween('pp.created_at', [$from, $to])
                ->where('pur.user_id', $sale_box->user_id)
                ->where('pp.product_id', $product->id)
                ->sum('quantity');

                $incp = Product_purchase::from('product_purchases as pp')
                ->join('purchases as pur', 'pp.purchase_id', 'pur.id')
                ->join('products as pro', 'pp.product_id', 'pro.id')
                ->select('pro.id', 'pro.name', 'pp.quantity', 'pp.incsubt', 'pp.subtotal', 'pp.created_at')
                ->whereBetween('pp.created_at', [$from, $to])
                ->where('pur.user_id', $sale_box->user_id)
                ->where('pp.product_id', $product->id)
                ->sum('incsubt');

                if ($product_purchases) {
                    $productpurc[$cont] = Product::findOrFail($product->id);
                    $productpurc[$cont]->stock = $product_purchases;
                    $productpurc[$cont]->price = $incp;
                    $cont++;
                }
            }

            $invoices = Invoice::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
            $invbalance = Invoice::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('balance');
            $invpay = Invoice::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('pay');

            $orders = Order::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
            $ordbalance = Order::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('balance');
            $ordpay = Order::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('pay');

            $purchases = Purchase::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
            $purbalance = Purchase::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('balance');
            $purpay = Purchase::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('pay');

            $expenses = Expense::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();

            $ncinvoices = Ncinvoice::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
            $ncipay =  Ncinvoice::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('total_pay');

            $ndinvoices = Ndinvoice::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
            $ndipay = Ndinvoice::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('total_pay');

            $pay_orders = Pay_order::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
            $sum_pay_orders = Pay_order::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('pay');

            $pay_invoices = Pay_invoice::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
            $sum_pay_invoices = Pay_invoice::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('pay');

            $pay_purchases = Pay_purchase::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
            $sum_pay_purchases = Pay_purchase::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('pay');

            $pay_expenses = Pay_expense::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
            $sum_pay_expenses = Pay_expense::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('pay');

            $payments = Payment::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
            $sum_payments = Payment::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('pay');

            $advances = Advance::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
            $sum_advances = Advance::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('pay');

            //$cash_outs = Cash_out::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
            $sum_pay_cashs = Cash_out::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('payment');
            $cash_outs = Cash_out::from('cash_outs AS cas')
            ->join('sale_boxes AS sai', 'cas.sale_box_id', 'sai.id')
            ->join('users AS use', 'cas.user_id', 'use.id')
            ->join('users AS usa', 'cas.admin_id', 'usa.id')
            ->select('cas.id', 'cas.payment', 'cas.created_at', 'usa.name')
            ->where('cas.user_id', '=', $sale_box->user_id)
            ->whereBetween('cas.created_at', [$from, $to])
            ->get();
        } else {*/
            $company = Company::findOrFail(1);
            $users    = Auth::user()->role_id;
            $user     = Auth::user()->id;
            $cause    = Auth::user()->name;
            $sale_box = Sale_box::findOrFail($id);
            $from     = $sale_box->created_at;
            $to       = $sale_box->updated_at;
            //seccion de detalle de productos en compra


            //seccion de detalle de productos Vendidos
            $invoiceMenus = [];//informacion de totales
            $menus = Menu::get();
            //obteniendo totales por productos de product purchases
            foreach ($menus as $key => $menu ) {
                //total de productos
                $invoiceMenu = InvoiceMenu::from('invoice_menus as im')
                ->join('invoices as inv', 'im.invoice_id', 'inv.id')
                ->join('menus as men', 'im.menu_id', 'men.id')
                ->whereBetween('im.created_at', [$from, $to])
                ->where('inv.user_id', $sale_box->user_id)
                ->where('im.menu_id', $menu->id)
                ->sum('quantity');

                //total  de inc por producto
                $incMenu = InvoiceMenu::from('invoice_menus as im')
                ->join('invoices as inv', 'im.invoice_id', 'inv.id')
                ->join('menus as men', 'im.menu_id', 'men.id')
                ->whereBetween('im.created_at', [$from, $to])
                ->where('inv.user_id', $sale_box->user_id)
                ->where('im.menu_id', $menu->id)
                ->sum('incsubt');

                //subtotal por
                $subtotalMenu = InvoiceMenu::from('invoice_menus as im')
                ->join('invoices as inv', 'im.invoice_id', 'inv.id')
                ->join('menus as men', 'im.menu_id', 'men.id')
                ->whereBetween('im.created_at', [$from, $to])
                ->where('inv.user_id', $sale_box->user_id)
                ->where('im.menu_id', $menu->id)
                ->sum('subtotal');
                //envienado informacion de totales a travez de este array
                if ($invoiceMenu) {
                    $invoiceMenus[$key] = Menu::findOrFail($menu->id);
                    $invoiceMenus[$key]->stock = $invoiceMenu;
                    $invoiceMenus[$key]->price = $incMenu;
                    $invoiceMenus[$key]->salePrice = $subtotalMenu;
                }
            }
            $sumSubtotalInvoices = InvoiceMenu::from('invoice_menus as im')
            ->join('invoices as inv', 'im.invoice_id', 'inv.id')
            ->whereBetween('im.created_at', [$from, $to])
            ->where('inv.user_id', $sale_box->user_id)
            ->sum('subtotal');

            //suma de total de inc de toda las compras
            $incTotalInvoices = InvoiceMenu::from('invoice_menus as im')
            ->join('invoices as inv', 'im.invoice_id', 'inv.id')
            ->whereBetween('im.created_at', [$from, $to])
            ->where('inv.user_id', $sale_box->user_id)
            ->sum('incsubt');

            //seccion de detalle de productos en compra
            $productPurchases = [];//informacion de totales
            $products = Product::get();
            //obteniendo totales por productos de product purchases
            foreach ($products as $key => $product ) {
                //total de productos
                $product_purchase = Product_purchase::from('product_purchases as pp')
                ->join('purchases as pur', 'pp.purchase_id', 'pur.id')
                ->join('products as pro', 'pp.product_id', 'pro.id')
                ->whereBetween('pp.created_at', [$from, $to])
                ->where('pur.user_id', $sale_box->user_id)
                ->where('pp.product_id', $product->id)
                ->sum('quantity');

                //total  de inc por producto
                $incProduct = Product_purchase::from('product_purchases as pp')
                ->join('purchases as pur', 'pp.purchase_id', 'pur.id')
                ->join('products as pro', 'pp.product_id', 'pro.id')
                ->whereBetween('pp.created_at', [$from, $to])
                ->where('pur.user_id', $sale_box->user_id)
                ->where('pp.product_id', $product->id)
                ->sum('incsubt');
                //subtotal por producto
                $subtotalProduct = Product_purchase::from('product_purchases as pp')
                ->join('purchases as pur', 'pp.purchase_id', 'pur.id')
                ->join('products as pro', 'pp.product_id', 'pro.id')
                ->whereBetween('pp.created_at', [$from, $to])
                ->where('pur.user_id', $sale_box->user_id)
                ->where('pp.product_id', $product->id)
                ->sum('subtotal');
                //envienado informacion de totales a travez de este array
                if ($product_purchase) {
                    $productPurchases[$key] = Product::findOrFail($product->id);
                    $productPurchases[$key]->stock = $product_purchase;
                    $productPurchases[$key]->price = $incProduct;
                    $productPurchases[$key]->salePrice = $subtotalProduct;
                }
            }
            //suma subtotales de todas las compras
            $sumSubtotalPurchases = Product_purchase::from('product_purchases as pp')
            ->join('purchases as pur', 'pp.purchase_id', 'pur.id')
            ->where('pur.user_id', $sale_box->user_id)
            ->whereBetween('pp.created_at', [$from, $to])
            ->sum('subtotal');

            //suma de total de inc de toda las compras
            $incTotalPurchases = Product_purchase::from('product_purchases as pp')
            ->join('purchases as pur', 'pp.purchase_id', 'pur.id')
            ->where('pur.user_id', $sale_box->user_id)
            ->whereBetween('pp.created_at', [$from, $to])
            ->sum('incsubt');
            //dd($productpurc);
            $invoices = Invoice::where('user_id', $user)->whereBetween('created_at', [$from, $to])->get();
            //$invTotalPay = Invoice::where('user_id', $user)->whereBetween('created_at', [$from, $to])->sum('total_pay');
            //$invbalance = Invoice::where('user_id', $user->id)->whereBetween('created_at', [$from, $to])->sum('balance');
            //$invpay = Invoice::where('user_id', $user)->whereBetween('created_at', [$from, $to])->sum('pay');

            $orders = Order::where('user_id', $user)->whereBetween('created_at', [$from, $to])->get();
            //$ordTotalPay = Order::where('user_id', $user)->whereBetween('created_at', [$from, $to])->sum('total_pay');
            //$ordbalance = Order::where('user_id', $user->id)->whereBetween('created_at', [$from, $to])->sum('balance');
            //$ordpay = Order::where('user_id', $user)->whereBetween('created_at', [$from, $to])->sum('pay');

            $purchases = Purchase::where('user_id', $user)->whereBetween('created_at', [$from, $to])->get();
            //$purTotalPay = Purchase::where('user_id', $user)->whereBetween('created_at', [$from, $to])->sum('total_pay');
            //$purbalance = Purchase::where('user_id', $user->id)->whereBetween('created_at', [$from, $to])->sum('balance');
            //$purpay = Purchase::where('user_id', $user)->whereBetween('created_at', [$from, $to])->sum('pay');

            $expenses = Expense::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
            //$expTotalPay = Purchase::where('user_id', $user)->whereBetween('created_at', [$from, $to])->sum('total_pay');

            //$ncinvoices = Ncinvoice::where('user_id', $user)->whereBetween('created_at', [$from, $to])->get();
            //$ncipay =  Ncinvoice::where('user_id', $user)->whereBetween('created_at', [$from, $to])->sum('total_pay');

            //$ndinvoices = Ndinvoice::where('user_id', $user)->whereBetween('created_at', [$from, $to])->get();
            //$ndipay = Ndinvoice::where('user_id', $user)->whereBetween('created_at', [$from, $to])->sum('total_pay');

            //$ncpurchases = Ncpurchase::where('user_id', $user)->whereBetween('created_at', [$from, $to])->get();
            //$ncipay =  Ncinvoice::where('user_id', $user)->whereBetween('created_at', [$from, $to])->sum('total_pay');

            //$ndpurchases = Ndpurchase::where('user_id', $user)->whereBetween('created_at', [$from, $to])->get();
            //$ndipay = Ndinvoice::where('user_id', $user)->whereBetween('created_at', [$from, $to])->sum('total_pay');

            //$pay_orders = Pay_order::where('user_id', $user)->whereBetween('created_at', [$from, $to])->get();
            //$sum_pay_orders = Pay_order::where('user_id', $user)->whereBetween('created_at', [$from, $to])->sum('pay');

            $pay_invoices = Pay_invoice::where('user_id', $user)->whereBetween('created_at', [$from, $to])->get();
            $sum_pay_invoices = Pay_invoice::where('user_id', $user)->whereBetween('created_at', [$from, $to])->sum('pay');

            $pay_purchases = Pay_purchase::where('user_id', $user)->whereBetween('created_at', [$from, $to])->get();
            $sum_pay_purchases = Pay_purchase::where('user_id', $user)->whereBetween('created_at', [$from, $to])->sum('pay');

            $pay_expenses = Pay_expense::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->get();
            $sum_pay_expenses = Pay_expense::where('user_id', $sale_box->user_id)->whereBetween('created_at', [$from, $to])->sum('pay');

            //$payments = Payment::where('user_id', $user)->whereBetween('created_at', [$from, $to])->get();
            //$sum_payments = Payment::where('user_id', $user)->whereBetween('created_at', [$from, $to])->sum('pay');

            //$advances = Advance::where('user_id', $user)->whereBetween('created_at', [$from, $to])->get();
            //$sum_advances = Advance::where('user_id', $user)->whereBetween('created_at', [$from, $to])->sum('pay');

            //$cash_outs = Cash_out::where('user_id', $user->id)->whereBetween('created_at', [$from, $to])->get();
            $sum_cash_outs = Cash_out::where('user_id', $user)->whereBetween('created_at', [$from, $to])->sum('payment');

            $cashOuts = Cash_out::from('cash_outs AS cas')
            ->join('sale_boxes AS sai', 'cas.sale_box_id', 'sai.id')
            ->join('users AS use', 'cas.user_id', 'use.id')
            ->join('users AS usa', 'cas.admin_id', 'usa.id')
            ->select('cas.id', 'cas.payment', 'cas.created_at', 'usa.name')
            ->where('cas.user_id', '=', $user)
            ->whereBetween('cas.created_at', [$from, $to])
            ->get();

            $sum_cash_ins = Cash_in::where('user_id', $user)->whereBetween('created_at', [$from, $to])->sum('payment');
            $cashIns = Cash_in::from('cash_ins AS cas')
            ->join('sale_boxes AS sai', 'cas.sale_box_id', 'sai.id')
            ->join('users AS use', 'cas.user_id', 'use.id')
            ->join('users AS usa', 'cas.admin_id', 'usa.id')
            ->select('cas.id', 'cas.payment', 'cas.created_at', 'usa.name')
            ->where('cas.user_id', '=', $user)
            ->whereBetween('cas.created_at', [$from, $to])
            ->get();
        //}

        $view = \view('admin.sale_box.showpos', compact(
            'company',
            'invoiceMenus',
            'productPurchases',
            'sale_box',
            'invoices',
            'orders',
            'purchases',
            'expenses',
            'pay_invoices',
            'sum_pay_invoices',
            'pay_purchases',
            'sum_pay_purchases',
            'pay_expenses',
            'sum_pay_expenses',
            'cashIns',
            'sum_cash_ins',
            'cashOuts',
            'sum_cash_outs',
            'incProduct',
            'subtotalProduct'
            ))->render();

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        //$pdf->setPaper (array(0,0,226.76,497.64));
        $pdf->setPaper('b7', 'portrait');

        return $pdf->stream('reporte_caja.pdf');
        /*
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        $pdf->setPaper (array(0,0,226.76,497.64));

        return $pdf->stream('reporte_caja.pdf');

        $data = PDF::loadView('vista-pdf', $data)
        ->save(storage_path('app/public/') . 'archivo.pdf');*/
    }

    public function show_out( $id)
    {
        $sale_box = Sale_box::findOrFail($id);
        if($sale_box->status == 'close'){
            return redirect("sale_box")->with('warning', 'Esta Caja ya esta cerrada');
        }
        $users = User::where('id', '!=', 1)->get();
        $sale_box = Sale_box::where('user_id', '=', Auth::user()->id)->where('status', '=', 'open')->first();

        \Session::put('sale_box', $sale_box->id, 60 * 24 * 365);
        \Session::put('branch', $sale_box->branch_id, 60 * 24 * 365);
        \Session::put('user', $sale_box->user_id, 60 * 24 * 365);



        return view("admin.cash_out.create", compact('users', 'sale_box'));
    }
    //funcion para registrar una recarga a la caja de efectivo
    public function show_cashIn( $id)
    {
        $sale_box = Sale_box::findOrFail($id);
        if($sale_box->status == 'close'){
            return redirect("sale_box")->with('warning', 'Esta Caja ya esta cerrada');
        }
        $users = User::where('id', '!=', 1)->get();
        $sale_box = Sale_box::where('user_id', '=', Auth::user()->id)->where('status', '=', 'open')->first();
        \Session::put('sale_box', $sale_box->id, 60 * 24 * 365);
        \Session::put('branch', $sale_box->branch_id, 60 * 24 * 365);
        \Session::put('user', $sale_box->user_id, 60 * 24 * 365);


        return view("admin.cash_in.create", compact('users', 'sale_box'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sale_box  $sale_box
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sale_box = Sale_box::findOrFail($id);
        $users = User::where('id', '!=', 1)->get();
        return view('admin.sale_box.edit', compact('sale_box', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSaleboxRequest  $request
     * @param  \App\Models\Sale_box  $sale_box
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSaleboxRequest $request, $id)
    {

        $close = $request->user_close_id;
        $verific = $request->verification_code_close;
        $verification_code = Verification_code::select('id', 'code')->where('user_id', '=', $close)->first();
        $box_close = Sale_box::select('status')->where('id', '=', $id)->first();

        if($verification_code == null){
            return redirect("sale_box")->with('warning', 'Usuario No autorizado para ejercer como administrador');
        }

        if ($verification_code->code != $verific) {
            return redirect("sale_box")->with('warning', 'Error en codigo de verificacion');
        } elseif ($box_close->status == 'close') {
            return redirect("sale_box")->with('warning', 'Esta caja ya fue cerrada Anteriormente');
        } else {
            $sale_box = Sale_box::findOrFail($id);
            $sale_box->user_close_id  = $close;
            $sale_box->verification_code_close   = $verific;
            $sale_box->status         = 'close';
            $sale_box->update();
        }
        return redirect("sale_box")->with('success', 'Caja cerrada Satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale_box  $sale_box
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale_box $sale_box)
    {
        //
    }
}

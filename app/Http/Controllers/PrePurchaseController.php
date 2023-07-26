<?php

namespace App\Http\Controllers;

use App\Models\PrePurchase;
use App\Http\Requests\StorePrePurchaseRequest;
use App\Http\Requests\UpdatePrePurchaseRequest;
use App\Models\Advance;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\Card;
use App\Models\Company;
use App\Models\Department;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\GenerationType;
use App\Models\IdentificationType;
use App\Models\Liability;
use App\Models\Municipality;
use App\Models\Organization;
use App\Models\Payment_form;
use App\Models\Payment_method;
use App\Models\PaymentForm;
use App\Models\PaymentMethod;
use App\Models\Percentage;
use App\Models\PrePurchaseProduct;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Regime;
use App\Models\Resolution;
use App\Models\Supplier;
use App\Models\Type_document;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PrePurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            //Muestra todas las compras de la empresa
            $prePurchases = PrePurchase::get();


            return DataTables::of($prePurchases)
            ->addIndexColumn()
            ->addColumn('supplier', function (PrePurchase $prePurchase) {
                return $prePurchase->supplier->name;
            })
            ->addColumn('branch', function (PrePurchase $prePurchase) {
                return $prePurchase->branch->name;
            })
            ->addColumn('status', function (PrePurchase $prePurchase) {
                if ($prePurchase->status == 'active') {
                    return $prePurchase->status == 'active' ? 'Precompra' : 'Facturado';
                } elseif ($prePurchase->status == 'generated') {
                    return $prePurchase->status == 'generated' ? 'Facturado' : 'Cancelado';
                } else {
                    return $prePurchase->status == 'canceled' ? 'Anulada' : 'Anulada';
                }
            })

            ->editColumn('created_at', function(PrePurchase $prePurchase) {
                return $prePurchase->created_at->format('yy-m-d: h:m');
            })
            ->addColumn('btn', 'admin/pre_purchase/actions')
            ->rawColumns(['btn'])
            ->make(true);
        }
        return view('admin.pre_purchase.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::get();
        $municipalities = Municipality::get();
        $documents = Document::get();
        $liabilities = Liability::get();
        $organizations = Organization::get();
        $suppliers = Supplier::get();
        $regimes = Regime::get();
        $branchs = Branch::get();
        $products = Product::where('status', 'activo')->get();
        return view('admin.pre_purchase.create',
        compact(
            'departments',
            'municipalities',
            'documents',
            'liabilities',
            'organizations',
            'suppliers',
            'regimes',
            'branchs',
            'products'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePrePurchaseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePrePurchaseRequest $request)
    {
        try{
            DB::beginTransaction();

            //Variables del request
            $product_id = $request->product_id;
            $quantity   = $request->quantity;
            $price      = $request->price;
            $iva        = $request->iva;
            $branch     = $request->branch_id[0];

            //Crea un registro de compras
            $prePurchase = new PrePurchase();
            $prePurchase->user_id = Auth::user()->id;
            $prePurchase->branch_id = $branch;
            $prePurchase->supplier_id = $request->supplier_id;
            $prePurchase->items       = count($product_id);
            $prePurchase->total       = $request->total;
            $prePurchase->total_iva    = $request->total_iva;
            $prePurchase->total_pay    = $request->total_pay;
            $prePurchase->status      = 'active';
            $prePurchase->balance     = $request->total_pay;
            $prePurchase->save();

            $cont = 0;
            //Ingresa los productos que vienen en el array
            while($cont < count($product_id)){
                $item = $cont + 1;

                //Metodo para registrar la relacion entre producto y compra
                $prePurchase_product = new PrePurchaseProduct();
                $prePurchase_product->pre_purchase_id = $prePurchase->id;
                $prePurchase_product->product_id = $product_id[$cont];
                $prePurchase_product->quantity = $quantity[$cont];
                $prePurchase_product->price = $price[$cont];
                $prePurchase_product->iva = $iva[$cont];
                $prePurchase_product->subtotal = $quantity[$cont] * $price[$cont];
                $prePurchase_product->iva_subtotal =($quantity[$cont] * $price[$cont] * $iva[$cont])/100;
                $prePurchase_product->item = $item;
                $prePurchase_product->save();

                $cont++;
            }
            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
        }
        return redirect('prePurchase');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PrePurchase  $prePurchase
     * @return \Illuminate\Http\Response
     */
    public function show(PrePurchase $prePurchase)
    {
        $prePurchaseProducts = PrePurchaseProduct::where('pre_purchase_id', $prePurchase->id)->where('quantity', '>', 0)->get();
        return view('admin.pre_purchase.show', compact('prePurchase', 'prePurchaseProducts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PrePurchase  $prePurchase
     * @return \Illuminate\Http\Response
     */
    public function edit(PrePurchase $prePurchase)
    {
        $departments = Department::get();
        $municipalities = Municipality::get();
        $documents = Document::get();
        $liabilities = Liability::get();
        $organizations = Organization::get();
        $suppliers = Supplier::get();
        $regimes = Regime::get();
        $branchs = Branch::get();
        $products = Product::where('status', 'activo')->get();
        $prePurchaseProducts = PrePurchaseProduct::from('pre_purchase_products as pp')
         ->join('products as pro', 'pp.product_id', 'pro.id')
         ->join('categories as cat', 'pro.category_id', 'cat.id')
         ->select('pp.id', 'pro.id as idP', 'pro.name', 'pro.stock', 'pp.quantity', 'pp.price', 'pp.iva_subtotal', 'pp.subtotal', 'cat.iva')
         ->where('pp.pre_purchase_id', $prePurchase->id)
         ->get();
        return view('admin.pre_purchase.edit',
        compact(
            'departments',
            'municipalities',
            'documents',
            'liabilities',
            'organizations',
            'suppliers',
            'regimes',
            'branchs',
            'products',
            'prePurchase',
            'prePurchaseProducts'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePrePurchaseRequest  $request
     * @param  \App\Models\PrePurchase  $prePurchase
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePrePurchaseRequest $request, PrePurchase $prePurchase)
    {
        try{
            DB::beginTransaction();
            //llamado a variables
            $product_id = $request->product_id;
            $quantity   = $request->quantity;
            $price      = $request->price;
            $iva        = $request->iva;
            $branch     = $request->branch_id[0];

            //Actualizando un registro de compras
            $prePurchase->user_id = Auth::user()->id;
            $prePurchase->branch_id = $branch;
            $prePurchase->supplier_id = $request->supplier_id;
            $prePurchase->items = count($product_id);
            $prePurchase->total = $request->total;
            $prePurchase->total_iva = $request->total_iva;
            $prePurchase->total_pay = $request->total_pay;
            $prePurchase->balance = $request->total_pay;
            $prePurchase->status = 'active';
            $prePurchase->note = $request->note;
            $prePurchase->update();

            $prePurchaseProducts = PrePurchaseProduct::where('pre_purchase_id', $prePurchase->id)->get();
            foreach ($prePurchaseProducts as $key => $prePurchaseProduct) {
                $prePurchaseProduct->quantity    = 0;
                $prePurchaseProduct->price       = 0;
                $prePurchaseProduct->iva         = 0;
                $prePurchaseProduct->subtotal    = 0;
                $prePurchaseProduct->iva_subtotal = 0;
                $prePurchaseProduct->item        = 0;
                $prePurchaseProduct->update();

            }

            //Toma el Request del array
            $item = 1;
            for ($i=0; $i < count($product_id); $i++) {
                $prePurchaseProduct = PrePurchaseProduct::where('pre_purchase_id', $prePurchase->id)
                ->where('product_id', $product_id[$i])->first();

                //Inicia proceso actualizacio pre compra producto si no existe
                if (is_null($prePurchaseProduct)) {
                    $subtotal = $quantity[$i] * $price[$i];
                    $iva_subtotal = $subtotal * $iva[$i]/100;
                    $item = $i + 1;

                    $prePurchaseProduct = new PrePurchaseProduct();
                    $prePurchaseProduct->pre_purchase_id = $prePurchase->id;
                    $prePurchaseProduct->product_id  = $product_id[$i];
                    $prePurchaseProduct->quantity    = $quantity[$i];
                    $prePurchaseProduct->price       = $price[$i];
                    $prePurchaseProduct->iva         = $iva[$i];
                    $prePurchaseProduct->subtotal    = $subtotal;
                    $prePurchaseProduct->iva_subtotal     = $iva_subtotal;
                    $prePurchaseProduct->item        = $item;
                    $prePurchaseProduct->save();
                    $item ++;

                } else {
                    if ($quantity[$i] > 0) {

                        $subtotal = $quantity[$i] * $price[$i];
                        $iva_subtotal = $subtotal * $iva[$i]/100;

                        if ($prePurchaseProduct->quantity > 0) {
                            $prePurchaseProduct->quantity    += $quantity[$i];
                            $prePurchaseProduct->price       = $price[$i];
                            $prePurchaseProduct->iva         = $iva[$i];
                            $prePurchaseProduct->subtotal    += $subtotal;
                            $prePurchaseProduct->iva_subtotal     += $iva_subtotal;
                            $prePurchaseProduct->update();
                        } else {
                            $prePurchaseProduct->quantity    = $quantity[$i];
                            $prePurchaseProduct->price       = $price[$i];
                            $prePurchaseProduct->iva         = $iva[$i];
                            $prePurchaseProduct->subtotal    = $subtotal;
                            $prePurchaseProduct->iva_subtotal     = $iva_subtotal;
                            $prePurchaseProduct->item        = $item;
                            $prePurchaseProduct->update();
                            $item ++;
                        }
                    }
                }
            }
            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
        }
        return redirect('prePurchase');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PrePurchase  $prePurchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(PrePurchase $prePurchase)
    {
        //
    }

    public function invoice($id)
    {
        $prePurchase = PrePurchase::findOrFail($id);
        //Session()->put('prePurchase', $prePurchase->id, 60 * 24 * 365);
        $suppliers = Supplier::get();
        $paymentForms = Payment_form::get();
        $paymentMethods = Payment_method::get();
        $banks = Bank::get();
        $cards = Card::get();
        $branchs = Branch::get();
        $percentages = Percentage::get();
        $advances = Advance::where('status', '!=', 'aplicado')->get();
        $products = Product::where('status', 'active')->get();
        $date = Carbon::now();
        $prePurchaseProducts = PrePurchaseProduct::from('pre_purchase_products as pp')
        ->join('products as pro', 'pp.product_id', 'pro.id')
        ->select('pro.id', 'pro.name', 'pro.stock', 'pp.quantity', 'pp.price', 'pp.iva', 'pp.subtotal')
        ->where('pre_purchase_id', $prePurchase->id)
        ->get();
        return view('admin.pre_purchase_product.create', compact(
            'prePurchase',
            'suppliers',
            'paymentForms',
            'paymentMethods',
            'banks',
            'cards',
            'branchs',
            'percentages',
            'advances',
            'products',
            'date',
            'prePurchaseProducts'
        ));
    }

    public function prePurchasePdf(Request $request, $id)
    {
        $prePurchase = PrePurchase::findOrFail($id);
        $prePurchaseProducts = PrePurchaseProduct::where('pre_purchase_id', $id)->where('quantity', '>', 0)->get();
        $company = Company::findOrFail(1);

        $prePurchasepdf = "COMP-". $prePurchase->id;
        $logo = './imagenes/logos'.$company->logo;
        $view = \view('admin.pre_purchase.pdf', compact('prePurchase', 'prePurchaseProducts', 'company', 'logo'));
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        //$pdf->setPaper ( 'A7' , 'landscape' );

        return $pdf->stream('vista-pdf', "$prePurchasepdf.pdf");
        //return $pdf->download("$purchasepdf.pdf");
    }

    public function prePurchasePost(Request $request, $id)
    {
        $prePurchase = PrePurchase::findOrFail($id);
        $prePurchaseProducts = PrePurchaseProduct::where('pre_purchase_id', $id)->where('quantity', '>', 0)->get();
        $company = Company::findOrFail(1);

        $prePurchasepost = "COMP-". $prePurchase->id;
        $logo = './imagenes/logos'.$company->logo;
        $view = \view('admin.pre_purchase.post', compact('prePurchase', 'prePurchaseProducts', 'company', 'logo'));
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        $pdf->setPaper (array(0,0,226.76,497.64), 'portrait');
        //$pdf->setPaper ( 'A7' , 'landscape' );

        return $pdf->stream('vista-pdf', "$prePurchasepost.pdf");
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
}

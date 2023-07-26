<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use App\Models\Company;
use App\Models\Department;
use App\Models\Municipality;
use App\Models\Sale_box;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\FacadesSession;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->session()->forget('branch');

        if (request()->ajax()) {
            if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {

                //Consulta para mostrar branch a administradores y superadmin
                $branches = Branch::get();
            } else {
                //Consulta para mostrar branch a roles 3 -4 -5
                $branches = Branch::where('id', Auth::user()->branch_id)->get();
            }

            return DataTables::of($branches)
                ->addIndexColumn()
                ->addColumn('department', function (Branch $branch) {
                    return $branch->department->name;
                })
                ->addColumn('municipality', function (Branch $branch) {
                    return $branch->municipality->name;
                })
                ->addColumn('company', function (Branch $branch) {
                    return $branch->company->nit;
                })


                ->addColumn('order', 'admin/branch/btn/order')
                ->addColumn('invoice', 'admin/branch/btn/invoice')
                ->addColumn('box', 'admin/branch/btn/box')
                ->addColumn('prePurchase', 'admin/branch/btn/prePurchase')
                ->addColumn('purchase', 'admin/branch/btn/purchase')
                ->addColumn('expense', 'admin/branch/btn/expense')
                ->addColumn('product', 'admin/branch/btn/product')
                ->addColumn('transfer', 'admin/branch/btn/transfer')
                ->addColumn('edit', 'admin/branch/btn/edit')
                ->addColumn('show', 'admin/branch/btn/show')
                ->rawcolumns(['order', 'invoice', 'box', 'prePurchase', 'purchase', 'expense', 'product', 'transfer', 'edit', 'show'])
                ->make(true);
        }
        return view('admin.branch.index');
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
        return view('admin.branch.create', compact('departments', 'municipalities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBranchRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBranchRequest $request)
    {
        $company = Company::where('id', '=', 1)->first();
        $branch = new Branch();
        $branch->department_id = $request->department_id;
        $branch->municipality_id = $request->municipality_id;
        $branch->company_id = $company->id;
        $branch->name = $request->name;
        $branch->address = $request->address;
        $branch->phone = $request->phone;
        $branch->mobile = $request->mobile;
        $branch->email = $request->email;
        $branch->manager = $request->manager;
        $branch->save();
        return redirect('branch');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show($branch)
    {
        $branch = Branch::findOrFail($branch);

        return view('admin.branch.show', compact('branch'));
    }
    //funcion para redirigir a compras



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function edit($branch)
    {
        $branch = Branch::findOrFail($branch);
        $departments = Department::get();
        $municipalities = Municipality::get();
        $companies = Company::get();
        return view('admin.branch.edit', compact('branch', 'departments', 'municipalities', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBranchRequest  $request
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBranchRequest $request, $branch)
    {
        $company = Company::where('id', '=', 1)->first();
        $branch = Branch::findOrFail($branch);
        $branch->department_id = $request->department_id;
        $branch->municipality_id = $request->municipality_id;
        $branch->company_id = $company->id;
        $branch->name = $request->name;
        $branch->address = $request->address;
        $branch->phone = $request->phone;
        $branch->mobile = $request->mobile;
        $branch->email = $request->email;
        $branch->manager = $request->manager;
        $branch->update();
        return redirect('branch');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        //
    }
    //funcion para llevar los municipios al create
    public function getMunicipalities(Request $request, $id)
    {
        if($request)
        {
            $municipalities = Municipality::where('department_id', '=', $id)->get();

            return response()->json($municipalities);
        }
    }

    public function logout()
    {
        session()->forget('branch');

        return redirect('branch');
    }

    public function show_prePurchase($id)
    {
        $user = Auth::user();
        $sale_box = Sale_box::select('id')
        ->where('user_id', $user->id)
        ->where('status', 'open')
        ->first();
        if ($user->role_id != 1) {
            if(is_null($sale_box)){
                return redirect("branch")->with('warning', 'Debes tener una caja Abierta para realizar Compras');
            }
        }
        $branch = Branch::findOrFail($id);
        Session::put('branch', $branch->id, 60 * 24 * 365);
        Session::put('name', $branch->name, 60 * 24 * 365);

        /*
        $branch = Branch::findOrFail($id);
        Session::put('branch', $branch->id, 60 * 24 * 365);
        Session::put('name', $branch->name, 60 * 24 * 365);

        if($branch->id != 1){
            return redirect("admin/branch")->with('warning', 'Esta branch no esta autorizada para hacer compras');
        }*/

        return redirect('prePurchase');
    }

    public function show_purchase($id)
{       $user = Auth::user();
        $sale_box = Sale_box::select('id')
        ->where('user_id', '=', $user->id)
        ->where('status', '=', 'open')
        ->first();
        if ($user->role_id != 1) {
            if(is_null($sale_box)){
                return redirect("branch")->with('warning', 'Debes tener una caja Abierta para realizar Compras');
            }
        }

        $branch = Branch::findOrFail($id);
        Session::put('branch', $branch->id, 60 * 24 * 365);
        Session::put('name', $branch->name, 60 * 24 * 365);

        /*
        $branch = Branch::findOrFail($id);
        Session::put('branch', $branch->id, 60 * 24 * 365);
        Session::put('name', $branch->name, 60 * 24 * 365);

        if($branch->id != 1){
            return redirect("admin/branch")->with('warning', 'Esta branch no esta autorizada para hacer compras');
        }*/

        return redirect('purchase');
    }
    public function show_expense($id)
    {
        $user = Auth::user();
        $sale_box = Sale_box::select('id')
        ->where('user_id', '=', $user->id)
        ->where('status', '=', 'open')
        ->first();
        if ($user->role_id != 1) {
            if(is_null($sale_box)){
                return redirect("branch")->with('warning', 'Debes tener una caja Abierta para realizar Gastos');
            }
        }
        $branch = Branch::findOrFail($id);
        Session::put('branch', $branch->id, 60 * 24 * 365);
        Session::put('name', $branch->name, 60 * 24 * 365);

        return redirect('expense');
    }
    //funcion para redirigir a ventas
    public function show_invoice($id)
    {
        $user = Auth::user();
        $sale_box = Sale_box::select('id')
        ->where('user_id', '=', $user->id)
        ->where('status', '=', 'open')
        ->first();
        if ($user->role_id != 1) {
            if(is_null($sale_box)){
                return redirect("branch")->with('warning', 'Debes tener una caja Abierta para realizar Ventas');
            }
        }
        $branch = Branch::findOrFail($id);
        Session::put('branch', $branch->id, 60 * 24 * 365);
        Session::put('name', $branch->name, 60 * 24 * 365);

        return redirect('invoice');
    }

    public function show_order($id)
    {
        $user = Auth::user();
        $sale_box = Sale_box::select('id')
        ->where('user_id', '=', $user->id)
        ->where('status', '=', 'open')
        ->first();
        if ($user->role_id != 1) {
            if(is_null($sale_box)){
                return redirect("order")->with('warning', 'Debes tener una caja Abierta para realizar Pedidos');
            }
        }

        $branch = Branch::findOrFail($id);
        Session::put('branch', $branch->id, 60 * 24 * 365);
        Session::put('name', $branch->name, 60 * 24 * 365);

        return redirect('order');

    }
    //funcion para redirigir a productos sucursal
    public function show_product($id)
    {
        $branch = Branch::findOrFail($id);
        Session::put('branch', $branch->id, 60 * 24 * 365);
        Session::put('name', $branch->name, 60 * 24 * 365);

        return redirect('branch_product');
    }
    //funcion para redirigir a
    public function show_transfer($id)
    {
        $branch = Branch::findOrFail($id);
        Session::put('branch', $branch->id, 60 * 24 * 365);
        Session::put('name', $branch->name, 60 * 24 * 365);

        return redirect('transfer');
    }
    //funcion para redirigir a caja
    public function show_sale_box($id)
    {
        //
        $branch = Branch::findOrFail($id);
        Session::put('branch', $branch->id, 60 * 24 * 365);
        Session::put('name', $branch->name, 60 * 24 * 365);

        $user = Auth::user()->branch_id;

        if ($branch->id == $user) {
            /*
            if($branch->id == 1){
                Alert::warning('Warning', 'Esta Sucursal No autorizada para tener cajas');
                return redirect("branch")->with('warning', 'Esta Sucursal No autorizada para tener caja');
            }*/
            return redirect('sale_box');
        } else {
            return redirect("branch")->with('warning', 'Usuario no autorizado en esta sucursal');
        }
    }
}

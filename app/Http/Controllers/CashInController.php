<?php

namespace App\Http\Controllers;

use App\Models\Cash_in;
use App\Http\Requests\StoreCash_inRequest;
use App\Http\Requests\UpdateCash_inRequest;
use App\Models\Branch;
use App\Models\Sale_box;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class CashInController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $cash_ins = Cash_in::get();

            return DataTables::of($cash_ins)
                ->addIndexColumn()
                ->addColumn('payment', function (Cash_in $cash_in) {
                    return number_format($cash_in->payment, 2);
                })
                ->addColumn('user', function (Cash_in $cash_in) {
                    return $cash_in->user->name;
                })
                ->addColumn('admin', function (Cash_in $cash_in) {
                    return $cash_in->admin->name;
                })
                ->addColumn('branch', function (Cash_in $cash_in) {
                    return $cash_in->branch->name;
                })
                ->editColumn('created_at', function(Cash_in $cash_in){
                    return $cash_in->created_at->format('yy-m-d h:i');
                })
                ->make(true);
        }

        return view('admin.cash_in.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $users = User::where('id', '!=', 1)->get();
        $sale_box = Sale_box::where('user_id', '=', Auth::user()->id)->where('status', '=', 'open')->first();
        return view("admin.cash_in.create", compact('users', 'sale_box'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCash_inRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCash_inRequest $request)
    {
        $user = Auth::user()->id;
        $branch = $request->session()->get('branch');
        $payment = $request->payment;
        $sale_box = Sale_box::where('user_id', '=', $user)->where('status', '=', 'open')->first();

        $cash_in = new Cash_in();
        $cash_in->payment     = $payment;
        $cash_in->reason      = $request->reason;
        $cash_in->sale_box_id = $sale_box->id;
        $cash_in->user_id     = $request->user_id;
        $cash_in->branch_id   = $branch;
        $cash_in->admin_id    = $request->admin_id;
        $cash_in->save();

        $sale_box->cash += $payment;
        $sale_box->in_cash += $payment;
        $sale_box->in_total += $payment;
        $sale_box->update();

        return redirect("cash_in")->with('success', 'Recarga de Caja creada Satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cash_in  $cash_in
     * @return \Illuminate\Http\Response
     */
    public function show(Cash_in $cash_in)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cash_in  $cash_in
     * @return \Illuminate\Http\Response
     */
    public function edit(Cash_in $cash_in)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCash_inRequest  $request
     * @param  \App\Models\Cash_in  $cash_in
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCash_inRequest $request, Cash_in $cash_in)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cash_in  $cash_in
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cash_in $cash_in)
    {
        //
    }
}

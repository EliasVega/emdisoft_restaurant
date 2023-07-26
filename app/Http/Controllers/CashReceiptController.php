<?php

namespace App\Http\Controllers;

use App\Models\Cash_receipt;
use App\Http\Requests\StoreCash_receiptRequest;
use App\Http\Requests\UpdateCash_receiptRequest;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class CashReceiptController extends Controller
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
            $cashReceipts = Cash_receipt::get();
            return DataTables::of($cashReceipts)
            ->addIndexColumn()
            ->addColumn('order', function (Cash_receipt $cashOrder) {
                return $cashOrder->payable->order->id;
            })
            /*
            ->addColumn('total_pay', function (Cash_receipt $cashOrder) {
                return $cashOrder->order->total_pay;
            })
            ->addColumn('customer', function (Cash_receipt $cashOrder) {
                return $cashOrder->order->customer->name;
            })
            ->addColumn('branch', function (Cash_receipt $cashOrder) {
                return $cashOrder->branch->name;
            })
            ->addColumn('user', function (Cash_receipt $cashOrder) {
                return $cashOrder->user->name;
            })*/
            ->editColumn('created_at', function(Cash_receipt $cashOrder){
                return $cashOrder->created_at->format('yy-m-d: h:m');
            })
            ->addColumn('btn', 'admin/Cash_receipt/actions')
            ->rawColumns(['btn'])
            ->make(true);
        }
        return view('admin.Cash_receipt.index');
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
     * @param  \App\Http\Requests\StoreCash_receiptRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCash_receiptRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cash_receipt  $cash_receipt
     * @return \Illuminate\Http\Response
     */
    public function show(Cash_receipt $cash_receipt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cash_receipt  $cash_receipt
     * @return \Illuminate\Http\Response
     */
    public function edit(Cash_receipt $cash_receipt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCash_receiptRequest  $request
     * @param  \App\Models\Cash_receipt  $cash_receipt
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCash_receiptRequest $request, Cash_receipt $cash_receipt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cash_receipt  $cash_receipt
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cash_receipt $cash_receipt)
    {
        //
    }
}

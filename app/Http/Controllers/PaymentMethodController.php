<?php

namespace App\Http\Controllers;

use App\Models\Payment_method;
use App\Http\Requests\StorePaymentMethodRequest;
use App\Http\Requests\UpdatePaymentMethodRequest;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $payment_methods = Payment_method::get();

            return datatables()
            ->of($payment_methods)
            ->addColumn('edit', 'admin/payment_method/actions')
            ->rawcolumns(['edit'])
            ->toJson();
        }
        return view('admin.payment_method.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.payment_method.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePaymentMethodRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaymentMethodRequest $request)
    {
        $payment_method = new Payment_method();
        $payment_method->code = $request->code;
        $payment_method->name = $request->name;
        $payment_method->save();
        return redirect('payment_method');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment_method  $payment_method
     * @return \Illuminate\Http\Response
     */
    public function show(Payment_method $payment_method)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment_method  $payment_method
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payment_method = Payment_method::findOrFail($id);
        return view('admin.payment_method.edit', compact('payment_method'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePaymentMethodRequest  $request
     * @param  \App\Models\Payment_method  $payment_method
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaymentMethodRequest $request, $id)
    {
        $payment_method = Payment_method::findOrFail($id);
        $payment_method->code = $request->code;
        $payment_method->name = $request->name;
        $payment_method->update();
        return redirect('payment_method');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment_method  $payment_method
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment_method $payment_method)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Payment_form;
use App\Http\Requests\StorePaymentFormRequest;
use App\Http\Requests\UpdatePaymentFormRequest;

class PaymentFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $payment_forms = Payment_form::get();

            return datatables()
            ->of($payment_forms)
            ->addColumn('edit', 'admin/payment_form/actions')
            ->rawcolumns(['edit'])
            ->toJson();
        }
        return view('admin.payment_form.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.payment_form.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePaymentFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaymentFormRequest $request)
    {
        $payment_form = new Payment_form();
        $payment_form->name = $request->name;
        $payment_form->save();
        return redirect('payment_form');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentForm  $paymentForm
     * @return \Illuminate\Http\Response
     */
    public function show(Payment_form $payment_form)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentForm  $paymentForm
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $paymentForm = Payment_form::findOrFail($id);
        return view('admin.payment_form.edit', compact('payment_form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePaymentFormRequest  $request
     * @param  \App\Models\PaymentForm  $paymentForm
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaymentFormRequest $request, $id)
    {
        $payment_form = Payment_form::findOrFail($id);
        $payment_form->name = $request->name;
        $payment_form->update();
        return redirect('payment_form');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentForm  $paymentForm
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment_form $paymentForm)
    {
        //
    }
}

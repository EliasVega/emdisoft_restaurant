<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Document;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $customers = Customer::get();

            return DataTables::of($customers)
                ->addIndexColumn()
                ->addColumn('document', function (Customer $customer) {
                    return $customer->document->initial;
                })
                ->addColumn('edit', 'admin/customer/actions')
                ->rawcolumns(['edit'])
                ->make(true);
        }
        return view('admin.customer.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $documents = Document::get();
        return view('admin.customer.create', compact('documents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {
        $branch = $request->session()->get('branch');
        //
        $customer = new Customer();
        $customer->document_id = $request->document_id;
        $customer->name = $request->name;
        $customer->number = $request->number;
        $customer->email = $request->email;
        $customer->save();
        if($branch > 0)
        {
            return back();
            //return redirect("invoice/create");
        }
        else{
            return redirect("customer");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        $documents = Document::get();
        return view('admin.customer.edit', compact('customer', 'documents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomerRequest  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->document_id = $request->document_id;
        $customer->name = $request->name;
        $customer->number = $request->number;
        $customer->email = $request->email;
        $customer->update();

        return redirect("customer");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}

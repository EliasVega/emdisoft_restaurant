<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Category;
use App\Models\Unit_measure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $services = Service::get();

            return datatables()
            ->of($services)
            ->addColumn('edit', 'admin/service/actions')
            ->rawcolumns(['edit'])
            ->toJson();
        }
        return view('admin.service.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::select('id', 'name')->get();
        $measures = Unit_measure::get();

        return view("admin.service.create", compact('categories', 'measures'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request): RedirectResponse
    {
        $service = new Service();
        $service->category_id = $request->category_id;
        $service->unit_measure_id = $request->unit_measure_id;
        $service->code = $request->code;
        $service->name = $request->name;
        $service->price = $request->price;
        $service->status = 1;
        $service->save();

        return redirect('service');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        $categories = Category::select('id', 'name')->get();

        return view("admin.service.show", compact('categories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        $categories = Category::get();

        return view("admin.service.edit", compact('service', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $service->category_id = $request->category_id;
        $service->unit_measure_id = $request->unit_measure_id;
        $service->code = $request->code;
        $service->name = $request->name;
        $service->price = $request->price;
        $service->status = 1;
        $service->update();

        return redirect('service');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        //
    }
}

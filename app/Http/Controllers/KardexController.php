<?php

namespace App\Http\Controllers;

use App\Models\Kardex;
use App\Http\Requests\StoreKardexRequest;
use App\Http\Requests\UpdateKardexRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class KardexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->end)) {
                $kardexes = Kardex::whereBetween('created_at', [$request->start, $request->end])->get();
                /*$kardexes = Kardex::from('kardexes AS kar')
                ->join('products as pro', 'kar.product_id', 'pro.id')
                ->join('branches as bra', 'kar.branch_id', 'bra.id')
                ->select('kar.id', 'kar.operation', 'kar.number', 'kar.quantity', 'kar.stock', 'kar.created_at', 'pro.id as idP', 'pro.name', 'bra.name as nameB')
                ->whereBetween('kar.created_at', [$request->start, $request->end])
                ->get();*/
            } else {
                $kardexes = Kardex::get();
                /*
                $kardexes = Kardex::from('kardexes AS kar')
                ->join('products as pro', 'kar.product_id', 'pro.id')
                ->join('branches as bra', 'kar.branch_id', 'bra.id')
                ->select('kar.id', 'kar.operation', 'kar.number', 'kar.quantity', 'kar.stock', 'kar.created_at', 'pro.id as idP', 'pro.name', 'bra.name as nameB')
                ->get();*/
            }
            return DataTables::of($kardexes)
            ->addIndexColumn()
            ->addColumn('idP', function (Kardex $kardex) {
                return $kardex->product->id;
            })
            ->addColumn('product', function (Kardex $kardex) {
                return $kardex->product->name;
            })
            ->addColumn('branch', function (Kardex $kardex) {
                return $kardex->branch->name;
            })
            ->editColumn('created_at', function(Kardex $kardex){
                return $kardex->created_at->format('yy-m-d: h:m');
            })
            ->addColumn('btn', 'admin/jardex/actions')
            ->rawColumns(['btn'])
            ->make(true);
        }
        return view('admin.kardex.index');
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
     * @param  \App\Http\Requests\StoreKardexRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKardexRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kardex  $kardex
     * @return \Illuminate\Http\Response
     */
    public function show(Kardex $kardex)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kardex  $kardex
     * @return \Illuminate\Http\Response
     */
    public function edit(Kardex $kardex)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKardexRequest  $request
     * @param  \App\Models\Kardex  $kardex
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKardexRequest $request, Kardex $kardex)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kardex  $kardex
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kardex $kardex)
    {
        //
    }
}

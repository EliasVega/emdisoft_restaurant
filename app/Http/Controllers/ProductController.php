<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Branch_product;
use App\Models\Category;
use App\Models\Indicator;
use App\Models\Unit_measure;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $products = Product::get();

            return datatables()
            ->of($products)
            ->addColumn('edit', 'admin/product/actions')
            ->rawcolumns(['edit'])
            ->toJson();
        }
        return view('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::select('id', 'name')->get();
        $measures = Unit_measure::where('status', 'activo')->get();

        return view("admin.product.create", compact('categories', 'measures'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $product = new Product();
        $product->category_id = $request->category_id;
        $product->unit_measure_id = $request->unit_measure_id;
        $product->code = $request->code;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = 0;
        $product->save();

            //metodo para agregar producto a la sede
        $branch_product = new Branch_product();
        $branch_product->branch_id = 1;
        $branch_product->product_id = $product->id;
        $branch_product->stock = 0;
        $branch_product->order_product = 0;
        $branch_product->save();

        return redirect('product');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $categories = Category::select('id', 'name')->get();

        return view("admin.product.show", compact('categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::select('id', 'name')->get();
        $measures = Unit_measure::where('status', 'activo')->get();

        return view("admin.product.edit", compact('product', 'categories', 'measures'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->category_id = $request->category_id;
        $product->code = $request->code;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->update();

        $branchProduct = Branch_product::where('product_id', $product->id)->first();
        $branchProduct->stock = $request->stock;
        $branchProduct->update();

        return redirect('product');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function status($id)
    {

        $product = Product::findOrFail($id);
        if ($product->status == 'active') {
            $product->status = 'inactive';
        } else {
            $product->status = 'active';
        }
        $product->update();

        return redirect('product');
    }
}

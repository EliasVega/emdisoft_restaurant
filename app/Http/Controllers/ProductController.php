<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Branch_product;
use App\Models\Category;
use App\Models\Indicator;
use App\Models\ProductRawMaterial;
use App\Models\RawMaterial;
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
        $rawMaterials = RawMaterial::get();
        $indicator = Indicator::findOrFail(1);

        return view("admin.product.create", compact('categories', 'measures', 'rawMaterials', 'indicator'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $indicator = Indicator::findOrFail(1);
        $product = new Product();
        $product->category_id = $request->category_id;
        $product->unit_measure_id = $request->unit_measure_id;
        $product->code = $request->code;
        $product->name = $request->name;
        if ($indicator->restaurant == 'on') {
            $product->price = $request->total;
        } else {
            $product->price = $request->price;
        }
        $product->sale_price = $request->sale_price;
        $product->stock = 0;

        //Handle File Upload
        if($request->hasFile('image')){
            //Get filename with the extension
            $filenamewithExt = $request->file('image')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenamewithExt,PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('image')->guessClientExtension();
            //FileName to store
            $fileNameToStore = time().'.'.$extension;
            //Upload Image
            $path = $request->file('image')->move('images/products',$fileNameToStore);
            } else{
                $fileNameToStore="noimagen.jpg";
            }
            $product->image=$fileNameToStore;
        $product->save();
            //metodo para agregar producto a la sede
        $branch_product = new Branch_product();
        $branch_product->branch_id = 1;
        $branch_product->product_id = $product->id;
        $branch_product->stock = 0;
        $branch_product->order_product = 0;
        $branch_product->save();


        if ($indicator->restaurant == 'on') {
            $quantity = $request->quantity;
            $consumer = $request->consumer_price;
            $material = $request->raw_material_id;
            for ($i=0; $i < count($quantity); $i++) {
                $product_rawMaterial = new ProductRawMaterial();
                $product_rawMaterial->quantity = $quantity[$i];
                $product_rawMaterial->consumer_price = $consumer[$i];
                $product_rawMaterial->subtotal = $quantity[$i] * $consumer[$i];
                $product_rawMaterial->raw_material_id = $material[$i];
                $product_rawMaterial->product_id = $product->id;
                $product_rawMaterial->save();
            }

        }

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
        $product->sale_price = $request->sale_price;
        $product->stock = $request->stock;
        $product->status = $request->status;

        //Handle File Upload
        if($request->hasFile('image')){
            //Get filename with the extension
            $filenamewithExt = $request->file('image')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenamewithExt,PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('image')->guessClientExtension();
            //FileName to store
            $fileNameToStore = time().'.'.$extension;
            //Upload Image
            $path = $request->file('image')->move('images/products',$fileNameToStore);
            } else{
                $fileNameToStore="noimagen.jpg";
            }
            $product->image=$fileNameToStore;
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
}

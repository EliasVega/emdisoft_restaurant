<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Models\Category;
use App\Models\Indicator;
use App\Models\MenuProduct;
use App\Models\Product;
use App\Models\Unit_measure;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $menus = Menu::get();

            return datatables()
            ->of($menus)
            ->addIndexColumn()
            ->addColumn('unitMeasure', function (Menu $menu) {
                return $menu->unitMeasure->name;
            })
            ->addColumn('edit', 'admin/menu/actions')
            ->rawcolumns(['edit'])
            ->toJson();
        }
        return view('admin.menu.index');
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
        $products = Product::get();

        return view("admin.menu.create", compact('categories', 'measures', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMenuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMenuRequest $request)
    {
        $menu = new Menu();
        $menu->category_id = $request->category_id;
        $menu->unit_measure_id = $request->unit_measure_id;
        $menu->code = $request->code;
        $menu->name = $request->name;
        $menu->price = $request->total;
        $menu->sale_price = $request->price;
        $menu->stock = 0;

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
            $path = $request->file('image')->move('images/menus',$fileNameToStore);
            } else{
                $fileNameToStore="noimagen.jpg";
            }
            $menu->image=$fileNameToStore;
        $menu->save();

        $quantity = $request->quantity;
        $consumer = $request->consumer_price;
        $product = $request->product_id;
        for ($i=0; $i < count($quantity); $i++) {
            $menuProducts = new MenuProduct();
            $menuProducts->quantity = $quantity[$i];
            $menuProducts->consumer_price = $consumer[$i];
            $menuProducts->subtotal = $quantity[$i] * $consumer[$i];
            $menuProducts->menu_id = $menu->id;
            $menuProducts->product_id = $product[$i];
            $menuProducts->save();
        }
        return redirect('menu');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        $categories = Category::select('id', 'name')->get();

        return view("admin.menu.show", compact('categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        $categories = Category::select('id', 'name')->get();
        $measures = Unit_measure::where('status', 'activo')->get();

        return view("admin.menu.edit", compact('menu', 'categories', 'measures'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMenuRequest  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMenuRequest $request, Menu $menu)
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

        return redirect('menu');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        //
    }

    public function status($id)
    {

        $menu = Menu::findOrFail($id);
        if ($menu->status == 'active') {
            $menu->status = 'inactive';
        } else {
            $menu->status = 'active';
        }
        $menu->update();

        return redirect('menu');
    }
}

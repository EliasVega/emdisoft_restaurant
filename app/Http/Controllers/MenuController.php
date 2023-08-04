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

use function PHPUnit\Framework\isNull;

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
        $quantity = $request->quantity;
        $consumer = $request->consumer_price;
        $product = $request->product_id;

        $menu = new Menu();
        $menu->category_id = $request->category_id;
        $menu->unit_measure_id = $request->unit_measure_id;
        $menu->code = $request->code;
        $menu->name = $request->name;
        $menu->price = $request->total;
        $menu->sale_price = $request->price;

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
        $menuProducts = MenuProduct::where('menu_id', $menu->id)->where('quantity', '>', 0)->get();

        return view("admin.menu.show", compact('menu', 'menuProducts'));
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
        $products = Product::where('status', 'active')->get();
        //$menuProducts = MenuProduct::where('menu_id', $menu->id)->get();
        $menuProducts = MenuProduct::from('menu_products as mp')
        ->join('products as pro', 'mp.product_id', 'pro.id')
        ->join('menus as men', 'mp.menu_id', 'men.id')
        ->select('mp.id', 'pro.id as idP', 'pro.name', 'mp.quantity', 'mp.consumer_price', 'mp.subtotal')
        ->where('menu_id', $menu->id)
        ->get();

        return view("admin.menu.edit", compact('menu', 'categories', 'measures', 'menuProducts', 'products'));
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
        $quantity = $request->quantity;
        $consumer = $request->consumer_price;
        $product = $request->product_id;

        $menu->category_id = $request->category_id;
        $menu->unit_measure_id = $request->unit_measure_id;
        $menu->code = $request->code;
        $menu->name = $request->name;
        $menu->price = $request->total;
        $menu->sale_price = $request->price;

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
        $menu->update();



        $menuProducts = MenuProduct::where('menu_id', $menu->id)->get();
        foreach ($menuProducts as $key => $menuProduct) {
            $menuProduct->quantity = 0;
            $menuProduct->consumer_price = 0;
            $menuProduct->subtotal = 0;
            $menuProduct->update();
        }

        for ($i=0; $i < count($product); $i++) {
            $menuProducts = MenuProduct::where('menu_id', $menu->id)->where('product_id', $product[$i])->first();

            if (isNull($menuProducts)) {
                $menuProducts = new MenuProduct();
                $menuProducts->quantity = $quantity[$i];
                $menuProducts->consumer_price = $consumer[$i];
                $menuProducts->subtotal = $quantity[$i] * $consumer[$i];
                $menuProducts->menu_id = $menu->id;
                $menuProducts->product_id = $product[$i];
                $menuProducts->save();
            } else {
                $menuProducts->quantity = $quantity[$i];
                $menuProducts->consumer_price = $consumer[$i];
                $menuProducts->subtotal = $quantity[$i] * $consumer[$i];
                $menuProducts->update();
            }
        }
        return redirect('menu')->with('success', 'Menu editado correctamente');
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

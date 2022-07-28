<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=Product::all();
        return view("admin.products.index",compact("products"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::all();
        return view("admin.products.create",compact("categories"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'shortDescription' => 'required',
            'longDescription' => 'required',
            'regularPrice' => 'required',
            'salePrice' => 'required',
            'sku' => 'required',
            'stockStatus' => 'required',
            'featured' => 'required',
            'quantity' => 'required',
            'category' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png',
        ]);

        $imgName=hexdec(uniqid()).'.'.$request->image->extension();
        $uploadLocation="images/uploads/products/";
        $request->image->move(public_path($uploadLocation),$imgName);

        $product=new Product();
        $product->name=$request->name;
        $product->slug=Str::slug($request->name);
        $product->short_description=$request->shortDescription;
        $product->long_description=$request->longDescription;
        $product->regular_price=$request->regularPrice;
        $product->sale_price=$request->salePrice;
        $product->sku=$request->sku;
        $product->stock_status=$request->stockStatus;
        $product->featured=$request->featured;
        $product->quantity=$request->quantity;
        $product->category_id=$request->category;
        $product->image=$uploadLocation.$imgName;
        $product->save();

        return Redirect()->back()->with("success","Product created successfully!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product=Product::find($id);
        $categories=Category::all();
        return view("admin.products.edit",compact("product","categories"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'shortDescription' => 'required',
            'longDescription' => 'required',
            'regularPrice' => 'required',
            'salePrice' => 'required',
            'sku' => 'required',
            'stockStatus' => 'required',
            'featured' => 'required',
            'quantity' => 'required',
            'category' => 'required',
        ]);
        if($request->image){
            unlink($request->oldImage);
            $imgName=hexdec(uniqid()).'.'.$request->image->extension();
            $uploadLocation="images/uploads/products/";
            $request->image->move(public_path($uploadLocation),$imgName);
            $product=Product::find($id);
            $product->name=$request->name;
            $product->slug=Str::slug($request->name);
            $product->short_description=$request->shortDescription;
            $product->long_description=$request->longDescription;
            $product->regular_price=$request->regularPrice;
            $product->sale_price=$request->salePrice;
            $product->sku=$request->sku;
            $product->stock_status=$request->stockStatus;
            $product->featured=$request->featured;
            $product->quantity=$request->quantity;
            $product->category_id=$request->category;
            $product->image=$uploadLocation.$imgName;
            $product->save();
        }else{
            $product=Product::find($id);
            $product->name=$request->name;
            $product->slug=Str::slug($request->name);
            $product->short_description=$request->shortDescription;
            $product->long_description=$request->longDescription;
            $product->regular_price=$request->regularPrice;
            $product->sale_price=$request->salePrice;
            $product->sku=$request->sku;
            $product->stock_status=$request->stockStatus;
            $product->featured=$request->featured;
            $product->quantity=$request->quantity;
            $product->category_id=$request->category;
            $product->save();
        }
        return Redirect()->route("products.index")->with("success","Product updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        unlink($product->image);
        $product->delete();
        return redirect()->back()->with("success","Product deleted permanently!");
    }
}

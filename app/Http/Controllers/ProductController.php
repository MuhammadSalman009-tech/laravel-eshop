<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=Product::paginate(12);
        return view("frontend.shop",compact("products"));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {

        $product=Product::where("slug",$slug)->first();
        $popularProducts=Product::inRandomOrder()->limit(4)->get();
        $relatedProducts=Product::where("category_id",$product->category_id)->inRandomOrder()->limit(5)->get();
        return view("frontend.product-detail",compact("product","popularProducts","relatedProducts"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function cart(){
        return view("frontend.cart");
    }
    public function addToCart($id){
        $product=Product::findOrFail($id);
        $cart=session()->get("cart",[]);
        if(isset($cart[$id])){
            $cart[$id]["quantity"]++;
        }else{
            $cart[$id]=[
                "name"=>$product->name,
                "quantity"=>1,
                "price"=>$product->regular_price,
                "image"=>$product->image
            ];
        }
        session()->put('cart', $cart);
        return redirect()->back()->with("success","Product added to cart successfully!");
    }
    public function updateCart(Request $request){

        if($request->id && $request->quantity){
            $cart=session()->get("cart");
            $cart[$request->id]["quantity"]=$request->quantity;
            session()->put("cart",$cart);
            session()->flash("success","Cart updated successfully!");
        }
    }
    public function removeFromCart(Request $request){

        if($request->id){
            $cart=session()->get("cart");
            if(isset($cart[$request->id])){
                unset($cart[$request->id]);
                session()->put("cart",$cart);
                session()->flash("success","Product removed successfully!");
            }

        }
    }
}

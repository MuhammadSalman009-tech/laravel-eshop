<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products=Product::paginate(12);
        $categories=Category::all();
        return view("frontend.shop",compact("products","categories"));

    }
    public function productsByCategory($slug)
    {
        $category=Category::where("slug",$slug)->first();
        $products=Product::where("category_id",$category->id)->paginate(3);
        $categories=Category::all();
        return view("frontend.category-poducts",compact("products","categories"));

    }
    public function sortProducts(Request $request){
        $productPerPage=12;
        if($request->has("productsPerPage")){
            $productPerPage=$request->get("productsPerPage");
        }
        if($request->has('orderBy')){
            if($request->get("orderBy")=="date"){
                $products=Product::orderBy("created_at","DESC")->paginate($productPerPage);
            }else if($request->get("orderBy")=="price"){
                $products=Product::orderBy("regular_price","ASC")->paginate($productPerPage);
            }else if($request->get("orderBy")=="price-desc"){
                $products=Product::orderBy("regular_price","DESC")->paginate($productPerPage);
            }else{
                $products=Product::paginate($productPerPage);
            }
        }else{
            $products=Product::paginate($productPerPage);
        }
        $response = Response()->json([
            'st' => 'ok',
            'data'=> '',
            'msg'=> 'added',
            'html' => View::make('frontend.loading-products',compact("products"))->render(),
        ]);
        return $response;
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

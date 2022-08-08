<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Auth::check()){
            return redirect()->route("login");
        }else{
            return view("frontend.checkout");
        }
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

        $validated = $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'country' => 'required',
            'province' => 'required',
            'postcode' => 'required',
            'city' => 'required',
            'paymentMethod' => 'required',
        ]);
        $order=new Order();
        $order->user_id=Auth::user()->id;
        $order->subtotal=session()->get('total');
        $order->discount=0;
        $order->tax=0;
        $order->total=session()->get('total');
        $order->firstname=$request->firstName;
        $order->lastname=$request->lastName;
        $order->mobile=$request->phone;
        $order->email=$request->email;
        $order->address=$request->address;
        $order->city=$request->city;
        $order->province=$request->province;
        $order->country=$request->country;
        $order->zipcode=$request->postcode;
        $order->status="ordered";
        $order->save();

        foreach (session('cart') as $id => $details){
            $orderItem=new OrderItem();
            $orderItem->product_id=$id;
            $orderItem->order_id=$order->id;
            $orderItem->price=$details["price"];
            $orderItem->quantity=$details["quantity"];
            $orderItem->save();
        }

        if($request->paymentMethod=="COD"){
            $this->makeTransaction($order->id,"pending","COD");
        }
        if($request->paymentMethod=="card"){
            $validated = $request->validate([
                'cardNumber' => 'required',
                'expireMonth' => 'required',
                'expireYear' => 'required',
                'cvc' => 'required',
            ]);

            $stripe=Stripe::make(env("STRIPE_KEY"));
            try{
                $token=$stripe->tokens()->create([
                    "card"=>[
                        'number' => $request->cardNumber,
                    'exp_month' => $request->expireMonth,
                    'exp_year' => $request->expireYear,
                    'cvc' => $request->cvc,
                    ]
                ]);
                if(!isset($token["id"])){
                    session()->flash("stripe_error","The stripe token was not generated successfully");
                }

                $customer=$stripe->customers()->create([
                    "name"=>$request->firstName.' '.$request->lastName,
                    "email"=>$request->email,
                    "phone"=>$request->phone,
                    "address"=>[
                        'line1' => $request->postcode,
                        'postal_code' => $request->country,
                        'city' => $request->city,
                        'state' => $request->province,
                        'country' => $request->country
                    ],
                    "source"=>$token["id"]
                    ]);
                    $charge=$stripe->charges()->create([
                        "customer"=>$customer["id"],
                        "currency"=>"USD",
                        "amount"=>session()->get("total"),
                        "description"=>"Payment for order no ".$order->id
                    ]);
                    if($charge["status"]=="succeeded"){
                        $this->makeTransaction($order->id,"pending","card");
                    }else{
                    session()->flash("stripe_error","Error in transaction");
                    }
            }catch(Exception $e){
                session()->flash("stripe_error",$e->getMessage());
            }

        }
        $cart=session()->forget("cart");
        $total=session()->forget("total");
        return redirect()->route("thankyou");
    }
    public function makeTransaction($orderID,$status,$mode){
        $transaction=new Transaction();
        $transaction->user_id=Auth::user()->id;
        $transaction->order_id=$orderID;
        $transaction->mode=$mode;
        $transaction->status=$status;
        $transaction->save();
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
}

@extends('frontend.layouts.base')
@section('frontend-content')
    <div class="container">

        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="#" class="link">home</a></li>
                <li class="item-link"><span>Checkout</span></li>
            </ul>
        </div>
        <div class=" main-content-area">
            <div class="wrap-address-billing">
                <h3 class="box-title">Billing Address</h3>
                <form action="{{ route('checkout.store') }}" method="POST" name="frm-billing">
                    @csrf
                    <p class="row-in-form">
                        <label for="fname">first name<span>*</span></label>
                        <input id="fname" type="text" name="firstName" value="" placeholder="Your name">
                        @error('firstName')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </p>

                    <p class="row-in-form">
                        <label for="lname">last name<span>*</span></label>
                        <input id="lname" type="text" name="lastName" value="" placeholder="Your last name">
                        @error('lastName')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </p>

                    <p class="row-in-form">
                        <label for="email">Email Addreess:</label>
                        <input id="email" type="email" name="email" value="" placeholder="Type your email">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </p>
                    <p class="row-in-form">
                        <label for="phone">Phone number<span>*</span></label>
                        <input id="phone" type="number" name="phone" value="" placeholder="10 digits format">
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </p>
                    <p class="row-in-form">
                        <label for="add">Address:</label>
                        <input id="add" type="text" name="address" value=""
                            placeholder="Street at apartment number">
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </p>
                    <p class="row-in-form">
                        <label for="country">Country<span>*</span></label>
                        <input id="country" type="text" name="country" value="" placeholder="Pakistan">
                        @error('country')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </p>
                    <p class="row-in-form">
                        <label for="country">Province<span>*</span></label>
                        <input id="country" type="text" name="province" value="" placeholder="Punjab">
                        @error('province')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </p>
                    <p class="row-in-form">
                        <label for="zip-code">Postcode / ZIP:</label>
                        <input id="zip-code" type="number" name="postcode" value="" placeholder="Your postal code">
                        @error('postcode')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </p>
                    <p class="row-in-form">
                        <label for="city">City<span>*</span></label>
                        <input id="city" type="text" name="city" value="" placeholder="City name">
                        @error('city')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </p>
            </div>
            <div class="summary summary-checkout">
                <div class="summary-item payment-method">
                    <h4 class="title-box">Payment Method</h4>
                    <p class="summary-info"><span class="title">Check / Money order</span></p>
                    <p class="summary-info"><span class="title">Credit Cart (saved)</span></p>
                    <div class="choose-payment-methods">
                        <label class="payment-method">
                            <input name="paymentMethod" id="payment-method-bank" value="COD" type="radio">
                            <span>Cash On Delivery</span>
                            <span class="payment-desc">Buy now pay on delivery</span>
                        </label>
                        <label class="payment-method">
                            <input name="paymentMethod" id="payment-method-visa" value="card" type="radio">
                            <span>Debit / Credit Card </span>
                            <div class="payment-desc">
                                @if (session('stripe_error'))
                                    <div class="container-fluid">
                                        <div class="alert alert-info alert-dismissible fade show mt-3" role="alert">
                                            {{ session('stripe_error') }}
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                                <div class="wrap-address-billing">
                                    <p class="row-in-form">
                                        <label for="fname">Card Number<span>*</span></label>
                                        <input id="fname" type="text" name="cardNumber" value=""
                                            placeholder="Your name">
                                        @error('cardNumber')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </p>

                                    <p class="row-in-form">
                                        <label for="lname">Expire Month<span>*</span></label>
                                        <input id="lname" type="text" name="expireMonth" value=""
                                            placeholder="Your last name">
                                        @error('expireMonth')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </p>

                                    <p class="row-in-form">
                                        <label for="email">Expire Year</label>
                                        <input id="email" type="text" name="expireYear" value=""
                                            placeholder="Type your email">
                                        @error('expireYear')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </p>
                                    <p class="row-in-form">
                                        <label for="phone">CVC<span>*</span></label>
                                        <input id="phone" type="password" name="cvc" value=""
                                            placeholder="10 digits format">
                                        @error('cvc')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </p>
                                </div>
                            </div>
                        </label>
                        <label class="payment-method">
                            <input name="paymentMethod" id="payment-method-paypal" value="paypal" type="radio">
                            <span>Paypal</span>
                            <span class="payment-desc">You can pay with your credit</span>
                            <span class="payment-desc">card if you don't have a paypal account</span>
                        </label>
                        @error('paymentMethod')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <p class="summary-info grand-total"><span>Grand Total</span> <span
                            class="grand-total-price">${{ session()->get('total') }}</span></p>
                    <button type="submit" class="btn btn-medium">Place order now</button>
                </div>
                <div class="summary-item shipping-method">
                    <h4 class="title-box f-title">Shipping method</h4>
                    <p class="summary-info"><span class="title">Flat Rate</span></p>
                    <p class="summary-info"><span class="title">Fixed 0</span></p>
                </div>
            </div>
            </form>

        </div>
        <!--end main content area-->
    </div>
    <!--end container-->
@endsection

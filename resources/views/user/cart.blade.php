@extends('layouts.layout_main')
@section('title', 'AMPL Cart')
@section('metatags')
<meta name="keywords" content="publisher,  welcome, text, novel, online bookstore, entertain, reader, publisher" />
<meta name="description" content="AMPL Publishing is a Canadian company, dedicated to produce and sell entertaining electronic fictional literature (e-books for e-readers). Aspiring Authors are welcome." />
<meta name="robots" content="index,follow,archive" />
<meta name="author" content="AMPL Publishing" />
@stop
@section('content')

<div class="container main-content full-page">
    <div class="col-lg-12">
        <h1 class="page-header">Your Cart</h1>
    </div>

    <div class="row" ng-show="cart.length == 0" class="cart-page">
        <div class="col-xs-12 text-center">
            <h3>There are no items in your cart</h3>
            <br><br>

            Go to the <a href="[[ URL::to('bookstore') ]]">Bookstore</a> to purchase some great books!
        </div>
    </div>

    <div class="row" ng-show="cart.length != 0" ng-cloak>
        <table class="table table-bordered " >
            <thead>
                <tr bgcolor="green" style="color:white">
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Item Total</th>
                </tr>
            </thead>

            <tbody>
                <tr ng-repeat="item in cart" class="remove-button">
                    <td>{{ item.title }}({{ item.type }}) <a href="" class="book-soft-remove" data-ng-click="deleteBook(item.book_id, item.type_id )">remove</a></td>
                    <td>{{ item.quantity }}</td>
                    <td>${{ item.price | number:2 }}</td>
                    <td>${{ item.price * item.quantity | number:2 }}</td>
                </tr>

                <tr>
                    <td colspan="2" style="border:none"></td>
                    <td style="color:white; " bgcolor="grey" class="text-right"><strong>Tax(13%)</strong></td>
                    <td  style=" border-top: 4px solid #ddd;">${{ cartTax | number:2 }}</td>
                </tr>
                <tr>
                    <td colspan="2" style="border:none"></td>
                    <td style="color:white" bgcolor="grey" class="text-right"><strong>Shipping</strong></td>
                    <td>${{ shipping | number:2 }}</td>
                </tr>
                
                <tr>
                    <td colspan="2" style="border:none" border="0"></td>
                    <td style="color:white; " bgcolor="grey" class="text-right"><strong>Total</strong></td>
                    <td style=" border-top: 4px solid #ddd;">${{ cartTotal+cartTax+shipping | number:2 }}</td>
                </tr>
            </tbody>
        </table>
        <div class="col-lg-6" style="text-align:left; display:inline;">
            <a href="[[ URL::previous() ]]">
                <button class="btn btn-primary btn-md">
                    Continue Shopping
                </button>
            </a>
        </div>
        <div class="col-lg-6" style="text-align:right; display: inline;">
            @if(Auth::user())
                <a href="[[ URL::to('paypal/payment') ]]">
                    <button class="btn btn-primary btn-md">
                        <i class="fa fa-dollar"></i> Check Out
                    </button>
                </a>
            @else
                <a href="#" data-toggle="modal" data-target="#login_modal">
                    <button class="btn btn-primary btn-md" onclick="#login_modal">
                        <i class="fa fa-dollar"></i> Check Out
                    </button>
                </a>
            @endif
        </div>
    </div>
</div>


@stop
@stop @section('scripts')
@stop

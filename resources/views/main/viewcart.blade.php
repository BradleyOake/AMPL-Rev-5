@extends('layouts.layout_main')
@section('title', 'View Cart')
@stop
@section('content')

<!-- INSIDE VIEWCART -->
<div class="container main-content">
    @if (Session::has('cart') && count(Session::get('cart')) > 0)
        <div class="col-lg-12">
            <h1 class="page-header">Your Cart</h1>
        </div>

        <table width="100%" class="table table-striped table-bordered ampl-table">
            <tr>
                <th>Title</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Update/Remove</th>
            </tr>
            
            @foreach($cart as $index=>$item)
                <tr>
                    <td>{{ $item['title'] }}</td>
                    <td>${{ $item['price'] }}</td>
                    <td><input type="text" id="book{{ $item['bookID'] }}" class="cartQuantity" name="Quantity" value="{{ $item['quantity'] }}" /></td>
                    <td>
                        <button data-index="{{ $index }}" data-book-id="{{ $item['bookID'] }}" class="updateItem btn btn-sm btn-primary" title="Update Item" data-toggle="tooltip">
                            <i class="fa fa-refresh"></i>
                        </button>
                        <button data-index="{{ $index }}" class="removeFromCart btn btn-sm btn-danger" title="Remove From Cart" data-toggle="tooltip">
                            <i class="fa fa-times"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </table>

        <table style="float:right" class="cartTotal table ampl-table table-striped">
            <tr>
                <th>Subtotal:</th>
                <td>${{ number_format($totals['subtotal'], 2, '.', ',') }}</td>
            </tr>
            <tr>
                <th>Shipping:</th>
                <td>${{ number_format($totals['shipping'], 2, '.', ',') }}</td>
            </tr>
            <tr>
                <th>Tax:</th>
                <td>${{ number_format($totals['tax'], 2, '.', ',') }}</td>
            </tr>
            <tr>
                <th>Total Cost:</th>
                <td>${{ number_format($totals['totalCost'], 2, '.', ',') }}</td>
            </tr>
            <tr>
                <td colspan=2>
                    <button class="btn btn-sm btn-primary" title="Checkout" data-toggle="tooltip">
                        Checkout
                    </button>
                </td>
            </tr>
        </table>
    @else
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Your cart is currently empty</h1>
            </div>
        </div>
    @endif
</div>

@stop @section('javascripts')

<script>
    $(".removeFromCart").click(function () {
        var sender = $(this);
        var index = sender.data('index');
        $.ajax({
            type: "POST",
            url: "{{URL::to('cart/removeItem')}}",
            data: {
                index: index,
            },
            success: function (data) {
                location.reload();
            }
        });

        return false; // avoid to execute the actual submit of the form.
    });

    $(".updateItem").click(function () {
        var sender = $(this);
        var index = sender.data('index');
        var bookID = sender.data('book-id');
        var quantity = $("#book" + bookID.toString()).val();

        $.ajax({
            type: "POST",
            url: "{{URL::to('cart/updateItem')}}",
            data: {
                index: index,
                quantity: quantity
            },
            success: function (data) {
                location.reload();
            }
        });

        return false; // avoid to execute the actual submit of the form.
    });
</script>
@stop

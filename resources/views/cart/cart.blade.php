<!-- INSIDE CART -->
<div id="cart" class="cart" ng-show="cart.length != 0">
    <div id="cart-content" ng-cloak>
        <form METHOD="link" ACTION="[[ URL::to('cart') ]]">
            <button type="submit"  class="hvr-shutter-out-horizontal" class="btn btn-primary" style="color: white" title="View cart" data-toggle='tooltip'>
                <i class="fa fa-3x fa-shopping-cart pull-left"></i>
                <strong>
                    <ng-pluralize count="cartNumberItems"
                                when="{'0': 'No Items',
                         '1': '{{ cartNumberItems}} Item',
                         'other': '{{ cartNumberItems}} Items'}">
                    </ng-pluralize>
                </strong>
                <br>
                
                <div id="cart_total" data-cart-total=0 class="text-center">
                    ${{ cartTotal | number:2 }}
                </div>
            </button>
        </form>
    </div>
</div>

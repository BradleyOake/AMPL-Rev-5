<?php namespace App\Http\Controllers;


use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Session;
use App\Book;
use App\Cart;

 /*
 * CartController
 */
class CartController extends Controller {


    public function add(Request $request){
//Session::flush();

        $cart = new Cart();

        $book_id = $request->input('book_id');      // Book identifier
        $type_id = $request->input('type_id');      // Book type identifier
        $quantity = $request->input('quantity');    // Quantity of books

        if (Session::has('cart')) // Check for existing cart session
        {
           $cart = $request->session()->get('cart');
        }
        $cart->addBook($book_id, $type_id, $quantity); // Add item to cart

        $request->session()->put('cart', $cart);

        return response()->json(array('valid' => 'true','message' => 'Item added to cart'));

    }

    public function remove(Request $request) {

        $book_id = $request->input('book_id');      // Book identifier
        $type_id = $request->input('type_id');      // Book type identifier
        $item_id = $book_id.$type_id;   // Item itentifier

        if (Session::has('cart')) // Check for existing cart session
        {
           $cart = $request->session()->get('cart');
            $cart->removeBook($book_id, $type_id);

            $request->session()->put('cart', $cart);

            return response()->json(array('valid' => 'true','message' => 'Item removed from cart'));
        }
    }

    public function get(Request $request){

        $cart = new Cart();

         if (Session::has('cart')) // Check for existing cart session
        {
             $cart = $request->session()->get('cart');

        }
        return response()->json($cart);

    }

}

<?php
namespace App;
use App\Book;
use DB;

/*
 *  Cart
 *  -----------------------------------------------
 *
 */

class Cart {

    var $items; // Item in the cart

    public function __construct(){
        $this->items = array();
    }

    public function addBook($book_id, $type_id, $quantity)
    {
        $item_id = $book_id.$type_id;   // Item identifier
        $type_name = DB::table('book_type')->where('type_id', $type_id)->pluck('description');
        $price = "";
        $book = Book::find($book_id);

        if($type_id == 5)   // get paperback price
        {
            $price = $book->soft_price;
        }
        else if($type_id == 0)  // get general electronic price
        {
            $quantity = 1;
            $price = $book->electronic_price;
        }
        else if($type_id == 6)  // get hardcover price
        {
            $price = $book->hard_price;
        }
        else if($type_id == 4) // get mp3 price
        {
            $quantity = 1;
            $price = $book->audio_price;
        }
        else if($type_id == 3 || $type_id == 2 || $type_id == 1) // get electronic prices
        {
            $quantity = 1;
            $price = $book->electronic_price;
        }

         $this->items[$item_id] =
             array(
                'book_id'  => $book_id,
                'title' => $book->title,
                'type_id' =>  $type_id,
                'type' => $type_name,
                'quantity' => $quantity,
                'price' => $price

        );

    }

    public function removeBook($book_id, $type_id)
    {
        $item_id = $book_id.$type_id;   // Item itentifier

        unset($this->items[$item_id]); // Remove from items array
     }

    public function hasBook($book_id, $type_id)
    {
        $item_id = $book_id.$type_id;   // Item itentifier
        return array_key_exists($item_id, $this->items); // returns boolean
    }
}

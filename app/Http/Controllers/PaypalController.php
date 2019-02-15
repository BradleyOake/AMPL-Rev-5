<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Book;
use Session;
use Config;
use DB;
use Auth;
use Mail;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use PayPal\Service\PayPalAPIInterfaceServiceService;
use PayPal\EBLBaseComponents\PaymentDetailsType;
use PayPal\EBLBaseComponents\PaymentDetailsItemType;
use PayPal\CoreComponentTypes\BasicAmountType;
use PayPal\EBLBaseComponents\SetExpressCheckoutRequestDetailsType;
use PayPal\PayPalAPI\SetExpressCheckoutRequestType;
use PayPal\PayPalAPI\SetExpressCheckoutReq;
use PayPal\EBLBaseComponents\DoExpressCheckoutPaymentRequestDetailsType;
use PayPal\PayPalAPI\DoExpressCheckoutPaymentRequestType;
use PayPal\PayPalAPI\DoExpressCheckoutPaymentReq;


use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

class PaypalController extends Controller
{

    private $_api_context;

     public function __construct()
    {

        // setup PayPal api context
        $paypal_conf = Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        //$this->_api_context->setConfig($paypal_conf['settings']);
        
        $this->_api_context->setConfig( array( 
        'mode' => 'sandbox', 
        'http.ConnectionTimeOut' => 30, 
        'log.LogEnabled' => true, 
        'log.FileName' => 'PayPal.log', 
        'log.LogLevel' => 'FINE', 
        'validation.level' => 'log' 
        ) 
      ); 
      return $this->_api_context; 
    }



    /*
    |--------------------------------------------------------------------------
    | Cancel
    |--------------------------------------------------------------------------
    | This is where paypal redirects after a user cancels the payment
    |
    |
    */
    public function cancel()
    {
        return'
        <script>
        alert("Payment Cancelled");
         // add relevant message above or remove the line if not required
        window.onload = function(){
             if(window.opener){
                 window.close();
            }
             else{
                 if(top.dg.isOpen() == true){
                      top.dg.closeFlow();
                      return true;
                  }
             }
        };
        </script>';
    }

    /*
    |--------------------------------------------------------------------------
    | setExpressCheckout
    |--------------------------------------------------------------------------
    |
    | This makes the inital call to paypal to get a token
    |
    */
    public function setExpressCheckout(Request $request) {

        $type = "";
        $name = "";
        $price_with_hst;
        $hst = 1.13;
        $typeID = $request->input('type_id');
        $bookID = $request->input('book_id');; // grabbed from the form input

        $book = Book::find($bookID); // get the book details

        Session::put('book_id', $bookID); // set the book id for doExpressCheckout
        Session::put('type_id', $typeID); // set the type id for doExpressCheckout

        if($typeID <= 3) // electronic purchase
        {
             $type = 'Electronic';

             $price_with_hst = $book->electronic_price * $hst;
             Session::put('book_price', $price_with_hst);
             $bookPrice = $price_with_hst;
        }
        else if($typeID == 4) // audio purchase
        {
             $type = 'Audio';

            $price_with_hst = $book->audio_price * $hst;
             Session::put('book_price', $price_with_hst);
             $bookPrice = $price_with_hst;
        }

        $config = Config::get('paypal'); // get the global paypal configuration

        $paypalService = new PayPalAPIInterfaceServiceService($config);
        $paymentDetails= new PaymentDetailsType();

        $itemDetails = new PaymentDetailsItemType();


        $itemDetails->Name = $book->title;
        $itemAmount = $bookPrice;
        $itemDetails->Amount = $itemAmount;
        $itemQuantity = '1';
        $itemDetails->Quantity = $itemQuantity;

        $itemDetails->ItemCategory =  'Digital';

        $paymentDetails->PaymentDetailsItem[0] = $itemDetails;

        $orderTotal = new BasicAmountType();
        $orderTotal->currencyID = 'CAD';
        $orderTotal->value = $itemAmount * $itemQuantity;

        $paymentDetails->OrderTotal = $orderTotal;
        $paymentDetails->PaymentAction = 'Sale';

        Session::put('paymentDetails', $paymentDetails);
        $setECReqDetails = new SetExpressCheckoutRequestDetailsType();
        $setECReqDetails->PaymentDetails[0] = $paymentDetails;
        $setECReqDetails->CancelURL = url('paypal/cancel');
        $setECReqDetails->ReturnURL = url('paypal/confirm');

        $setECReqType = new SetExpressCheckoutRequestType();
        $setECReqType->Version = '104.0';
        $setECReqType->SetExpressCheckoutRequestDetails = $setECReqDetails;

        $setECReq = new SetExpressCheckoutReq();
        $setECReq->SetExpressCheckoutRequest = $setECReqType;

        $setECResponse = $paypalService->SetExpressCheckout($setECReq);

        if($setECResponse->Ack == 'Success') {

            if($config['mode'] == 'live')
                return Redirect::to('https://www.paypal.com/incontext?token='.$setECResponse->Token); // validate the token through paypal
            else
                return Redirect::to('https://www.sandbox.paypal.com/incontext?token='.$setECResponse->Token); // validate the token through paypal

        }
        else {
            echo "error in SetEC API call";
        }
     }


    /*
    |--------------------------------------------------------------------------
    | doExpressCheckout
    |--------------------------------------------------------------------------
    |
    | This is where you are redirected after paypal validates the token.
    | This processes the payment and updates the database and send emails.
    |
    */
    public function doExpressCheckout() {

        $config = Config::get('paypal');

        $paymentDetails= new PaymentDetailsType();
        $payerId=urlencode(  $_REQUEST['PayerID']);
        $token =urlencode( $_REQUEST['token']);

        $paymentDetails =Session::get('paymentDetails');

        $typeID = Session::get('type_id');
        $bookID = Session::get('book_id');
        $amount = Session::get('book_price');

        $paypalService = new PayPalAPIInterfaceServiceService($config);

        $DoECRequestDetails = new DoExpressCheckoutPaymentRequestDetailsType();
        $DoECRequestDetails->PayerID = $payerId;
        $DoECRequestDetails->Token = $token;
        $DoECRequestDetails->PaymentDetails[0] = $paymentDetails;

        $DoECRequest = new DoExpressCheckoutPaymentRequestType();
        $DoECRequest->DoExpressCheckoutPaymentRequestDetails = $DoECRequestDetails;
        $DoECRequest->Version = '104.0';

        $DoECReq = new DoExpressCheckoutPaymentReq();
        $DoECReq->DoExpressCheckoutPaymentRequest = $DoECRequest;

        $DoECResponse = $paypalService->DoExpressCheckoutPayment($DoECReq);

        if($DoECResponse->Ack == 'Success')
        {
            /*
            |--------------------------------------------------------------------------
            | Create the user invoice for the sale
            |--------------------------------------------------------------------------
            */
            $id = DB::table('user_invoice')->insertGetId(
                array('book_id' => $bookID, 'email' => Auth::user()->email, 'type_id'=> $typeID, 'amount'=>$amount)
            );

            $book = Book::find($bookID);


            /*
            |--------------------------------------------------------------------------
            | Create the author invoices for each current author with current rate
            |--------------------------------------------------------------------------
            */
            if($typeID <= 3) {

                $type = 'electronic';

                foreach($book->authors as $author)
                {
                    DB::table('author_invoice')->insert(
                        array('sale_id' => $id, 'email' => $author->email, 'rate'=> $author->electronic_rate)
                    );
                }

            } else if($typeID == 4) {

                $type = 'audio';

                foreach($book->authors as $author)
                {
                    DB::table('author_invoice')->insert(
                        array('sale_id' => $id, 'email' => $author->email, 'rate'=> $author->audio_rate)
                    );
                 }

            }

            
            // ...holds email info
            $first = DB::table('user')->where('email',  Auth::user()->email)->pluck('first_name');
            $last = DB::table('user')->where('email',  Auth::user()->email)->pluck('last_name');
            $title = DB::table('book')->where('book_id', $bookID)->pluck('title');
            $type = DB::table('book_type')->where('type_id', $typeID)->pluck('description');
            $buyeremail = Auth::user()->email;
            $amplemail = config('mail.admin.address');
            $amplname = config('mail.admin.name');
            
            /*
            |--------------------------------------------------------------------------
            | Admin Email
            |--------------------------------------------------------------------------
            */
             $user = array(
                'buyer_email'=> $buyeremail,
                'buyer_first'=> $first,
                'buyer_last'=> $last,
                'amplemail'=> $amplemail,
                'amplname'=> $amplname,                          
            );

            $data = array(
                'sale_id'=> $id,
                'buyer_first'=> $first,
                'buyer_last'=> $last,
                'buyer_email'=> $buyeremail,
                'title'=> $title,                
                'type'=> $type,
                'book_id'=> $bookID,
                'type_id'=> $typeID,
                'amount'=> $amount               
            );
            
            Mail::send('emails.purchase_admin', $data, function($message) use ($user)
            {
                $message->to($user['amplemail'], $user['amplname'] )->subject('There Has Been a Purchase');
            });

            /*
            |--------------------------------------------------------------------------
            | User Email
            |--------------------------------------------------------------------------
            */
                                                        
            Mail::send('emails.purchase_user', $data, function($message) use ($user)
            {
                $message->to($user['buyer_email'], $user['buyer_first'] . ' ' . $user['buyer_last'] )->subject('Thank You For Your Purchase');
                $message->from($user['amplemail'], $user['amplname']);
            });


            

            // set the message for redirect
           // Session::flash('successMessage', 'You have succesfully purchased '.$book->title.' in the '.$type.' format!');

            // close the lightbox and redirect to purchases page
            echo '<script>
                    window.opener.location.href="'.url('user/myPurchases').'";
                    // add relevant message above or remove the line if not required
                    window.onload = function(){
                    if(window.opener){
                    window.close();
                    }
                    else{
                    if(top.dg.isOpen() == true){
                    top.dg.closeFlow();
                    return true;
                    }
                    }
                    };
                    </script>';


        }
        else
        {
            return '<script>
            alert("Payment Failed");

            window.onload = function(){
                 if(window.opener){
                     window.close();
                }
                 else{
                     if(top.dg.isOpen() == true){
                          top.dg.closeFlow();
                          return true;
                      }
                 }
            };
            </script>';
        }

    }


 /*
    |--------------------------------------------------------------------------
    | postPayment
    |--------------------------------------------------------------------------
    |
    | This is where buyers are located to paypal checkout for physical books.
    | Gets all the items in the cart and send them to paypal.
    |
    */
    public function postPayment()
{

    $payer = new Payer();
    $payer->setPaymentMethod('paypal');


$itemsArray = array();
        $total = 0;
//var_dump(Session::get('cart'));
    foreach (Session::get('cart')->items as $item)
    {
        //echo var_dump($item);

        $newItem = new Item();
        $newItem->setName($item['title'].' ('. $item['type'] . ')') // item name
            ->setCurrency('CAD')
            ->setQuantity($item['quantity'])
            ->setPrice($item['price']); // unit price

        $total +=$item['price'];

        array_push($itemsArray, $newItem);
    }



    // add item to list
    $item_list = new ItemList();
    $item_list->setItems($itemsArray);

    $amount = new Amount();
    $amount->setCurrency('CAD')
        ->setTotal($total);

    $transaction = new Transaction();
    $transaction->setAmount($amount)
        ->setItemList($item_list)
        ->setDescription('This is the transaction description');

    $redirect_urls = new RedirectUrls();
    $redirect_urls->setReturnUrl(url('paypal/payment/status'))
        ->setCancelUrl(url('paypal/payment/status'));

    $payment = new Payment();
    $payment->setIntent('Sale')
        ->setPayer($payer)
        ->setRedirectUrls($redirect_urls)
        ->setTransactions(array($transaction));

    try {
        $payment->create($this->_api_context);
    } catch (\PayPal\Exception\PPConnectionException $ex) {
        if (\Config::get('app.debug')) {
            echo "Exception: " . $ex->getMessage() . PHP_EOL;
            $err_data = json_decode($ex->getData(), true);
            exit;
        } else {
            die('Some error occur, sorry for inconvenient');
        }
    }

    foreach($payment->getLinks() as $link) {
        if($link->getRel() == 'approval_url') {
            $redirect_url = $link->getHref();
            break;
        }
    }

    // add payment ID to session
    Session::put('paypal_payment_id', $payment->getId());

    if(isset($redirect_url)) {
        // redirect to paypal
        return Redirect::away($redirect_url);
    }

    return Redirect::route('original.route')
        ->with('error', 'Unknown error occurred');
}


     /*
    |--------------------------------------------------------------------------
    | getPaymentStatus
    |--------------------------------------------------------------------------
    |
    | THis is what happends after a user goes through paypal
    |
    */
    public function getPaymentStatus(Request $request)
    {
        // Get the payment ID before session clear
        $payment_id = Session::get('paypal_payment_id');

        // clear the session payment ID
        Session::forget('paypal_payment_id');

        if (empty($request->input('PayerID') || $request->input('token') )) {
            return Redirect::route('original.route')
                ->with('error', 'Payment failed');
        }

        $payment = Payment::get($payment_id, $this->_api_context);

        // PaymentExecution object includes information necessary
        // to execute a PayPal account payment.
        // The payer_id is added to the request query parameters
        // when the user is redirected from paypal back to your site
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID') );

        //Execute the payment
        $result = $payment->execute($execution, $this->_api_context);

        echo '<pre>';print_r($result);echo '</pre>';exit; // DEBUG RESULT, remove it later

        if ($result->getState() == 'approved') { // payment made
            return Redirect::route('original.route')
                ->with('success', 'Payment success');
        }
        return Redirect::route('original.route')
            ->with('error', 'Payment failed');
    }



}

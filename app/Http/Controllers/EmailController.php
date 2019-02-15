<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Hash;


use Illuminate\Http\Request;
use Mail;

class EmailController extends Controller {

  /**
    *  Send email from the contact form to the admin
    *
    */
    public function sendContactEmail (Request $request)
    {
        config([
            'config/mail.php',
        ]);
        
        $email = $request->input('contact_email');
        $name = $request->input('contact_name');
        $subject = $request->input('contact_subject');
        $message = $request->input('contact_message');
        $toemail = config('mail.admin.address');
        $toname = config('mail.admin.name');
        $valid = false;
        $valid2 = false;
              
        $user = array(
            'admin_email'=> $toemail,
            'admin_name'=> $toname,
            'user_email'=> $email,
            'user_name'=> $name,
            'subject'=> $subject           
        );

        $data = array(
            'name'=> $name,
            'email'=> $email,
            'contact_message'=> $message,
            'subject'=> $subject
        );
       
        $valid = Mail::send('emails.contact_form_user', $data, function($message) use ($user)
        {
            $message->to($user['user_email'], $user['user_name'] )->subject('Thank You For Your Feedback');
            $message->from($user['admin_email'], $user['admin_name']);
        });
                
        $valid2 = Mail::send('emails.contact_form_admin', $data, function($message) use ($user)
        {
            $message->to($user['admin_email'], $user['admin_name'] )->subject('AMPL Publishing: ' . $user['subject']);
            $message->from($user['user_email'], $user['user_name']);
        });
        
        if($valid && $valid2) {
            return response()->json(array('valid' => 'true','message' => 'Email has been sent'));
        } else {
            return response()->json(array('valid' => 'false','message' => 'Email Not sent'));
        }
    }

    /*
     *  adminElectronicPurchase
     *  ----------------------------------------------
     *
     *  Send an email to the admin regarding a new electronic goods sale
     */
    public static function adminElectronicPurchase ()
    {

           $user = array(
                'email'=>Config::get('mail.admin.address'),
                'name'=>Config::get('mail.admin.name'),
                'book_title' => $book->title
            );

            $data = array(
                'buyer_email'   => Auth::user()->email,
                'buyer_first'   => Auth::user()->first_name,
                'buyer_last'    => Auth::user()->last_name,
                'book_id'       => $bookID,
                'type_id'       => $typeID,
                'amount'        => $amount,
                'title'         => $book->title

            );

            // use Mail::send function to send email passing the data and using the $user variable in the closure
            Mail::queue('emails.purchase_admin', $data, function($message) use ($user) {
                $message->to($user['email'], $user['name'])->subject('Book Purchase: '. $user['book_title']);
            });
     }

     /*
     *  adminElectronicPurchase
     *  ----------------------------------------------
     *
     *  Send an email to the user regarding their new electronic goods sale
     */
    public static function userElectronicPurchase ()
    {

           $user = array(
                'email'=>Auth::user()->email,
                'name'=>Auth::user()->first_name.' '.Auth::user()->last_name,
                'book_title' => $book->title
            );

            $data = array(
                'name'=>Auth::user()->first_name.' '.Auth::user()->last_name,
                'type'=> $type,
                'amount' => $amount,
                'buyer_email'    => Auth::user()->email,
                'buyer_first'    => Auth::user()->first_name,
                'buyer_last'    => Auth::user()->last_name,
                'amount' => $amount,
                'title' => $book->title,
                'sale_id' => $id
            );

            // use Mail::send function to send email passing the data and using the $user variable in the closure
            Mail::queue('emails.purchase_user', $data, function($message) use ($user) {
                $message->to($user['email'], $user['name'])->subject('Book Purchase: ' . $user['book_title'] );
            });
     }
     
     //send email to newly registered user
     public function sendRegistrationEmail (Request $request)
     {
        $email = $request->input('email');
        $firstname = $request->input('first_name');
        $lastname = $request->input('last_name');
        $adminemail = config('mail.admin.address');
        $adminname = config('mail.admin.name');         
        $createdat = DB::table('user')->where('email', $email)->pluck('created_at');
         
        $user = array(
            'email'=> $email,
            'adminemail'=> $adminemail,
        );

        $data = array(
            'email'=> $email,
            'firstname'=> $firstname,
            'lastname'=> $lastname,
            'createdat'=> $createdat,
        );

        Mail::send('emails.registration_user', $data, function($message) use ($user)
        {
            $message->to($user['email'])->subject('Thank you for registering with AMPL Publishing!');
        });
        
        Mail::send('emails.registration_admin', $data, function($message) use ($user)
        {
            $message->to($user['adminemail'])->subject('A New User Has Registered With AMPL Publishing!');
            $message->from($user['email'], 'AMPL Website/Registration');
        });

     }
     
     
       /*
     *  Printing Services page order
     *  ----------------------------------------------
     *
     *  Send email to AMPL for single print jobs ordered on website
     */
    public function sendPrintJobEmail (Request $request)
    {
        $printemail = $request->input('printEmail');
        $jobname = $request->input('jobName');
        $numpages = $request->input('numPagesOrder');
        $ordercover = $request->input('orderCover');
        $orderpaper = $request->input('orderPaper');
        $orderink = $request->input('orderInk');
        $orderadditional = $request->input('orderAdditional');
        
        $uploadtext = $request->file('uploadText')->getPathName();
        $uploadFileName = $request->file('uploadText')->getClientOriginalName();
        $mime = $request->file('uploadText')->getMimeType();
        
        $valid = false;
        $valid2 = false;
        
        $user = array(
            'email'=> $printemail,
            'jobname'=> $jobname,
            'uploadtext'=> $uploadtext,
            'uploadname'=> $uploadFileName,
            'mime'=> $mime
        );
        
        $data = array(
            'jobname' => $jobname,
            'numpages' => $numpages,
            'ordercover' => $ordercover,
            'orderpaper' => $orderpaper,
            'orderink' => $orderink,
            'orderadditional' => $orderadditional,
            'uploadname'=> $uploadFileName,
        );
        
        $valid = Mail::send('emails.print_job', $data, function($message) use ($user)
        {
            $message->to('printing@amplbooks.com')->subject('New Print Job: ' . $user['jobname']);
            $message->from($user['email'], 'AMPL Website/Printing Services');
            $message->attach($user['uploadtext'], ['as' => $user['uploadname'], 'mime' => $user['mime']] );
        });
        $valid2 = Mail::send('emails.print_job_user', $data, function($message) use ($user)
        {
            $message->to($user['email'])->subject('Your print request is being processed');
            $message->from('printing@amplbooks.com');

        });
        
          if($valid && $valid2) {
            return response()->json(array('valid' => 'true','message' => 'Email has been sent'));
        } else {
            return response()->json(array('valid' => 'false','message' => 'Email Not sent'));
        }
    }
    

    
    //send password CHANGE email
    public function changePasswordEmail (Request $request)
    {
        $email = Auth::user()->email;
        $name = Auth::user()->first_name;
        
        $user = array(
            'email'=> $email               
        );

        $data = array(
            'name'=> $name,
            'email'=> $email,
        );
        
        $valid = Mail::send('emails.password_change', $data, function($message) use ($user)
        {
            $message->to($user['email'])->subject('amplbooks.com - PASSWORD CHANGE');
        });
        
        if($valid) {
            return response()->json(array('valid' => 'true','message' => 'Email has been sent'));
        } else {
            return response()->json(array('valid' => 'false','message' => 'Email Not sent'));
        }
        
    }


    public function resetPassword(Request $request)
    {
        //get input from ajax on forgot-password.js
        $email =  $request->input('email');
      
  
        //create random 8 character string for new password
        function randomPassword() 
        {
            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $pass = array();
            $alphaLength = strlen($alphabet) - 1; 
            
            for ($i = 0; $i < 8; $i++) 
            {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            
            return implode($pass);
        }
        

        $name = DB::table('user')->where('email', $email)->pluck('first_name');
        $password = randomPassword();

        //send password to user
        $user = array(
            'email'=> $email               
        );

        $data = array(
            'email'=> $email,
            'password'=> $password,
            'name'=> $name
        );
               
        Mail::send('emails.password_reset', $data, function($message) use ($user)
        {
            $message->to($user['email'])->subject('amplbooks.com - PASSWORD RESET');
        });


        $updatePassword = Hash::make($password);
       
        DB::table('user')->where('email', $email)->update(array('password'=> $updatePassword));

    }
}

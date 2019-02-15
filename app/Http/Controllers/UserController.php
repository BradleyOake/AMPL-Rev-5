<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Auth;
use Hash;
use App\User;
class UserController extends Controller {


   


    /*
    |--------------------------------------------------------------------------
    | The name update part of the profile page
    |--------------------------------------------------------------------------
    */
    public function nameUpdate(Request $request)
    {
       

        $first =  $request->input('first');
        $last =  $request->input('last');
        $valid = false;
        $name = $first.' '.$last;
       
            DB::table('user')
            ->where('email', Auth::user()->email)
            ->update(array('first_name' => $first, 'last_name' => $last));

            Auth::loginUsingId(Auth::user()->email); // reauth to update info
            $valid = true;
        

       
        return response()->json(array('valid' => $valid,'name' => $first.' '.$last));
    }


    /*
    |--------------------------------------------------------------------------
    | The password update part of the profile page
    |--------------------------------------------------------------------------
    */
    public function passwordUpdate(Request $request)
    {
        
        $oldPassword =  $request->input('oldpassword');
        $newPassword =  $request->input('password');
        $valid = false;
         $message = '';

         $newPassword = Hash::make($newPassword); // hash the new password

       
            if(Hash::check($oldPassword, Auth::user()->password)) // check for right old password
            {
                DB::table('user')
                ->where('email', Auth::user()->email)
                ->update(array('password' => $newPassword));

               Auth::loginUsingId(Auth::user()->email); // reauth to update info
                $message = 'Password updated successfully';
                $valid = true;
           }
            else{
                 $message = 'The password you have entered is incorrect';
            }
        

       
         return response()->json(array('valid' => $valid,'message' => $message));

    }

     public function EmailCheck(Request $request)
    {
        $valid = true;

        $data = Input::all();
        $email = $data['email2'];

        if(Request::ajax())
        {
            if($user = DB::table('user')->where('email', $email)->exists()){

                $valid = false;
            }
        }
        echo json_encode(array('valid' => $valid));
         return response()->json(array('valid' => true,'message' => 'Book has been submitted'));
    }


    /*
    |--------------------------------------------------------------------------
    | Admin actions against users
    |--------------------------------------------------------------------------
    */
    public function updateUser(Request $request)
    {      

        $first =  $request->input('first');
        $last =  $request->input('last');
        
        $message = '';
        $valid = false;
       
        $id = $request->input('id');

        $first = $request->input('user_first');
        $last = $request->input('user_last');
        $email = $request->input('user_email');
        $type = $request->input('user_type');
        $password = $request->input('user_password');
        $mDescription = $request->input('m_description');
        $mKeywords = $request->input('m_keywords');

        $bio = ($request->input('bio') == '') ? null : Input::file('bio');
        $image = ($request->input('image') == '') ? null : Input::file('image');

        $user = User::find($email);        
    
        if ($password == '')
        {
            $valid = DB::table('user')
                  ->where('email', $email)
                  ->update(array('first_name' => $first, 'last_name' => $last, 'role_id' => $type, 'm_description'=> $mDescription, 'm_keywords' => $mKeywords ));
            
            if($valid)
                $message .= 'User info has been updated successfully.<br>';
            else
                 $message .= 'No changes made to database.<br>';

        }
        else
        {
            $updatePassword = Hash::make($password);

            $valid = DB::table('user')
                  ->where('email', $email)
                  ->update(array('first_name' => $first, 'last_name' => $last, 'password' => $updatePassword, 'role_id' => $type, 'm_description'=> $mDescription, 'm_keywords' => $mKeywords ));
            
            if($valid)
                $message .= 'User info and user password have been updated successfully.<br>';
              else
                 $message .= 'No changes made to database.<br>';
        }

        
        if ($bio!= null) {
            if($bio->move(storage_path() . '/authors/'. $id .'/about/', $id.'_about.'.$bio->getClientOriginalExtension()))
                $message .= 'User bio has been uploaded successfully.<br>';
        }

        if ($image!= null) 
        {             
            if($user->coverExists()) 
             {File::delete($user->coverPath());}
            
            if($image->move('images/authors/'.$id.'/',$id.'_cover.'.$image->getClientOriginalExtension()) )
              $message .= 'User image has been uploaded successfully.<br>';
        }

        $valid = true;
        

       return response()->json(array('valid' => $valid,'message' => $message));
    }

    public function insertUser(Request $request)
    {      

        $first =  $request->input('first');
        $last =  $request->input('last');
        
        $message = '';
        $valid = false;
       
        $id = $request->input('id');

        $first = $request->input('user_first');
        $last = $request->input('user_last');
        $email = $request->input('email2');
        $type = $request->input('user_type');
        $password = $request->input('user_password');
        $mDescription = $request->input('m_description');
        $mKeywords = $request->input('m_keywords');

        $bio = ($request->input('bio') == '') ? null : Input::file('bio');
        $image = ($request->input('image') == '') ? null : Input::file('image');
        
        //Hashes the password
        $password = Hash::make($password);

        
        $id = DB::table('user')
          ->insertGetId(array('email' => $email, 'first_name' => $first, 'last_name' => $last, 'password' => $password, 'role_id' => $type, 'm_description'=> $mDescription, 'm_keywords' => $mKeywords ));
        $valid = true;

          if ($bio!= null) {
            $bio->move(storage_path() . '/authors/'. $id .'/about/', $id.'_about.'.$bio->getClientOriginalExtension());
        }

        if ($image!= null) {
            $image->move('images/authors/',$id.'.'.$image->getClientOriginalExtension());
        }
    

         return response()->json(array('valid' => $valid,'message' => $message, 'id' => $id));
    }

    public function unlockDownload($saleId, $bookId, $typeId)
    {
        $allowedTime = date('Y-m-d', strtotime("+3 days"));

        $check = DB::table('download_access')
                   ->where('sale_id', '=', $saleId)
                   ->where('book_id', '=', $bookId)
                   ->where('type_id', '=', $typeId)
                   ->get();

        if (count($check) > 0)
        {
            DB::table('download_access')
             ->where('sale_id', '=', $saleId)
              ->update(array('allow_until' => $allowedTime));
        }
        else
        {
            DB::table('download_access')
              ->insert(array('sale_id' => $saleId, 'book_id' => $bookId, 'type_id' => $typeId, 'allow_until' => $allowedTime));
        }

        return Redirect::back();
    }
}



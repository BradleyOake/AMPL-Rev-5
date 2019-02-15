<?php namespace App\Http\Controllers;

use Auth;
use Session;
use App\User;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
*  Controller used for all authentication including regisration and password reset
*
*/
class AuthController extends Controller {

    /**
     *  login
     *  =======================================================
     *  Authenticates user with provided email and password
     *
     *  Parameters[
     *      string:     email, password
     *      boolean:    remember
     *  ]
     *
     *  returns: JSON object containng a valid value and a message from the server
     */
    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->input('remember');

        if(Auth::attempt(array('email' => $email, 'password' => $password), $remember)){
            return response()->json(array('valid' => 'true','message' => 'login: Login succesful'));
        }else {
            return response()->json(array('valid' => 'false','message' => 'login: Login not succesful'));
        }
    }


    /**
     *  emailCheck
     *  =======================================================
     *  Checks if a given email exists in the database
     *
     *  Parameters[
     *      string:     email
     *  ]
     *
     *  returns a JSON object containng a valid value
     */
    public function emailCheck(Request $request)
    {
        $email = $request->input('register_email');
          if(User::find($email) === null){
            return response()->json(array('valid' => 'true'));
        }else {
            return response()->json(array('valid' => 'false'));
        }
    }
    
    //Reverse 'emailCheck' for use in 'forgot password' funtionality
    public function emailExist(Request $request)
    {
        $email = $request->input('email');
          if(User::find($email) === null){
            return response()->json(array('valid' => 'false'));
        }else {
            return response()->json(array('valid' => 'true'));
        }
    }

     /**
     *  register
     *  =======================================================
     *  Registers and validates user input
     *
     *  Parameters[
     *      string:     email, password, firstname, lastname
     *      boolean:    remember
     *  ]
     *
     *  returns a JSON object containng a valid value and a message from the server
     */
    public function register(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $firstName = $request->input('first_name');
        $lastName = $request->input('last_name');

        $validator = Validator::make(
            [
                'email' => $email,
                'password' => $password,
                'first_name' => $firstName,
                'last_name' => $lastName
            ],
            [
                'email' => 'required',
                'password' => 'required|min:6',
                'first_name' => 'required',
                'last_name' => 'required'
             ]
        );

        // return false if data invalid
        if ($validator->fails())
        {
            return response()->json(array('valid' => 'false','message' => $validator->messages()));
        }

        $password = bcrypt($password);

        $user = new User;

        $user->email = $email;
        $user->password = $password;
        $user->first_name = $firstName;
        $user->last_name = $lastName;

        $user->save();

        Auth::loginUsingId($email);
        
        if(Auth::check()){
            return response()->json(array('valid' => 'true','message' => 'Registration succesful'));
        }else {
            return response()->json(array('valid' => 'false','message' => 'Registration not succesful'));
        }
    }


    /**
     *  facebookLogin
     *  =======================================================
     *  Sends a token to facebook to get user email, firstname, and lastname
     *
     *  Parameters
     *      string:     token
     *
     *  returns a JSON object containng a valid value and a message from the server
     */
    public function facebookLogin(Request $request)
    {
        $token = $request->input('token');

        $json = file_get_contents('https://graph.facebook.com/me?access_token='.urlencode($token));
        $obj = json_decode($json);

        // Get user information
        $facebookID = $obj->id;
        $email = $obj->email;
        $firstName = $obj->first_name;
        $lastName = $obj->last_name;

        // Check for required fields
        if(!isset($obj->email)){
            return response()->json(array('valid' => 'false', 'message' => 'No email on Facebook account'));
        }

        $user = User::find($email);

        // User with email doesnt exist
        if($user === null) {
            $user = new User;

            $user->email = $email;
            $user->first_name = $firstName;
            $user->last_name = $lastName;
            $user->facebook_id = $facebookID;

            $user->save();
        }

         // User facebook account not linked
        if ($user->facebook_id === null){
            $user->facebook_id = $facebookID;
            $user->save();
        }else if($user->facebook_id != $facebookID)
        {
             return response()->json(array('valid' => 'false','message' => 'Facebook account and email do not match'));
        }

        Auth::login($user);

        // Return response to ajax call
        if(Auth::check()){
            return response()->json(array('valid' => 'true','message' => 'Facebook login succesful'));
        }else {
            return response()->json(array('valid' => 'false','message' => 'Facebook login not succesful'));
        }
    }



   /**
     *  googleLogin
     *  =======================================================
     *  Sends a token to facebook to get user email, firstname, and lastname
     *
     *  Parameters[
     *      string:     token
     *  ]
     *
     *  returns a JSON object containng a valid value and a message from the server
     */
    public function googleLogin(Request $request)
    {
        $token = $request->input('token');

        $json = file_get_contents('https://www.googleapis.com/oauth2/v3/tokeninfo?id_token='.urlencode($token));
        $obj = json_decode($json);

        $googleID = $obj->sub;
        $email = $obj->email;
        $firstName = $obj->given_name;
        $lastName = $obj->family_name;

        // Check for required fields
        if(!isset($obj->email)){
            return response()->json(array('valid' => 'false', 'message' => 'No google email provided'));
        }

        $user = User::find($email);

        // User with email doesnt exist
        if($user === null) {
            $user = new User;

            $user->email = $email;
            $user->first_name = $firstName;
            $user->last_name = $lastName;
            $user->google_id = $googleID;

            $user->save();
        }

         // User google account not linked
        if ($user->google_id === null){
            $user->google_id = $googleID;
            $user->save();
        }else if($user->google_id != $googleID)
        {
             return response()->json(array('valid' => 'false','message' => 'Google account and email do not match'));
        }

        Auth::login($user);


        // Return response to ajax call
        if(Auth::check()){
            return response()->json(array('valid' => 'true','message' => 'Google login succesful'));
        }else {
            return response()->json(array('valid' => 'false','message' => 'Google login not succesful'));
        }

    }



    /**
     *  Unauthenticates user
     *
     */
    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->intended('/');
    }

     /**
     *  Unauthenticates user
     *
     */
    public function sendResetToken (Request $request)
    {
        $email = $request->input('email');
        $token = bin2hex(openssl_random_pseudo_bytes(32));
    }




    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function authenticate()
    {
        if (Auth::attempt(['email' => $email, 'password' => $password]))
        {
            return redirect()->intended('dashboard');
        }
    }



}

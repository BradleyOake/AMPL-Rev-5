<?php namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

 /*
 * NewsCommentController
 */
class NewsCommentController extends Controller {

     /**
     *  agree
     *  =======================================================
     *  Changes the aggree value to a specific comment given a comment id
     *  and using the current authorized user's email
     *
     *  Parameters[
     *      integer:     comment_id
     *  ]
     *
     *  returns: JSON object containg a valid value and a message from the server
     */
     public function agree(Request $request){

         $id = $request->input('comment_id');
         $valid = false;

         // Check if a database entry exists
         $commentExists = DB::table('news_comment_opinion')
            ->where('comment_id', $id)
            ->where('email', Auth::user()->email)
            ->exists();

        if($commentExists) {    // If entry update

            $valid = DB::table('news_comment_opinion')
                ->where('comment_id', $id)
                ->where('email', Auth::user()->email)
                ->update( array('email' => Auth::user()->email, 'comment_id' => $id, 'agreed' => 1));
        } else {    // If no entry insert
            $valid = DB::table('news_comment_opinion')
                ->insert(
                    array('email' => Auth::user()->email, 'comment_id' => $id, 'agreed' => 1)
                );
        }

        if($valid) {
            return response()->json(array('valid' => true,'message' => 'Comment has been liked'));
        } else {
            return response()->json(array('valid' => false,'message' => 'An error occured'));
        }
     }

     /**
     *  disagree
     *  =======================================================
     *  Changes the aggree value to a specific comment given a comment id
     *  and using the current authorized user's email
     *
     *  Parameters[
     *      integer:     comment_id
     *  ]
     *
     *  returns: JSON object containg a valid value and a message from the server
     */
    public function disagree(Request $request){
        $id = $request->input('comment_id');
        $valid = false;

         // Check if a database entry exists
         $commentExists = DB::table('news_comment_opinion')
            ->where('comment_id', $id)
            ->where('email', Auth::user()->email)
            ->exists();

        if($commentExists) {    // If entry update

            $valid = DB::table('news_comment_opinion')
                ->where('comment_id', $id)
                ->where('email', Auth::user()->email)
                ->update( array('email' => Auth::user()->email, 'comment_id' => $id, 'agreed' => -1));

        } else {    // If no entry insert

            $valid = DB::table('news_comment_opinion')
                ->insert(
                    array('email' => Auth::user()->email, 'comment_id' => $id, 'agreed' => -1)
                );
        }

        if($valid) {
            return response()->json(array('valid' => true,'message' => 'Comment has been disliked'));
        } else {
            return response()->json(array('valid' => false,'message' => 'An error occured'));
        }
     }




    /**
     *  delete
     *  =======================================================
     *  Deletes a comment using the id. Checks for ownership of comment
     *
     *  Parameters[
     *      integer:     comment_id
     *  ]
     *
     *  returns: JSON object containg a valid value and a message from the server
     */
    public function approve(Request $request){

        $id = $request->input('comment_id');

        if( Auth::user()->role_id == 7) {

               $valid = $update = DB::table('news_comment')->where('comment_id', $id)->update(
                [
                    'comment_status' => 1
                ]
            );

           echo json_encode(array('valid' => $valid));
        }
        else
        {
            echo json_encode(array('valid' => false));
        }
    }



     /**
    * Delete to a news comment
    */
    public function delete(Request $request)
    {
        $id = $request->input('comment_id');
        $valid = false;
      
        //$data = Input::all();
        //$id = $data['comment_id'];

        if(Auth::user()->role_id == 7 || DB::table('news_comment')->where('comment_id', $id)->where('email', Auth::user()->email)->exists())
        {
            $valid = DB::table('news_comment')->where('comment_id', $id)->delete();          
        }


        if($valid) 
        {
            return response()->json(array('valid' => true,'message' => 'Comment Deleted'));
        } 
        else 
        {
            return response()->json(array('valid' => false,'message' => 'Delete Failed'));
        }
    }

     /**
    * Report a news comment
    */
    public function report(Request $request){

        $id = $request->input('comment_id');
        $email = Auth::user()->email;
        $valid = false;
        $value;

        $comment = DB::table('news_comment_opinion')
            ->where('comment_id', $id)
            ->where('email', $email)
            ->first();

        if($comment)
        {
            $value = ($comment->reported == 1 ? 0 : 1); // get the opposite value

            
            $valid = DB::table('news_comment_opinion')
                ->where('comment_id', $id)
                ->where('email', $email)
                ->update( array('email' => $email, 'comment_id' => $id, 'reported' =>  $value));

        } else {
            $value = 0;
            $valid = DB::table('news_comment_opinion')
                ->insert(
                    array('email' => $email, 'comment_id' => $id, 'reported' =>  1)
                );

        }

         if($valid) {
            if($value == 1)
                return response()->json(array('valid' => true,'message' => 'Comment has been reported'));
             else
                 return response()->json(array('valid' => true,'message' => 'Comment has been unreported'));
        } else {
            return response()->json(array('valid' => false,'message' => 'An error occured'));
        }
    }



    /**
    * Insert a news comment
    */
    public function insertComment(Request $request){

        $id = $request->input('news_id');
        $alias = $request->input('alias');
        $text = $request->input('comment_text');
        $recaptcha = $request->input('comment_recaptcha');
        $valid = false;

        /*
         *  Recaptcha validation
         *
         *
         */
        $secret = '6LfayPQSAAAAAHNG4OF_mA1mPhyDaGtpnYf1HPsl';
        //set POST variables
        $url = 'https://www.google.com/recaptcha/api/siteverify';


        $postfields = array('secret'=>$secret, 'response'=>$recaptcha);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // On dev server only!
        $result = curl_exec($ch);

        $result = json_decode($result, true);

        if (!isset($result['success']) || $result['success'] != true) {
           return response()->json(array('valid' => false,'message' => 'Please complete the recaptcha'));
        }

        $valid = DB::table('news_comment')->insert(
            [
                'news_id' => $id,
                'email' => Auth::user()->email,
                'alias' => $alias,
                'text' => $text
            ]
        );

         if($valid) {
            return response()->json(array('valid' => true,'message' => 'Comment has been disliked'));
        } else {
            return response()->json(array('valid' => false,'message' => 'An error occured'));
        }
    }

    /**
    * Update a news comment
    */
    public function updateComment(Request $request)
    {
        $text = $request->input('editcomment_text');
        $id = $request->input('news_id'); 
        $commentID = $request->input('comment_id');
        $valid = false;

        $valid = DB::table('news_comment')->where('comment_id', $commentID)->update(
        [
            'text' => $text
        ]
        );
        
        if($valid) {
            return response()->json(array('valid' => true,'message' => 'Comment Updated'));
        } else {
            return response()->json(array('valid' => false,'message' => 'Please edit your comment or rating'));
        }
    }

}

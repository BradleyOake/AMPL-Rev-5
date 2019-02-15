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
class NewsPostController extends Controller {

    //Delete post
    public function delete(Request $request)
    {
        $id = $request->input('news_id');
        $valid = false;
      
        //$data = Input::all();
        //$id = $data['comment_id'];

        if(Auth::user()->role_id == 7)
        {
            $valid = DB::table('news_post')->where('news_id', $id)->delete();          
        }

        if($valid) 
        {
            return response()->json(array('valid' => true,'message' => 'Post Deleted'));
        } 
        else 
        {
            return response()->json(array('valid' => false,'message' => 'Delete Failed'));
        }
    }
            
    //Edit a news post
    public function updatePost(Request $request)
    {
        $id = $request->input('news_id'); 
        $title = $request->input('post_title');
        $keywords = $request->input('post_keywords');
        $description = $request->input('post_description');
        $subtopic = $request->input('post_subtopic');
        $html = $request->input('post_html');
                      
        $valid = false;

        $valid = DB::table('news_post')->where('news_id', $id)->update(
        [
            'title' => $title,
            'm_keywords' => $keywords,
            'm_description' => $description,
            'subtopic' => $subtopic,
            'html' => $html
        ]
        );
        
        if($valid) {
            return response()->json(array('valid' => true,'message' => 'Post Updated'));
        } else {
            return response()->json(array('valid' => false,'message' => 'Edit Post to Update'));
        }
    }
    
    
    //Add a news post
    public function addPost(Request $request)
    {
        $title = $request->input('addpost_title');
        $keywords = $request->input('addpost_keywords');
        $description = $request->input('addpost_description');
        $subtopic = $request->input('addpost_subtopic');
        $html = $request->input('addpost_html');
        $createdOn = date("Y/m/d");
        $image = '0';
        $imageAlign = 'right';
        $imagePath = null;
                              
        $valid = false;

        $valid = DB::table('news_post')->insert(
        [
            'title' => $title,
            'm_keywords' => $keywords,
            'm_description' => $description,
            'subtopic' => $subtopic,
            'html' => $html,
            'created_on' => $createdOn,
            'image' => $image,
            'image_align' => $imageAlign,
            'image_path' => $imagePath
        ]
        );
        
        if($valid) {
            return response()->json(array('valid' => true,'message' => 'Post Added'));
        } else {
            return response()->json(array('valid' => false,'message' => 'Add Failed'));
        }
    }
}

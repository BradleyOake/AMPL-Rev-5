<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

use File;
use Auth;
use App\Book;
use Response;

/*
    Handles any file download request
*/
class DownloadController extends Controller {


    public function downloadFinal($id, $type){

    $valid = false;
    $book = Book::find($id); // get the book title for the naming
    // validation for full download
    if(Auth::check() && Auth::user()->authorizedDownload($id, $type)) // if logged in
    {

        $book = Book::find($id); // get the book title for the naming
        $fileFullPath = '';
        $filePath = $book->finalRoot();
        $files = array_diff(scandir($filePath), array('..', '.')); // get file names

        if($type == 0 || $type == 3) // if generic or pdf, download pdf
        {
            $name = 'pdf';
        }
        else if($type == 1) // if txt
        {
            $name = 'txt';
        }
         else if($type == 2) // if epub (in a zip file)
        {
            $name = 'epub';
        }
         else if($type == 4) // if mp3
        {
            $name = 'mp3';
        }

        foreach($files as $file) // get the full files paths
        {
            if(stripos($file, $name) !== FALSE)
            {
                $fileFullPath =  $filePath.$file;
            }
        }

        $ext = pathinfo($fileFullPath, PATHINFO_EXTENSION);

        //If the file exists
        if(File::exists($fileFullPath))
        {
            return Response::download($fileFullPath, $book->title.'.'.$ext);
        }
        else // doesnt exist
        {
            return Redirect::back()->with('errorMessage', 'Sorry, we were unable to retrieve "'.$book->title.'" in the '.$name.' format.');
        }
    }
    else{
        return Redirect::back()->with('errorMessage', 'Sorry, you are not currently authorized to download "'.$book->title.'"');

    }

}

/*
|--------------------------------------------------------------------------
| Submission Book Downloads
|--------------------------------------------------------------------------
*/
   public function downloadSubmission($id, $type){
    $chapters = $synopsis = '';

    $valid = false;
    $book = Book::find($id); // get the book title for the naming
    // validation for full download
    if(Auth::check()) // if logged in
    {
        if(     Auth::user()->roleId == 7 // if admin
            || $author = DB::table('author') // if author
                    ->where('email', '=', Auth::user()->email)
                    ->where('book_id', '=', $id)
                    ->get()) // allow if logged in as admin)
        {
            $valid = true;
        }
    }

    if($valid)
    {
        $filePath = $book->submissionRoot();

        $files = array_diff(scandir($filePath), array('..', '.')); // get file names

        foreach($files as $file) // get the full files paths
        {
            if(stripos($file, 'chapters') !== FALSE)
            {
                $chapters =  $filePath.$file;
            }
            else if(stripos($file, 'synopsis') !== FALSE)
            {
                $synopsis =  $filePath.$file;
            }
        }

        if($type =='chapters') // if generic or pdf, download pdf
        {
            $file = $chapters;
            $name = 'chapters';
        }
        else if($type == 'synopsis') // if txt
        {
            $file = $synopsis;
            $name = 'synopsis';
        }
        else{ // something wrong with the type
            //do nothing
        }

        //If the file exists
        if(File::exists($file))
        {
            return Response::download($file);
        }
        else // doesnt exist
        {

            return Redirect::back()->with('errorMessage', 'Sorry, we were unable to locate the '.$name.' for "'.$book->title.'".');
        }
    }
    else{
        return Redirect::back()->with('errorMessage', 'Sorry, you are not currently authorized to download the '.$name.' for " '.$book->title.'".');
    }
}

/*
|--------------------------------------------------------------------------
| Sample Book Downloads
|--------------------------------------------------------------------------
*/

   public function downloadSample($id, $type){

    $book = Book::find($id); // get the book title for the naming
        $fileFullPath = '';
        $filePath = $book->sampleRoot();
        $files = array_diff(scandir($filePath), array('..', '.')); // get file names


        if($type == 0 || $type == 3) // if generic or pdf, download pdf
        {
            $name = 'pdf';
        }
        else if($type == 1) // if txt
        {
            $name = 'txt';
        }
         else if($type == 2) // if epub (in a zip file)
        {
            $name = 'epub';
        }
         else if($type == 4) // if mp3
        {
            $name = 'mp3';
        }

        foreach($files as $file) // get the full files paths
        {
            if(stripos($file, $name) !== FALSE)
            {
                $fileFullPath =  $filePath.$file;
            }
        }

        $ext = pathinfo($fileFullPath, PATHINFO_EXTENSION);

        //If the file exists
        if(File::exists($fileFullPath))
        {
            return Response::download($fileFullPath, $book->title.'(sample).'.$ext);
        }
        else // doesnt exist
        {
            return Redirect::back()->with('errorMessage', 'Sorry, we were unable to retrieve "'.$book->title.'" in the '.$name.' format.');
        }

}




}

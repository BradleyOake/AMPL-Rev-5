<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Auth;
use Config;
use Mail;
use App\Book;
use File;
use Response;
use Redirect;
use Log;

class BookController extends Controller
{
    public function newSubmission(Request $request)
    {
        var_dump($request->all());
        $valid = false;
    
        $title = $request->input('title');
        $name = $request->input('author');
        $synopsis = $request->file('synopsis');
        $chapters = $request->file('chapters');

        Log::info('TITLE( ' . $title . ' )');
        Log::info('NAME( ' . $name . ' )');
        
        // insert the new book
        $id = DB::table('book')->insertGetId( array('title' => $title, 'status_id' => 1) );

        // add the author
        DB::table('author')->insert(array('email' => Auth::user()->email, 'book_id' => $id, 'name_on_book' => $name));

        // Update to author if a customer
        if(Auth::user()->role_id == 1)
        {
            DB::table('user')
                ->where('email', Auth::user()->email)
                ->update(array('role_id' => 2));
        }

        $storagePath = storage_path().'/books/'.$id.'/submission/';

        $synopsis->move($storagePath,'synopsis_'.$title.'.'.$synopsis->getClientOriginalExtension());
        $chapters->move($storagePath,'chapters_'.$title.'.'.$chapters->getClientOriginalExtension());
        $valid = true;


        /*
        |--------------------------------------------------------------------------
        | Admin Email
        |--------------------------------------------------------------------------
        */
        $user = array(
            'email'=>Config::get('mail.admin.address'),
            'name'=>Config::get('mail.admin.name')
        );

        $data = array(
            'email' => Auth::user()->email,
            'first' => Auth::user()->first_name,
            'last'  => Auth::user()->last_name,
            'title' => $title
        );

        // use Mail::send function to send email passing the data and using the $user variable in the closure
        Mail::queue('emails.submission_admin', $data, function($message) use ($user)
        {
            $message->to($user['email'], $user['name'])->subject('Book Submission');
        });


        /*
        |--------------------------------------------------------------------------
        | User Email
        |--------------------------------------------------------------------------
        */
        $user = array(
            'email' => Auth::user()->email,
            'name'  => Auth::user()->first_name.' '.Auth::user()->last_name
        );

        $data = array(
            'name'  => Auth::user()->first_name.' '.Auth::user()->last_name,
            'title' => $title
        );

        // use Mail::send function to send email passing the data and using the $user variable in the closure
        Mail::queue('emails.submission_user', $data, function($message) use ($user)
        {
            $message->to($user['email'], $user['name'])->subject('Book Submission');
        });

        return response()->json(array('valid' => true,'message' => 'Book has been submitted'));
    }


    public function addBook(Request $request)
    {
        //var_dump($request->all());
        $valid = false;
    
        
        
        $message = '';
        $valid = false;
       

        $title = $request->input('book_title');
        $description = $request->input('book_description');
        $status = $request->input('book_status');
        $electronicPrice = $request->input('electronic_price');
        $audioPrice = $request->input('audio_price');

         $mDescription = $request->input('m_description');
         $mKeywords = $request->input('m_keywords');
        // $softPrice = $request->input('soft_price');
        // $hardPrice = $request->input('hard_price');


        $isbn = ($request->input('isbn') == '') ? null : $request->input('isbn');
        $datePublished = ($request->input('date_published') == '') ? null : $request->input('date_published');

        $synopsis = ($request->input('synopsis') == '') ? null : $request->file('synopsis');
        $chapters = ($request->input('chapters') == '') ? null : $request->file('chapters');

        $txtFull = ($request->input('txt_full') == '') ? null : $request->file('txt_full');
        $txtSample = ($request->input('txt_sample') == '') ? null : $request->file('txt_sample');

        $mp3Full = ($request->input('mp3_full') == '') ? null : $request->file('mp3_full');
        $mp3Sample = ($request->input('mp3_sample') == '') ? null : $request->file('mp3_sample');

        $pdfFull = ($request->input('pdf_full') == '') ? null : $request->file('pdf_full');
        $pdfSample = ($request->input('pdf_sample') == '') ? null : $request->file('pdf_sample');

        $epubFull = ($request->input('epub_full') == '') ? null : $request->file('epub_full');
        $epubSample = ($request->input('epub_sample') == '') ? null : $request->file('epub_sample');

        $coverImage = ($request->input('cover_image') == '') ? null : $request->file('cover_image');

       
            // insert the new book
            $id = DB::table('book')->insertGetId( array(
                'title' => $title,
                 'description' => $description,
                 'm_keywords' => $mKeywords,
                'm_description' => $mDescription,
                'status_id' => $status,
                'electronic_price' => $electronicPrice,
                'audio_price' => $audioPrice,
                'ISBN' => $isbn,
                'date_published' => $datePublished));


            if($id)
            {
                $message .= 'Database updated successfully<br>';
                $book = Book::find($id);
            }
        
            $submissionStoragePath = storage_path().'/books/'.$id.'/submission/';
            $finalStoragePath = storage_path().'/books/'.$id.'/final/';
            $sampleStoragePath = storage_path().'/books/'.$id.'/sample/';
            $coverStoragePath = public_path().'/images/bookcovers/bookid'.$id.'/';

           if ($synopsis!= null) {
                if($synopsis->move($submissionStoragePath,'synopsis_'.$title.'.'.$synopsis->getClientOriginalExtension()) )
                 $message .= '<br>Synopsis has been updated.';
            }

            if ($chapters!= null) {
                if($chapters->move($submissionStoragePath,'chapters_'.$title.'.'.$chapters->getClientOriginalExtension()) )
                 $message .= '<br>Chapters has been updated.';
            }

            if ($txtFull != null) {
                if($txtFull->move($finalStoragePath,$id.'_txt.txt') )
                 $message .= '<br>Text final has been updated.';
            }
            if ($txtSample != null) {
                if($txtSample->move($sampleStoragePath,$id.'_txt.txt') )
                     $message .= '<br>Text sample has been updated.';
            }

            if ($pdfFull != null) {
                if( $pdfFull->move($finalStoragePath,$id.'_pdf.pdf') )
                     $message .= '<br>Pdf final has been updated.';
            }
            if ($pdfSample != null) {
                if( $pdfSample->move($sampleStoragePath,$id.'_pdf.pdf') )
                     $message .= '<br>Pdf Sample has been updated.';
            }

            if ($epubFull != null) {
                if( $epubFull->move($finalStoragePath,$id.'_epub.epub') )
                     $message .= '<br>Epub final has been updated.';
            }
            if ($epubSample != null) {
                if( $epubSample->move($sampleStoragePath,$id.'_epub.epub') )
                     $message .= '<br>Epub sample has been updated.';
            }

            if ($mp3Full != null) {
                if( $mp3Full->move($finalStoragePath,$id.'_mp3.mp3') )
                     $message .= '<br>Mp3 final has been updated.';
            }
            if ($mp3Sample != null) {
                if( $mp3Sample->move($sampleStoragePath,$id.'_mp3.mp3') )
                     $message .= '<br>Mp3 sample has been updated.';
            }

            if ($coverImage != null) {
                if($book->coverExists())
                    File::delete($book->coverPath());
                if( $coverImage->move($coverStoragePath,$id.'_cover.'.$coverImage->getClientOriginalExtension()) )
                     $message .= '<br>Cover image has been updated.';
            }

             $valid = true;
        

            return response()->json(array('valid' => $valid,'message'=> $message, 'id'=> $id));
         


    }

    public function editBook(Request $request)
    {
        $message = '';
        $valid = false;  

        $id = $request->input('book_id');
        //$book = Book::find($id);

        $title = $request->input('book_title');
        $mKeywords = $request->input('m_keywords');
        $mDescription = $request->input('m_description');
        $description = $request->input('book_description');
        $electronicPrice = $request->input('electronic_price');
        $audioPrice = $request->input('audio_price');
        $softPrice = ($request->input('soft_price') == '') ? null : $request->input('soft_price');
        $hardPrice = ($request->input('hard_price') == '') ? null : $request->input('hard_price');
        $inSoft = $request->input('in_soft');
        $inHard = $request->input('in_hard');
        $status = $request->input('book_status');
        $isbn = ($request->input('isbn') == '') ? null : $request->input('isbn');
        $datePublished = ($request->input('date_published') == '') ? null : $request->input('date_published');
        $notes = ($request->input('notes') == '') ? null : $request->input('notes');

        $synopsis = ($request->input('synopsis') == '') ? null : $request->file('synopsis');
        $chapters = ($request->input('chapters') == '') ? null : $request->file('chapters');

        $txtSample = ($request->input('txt_sample') == '') ? null : $request->file('txt_sample');
        $txtFull = ($request->input('txt_full') == '') ? null : $request->file('txt_full');

        $mp3Sample = ($request->input('mp3_sample') == '') ? null : $request->file('mp3_sample');
        $mp3Full = ($request->input('mp3_full') == '') ? null : $request->file('mp3_full');

        $pdfSample = ($request->input('pdf_sample') == '') ? null : $request->file('pdf_sample');
        $pdfFull = ($request->input('pdf_full') == '') ? null : $request->file('pdf_full');

        $epubSample = ($request->input('epub_sample') == '') ? null : $request->file('epub_sample');
        $epubFull = ($request->input('epub_full') == '') ? null : $request->file('epub_full');

        $coverImage = ($request->input('cover_image') == '') ? null : $request->file('cover_image');
        $bannerImage = ($request->input('banner_image') == '') ? null : $request->file('banner_image');
        
        // insert the new book
        $valid = DB::table('book')->where('book_id', $id)
            ->update(
            [
                'title' => $title,
                'm_keywords' => $mKeywords,
                'm_description' => $mDescription,
                'description' => $description,
                'electronic_price' => $electronicPrice,
                'audio_price' => $audioPrice,
                'soft_price' => $softPrice,
                'hard_price' => $hardPrice,
                'in_soft' => $inSoft,
                'in_hard' => $inHard,
                'status_id' => $status,
                'ISBN' => $isbn,
                'date_published' => $datePublished,
                'notes' => $notes
            ]
        );

        Log::info("VALID( " . $valid . " )");

        if($valid)
        {
            $message .= 'The book has been successfully updated.<br>';
        }
        else
        {
            $message .= 'There were no changes to the database.<br>';
        }

        /*$submissionStoragePath = storage_path().'/books/'.$id.'/submission/';
        $finalStoragePath = storage_path().'/books/'.$id.'/final/';
        $sampleStoragePath = storage_path().'/books/'.$id.'/sample/';
        $coverStoragePath = public_path().'/images/bookcovers/bookid'.$id.'/';*/

        /**********************************
        *****   STORAGE OF THE BOOK   *****
        **********************************/
        $submissionStoragePath = storage_path().'/books/'.$id.'/submission/';
        $finalStoragePath = storage_path().'/books/'.$id.'/final/';
        $sampleStoragePath = storage_path().'/books/'.$id.'/sample/';
        $coverStoragePath = public_path().'/images/bookcovers/bookid'.$id.'/';
        $bannerStoragePath = public_path().'/images/banners/bookid'.$id.'/';

        /**********************************
        *****   SYNOPSIS / CHAPTERS   *****
        **********************************/
        // If it exists, store the synopsis of the book
        if ($synopsis != null)
        {
            if($synopsis->move($submissionStoragePath,'synopsis_'.$title.'.'.$synopsis->getClientOriginalExtension()))
            {
                $message .= '<br>Synopsis has been updated.';
            }
        }

        // If it exists, store the chapters of the book
        if ($chapters != null)
        {
            if($chapters->move($submissionStoragePath,'chapters_'.$title.'.'.$chapters->getClientOriginalExtension()))
            {
                $message .= '<br>Chapters has been updated.';
            }
        }

        /***************************
        *****   TXT VERSIONS   *****
        ***************************/
        // If it exists, store the sample text of the book
        if ($txtSample != null)
        {
            if($txtSample->move($sampleStoragePath,$id.'_txt.txt'))
            {
                $message .= '<br>Text sample has been updated.';
            }
        }

        // If it exists, store the full text of the book
        if ($txtFull != null)
        {
            if($txtFull->move($finalStoragePath,$id.'_txt.txt'))
            {
                $message .= '<br>Text final has been updated.';
            }
        }

        /***************************
        *****   PDF VERSIONS   *****
        ***************************/
        // If it exists, store the sample pdf of the book
        if ($pdfSample != null) {
            if($pdfSample->move($sampleStoragePath,$id.'_pdf.pdf'))
            {
                $message .= '<br>Pdf Sample has been updated.';
            }
        }

        // If it exists, store the full pdf of the book
        try
        {
            if ($pdfFull != null)
            {
                if( move_uploaded_file($pdfFull,$finalStoragePath.$id.'_pdf.pdf'))
                {
                    $message .= '<br>Pdf final has been updated.';
                }
            }
        }
        catch (RuntimeException $e)
        {
            $message .=  $e->getMessage();
        }

        /****************************
        *****   EPUB VERSIONS   *****
        ****************************/
        // If it exists, store the sample epub of the book
        if ($epubSample != null) {
            if( $epubSample->move($sampleStoragePath,$id.'_epub.epub'))
            {
                $message .= '<br>Epub sample has been updated.';
            }
        }

        // If it exists, store the full epub of the book
        if ($epubFull != null)
        {
            if($epubFull->move($finalStoragePath,$id.'_epub.epub'))
            {
                $message .= '<br>Epub final has been updated.';
            }
        }

        /***************************
        *****   MP3 VERSIONS   *****
        ***************************/
        // If it exists, store the sample mp3 of the book
        if ($mp3Sample != null) {
            if( $mp3Sample->move($sampleStoragePath,$id.'_mp3.mp3'))
            {
                $message .= '<br>Mp3 sample has been updated.';
            }
        }

        // If it exists, store the full mp3 of the book
        if ($mp3Full != null) {
            if( $mp3Full->move($finalStoragePath,$id.'_mp3.mp3'))
            {
                $message .= '<br>Mp3 final has been updated.';
            }
        }

        /**********************************
        *****   BOOK COVER / BANNER   *****
        **********************************/
        // If it exists, store the cover image of the book
        if ($coverImage != null)
        {
            File::delete($book->coverPath());
            if( $coverImage->move($coverStoragePath,$id.'_cover.'.$coverImage->getClientOriginalExtension()))
            {
                $message .= '<br>Cover image has been updated.';
            }
        }

        // If it exists, store the banner image of the book
        if ($bannerImage != null)
        {
            File::delete($book->bannerPath());
            if( $bannerImage->move($bannerStoragePath,$id.'_banner.'.$bannerImage->getClientOriginalExtension()))
            {
                $message .= '<br>Banner image has been updated.';
            }
        }

        $valid = true;

        return response()->json(array('valid' => $valid,'message'=> $message));
        //return response()->json(array('valid' => $valid,'message'=> var_dump($request->all())));
    }
    
    public function checkISBN(Request $request)
    {
        $isbn = $request->input('eb_isbn');
        $check = DB::table('book')->where('isbn', $isbn)->first();
        
           if(is_null($check)){
            return response()->json(array('valid' => 'true'));
        }else {
            return response()->json(array('valid' => 'false'));
        }
    }
    

    /*********************************************
    *****   UPDATE BOOK FOR ADMIN/EDITBOOK   *****
    *********************************************/
    public function updateBook(Request $request)
    {
        $valid = false;
        //$data = Input::all();
        $message = '';

        $id = $request->input('book_id');
        $title = $request->input('title');
        $m_keywords = $request->input('m_keywords');
        $m_description = $request->input('m_description');
        $description = $request->input('description');
        $electronic_price = $request->input('electronic_price');
        $audio_price = $request->input('audio_price');
        $soft_price = $request->input('soft_price');
        $hard_price = $request->input('hard_price');
        $in_soft = $request->input('in_soft');
        $in_hard = $request->input('in_hard');
        $status_id = $request->input('status_id');
        $isbn = $request->input('isbn');
        $notes = $request->input('notes');
        $date_published = $request->input('date_published');

        $valid = DB::table('book')->where('book_id', $id)->update(
            [
                'title' => $title,
                'm_keywords' => $m_keywords,
                'm_description' => $m_description,
                'description' => $description,
                'electronic_price' => $electronic_price,
                'audio_price' => $audio_price,
                'soft_price' => $soft_price,
                'hard_price' => $hard_price,
                'in_soft' => $in_soft,
                'in_hard' => $in_hard,
                'status_id' => $status_id,
                'isbn' => $isbn,
                'date_published' => $date_published,
                'notes' => $notes
            ]);

        if($valid) 
        {
            return response()->json(array('valid' => true,'message' => 'Book successfully updated!'));
        } 
        else 
        {
            return response()->json(array('valid' => false,'message' => 'Book not updated, please fix any errors'));
        }   
    }

    public function updatePaper(Request $request)
    {
        $valid = false;
        $message = '';

        $id = $request->input('paper_id');
        $paper_name = $request->input('paper_name');
        $paper_type = $request->input('paper_type');
        $paper_usage = $request->input('paper_usage');
        $paper_size = $request->input('paper_size');
        $unit_cost = $request->input('unit_cost');

        $valid = DB::table('paper')->where('paper_id', $id)->update(
            [
                'paper_name' => $paper_name,
                'paper_type' => $paper_type,
                'paper_usage' => $paper_usage,
                'paper_size' => $paper_size,
                'unit_cost' => $unit_cost
            ]);

        if($valid)
        {
            return response()->json(array('valid' => true,'message' => 'Paper successfully updated!'));
        } 
        else 
        {
            return response()->json(array('valid' => false,'message' => 'Paper not updated, please fix any errors'));
        }
    }

    public function updateInk(Request $request)
    {
        $valid = false;
        $message = '';

        $id = $request->input('ink_id');
        $ink_name = $request->input('ink_name');
        $cost_per_side = $request->input('cost_per_side');

        $valid = DB::table('ink')->where('ink_id', $id)->update(
            [
                'ink_name' => $ink_name,
                'cost_per_side' => $cost_per_side
            ]);

        if($valid)
        {
            return response()->json(array('valid' => true,'message' => 'Ink successfully updated!'));
        } 
        else 
        {
            return response()->json(array('valid' => false,'message' => 'Ink not updated, please fix any errors'));
        }
    }

    public function addInk(Request $request)
    {
        $valid = false;
        $message = '';

        $ink_name = $request->input('ink_name');
        $cost_per_side = $request->input('cost_per_side');

        $valid = DB::table('ink')->insert(['ink_name' => $ink_name, 'cost_per_side' => $cost_per_side]);

        if($valid)
        {
            return response()->json(array('valid' => true,'message' => 'Ink successfully added!'));
        } 
        else 
        {
            return response()->json(array('valid' => false,'message' => 'Ink not added, please fix any errors'));
        }
    }

    public function addPaper(Request $request)
    {
        $valid = false;
        $message = '';

        $paper_name = $request->input('paper_name');
        $paper_type = $request->input('paper_type');
        $paper_usage = $request->input('paper_usage');
        $paper_size = $request->input('paper_size');
        $unit_cost = $request->input('unit_cost');

        $valid = DB::table('paper')->insert(['paper_name' => $paper_name, 'paper_type' => $paper_type, 'paper_usage' => $paper_usage, 'paper_size' => $paper_size, 'unit_cost' => $unit_cost]);

        if($valid)
        {
            return response()->json(array('valid' => true,'message' => 'Paper successfully added!'));
        } 
        else 
        {
            return response()->json(array('valid' => false,'message' => 'Paper not added, please fix any errors'));
        }
    }

    public function getBookSales()
    {
        $valid = false;
        $data =Input::all();

        $id = $request->input('id');
        $monthString = $request->input('monthString');
        $month = $request->input('month');
        $year = $request->input('year');
        $table = "";
        $summaryTable = "";

        if(Request::ajax())
        {
            $sales = DB::table('user_invoice')
              ->join('book_type', 'book_type.type_id', '=', 'user_invoice.type_id')
              ->where('book_id', '=', $id)
              ->where('sold_on', '<=', $year . '-' . $month . '-31')
              ->where('sold_on', '>=', $year . '-' . $month . '-01')
              ->select('user_invoice.book_id', 'user_invoice.type_id', 'book_type.description', 'user_invoice.sold_on', 'user_invoice.amount')
              ->orderBy('sold_on', 'DESC')
              ->get();

            if(count($sales) == 0)
            {
                $table = "<h3 class=\"text-center\">There are no sales for " . $monthString . ', ' . $year . "</h3>";
            }
            else
            {
                $table = "<table id=\"salesTable\" class=\"table table-striped table-bordered text-center\">
                            <caption id=\"tableCaption\" class=\"text-center\">" . $monthString . ', ' . $year . " Sales</caption>
                                <tr>
                                    <th class=\"text-center\">Sale Date</th>
                                    <th class=\"text-center\">Format</th>
                                    <th class=\"text-center\">Sale Price</th>
                                </tr>";

                $electronicsSales = 0;
                $electronicsCount = 0;
                $audioSales = 0;
                $audioCount = 0;
                foreach($sales as $sale)
                {
                    $table .= "<tr>
                                   <td>" . date('Y-m-d', strtotime($sale->sold_on)) . "</td>
                                   <td>" . $sale->description . "</td>
                                   <td>$" . $sale->amount . "</td>
                               </tr>";

                    if($sale->type_id <= 3)
                    {
                        $electronicsSales += $sale->amount;
                        $electronicsCount ++;
                    }
                    else if($sale->type_id == 4)
                    {
                        $audioSales += $sale->amount;
                        $audioCount ++;
                    }
                }

                $table .= "</table>";

                $summaryTable = "<table id=\"salesTable\" class=\"table table-striped table-bordered text-center\">
                                    <caption id=\"tableCaption\" class=\"text-center\">" .  $monthString . ", " . $year . " Summary</caption>
                                        <tr>
                                            <th class=\"text-center\">Total # of Sales: </th>
                                            <td class=\"text-center\">" . ($electronicsCount + $audioCount) . "</td>
                                            <th class=\"text-center\">Total Sales: </th>
                                            <td class=\"text-center\">$" . number_format(($electronicsSales + $audioSales), 2) . "</td>
                                        </tr>
                                        <tr>
                                           <th class=\"text-center\"># of Electronic Sales:</th>
                                           <td class=\"text-center\">" . $electronicsCount . "</td>
                                           <th class=\"text-center\">Electronic Sales:</th>
                                           <td class=\"text-center\">$" . number_format($electronicsSales, 2) . "</td>

                                       </tr>
                                        <tr>
                                           <th class=\"text-center\"># of Audio Sales:</th>
                                           <td class=\"text-center\">" . $audioCount . "</td>
                                           <th class=\"text-center\">Audio Sales:</th>
                                           <td class=\"text-center\">$" . number_format($audioSales, 2) . "</td>
                                       </tr>
                                   </table>";
            }

            $valid = true;
        }

        echo json_encode(array('valid' => $valid, 'table' => $table, 'summary' => $summaryTable));
    }

    public function getAnnualSales()
    {

        $valid = false;
        $data = Input::all();

        $year = $request->input('year');
        $email = $request->input('email');

        if(Request::ajax())
        {
            $sales = DB::table('user_invoice')
              ->join('book_type', 'book_type.type_id', '=', 'user_invoice.type_id')
              ->join('author', 'author.book_id', '=', 'user_invoice.book_id')
              ->join('book', 'book.book_id', '=', 'user_invoice.book_id')
              ->where('user_invoice.email', '=', $email)
              ->where('sold_on', '<=', $year . '-12-31')
              ->where('sold_on', '>=', $year . '-01-01')
              ->select('user_invoice.book_id', 'user_invoice.type_id', 'book_type.description', 'user_invoice.sold_on', 'user_invoice.amount',
                       'author.electronic_rate', 'author.audio_rate', 'author.soft_rate', 'author.hard_rate', 'author.payment_obtained',
                       'book.title')
              ->orderBy('sold_on', 'DESC')
              ->get();

            if(count($sales) == 0)
            {
                $table = "<h3 class=\"text-center\">There are no sales for " . $year . "</h3>";
                $summaryTable = "";
                $adjustmentsTable = "";
            }
            else
            {
                $table = "<table id=\"salesTable\" class=\"table table-striped table-bordered text-center\">
                            <caption id=\"tableCaption\" class=\"text-center\"><h2>" . $year . " Sales</h2></caption>
                                <tr>
                                    <th class=\"text-center\">Book Sold</th>
                                    <th class=\"text-center\">Sale Date</th>
                                    <th class=\"text-center\">Format</th>
                                    <th class=\"text-center\">Sale Price</th>".
                                    //<th class=\"text-center\">View Monthly Sales</th>
                                "</tr>";
                $electronicsSales = 0;
                $electronicsCount = 0;
                $audioSales = 0;
                $audioCount = 0;
                $softSales = 0;
                $softCount = 0;
                $hardSales = 0;
                $hardCount = 0;
                $totalRoyalties = 0;

                foreach($sales as $sale)
                {
                    $table .= "<tr>
                                   <td>" . $sale->title . "</td>
                                   <td>" . date('Y-m-d', strtotime($sale->sold_on)) . "</td>
                                   <td>" . $sale->description . "</td>
                                   <td>$" . $sale->amount . "</td>".
                                   //<td><a href=\"{{ URL::to('user/monthlysales', array('id' => $sale->book_id.)) }}\" class=\"btn btn-primary\"><i class=\"fa fa-line-chart\"> Monthly Sales</i></a></td>
                               "</tr>";

                    if($sale->type_id <= 3)
                    {
                        $electronicsSales += $sale->amount;
                        $electronicsCount ++;
                    }
                    else if($sale->type_id == 4)
                    {
                        $audioSales += $sale->amount;
                        $audioCount ++;
                    }
                    else if($sale->type_id == 5)
                    {
                        $softSales += $sale->amount;
                        $softCount ++;
                    }
                    else if($sale->type_id == 6)
                    {
                        $hardSales += $sale->amount;
                        $hardCount ++;
                    }
                    $totalRoyalties += (($electronicsSales * $sale->electronic_rate) + ($audioSales * $sale->audio_rate) + ($softSales * $sale->soft_rate) + ($hardSales * $sale->hard_rate));
                }

                $table .= "</table>";

                $summaryTable = "<table id=\"annualSalesTable\" class=\"table table-striped table-bordered text-center\">
                                    <caption id=\"tableCaption\" class=\"text-center\"><h2>Sales of " . $year . " Summary</h2></caption>
                                        <tr>
                                            <th class=\"text-center\">Total # of Sales: </th>
                                            <td class=\"text-center\">" . ($electronicsCount + $audioCount + $softCount + $hardCount) . "</td>
                                            <th class=\"text-center\">Total Sales: </th>
                                            <td class=\"text-center\">$" . number_format(($electronicsSales + $audioSales + $softSales + $hardSales), 2) . "</td>
                                        </tr>
                                        <tr>
                                           <th class=\"text-center\"># of Electronic Sales:</th>
                                           <td class=\"text-center\">" . $electronicsCount . "</td>
                                           <th class=\"text-center\">Electronic Sales:</th>
                                           <td class=\"text-center\">$" . number_format($electronicsSales, 2) . "</td>

                                       </tr>
                                        <tr>
                                           <th class=\"text-center\"># of Audio Sales:</th>
                                           <td class=\"text-center\">" . $audioCount . "</td>
                                           <th class=\"text-center\">Audio Sales:</th>
                                           <td class=\"text-center\">$" . number_format($audioSales, 2) . "</td>
                                       </tr>
                                       <tr>
                                            <th class=\"text-center\"># of Soft Sales:</th>
                                            <td class=\"text-center\">" . $softCount . "</td>
                                            <th class=\"text-center\">Soft Sales:</th>
                                            <td class=\"text-center\">$" . number_format($softSales, 2) . "</td>
                                       </tr>
                                       <tr>
                                            <th class=\"text-center\"># of Hard Sales:</th>
                                            <td class=\"text-center\">" . $hardCount . "</td>
                                            <th class=\"text-center\">Hard Sales:</th>
                                            <td class=\"text-center\">$" . number_format($hardSales, 2) . "</td>
                                       </tr>
                                   </table>";

                $adjustmentsTable = "<table id=\"salesAdjustmentTable\" class=\"table table-striped table-bordered text-center\">
                                        <caption id=\"tableCap\" class=\"text-center\"><h2>Adjustments for " . $year . "</h2></caption>
                                       <tr>
                                            <th class=\"text-center\">Royalties Earned by Author</th>
                                            <td class=\"text-center\">$".number_format((($electronicsSales*$sales[0]->electronic_rate) +
                                                                                        ($audioSales*$sales[0]->audio_rate) +
                                                                                        ($softSales*$sales[0]->soft_rate) +
                                                                                        ($hardSales*$sales[0]->hard_rate)), 2)."</td>
                                       </tr>
                                       <tr>
                                            <th class=\"text-center\">Royalties Paid to Author</th>
                                            <td class=\"text-center\">$".number_format($sales[0]->payment_obtained, 2)."</td>
                                       </tr>
                                       <tr>
                                            <th class=\"text-center\">Royalties Still Owed</th>
                                            <td class=\"text-center\">$".number_format(((($electronicsSales*$sales[0]->electronic_rate) +
                                                                                        ($audioSales*$sales[0]->audio_rate) +
                                                                                        ($softSales*$sales[0]->soft_rate) +
                                                                                        ($hardSales*$sales[0]->hard_rate)) - $sales[0]->payment_obtained), 2)."</td>
                                       </tr>
                                     </table>";

            }

            $valid = true;

        }

        echo json_encode(array('valid' => $valid, 'table' => $table, 'summary' => $summaryTable, 'adjust' => $adjustmentsTable));
    }



    public function deleteFile(){
        $valid = false;
        $data = Input::all();
         $id = $request->input('id');
         $type = $request->input('type');


        $book = Book::find($id); // get the book title for the naming
        $fileFullPath = '';
        $filePath = $book->finalRoot();

        if($type == 3) // if generic or pdf, download pdf
        {
           $file = $book->pdfFinalPath();
        }
        else if($type == 1) // if txt
        {
           $file = $book->txtFinalPath();
        }
         else if($type == 2) // if epub (in a zip file)
        {
            $file = $book->epubFinalPath();
        }
         else if($type == 4) // if mp3
        {
           $file = $book->mp3FinalPath();
        }
          else if($type == 'cover') // if mp3
        {
           $file = $book->coverPath();
        }
          else if($type == 'txtsample') // if mp3
        {
           $file = $book->txtSamplePath();
        }
          else if($type == 'pdfsample') // if mp3
        {
           $file = $book->pdfSamplePath();
        }
          else if($type == 'mp3sample') // if mp3
        {
           $file = $book->mp3SamplePath();
        }
        else if($type == 'epubsample') // if mp3
        {
           $file = $book->epubSamplePath();
        }


        File::delete($file);
        echo json_encode(array('valid' => true));
        Session::flash('successMessage', 'The file has been removed succesfully');

}



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

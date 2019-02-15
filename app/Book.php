<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Book extends Model {


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'book';
    protected $primaryKey = 'book_id';

    /**
    * The Paths of the book files
    *
    */
    public function finalRoot() {
        return storage_path() . '/books/'. $this->book_id .'/final/';
    }
    public function submissionRoot() {
        return storage_path() . '/books/'. $this->book_id .'/submission/';
    }
    public function sampleRoot() {
        return storage_path() . '/books/'. $this->book_id .'/sample/';
    }
    public function coverRoot() {
        return getcwd() .'/images/bookcovers/bookid'.$this->book_id.'/';
    }
    public function bannerRoot() {
        return getcwd() .'/images/banners/bookid'.$this->book_id.'/';
    }

    /**
    * File type checks and Paths
    *
    */

    // TXT
    public function txtFinalExists() {
        return file_exists($this->finalRoot() . $this->book_id. '_txt.txt');
    }
    public function txtFinalPath() {
       return $this->finalRoot() . $this->book_id. '_txt.txt';
    }
    public function txtSampleExists() {
        return file_exists($this->sampleRoot() . $this->book_id. '_txt.txt');
    }
    public function txtSamplePath() {
        return $this->sampleRoot() . $this->book_id. '_txt.txt';
    }

    // PDF
    public function pdfFinalExists() {
        return file_exists($this->finalRoot() . $this->book_id. '_pdf.pdf');
    }
    public function pdfFinalPath() {
        return $this->finalRoot() . $this->book_id. '_pdf.pdf';
    }
    public function pdfSampleExists() {
        return file_exists($this->sampleRoot() . $this->book_id. '_pdf.pdf');
    }
    public function pdfSamplePath() {
        return $this->sampleRoot() . $this->book_id. '_pdf.pdf';
    }

    // EPUB
    public function epubFinalExists() {
        return file_exists($this->finalRoot() . $this->book_id. '_epub.epub');
    }
    public function epubFinalPath()
    {
        return $this->finalRoot() . $this->book_id. '_epub.epub';
    }
    public function epubSampleExists() {
        return file_exists($this->sampleRoot() . $this->book_id. '_epub.epub');
    }
    public function epubSamplePath() {
        return $this->sampleRoot() . $this->book_id. '_epub.epub';
    }

    // MP3
    public function mp3FinalExists() {
       return file_exists($this->finalRoot() . $this->book_id. '_mp3.mp3');
    }
    public function mp3FinalPath() {
       return $this->finalRoot() . $this->book_id. '_mp3.mp3';
    }
    public function mp3SampleExists() {
        return file_exists($this->sampleRoot() . $this->book_id. '_mp3.mp3');
    }
    public function mp3SamplePath() {
        return $this->sampleRoot() . $this->book_id. '_mp3.mp3';
    }

    /**
    * Cover checks and Path
    *
    */
    public function coverExists() {
        $filePath = $this->coverRoot();

        if(file_exists($filePath))
             {
            $files = array_diff(scandir($filePath), array('..', '.')); // get file names

            foreach($files as $file) // get the full files paths
            {
                if(stripos($file, 'cover') !== FALSE)
                {
                    return File_exists($filePath.$file);
                }

            }}
        //return File_exists(.$this->book_id.'_cover.gif');
    }

    public function coverPath() {
        $filePath = $this->coverRoot();

        if(file_exists($filePath))
           {
        $files = array_diff(scandir($filePath), array('..', '.')); // get file names

        foreach($files as $file) // get the full files paths
        {
            if(stripos($file, 'cover') !== FALSE)
            {
                return $filePath.$file;
            }
        }
           }
    }
    public function coverShortPath() {
        $filePath = $this->coverRoot();

        $files = array_diff(scandir($filePath), array('..', '.')); // get file names

        foreach($files as $file) // get the full files paths
        {
            if(stripos($file, 'cover') !== FALSE)
            {
                return 'images/bookcovers/bookid'.$this->book_id.'/'.$file;
            }
        }
        //return 'images/bookcovers/bookid'.$this->book_id.'/'.$this->book_id.'_cover.gif';
    }

    public function coverBannerPath() {
        $filePath = $this->bannerRoot();

        $files = array_diff(scandir($filePath), array('..', '.')); // get file names

        foreach($files as $file) // get the full files paths
        {
            if(stripos($file, 'banner') !== FALSE)
            {
                return 'images/banners/bookid'.$this->book_id.'/'.$file;
            }
        }
        //return 'images/bookcovers/bookid'.$this->book_id.'/'.$this->book_id.'_cover.gif';
    }

    public function bannerExists() {
        $filePath = $this->bannerRoot();

        if(file_exists($filePath))
             {
            $files = array_diff(scandir($filePath), array('..', '.')); // get file names

            foreach($files as $file) // get the full files paths
            {
                if(stripos($file, 'banner') !== FALSE)
                {
                    return File_exists($filePath.$file);
                }

            }}
        //return File_exists(.$this->book_id.'_cover.gif');
    }


    /**
    * Authors with their account information
    *
    */
     public function authors()
    {
        return $this->hasMany('App\Author', 'book_id', 'book_id')
             ->leftJoin('user', 'author.email', '=', 'user.email');
    }

      public function authorDetails($email)
    {
        return $this->hasMany('Author', 'book_id', 'book_id')
             ->leftJoin('user', 'author.email', '=', 'user.email')
           ->where('email', $email);
    }

   /**
    * Rating of the book bassed on valid comments
    *
    */
    public function getRating() {
        $num = $this->validComments()->count();
        $comments = $this->validComments;

        if($num == 0) {
            return number_format(0, 1, '.', ',');
        }
        else {
            $total = 0;
            foreach($comments as $comment) {
                $total += $comment->rating;
            }
            return number_format($total/$num, 1, '.', ',');
        }
    }

   /**
    * Outputs the html & CSS of the stars of the rating
    *
    */
    public function getStars()
    {
        $i = 0;
        $stars = '';
        $rating = $this->getRating();

        // Loop for gold stars
        for($i; $i< $rating; $i++)
        {
            if($rating-$i < 1) // If half star needed
            {
                $stars .= '<i class="fa fa-star-half" style="color:gold"></i>';
                $stars .= '<i class="fa fa-star-half fa-flip-horizontal" style="color:grey; width: 12px;"></i>';
            }
            else
            {
                $stars .= '<i class="fa fa-star" style="color:gold"></i>';
            }
        }

        // Loop for grey stars
        for($i; $i< 5; $i++)
        {
            $stars .= '<i class="fa fa-star" style="color:grey"></i>';
        }

        return $stars;
    }


   /**
    * Returns all the comment including the bad ones
    *
    */
    public function allComments()
    {
       return $this->hasMany('App\BookComment');
    }

   /**
    * Returns only the book's valid comments
    *
    */
    public function validComments() {

         //return $this->hasMany('App\BookComment', 'book_id', 'book_id');
         return $this->allComments();
    }

   /**
    * Returns the books number of comments including the bad ones
    *
    */
    public function getNumberComments() {
        return $this->allComments()->count();
    }

    /**
    * Returns book's number valid comments
    *
    */
    public function getNumberValidComments() {
        return $this->validComments()->count();
    }



     public function status() {
        return DB::table('book_status')->where('status_id', $this->status_id)->pluck('description');
    }



    public function invoices() {
        return $this->hasMany('App\UserInvoice', 'book_id', 'book_id');
    }

    /*  Checks if a user owns a specific book. Differentiates between
        ebook (type_id = 3) and audiobook (type_id = 4) */
    public function isOwned($email, $type_id) {
      if(DB::table('user_invoice')
      ->where('email', '=', $email)
      ->where('book_id', '=', $this->book_id)
      ->where('type_id', '=', $type_id)
      ->count() == 0)
      {
        return false;
      }
      else
      {
        return true;
      }

    }

    /* Checks if a user has access to a specific book. Differentiates between
        ebook (type_id = 3) and audiobook (type_id = 4).
    */
    public function hasAccess($email, $type_id) {
      $accessUntil = strtotime(date(
      DB::table('user_invoice')
      ->where('email', '=', $email)
      ->where('book_id', '=', $this->book_id)
      ->where('type_id', '=', $type_id)
      ->pluck('access_until')));

      $currentDate = strtotime(date('Y-m-d'));
      if($accessUntil - $currentDate >= 0)
      {
        return true;
      }
      else
      {
        return false;
      }
    }
    public function electronicSales()
    {
      return $this->invoices()
                 ->where('type_id', '<=', 3)
                 ->get();
    }
    public function audioSales() {
         return $this->invoices()
                    ->where('type_id', '=', 4)
                    ->get();
    }

    public function electronicSalesYear($year) {
         return $this->invoices()
                    ->where('type_id', '<=', 3)
                    ->where('sold_on', 'LIKE', $year . '%')
                    ->get();
    }

    public function audioSalesYear($year) {
         return $this->invoices()
                    ->where('type_id', '=', 4)
                    ->where('sold_on', 'LIKE', $year . '%')
                    ->get();
    }

    public function softSalesYear($year) {
         return $this->invoices()
                    ->where('type_id', '=', 5)
                    ->where('sold_on', 'LIKE', $year . '%')
                    ->get();
    }

    public function hardSalesYear($year) {
             return $this->invoices()
                        ->where('type_id', '=', 6)
                        ->where('sold_on', 'LIKE', $year . '%')
                        ->get();
        }


    public function electronicSalesMonth($month) {
      $date = date('Y-'.sprintf('%02d',$month + 1));
      return $this->invoices()
                 ->where('type_id', '<=', 3)
                 ->where('sold_on', 'LIKE', $date . '%')
                 ->get();
    }

    public function audioSalesMonth($month)
    {
      $date = date('Y-'.sprintf('%02d',$month + 1));
      return $this->invoices()
                 ->where('type_id', '=', 4)
                 ->where('sold_on', 'LIKE', $date . '%')
                 ->get();

    }
    public function softSalesMonth($month)
    {
      $date = date('Y-'.sprintf('%02d',$month + 1));
      return $this->invoices()
                 ->where('type_id', '=', 5)
                 ->where('sold_on', 'LIKE', $date . '%')
                 ->get();
    }
    public function hardSalesMonth($month)
    {
      $date = date('Y-'.sprintf('%02d',$month + 1));
      return $this->invoices()
                 ->where('type_id', '=', 6)
                 ->where('sold_on', 'LIKE', $date . '%')
                 ->get();
    }
    public function electronicEarned($email, $year) {
        $total = 0;

        foreach($this->electronicSalesYear($year) as $invoice) { // loop through each electronic sale invoice
            foreach($invoice->authorInvoice()->where('email', $email)->get() as $authorInvoice)// loop through each author sale invoice for given email
            {
                $total += $authorInvoice->rate * $invoice->amount / 100;
            }
        }
            return $total;
    }

    public function audioEarned($email, $year)
    {
        $total = 0;

        foreach($this->audioSalesYear($year) as $invoice) // loop through each electronic sale invoice
        {
            foreach($invoice->authorInvoice()->where('email', $email)->get() as $authorInvoice)// loop through each author sale invoice for given email
            {
                $total += $authorInvoice->rate * $invoice->amount / 100;
            }
        }
            return $total;
    }

    public function softEarned($email, $year)
    {
        $total = 0;

        foreach($this->softSalesYear($year) as $invoice) // loop through each electronic sale invoice
        {
            foreach($invoice->authorInvoice()->where('email', $email)->get() as $authorInvoice)// loop through each author sale invoice for given email
            {
                $total += $authorInvoice->rate * $invoice->amount / 100;
            }
        }
            return $total;
    }

    public function hardEarned($email, $year)
    {
        $total = 0;

        foreach($this->hardSalesYear($year) as $invoice) // loop through each electronic sale invoice
        {
            foreach($invoice->authorInvoice()->where('email', $email)->get() as $authorInvoice)// loop through each author sale invoice for given email
            {
                $total += $authorInvoice->rate * $invoice->amount / 100;
            }
        }
            return $total;
    }

    public function royaltiesEarned($year)
    {
        $total = 0;

        $total = $this->audioEarned($this->email, $year) + $this->electronicEarned($this->email, $year) + $this->softEarned($this->email, $year) + $this->hardEarned($this->email, $year);

        return $total;
    }

    public function electronicEarnedMonth($email, $month) {
        $total = 0;

        foreach($this->electronicSalesMonth($month) as $invoice) { // loop through each electronic sale invoice
            foreach($invoice->authorInvoice()->where('email', $email)->get() as $authorInvoice)// loop through each author sale invoice for given email
            {
                $total += $authorInvoice->rate * $invoice->amount / 100;
            }
        }
            return $total;
    }

    public function audioEarnedMonth($email, $month)
    {
        $total = 0;

        foreach($this->audioSalesMonth($month) as $invoice) // loop through each electronic sale invoice
        {
            foreach($invoice->authorInvoice()->where('email', $email)->get() as $authorInvoice)// loop through each author sale invoice for given email
            {
                $total += $authorInvoice->rate * $invoice->amount / 100;
            }
        }
            return $total;
    }

    public function softEarnedMonth($email, $month)
    {
        $total = 0;

        foreach($this->softSalesMonth($month) as $invoice) // loop through each electronic sale invoice
        {
            foreach($invoice->authorInvoice()->where('email', $email)->get() as $authorInvoice)// loop through each author sale invoice for given email
            {
                $total += $authorInvoice->rate * $invoice->amount / 100;
            }
        }
            return $total;
    }

    public function hardEarnedMonth($email, $month)
    {
        $total = 0;

        foreach($this->hardSalesMonth($month) as $invoice) // loop through each electronic sale invoice
        {
            foreach($invoice->authorInvoice()->where('email', $email)->get() as $authorInvoice)// loop through each author sale invoice for given email
            {
                $total += $authorInvoice->rate * $invoice->amount / 100;
            }
        }
            return $total;
    }

    public function royaltiesEarnedMonth($email, $month)
    {
        $total = 0;

        $total = $this->audioEarnedMonth($email, $month) + $this->electronicEarnedMonth($email, $month) + $this->softEarnedMonth($email, $month) + $this->hardEarnedMonth($email, $month);
        return $total;
    }


    public function getUserRating($book, $email)
    {
        return DB::table('book_comment')->where('email', $email)->where('book_id',$book->book_id)->pluck('rating');;
    }

    public function getUserStars($book, $email)
    {
        $i = 0;
        $stars = '';
        $rating = $this->getUserRating($book,$email);

        // Loop for gold stars
        for($i; $i< $rating; $i++)
        {
            if($rating-$i < 1) // If half star needed
            {
                $stars .= '<i class="fa fa-star-half" style="color:gold"></i>';
                $stars .= '<i class="fa fa-star-half fa-flip-horizontal" style="color:grey; width: 12px;"></i>';
            }
            else
            {
                $stars .= '<i class="fa fa-star" style="color:gold"></i>';
            }
        }

        // Loop for grey stars
        for($i; $i< 5; $i++)
        {
            $stars .= '<i class="fa fa-star" style="color:grey"></i>';
        }

        return $stars;

    }


}

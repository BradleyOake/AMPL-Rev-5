<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use File;
use DB;


class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user';
    protected $primaryKey = 'email';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'role_id', 'facebook_id', 'google_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

     /**
     * Determines whether the user is an admin
     *
     * retun boolean
     */
    public function isAdmin() {
        return ($this->role_id == 7 ? true : false);
    }

     /**
     * Return the root directory of the user's author image
     *
     * return string
     */
    public function coverRoot() {
        return getcwd() .'/images/authors/'.$this->id.'/';
    }

     /**
     * Determines whether there is an author image for the user
     *
     * return boolean
     */
    public function coverExists() {
        $filePath = $this->coverRoot();

        if(file_exists($filePath)) {
            $files = array_diff(scandir($filePath), array('..', '.')); // get file names

            foreach($files as $file) {
                if(stripos($file, 'cover') !== FALSE) {
                    return File_exists($filePath.$file);
                }
            }
        }
        //return File_exists(.$this->book_id.'_cover.gif');
    }

     /**
     * Get the author image path
     *
     * return string
     */
    public function coverPath() {
        $filePath = $this->coverRoot();

        $files = array_diff(scandir($filePath), array('..', '.')); // get file names

        foreach($files as $file) {
            if(stripos($file, 'cover') !== FALSE) {
                return $filePath.$file;
            }
        }
    }

    public function coverShortPath() {
        $filePath = $this->coverRoot();

        $files = array_diff(scandir($filePath), array('..', '.')); // get file names

        foreach($files as $file) {
            if(stripos($file, 'cover') !== FALSE) {
                return 'images/authors/'.$this->id.'/'.$file;
            }
        }
        //return 'images/bookcovers/bookid'.$this->book_id.'/'.$this->book_id.'_cover.gif';
    }

    /**
     * Determines if the user has a bio file uploaded
     *
     * return boolean
     */
    public function bioExists() {
        return File::exists(storage_path() . '/authors/'. $this->id.'/about/'.$this->id. '_about.txt');
    }

     /**
     * Get the path for the author bio
     *
     * return string
     */
    public function bioPath() {
        return storage_path() . '/authors/'. $this->id.'/about/'.$this->id. '_about.txt';
    }

     public function newsCommentAgreed($comment)
    {
        return DB::table('news_comment_opinion')
            ->where('comment_id', $comment->comment_id)
            ->where('email', $this->email)
            ->pluck('agreed');

    }

    public function bookCommentAgreed($comment)
    {
        return DB::table('book_comment_opinion')
            ->where('comment_id', $comment->comment_id)
            ->where('email', $this->email)
            ->pluck('agreed');

    }

     public function newsCommentReported($comment) {
        return DB::table('news_comment_opinion')
            ->where('comment_id', $comment->comment_id)
            ->where('email', $this->email)
            ->pluck('reported');
    }

      public function bookCommentReported($comment) {
        return DB::table('book_comment_opinion')
            ->where('comment_id', $comment->comment_id)
            ->where('email', $this->email)
            ->pluck('reported');
    }

    public function bookCommentExists($book, $email)
    {
        $userComment = DB::table('book_comment')->where('email', $email)->where('book_id',$book->book_id)->first();

        if($userComment)
        {
            $return = true;
        }
        else
        {
            $return = false;
        }

        return $return;
    }

    /**FUNCTIONS FOR SUMMARY*/

    public function accountBalance()
    {
        //SELECT rate FROM author_invoice WHERE email={user}
        $balance = DB::table('author_invoice')
                ->where('email', $this->email)
                ->sum('rate');

        return $balance;
    }

    public function accruedEarnings()
    {
        //SELECT rate FROM author_invoice WHERE email={user}
        $balance = DB::table('author_invoice')
                ->where('email', $this->email)
                ->sum('rate');

        return $balance;
    }

    /*
    public function books($email)
    {
        //return $this->hasMany('App\Author', 'book_id');
        //return $this->hasMany('App\Author', 'book_id')->select(array('book_id'));

        $books = DB::table('author')
            ->leftJoin('book', 'book.book_id', '=', 'author.book_id')
            ->where('email', $email)
            ->where('status_id', 7)
            ->get();

        return $books;

    }*/


     public function books()
    {
        return $this->hasManyThrough('App\Book', 'App\Author', 'email', 'book_id');
    }



   public function authorizedDownload($book_id, $type_id){
       if(
              strtotime(DB::table('user_invoice') // if purchased and not pass download date
                        ->where('email', '=', $this->email)
                        ->where('book_id', '=', $book_id)
                        ->where('type_id', '<=', $type_id) // this gives access to any format under(like mp3 gets all )
                        ->pluck('access_until')
                        ) - strtotime(date('Y-m-d')) >= 0

       )
       {
           return true;
       }
       else if(
               DB::table('author') // if author
                    ->where('email', '=', $this->email)
                    ->where('book_id', '=', $book_id)
                    ->exists() // allow if logged in as admin)
                )
       {
           return true;
       }
        else if(  $this->isAdmin())
        {
            return true;
        }


   }


}

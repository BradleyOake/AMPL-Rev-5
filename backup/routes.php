<?php

use App\Book;
use App\Ink;
use App\Paper;
use App\User;
use App\NewsPost;
use App\NewsComment;
use App\BookComment;
use App\Http\Controllers;

use App\Http\Controllers\EmailController;

Blade::setContentTags("[[", "]]");        // for variables and all things Blade
Blade::setEscapedContentTags("[[[", "]]]");   // for escaped data
Blade::setRawTags("[!!", "!!]");

/*
|--------------------------------------------------------------------------
| Email Routes
|--------------------------------------------------------------------------
*/
Route::post('email/contact', 'EmailController@sendContactEmail');
Route::post('modals/registration', 'EmailController@sendRegistrationEmail');
Route::post('email/changePassword', 'EmailController@changePasswordEmail');
Route::post('email/resetPassword', 'EmailController@resetPasswordEmail');
Route::post('email/resetPassword', 'EmailController@resetPassword');


/*
|--------------------------------------------------------------------------
| Authorization Routes
|--------------------------------------------------------------------------
*/
Route::post('auth/emailCheck', 'AuthController@emailCheck');
Route::post('auth/emailExist', 'AuthController@emailExist');
Route::post('auth/register', 'AuthController@register');
Route::post('auth/login', 'AuthController@login');
Route::post('auth/facebook', 'AuthController@facebookLogin');
Route::post('auth/google', 'AuthController@googleLogin');

Route::get('logout', 'AuthController@logout');


Route::get('test', function(){ // the aspiring page for new authors
    return View::make('test');
});
/*
|--------------------------------------------------------------------------
| AMPL Main Page Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function(){ // the homepage
    $books = Book::all();

    return View::make('main.index', array('books' => $books))->nest('contact', 'main.contact_form');
});

Route::get('aspiring', function(){ // the aspiring page for new authors
    return View::make('main.aspiring');
});

Route::get('about', function(){ // the about page
    return View::make('main.about');
});

Route::get('contact', function(){
    return View::make('main.contact')->nest('contact', 'main.contact_form');
});

Route::get('privacypolicy', function(){
    return View::make('main.privacypolicy');
});

Route::get('businesspartners', function(){
    return View::make('main.businesspartners');
});

Route::get('editing', function(){
    return View::make('main.editing');
});

Route::get('printingservices', function(){
    return View::make('main.printingservices');
});



/*
|--------------------------------------------------------------------------
| Author Routes
|--------------------------------------------------------------------------
*/

Route::get('author/about', function(){
    return View::make('author.about');
});


/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/

Route::get('user/summary', function(){
    return View::make('user.summary');
});

Route::get('user/profile', function(){
    return View::make('user.profile');
});

Route::get('user/transactions', function(){
    $payments = DB::table('user_payment')->get();

    return View::make('user.transactions', array('payments' => $payments));
});


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|
|
|
|--------------------------------------------------------------------------
*/

Route::group(array('prefix' => 'admin', 'protected', 'middleware' => ['auth', 'admin']), function()
{

    Route::get('/', function(){
        
        $books = Book::all();
        $papers = Paper::all();
        $inks = Ink::all();       
        return View::make('admin.panel', array('books' => $books, 'papers' => $papers, 'inks' => $inks));
      
    });
    
    
    
    /*
    |--------------------------------------------------------------------------
    | ADMIN/USERS
    |--------------------------------------------------------------------------
    */
    Route::group(array('prefix' => 'users'), function()
    {
        // VIEW A LIST OF USERS
        Route::get('/', function()
        {
            $users = User::all();
            $users = $users->sortBy('id');

            return View::make('admin.user.users', array('users' => $users) );
        });
        
        // EDIT A GIVEN USERS ACCOUNT INFORMATION
        Route::get('edit/{email}', function($email)
        {
            $user = User::find($email);
            $userRoles = DB::table('user_role')->get();
            return View::make('admin.user.edit', array('user' => $user, 'userRoles' => $userRoles) );
        });        
        // POST ROUTE FOR "admin/users/edit/{email}" PAGE
        Route::post('postUpdate', 'UserController@updateUser');
        
        // ADD A NEW USER PAGE
        Route::get('add', function()
        {
            $userRoles = DB::table('user_role')->get();
            return View::make('admin.user.add', array('userRoles' => $userRoles) );
        });        
        // POST ROUTE FOR "admin/users/add" PAGE
        Route::post('postAdd', 'UserController@insertUser');


        // VIEW USER'S SALES
        Route::get('sales', function()
        {
            $users = User::all();
            return View::make('admin.userSales', array('users' => $users) );
        });

        Route::get('details/{email}', function($email)
        {
            $user = User::find($email);
            return View::make('admin.user.details', array('user' => $user) );
        });

         Route::get('bookSaleDetails/{email}/{id}', function($email, $id)
        {
            $book = Book::find($id);
            return View::make('admin.user.book_sale_details', array('book' => $book, 'email'=> $email) );
        });

      
      
        // RESETS THE USER'S ACCESS TO A BOOK DOWNLOAD
        Route::post('resetAccess', function()
        {
            $data = Input::all();
            $accessUntil = $data['access_until'];
             $saleID = $data['sale_id'];

            $valid = DB::table('user_invoice')
                 ->where('sale_id', '=', $saleID)
                  ->update(array('access_until' => $accessUntil));

            if($valid)
                echo json_encode(array('valid' => $valid, 'message'=> 'The user now has download access until '.date('F j, Y', strtotime($accessUntil)).'.' ));
            else
                 echo json_encode(array('valid' => $valid, 'message'=> 'No changes made to the database.'));
        });
    
     }); // END OF USERS GROUP


    /*
    |--------------------------------------------------------------------------
    | ADMIN/BOOKS
    |--------------------------------------------------------------------------
    */
    Route::group(array('prefix' => 'books'), function()
    {
         // VIEW A LIST OF BOOKS
        Route::get('/', function()
        {
            $books = Book::all();
            return View::make('admin.book.books', array('books' => $books) );
        });

        Route::get('add', function()
        {
            $users = DB::table('user')->get();
            $bookStatus = DB::table('book_status')->get();
            return View::make('admin.book.add', array('bookStatus' => $bookStatus));
        });

        Route::post('postAdd', 'BookController@addBook'); // add book form submission

        Route::get('edit/{book_id}', function($book_id)
        {
            $book = Book::find($book_id);
            $bookStatus = DB::table('book_status')->get();
            return View::make('admin.book.edit', array('book' => $book, 'bookStatus' => $bookStatus));
        });

        Route::get('pendingbooks', function()
        {
            $books = Book::all();
            return View::make('admin.book.pendingbooks', array('books' => $books));
        });

        Route::get('finishedbooks', function()
        {
            $books = Book::all();
            return View::make('admin.book.finishedbooks', array('books' => $books));
        });

        Route::post('postEdit', 'BookController@editBook');
        Route::post('deleteFile', 'BookController@deleteFile');
    });
    
    
    /*
    |--------------------------------------------------------------------------
    | Book Comments
    |--------------------------------------------------------------------------
    */
    Route::get('newBookComments', function()
    {
        $comments = BookComment::where('comment_status', '=', 0)->get();
        return View::make('admin.comment.newBookComments', array('comments' => $comments) );
    });

    Route::get('newNewsComments', function()
    {
        $comments = NewsComment::where('comment_status', '=', 0)->get();
        return View::make('admin.comment.newNewsComments', array('comments' => $comments) );
    });

    /*
    |--------------------------------------------------------------------------
    | News
    |--------------------------------------------------------------------------
    */

    Route::get('news', function()
    {
        $news = NewsPost::all();
        return View::make('admin.news.news', array('news' => $news) );
    });

    Route::get('addNews', function()
    {
        return View::make('admin.news.add');
    });

    Route::post('addNews', 'NewsController@insertNews');

    Route::get('editNews/{id}', function($id)
    {
        $post = DB::table('news_post')
            ->where('news_id', $id)
            ->first();
        return View::make('admin.news.edit', array('post' => $post));
    });

    Route::post('deleteNews', function()
    {
        $data = Input::all();
        $id = $data['news_id'];

        $post = DB::table('news_post')
            ->where('news_id', $id)
            ->delete();

        echo json_encode(array('valid' => true));
    });


    Route::get('editComments/{id}', function($id)
    {
        $comments = DB::table('news_comment')
            ->where('comment_id', $id)
            ->first();
        return View::make('admin.editComments', array('comments' => $comments));
    });

    Route::post('editNews', 'NewsController@updateNews');

    Route::get('purchases/{email}', function($email){

       $invoices = DB::table('user_invoice')
            ->leftJoin('book', 'user_invoice.book_id', '=', 'book.book_id')
            ->leftJoin('book_type', 'user_invoice.type_id', '=', 'book_type.type_id')
            ->where('email', '=', $email)
            ->select('book.title', 'user_invoice.book_id', 'user_invoice.access_until', 'book_type.description', 'user_invoice.sold_on', 'user_invoice.sale_id', 'book.ISBN', 'user_invoice.email')
            ->orderBy('user_invoice.sold_on', 'DESC')
            ->get();

        return View::make('admin.user.purchases', array('invoices' => $invoices, 'email'=> $email));
    });

     Route::get('resetPurchase/{id}', function($id){

          $invoice = DB::table('user_invoice')
            ->leftJoin('book', 'user_invoice.book_id', '=', 'book.book_id')
            ->leftJoin('book_type', 'user_invoice.type_id', '=', 'book_type.type_id')
            ->where('sale_id', '=', $id)
            ->select('book.title', 'user_invoice.book_id', 'user_invoice.access_until', 'book_type.description', 'user_invoice.sold_on', 'user_invoice.sale_id', 'book.ISBN', 'user_invoice.email')
            ->orderBy('user_invoice.sold_on', 'DESC')
            ->first();


        return View::make('admin.user.resetPurchase', array('invoice' => $invoice));
    });


    

    Route::get('editbooks', function(){
        $books = Book::all();

        
            return View::make('admin.editbooks', array('books' => $books));
        
    });

    Route::group(array('prefix' => 'editprinting'), function()
    {
        Route::get('/', function(){
            $papers = Paper::all();
            $inks = Ink::all();

            return View::make('admin.printing.editprinting', array('papers' => $papers, 'inks' => $inks));
        });

    });

    Route::get('editbook/{id}', function($id){
        $book = Book::find($id);
        $statusDescriptions = DB::table('book_status')
                                ->lists('description');

        if( !Auth::check() || !Auth::user()->isAdmin())
     
            return View::make('admin.editbook', array('book' => $book, 'statusDescription' => $statusDescriptions) )->nest('comments', 'admin.editbook', array( 'book' => $book, 'statusDescription' => $statusDescriptions));
        
    })->where('id', '[0-9]+');

    Route::get('admin/editpaper/{id}', function($id){
        $paper = Paper::find($id);
        $paperTypes = DB::table('paper_type')
                            ->lists('paper_type_description');
        $paperUsages = DB::table('paper_usage')
                            ->lists('paper_usage_description');

        return View::make('admin.printing.editpaper', array('paper' => $paper, 'paperType' => $paperTypes, 'paperUsage' => $paperUsages) )->nest('comments', 'admin.printing.editpaper', array( 'paper' => $paper, 'paperType' => $paperTypes, 'paperUsage' => $paperUsages));
        
    })->where('id', '[0-9]+');


    Route::get('editink/{id}', function($id){
        $ink = Ink::find($id);
        
        return View::make('admin.printing.editink', array('ink' => $ink) )->nest('comments', 'admin.printing.editink', array( 'ink' => $ink));
        
    });

    Route::get('addink', function()
    {
        return View::make('admin.printing.addink');
    });

    Route::get('addpaper', function()
    {
        $paperTypes = DB::table('paper_type')
                            ->lists('paper_type_description');
        $paperUsages = DB::table('paper_usage')
                            ->lists('paper_usage_description');

        return View::make('admin.printing.addpaper', array('paperType' => $paperTypes, 'paperUsage' => $paperUsages) )->nest('comments', 'admin.printing.addpaper', array('paperType' => $paperTypes, 'paperUsage' => $paperUsages));
    });

});

Route::group(array('prefix' => 'book', 'before' => 'auth'), function()
{
    Route::post('updateBook', 'BookController@updateBook'); // The profile form name section ajax call
    Route::post('checkISBN', 'BookController@checkISBN'); // The profile form name section ajax call
    Route::post('updatePaper', 'BookController@updatePaper'); // The profile form name section ajax call
    Route::post('updateInk', 'BookController@updateInk'); // The profile form name section ajax call
    Route::post('addInk', 'BookController@addInk'); // The profile form name section ajax call
    Route::post('addPaper', 'BookController@addPaper'); // The profile form name section ajax call
});


/*
|--------------------------------------------------------------------------
| News Routes
|--------------------------------------------------------------------------
*/

Route::group(array('prefix' => 'newsPost', 'before' => 'auth'), function()
{
    Route::post('delete', 'NewsPostController@delete'); // delete created post
    Route::post('update', 'NewsPostController@updatePost');
    Route::post('add', 'NewsPostController@addPost');

});


Route::get('news', function(){ // the news page showing 10 posts sotred from newest
    $newsPosts = Newspost::orderBy('created_on', 'desc')->paginate(10);
    return View::make('news.news', array('newsPosts' => $newsPosts) );
});


Route::get('news', function() { // the news page showing 10 posts sotred from newest

    $newsPosts = NewsPost::orderBy('created_on', 'desc')->get();

    if (Auth::check() && Auth::user()->isAdmin()) // logged in as admin
    {
       return View::make('news.news', array('newsPosts' => $newsPosts) );
    }
    else // logged in as normal user
    {
      return View::make('news.news', array('newsPosts' => $newsPosts) );
    }
});

Route::get('newspage/{id}',  function($id) // the individual page for a post
{
    $post = NewsPost::find($id);

    //return View::make('news.newspage', array('post' => $post) );

    if (Auth::check())
    {
        if (Auth::user()->isAdmin()) // logged in as admin
        {
           return View::make('news.newspage', array('post' => $post) )->nest('comments', 'news.comments_admin', array( 'post' => $post));
        }
        else // logged in as normal user
        {
           return View::make('news.newspage', array('post' => $post) )->nest('comments', 'news.comments_authenticated', array( 'post' => $post));
        }
    }
    else
    {
        return View::make('news.newspage', array('post' => $post) )->nest('comments', 'news.comments_unauthenticated', array( 'post' => $post));
    }

})->where('id', '[0-9]+');

/*
|--------------------------------------------------------------------------
| News Comment Routes
|--------------------------------------------------------------------------
*/
Route::group(array('prefix' => 'newsComment', 'before' => 'auth'), function()
{
    Route::post('agree', 'NewsCommentController@agree'); // agree to a post
    Route::post('disagree', 'NewsCommentController@disagree'); // agree to a post
    Route::post('delete', 'NewsCommentController@delete'); // delete created post
    Route::post('report', 'NewsCommentController@report'); // report a post

    Route::post('submit', 'NewsCommentController@insertComment');
    Route::post('update', 'NewsCommentController@updateComment');
});


/*
|--------------------------------------------------------------------------
| Book Comment Routes
|--------------------------------------------------------------------------
*/
Route::group(array('prefix' => 'bookComment', 'before' => 'auth'), function()
{
    Route::post('agree', 'BookCommentController@agree'); // agree to a post
    Route::post('disagree', 'BookCommentController@disagree'); // agree to a post
    Route::post('delete', 'BookCommentController@delete'); // delete created post
    Route::post('report', 'BookCommentController@report'); // report a post

    Route::post('submit', 'BookCommentController@insertComment');
    Route::post('update', 'BookCommentController@updateComment');
});

/*
|--------------------------------------------------------------------------
| Bookstore Pages
|--------------------------------------------------------------------------
*/
Route::get('bookstore', function(){
   // $books = Book::where('status_id', '=', 7);
    $books = Book::all();

    return View::make('bookstore.bookstore', array('books' => $books) );
});

Route::get('bookpage/{id}', function($id){

    $book = Book::find($id);

    $images = null;

    if(File::isDirectory('images/bookart/bookid' . $id))
    {
        $images = File::files('images/bookart/bookid' . $id);
    }

    if (Auth::check())
    {
        if (Auth::user()->isAdmin()) // logged in as admin
        {
           return View::make('bookstore.bookpage', array('book' => $book, 'images' => $images) )->nest('comments', 'bookstore.comments_admin', array( 'book' => $book));
        }
        else // logged in as normal user
        {
           return View::make('bookstore.bookpage', array('book' => $book, 'images' => $images) )->nest('comments', 'bookstore.comments_authenticated', array( 'book' => $book));
        }
    }
    else
    {
        return View::make('bookstore.bookpage', array('book' => $book, 'images' => $images) )->nest('comments', 'bookstore.comments_unauthenticated', array( 'book' => $book));
    }
})->where('id', '[0-9]+');

Route::get('buybook/{id}/{format}', function($id, $format){
    $book = Book::find($id);

    return View::make('bookstore.buybook', array('book' => $book, 'format' => $format) );
})->where('id', '[0-9]+');

Route::get('booksample/{id}', function($id){
    $book = Book::find($id);
    return View::make('bookstore.sample', array('book' => $book) );
})->where('id', '[0-9]+');

Route::get('comments/{id}', function($id){
  $book = Book::find($id);
  return View::make('bookstore.comments_authenticated', array('book' => $book));
})->where('id', '[0-9]+');

/*
|--------------------------------------------------------------------------
| Book Downloads
|--------------------------------------------------------------------------
*/
Route::group(array('prefix' => 'download'), function()
{
    Route::get('final/{id}/{type}', 'DownloadController@downloadFinal');
    Route::get('submission/{id}/{type}', 'DownloadController@downloadSubmission');
    Route::get('sample/{id}/{type}', 'DownloadController@downloadSample');
});


/*
|--------------------------------------------------------------------------
| PayPal Transaction Routes
|--------------------------------------------------------------------------
*/

Route::group(array('prefix' => 'paypal'), function()
{
    // Express checkout
    Route::post('checkout', array(
        'uses' => 'PaypalController@setExpressCheckout',
    ));

    // this is after make the payment, PayPal redirect back to your site
    Route::get('cancel', array(
        'uses' => 'PaypalController@cancel',
    ));

    Route::get('confirm', array(
        'uses' => 'PaypalController@doExpressCheckout',
    ));


    // Regular checkout
    // maybe should be post
    Route::get('payment', array(
        'as' => 'payment',
        'uses' => 'PaypalController@postPayment',
    ));

    // this is after make the payment, PayPal redirect back to your site
    Route::get('payment/status', array(
        //'as' => 'payment.status',
        'uses' => 'PaypalController@getPaymentStatus',
    ));

});

/*
|--------------------------------------------------------------------------
| Cart Routes
|--------------------------------------------------------------------------
*/

Route::group(array('prefix' => 'cart'), function()
{
    Route::post('add', array(
        'uses' => 'CartController@add',
    ));

    // this is after make the payment, PayPal redirect back to your site
    Route::post('remove', array(
        'uses' => 'CartController@remove',
    ));

    Route::get('get', 'CartController@get');


});


Route::get('cart', function(){
    return View::make('user.cart');
});



/*
|--------------------------------------------------------------------------
| Author Pages
|--------------------------------------------------------------------------
*/

Route::get('author/{id}/{name}', function($id,$name){

    $email = DB::table('author')->where('name_on_book', $name)->pluck('email');

    $user = User::find($email);

    $books = DB::table('author')
        ->leftJoin('book', 'book.book_id', '=', 'author.book_id')
        ->where('email', $email)
        ->where('status_id', 7)
        ->get();

    return View::make('author.about', array('user' => $user, 'name'=> $name, 'books' => $books ) );
});


/*
|--------------------------------------------------------------------------
| User Pages
|--------------------------------------------------------------------------
*/

Route::group(array('prefix' => 'user', 'before' => 'auth'), function()
{
     Route::get('summary', function()
    {


        return View::make('user.summary');
    });

     Route::get('transactions', function()
    {
        $payments = DB::table('user_payment')->get();

        return View::make('user.transactions', array('payments' => $payments));
    });

    Route::get('mybooks', function()
    {
         $books = DB::table('author')
            ->join('book', 'author.book_id', '=', 'book.book_id')
              ->join('book_status', 'book_status.status_id', '=', 'book.status_id')
            ->where('author.email', '=', Auth::user()->email)
                      ->get();


        return View::make('user.mybooks', array('books' => $books));
    });

    Route::get('editNewsComment/{id}', function($id)
    {
        $comments = DB::table('news_comment')
                    ->where('comment_id', $id)
                    ->where('comment_email', Auth::user()->email) // make sure they are the owner
                    ->first();

        return View::make('user.editNewsComment', array('comments' => $comments));
    });

      Route::get('editBookComment/{id}', function($id)
    {
        $comments = DB::table('book_comment')
                    ->where('comment_id', $id)
                    ->where('comment_email', Auth::user()->email) // make sure they are the owner
                    ->first();

        return View::make('user.editBookComment', array('comments' => $comments));
    });

    Route::get('sales', function()
    {
        $books = DB::table('book')
            ->join('author', 'author.book_id', '=', 'book.book_id')
            ->join('book_status', 'book_status.status_id', '=', 'book.status_id')
            ->join('user_invoice', 'user_invoice.book_id', '=', 'book.book_id')
            ->where('author.email', '=', Auth::user()->email)
            ->get();

        return View::make('user.sales', array('books' => $books));
    });

     Route::get('submission', function()
    {
        return View::make('user.submission');
    });

     Route::get('myPurchases', function()
    {

         $books = DB::table('user_invoice')
                    ->join('book', 'user_invoice.book_id', '=', 'book.book_id')
                    ->join('book_type', 'user_invoice.type_id', '=', 'book_type.type_id')
                    ->where('email', '=', Auth::user()->email)
                    ->select('book.title', 'user_invoice.book_id', 'user_invoice.access_until', 'book_type.description', 'user_invoice.sold_on', 'book.ISBN', 'user_invoice.email')
                    ->orderBy('user_invoice.sold_on', 'DESC')
                    ->orderBy('book.title', 'ASC')
                    ->get();

        return View::make('user.myPurchases', array('books' => $books));

    });

    Route::get('downloadBook/{id}', function($id)
    {
        if(DB::table('user_invoice') // if purchased
                ->where('email', '=', Auth::user()->email)
                ->where('book_id', '=', $id)
                ->where('type_id', '<=', 3)
                ->get()
            || DB::table('author') // if author
                    ->where('email', '=', Auth::user()->email)
                    ->where('book_id', '=', $id)
                    ->get() // allow if logged in as admin)
            || Auth::user()->isAdmin())
        {
            $showElectronic = true;
        }
        else
        {
            $showElectronic =  false;
        }

        if(DB::table('user_invoice') // if purchased
                ->where('email', '=', Auth::user()->email)
                ->where('book_id', '=', $id)
                ->where('type_id', '=', 4)
                ->get()
            || DB::table('author') // if author
                    ->where('email', '=',Auth::user()->email)
                    ->where('book_id', '=', $id)
                    ->get() // allow if logged in as admin)
            || Auth::user()->isAdmin())
        {
            $showAudio =  true;
        }
        else
        {
            $showAudio =  false;
        }

        $book = Book::find($id);

        return View::make('user.downloadBook', array('book' => $book,'showElectronic' => $showElectronic,'showAudio' => $showAudio));
    });

     Route::get('receipt/{id}', function($id)
    {
        $book = Book::find($id);
        return View::make('user.receipt', array('book' => $book));

    });


    Route::get('profile', function()
    {
        $userRole = DB::table('user_role')
            ->where('role_id', '=', Auth::user()->role_id)
            ->first();

        return View::make('user.profile',array('userRole' => $userRole));
    });


    Route::get('monthlysales/{id}', function($id){

       $book = Book::find($id);


        return View::make('user.monthlysales', array('book' => $book));

    });

    Route::post('bookSubmission', 'BookController@newSubmission'); // The book submission form's ajax call

    Route::post('nameUpdate', 'UserController@nameUpdate'); // The profile form name section ajax call

    Route::post('passwordUpdate', 'UserController@passwordUpdate'); // The password section of the profile ajax call

    Route::post('getBookSales', 'BookController@getBookSales');
   
    

});


/*
|--------------------------------------------------------------------------
| Book Downloads
|--------------------------------------------------------------------------
*/
Route::group(array('prefix' => 'download'), function()
{
    Route::get('final/{id}/{type}', 'BookController@downloadFinal');
    Route::get('submission/{id}/{type}', 'BookController@downloadSubmission');
    Route::get('sample/{id}/{type}', 'BookController@downloadSample');
});



/*
|--------------------------------------------------------------------------
| Printing Services
|--------------------------------------------------------------------------
*/
Route::get('printingservices', function(){
    $papers = DB::table('paper')
            ->join('paper_type', 'paper.paper_type', '=', 'paper_type.paper_type')
            ->join('paper_usage', 'paper.paper_usage', '=', 'paper_usage.paper_usage')
            ->get();
    $inks = DB::table('ink')->get();

    return View::make('main.printingservices', array('inks' => $inks, 'papers' => $papers) );
});

Route::group(array('prefix' => 'printingservices', 'before' => 'auth'), function()
{
    Route::post('submit', 'EmailController@sendPrintJobEmail');
});

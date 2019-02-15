<?php

use App\Author;
use App\Book;
use App\BookComment;
use App\Ink;
use App\NewsComment;
use App\NewsPost;
use App\Paper;
use App\User;
use App\Http\Controllers;
use App\Http\Controllers\EmailController;

Blade::setContentTags("[[", "]]");              // for variables and all things Blade
Blade::setEscapedContentTags("[[[", "]]]");     // for escaped data
Blade::setRawTags("[!!", "!!]");

/************************************************
*****   Admin Routes
************************************************/
Route::group(array('prefix' => 'book', 'before' => 'auth'), function()
{
    Route::post('updateBook', 'BookController@updateBook');
    Route::post('checkISBN', 'BookController@checkISBN');
    Route::post('updatePaper', 'BookController@updatePaper');
    Route::post('updateInk', 'BookController@updateInk');
    Route::post('addInk', 'BookController@addInk');
    Route::post('addPaper', 'BookController@addPaper');
});

Route::group(array('prefix' => 'admin', 'protected', 'middleware' => ['auth', 'admin']), function()
{
    Route::post('postAdd', 'BookController@addBook');           // Add book form submission
    Route::post('postEdit', 'BookController@editBook');
    Route::post('deleteFile', 'BookController@deleteFile');

    Route::post('editNews', 'NewsController@updateNews');

    /********************************************
    *****   admin/panel
    ********************************************/
    // Route for the admins panel
    Route::get('/', function()
    {    
        $books = Book::all();
        $papers = Paper::all();
        $inks = Ink::all();

        return View::make('admin.panel', array('books' => $books, 'papers' => $papers, 'inks' => $inks));
    });

    /********************************************
    *****   admin/author/*
    ********************************************/
    // Routes for the views within the admin/author folder
    Route::group(array('prefix' => 'author'), function()
    {
        // "Add Author" page
        Route::get('add', function()
        {
            $authors = Author::all();
            $books = Book::all();

            return View::make('admin.author.add', array('authors' => $authors, 'books' => $books));
        });

        // "View Authors" page
        Route::get('/', function()
        {
            $authors = Author::all();
            $books = Book::all();

            return View::make('admin.author.authors', array('authors' => $authors, 'books' => $books)); 
        });

        // "Edit Authors" page
        Route::get('edit', function()
        {
            $authors = Author::all();
            $books = Book::all();

            return View::make('admin.author.edit', array('authors' => $authors, 'books' => $books)); 
        });
    });
    // End of admin/author/* pages

    /********************************************
    *****   admin/book/*
    ********************************************/
    // Routes for the views within the admin/book folder
    Route::group(array('prefix' => 'book'), function()
    {
        // "Add Book" page
        Route::get('add', function()
        {
            $users = DB::table('user')->get();
            $bookStatus = DB::table('book_status')->get();

            return View::make('admin.book.add', array('bookStatus' => $bookStatus));
        });

        // "View Books" page
        Route::get('/', function()
        {
            $books = Book::all();

            return View::make('admin.book.books', array('books' => $books) );
        });

        // "Edit Books" page (The less detailed information page)
        Route::get('edit/{book_id}', function($book_id)
        {
            $book = Book::find($book_id);
            $bookStatus = DB::table('book_status')->get();

            return View::make('admin.book.edit', array('book' => $book, 'bookStatus' => $bookStatus));
        });

        // "Finished Books" page (The more detailed information page)
        Route::get('finishedbooks', function()
        {
            $books = Book::all();

            return View::make('admin.book.finishedbooks', array('books' => $books));
        });

        // "New Submissions" page
        Route::get('newSubmissions', function()
        {
            $submissions = Book::all();

            return View::make('admin.book.newsubmissions', array('submissions' => $submissions));
        });

        // "Pending Books" page (The more detailed information page)
        Route::get('pendingbooks', function()
        {
            $books = Book::all();

            return View::make('admin.book.pendingbooks', array('books' => $books));
        });
    });
    // End of admin/book/* pages

    /********************************************
    *****   admin/comment/*
    ********************************************/
    // Routes for the views within the admin/comment folder
    Route::group(array('prefix' => 'comment'), function()
    {
        // "Edit Comments" page
        Route::get('editComments/{id}', function($id)
        {
            $comments = DB::table('news_comment')
                        ->where('comment_id', $id)
                        ->first();

            return View::make('admin.comment.editComments', array('comments' => $comments));
        });

        // "Edit News Comment" page
        Route::get('editNewsComment/{id}', function($id)
        {
            $comments = DB::table('news_comment')
                        ->where('comment_id', $id)
                        ->where('comment_email', Auth::user()->email) // make sure they are the owner
                        ->first();

            return View::make('admin.comment.editNewsComment', array('comments' => $comments));
        });

        // "Approve Books" (comments) page
        Route::get('newBookComments', function()
        {
            $comments = BookComment::where('comment_status', '=', 0)->get();

            return View::make('admin.comment.newBookComments', array('comments' => $comments) );
        });

        // "Approve News" (comments) page
        Route::get('newNewsComments', function()
        {
            $comments = NewsComment::where('comment_status', '=', 0)->get();

            return View::make('admin.comment.newNewsComments', array('comments' => $comments) );
        });
    });
    // End of admin/comment/* pages

    /********************************************
    *****   admin/editor/*
    ********************************************/
    // Routes for the views within the admin/editor folder
    // NOTE: these files are not created yet, so this is commented out for now
    /*Route::group(array('prefix' => 'editor'), function()
    {
        // "Assign Editor" page
        Route::get('assignEditor', function()
        {
            return View::make('admin.editor.assign');
        });

        // "View Editor Status" page
        Route::get('viewEditorStatus', function()
        {
            return View::make('admin.editor.vieweditorstatus');
        });
    });*/
    // End of admin/editor/* pages

    /********************************************
    *****   admin/news/*
    ********************************************/
    // Routes for the views within the admin/news folder
    Route::group(array('prefix' => 'news'), function()
    {
        Route::post('addNews', 'NewsController@insertNews');

        // "Add News" page
        Route::get('addNews', function()
        {
            return View::make('admin.news.add');
        });

        // "View News" page
        Route::get('/', function()
        {
            $news = NewsPost::all();
            return View::make('admin.news.news', array('news' => $news) );
        });

        // "Edit News" page
        Route::get('editNews/{id}', function($id)
        {
            $post = DB::table('news_post')
                ->where('news_id', $id)
                ->first();
            return View::make('admin.news.edit', array('post' => $post));
        });
    });
    // End of admin/news/* pages

    /********************************************
    *****   admin/printing/*
    ********************************************/
    // Routes for the views within the admin/printing folder
    Route::group(array('prefix' => 'printing'), function()
    {
        // "Add Ink" page
        Route::get('addink', function()
        {
            return View::make('admin.printing.addink');
        });

        // "Add Paper" page
        Route::get('addpaper', function()
        {
            $paperTypes = DB::table('paper_type')
                            ->lists('paper_type_description');
            $paperUsages = DB::table('paper_usage')
                            ->lists('paper_usage_description');

            return View::make('admin.printing.addpaper', array('paperType' => $paperTypes, 'paperUsage' => $paperUsages));
        });

        // "Edit Ink" page
        Route::get('editink/{id}', function($id){
            $ink = Ink::find($id);
            
            return View::make('admin.printing.editink', array('ink' => $ink));
            
        });

        // "Edit Paper" page
        Route::get('editpaper/{id}', function($id)
        {
            $paper = Paper::find($id);
            $paperTypes = DB::table('paper_type')
                                ->lists('paper_type_description');
            $paperUsages = DB::table('paper_usage')
                                ->lists('paper_usage_description');

            return View::make('admin.printing.editpaper', array('paper' => $paper, 'paperType' => $paperTypes, 'paperUsage' => $paperUsages));
        })->where('id', '[0-9]+');

        // "Edit Printing" page
        Route::get('/', function()
        {
            $papers = Paper::all();
            $inks = Ink::all();

            return View::make('admin.printing.editprinting', array('papers' => $papers, 'inks' => $inks));
        });
    });
    // End of admin/printing/* pages

    /********************************************
    *****   admin/royalties/*
    ********************************************/
    // Routes for the views within the admin/royalties folder
    // NOTE: these files are not created yet, so this is commented out for now
    /*Route::group(array('prefix' => 'royalties'), function()
    {
        // "Sales By Book" page
        Route::get('salesbybook', function()
        {
            return View::make('admin.royalties.salesbybook');
        });
    });*/
    // End of admin/royalties/* pages

    /********************************************
    *****   admin/sales/*
    ********************************************/
    // Routes for the views within the admin/sales folder
    // NOTE: these files are not created yet, so this is commented out for now
    /*Route::group(array('prefix' => 'sales'), function()
    {
        // "Sales By Author" page
        Route::get('salesbyauthor', function()
        {
            return View::make('admin.sales.salesbyauthor');
        });

        // "Sales By Book" page
        Route::get('salesbybook', function()
        {
            return View::make('admin.sales.salesbybook');
        });
    });*/
    // End of admin/sales/* pages

    /********************************************
    *****   admin/user/*
    ********************************************/
    // Routes for the views within the admin/user folder
    Route::group(array('prefix' => 'user'), function()
    {
        Route::post('postUpdate', 'UserController@updateUser');
        Route::post('postAdd', 'UserController@insertUser');

        // "Add User" page
        Route::get('add', function()
        {
            $userRoles = DB::table('user_role')->get();

            return View::make('admin.user.add', array('userRoles' => $userRoles));
        });

        // "Book Sale Details" page
        // NOTE: Not sure where this links or is supposed to link to?
        Route::get('bookSaleDetails/{email}/{id}', function($email, $id)
        {
            $book = Book::find($id);

            return View::make('admin.user.book_sale_details', array('book' => $book, 'email'=> $email));
        });

        // "User Details" page
        Route::get('details/{email}', function($email)
        {
            $user = User::find($email);

            return View::make('admin.user.details', array('user' => $user));
        });

        // "Edit User" page
        Route::get('edit/{email}', function($email)
        {
            $user = User::find($email);
            $userRoles = DB::table('user_role')->get();

            return View::make('admin.user.edit', array('user' => $user, 'userRoles' => $userRoles) );
        });

        // "User Purchases" page
        Route::get('purchases/{email}', function($email)
        {
            $invoices = DB::table('user_invoice')
                            ->leftJoin('book', 'user_invoice.book_id', '=', 'book.book_id')
                            ->leftJoin('book_type', 'user_invoice.type_id', '=', 'book_type.type_id')
                            ->where('email', '=', $email)
                            ->select('book.title', 'user_invoice.book_id', 'user_invoice.access_until', 'book_type.description', 'user_invoice.sold_on', 'user_invoice.sale_id', 'book.ISBN', 'user_invoice.email')
                            ->orderBy('user_invoice.sold_on', 'DESC')
                            ->get();

            return View::make('admin.user.purchases', array('invoices' => $invoices, 'email'=> $email));
        });

        // "Reset User Purchase" page
        Route::get('resetPurchase/{id}', function($id)
        {
            $invoice = DB::table('user_invoice')
                            ->leftJoin('book', 'user_invoice.book_id', '=', 'book.book_id')
                            ->leftJoin('book_type', 'user_invoice.type_id', '=', 'book_type.type_id')
                            ->where('sale_id', '=', $id)
                            ->select('book.title', 'user_invoice.book_id', 'user_invoice.access_until', 'book_type.description', 'user_invoice.sold_on', 'user_invoice.sale_id', 'book.ISBN', 'user_invoice.email')
                            ->orderBy('user_invoice.sold_on', 'DESC')
                            ->first();

            return View::make('admin.user.resetPurchase', array('invoice' => $invoice));
        });

        // Used on the "Reset User Purchase" page
        Route::post('resetAccess', function()
        {
            $data = Input::all();
            $accessUntil = $data['access_until'];
            $saleID = $data['sale_id'];

            $valid = DB::table('user_invoice')
                        ->where('sale_id', '=', $saleID)
                        ->update(array('access_until' => $accessUntil));

            if($valid)
            {
                echo json_encode(array('valid' => $valid, 'message'=> 'The user now has download access until '.date('F j, Y', strtotime($accessUntil)).'.' ));
            }
            else
            {
                echo json_encode(array('valid' => $valid, 'message'=> 'No changes made to the database.'));
            }
        });

        // "View Users" page
        Route::get('/', function()
        {
            $users = User::all();
            $users = $users->sortBy('id');

            return View::make('admin.user.users', array('users' => $users) );
        });
    });
    // End of admin/user/* pages


    /********************************************
    *****   News
    ********************************************/
    Route::post('deleteNews', function()
    {
        $data = Input::all();
        $id = $data['news_id'];

        $post = DB::table('news_post')
                ->where('news_id', $id)
                ->delete();

        echo json_encode(array('valid' => true));
    });
});


/************************************************
*****   Auth Routes
************************************************/
Route::post('auth/emailCheck', 'AuthController@emailCheck');
Route::post('auth/emailExist', 'AuthController@emailExist');
Route::post('auth/register', 'AuthController@register');
Route::post('auth/login', 'AuthController@login');
Route::post('auth/facebook', 'AuthController@facebookLogin');
Route::post('auth/google', 'AuthController@googleLogin');

Route::get('logout', 'AuthController@logout');

Route::get('test', function()
{
    return View::make('test');
});


/************************************************
*****   Author Pages
************************************************/
Route::get('author/{id}/{name}', function($id,$name)
{
    $email = DB::table('author')->where('name_on_book', $name)->pluck('email');
    $user = User::find($email);
    $books = DB::table('author')
                ->leftJoin('book', 'book.book_id', '=', 'author.book_id')
                ->where('email', $email)
                ->where('status_id', 7)
                ->get();

    return View::make('author.about', array('user' => $user, 'name'=> $name, 'books' => $books));
});


/************************************************
*****   Bookstore Routes
************************************************/
Route::get('bookpage/{id}', function($id)
{
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

Route::get('bookstore', function()
{
    // $books = Book::where('status_id', '=', 7);
    $books = Book::all();

    return View::make('bookstore.bookstore', array('books' => $books));
});

Route::get('buybook/{id}/{format}', function($id, $format)
{
    $book = Book::find($id);

    return View::make('bookstore.buybook', array('book' => $book, 'format' => $format) );
})->where('id', '[0-9]+');

Route::get('booksample/{id}', function($id)
{
    $book = Book::find($id);
    return View::make('bookstore.sample', array('book' => $book) );
})->where('id', '[0-9]+');

Route::get('comments/{id}', function($id)
{
  $book = Book::find($id);
  return View::make('bookstore.comments_authenticated', array('book' => $book));
})->where('id', '[0-9]+');


/************************************************
*****   Cart Routes
************************************************/
Route::group(array('prefix' => 'cart'), function()
{
    Route::post('add', array('uses' => 'CartController@add'));

    // this is after make the payment, PayPal redirect back to your site
    Route::post('remove', array('uses' => 'CartController@remove'));

    Route::get('get', 'CartController@get');
});

Route::get('cart', function()
{
    return View::make('user.cart');
});


/************************************************
*****   Email Routes
************************************************/
Route::post('email/contact', 'EmailController@sendContactEmail');
Route::post('modals/registration', 'EmailController@sendRegistrationEmail');
Route::post('email/changePassword', 'EmailController@changePasswordEmail');
Route::post('email/resetPassword', 'EmailController@resetPasswordEmail');
Route::post('email/resetPassword', 'EmailController@resetPassword');


/************************************************
*****   Main Routes
************************************************/
// The about page
Route::get('about', function()
{
    return View::make('main.about');
});

// The aspiring page for new authors
Route::get('aspiring', function()
{
    return View::make('main.aspiring');
});

Route::get('businesspartners', function()
{
    return View::make('main.businesspartners');
});

Route::get('contact', function()
{
    return View::make('main.contact')->nest('contact', 'main.contact_form');
});

Route::get('editing', function()
{
    return View::make('main.editing');
});

Route::get('/', function()
{
    $books = Book::all();

    return View::make('main.index', array('books' => $books))->nest('contact', 'main.contact_form');
});

Route::get('printingservices', function()
{
    $papers = DB::table('paper')
                ->join('paper_type', 'paper.paper_type', '=', 'paper_type.paper_type')
                ->join('paper_usage', 'paper.paper_usage', '=', 'paper_usage.paper_usage')
                ->get();
    $inks = DB::table('ink')->get();

    return View::make('main.printingservices', array('inks' => $inks, 'papers' => $papers));
});

Route::group(array('prefix' => 'printingservices', 'before' => 'auth'), function()
{
    Route::post('submit', 'EmailController@sendPrintJobEmail');
});

Route::get('privacypolicy', function()
{
    return View::make('main.privacypolicy');
});


/************************************************
*****   News Routes
************************************************/
Route::group(array('prefix' => 'newsPost', 'before' => 'auth'), function()
{
    Route::post('delete', 'NewsPostController@delete'); // delete created post
    Route::post('update', 'NewsPostController@updatePost');
    Route::post('add', 'NewsPostController@addPost');
});

// The news page showing 10 posts sotred from newest
Route::get('news', function()
{
    $newsPosts = Newspost::orderBy('created_on', 'desc')->paginate(10);

    return View::make('news.news', array('newsPosts' => $newsPosts));
});

// The news page showing 10 posts sotred from newest
Route::get('news', function()
{
    $newsPosts = NewsPost::orderBy('created_on', 'desc')->get();

    if (Auth::check() && Auth::user()->isAdmin()) // logged in as admin
    {
       return View::make('news.news', array('newsPosts' => $newsPosts));
    }
    else // logged in as normal user
    {
        return View::make('news.news', array('newsPosts' => $newsPosts));
    }
});

// The individual page for a post
Route::get('newspage/{id}',  function($id)
{
    $post = NewsPost::find($id);

    if (Auth::check())
    {
        if (Auth::user()->isAdmin()) // logged in as admin
        {
           return View::make('news.newspage', array('post' => $post))->nest('comments', 'news.comments_admin', array('post' => $post));
        }
        else // logged in as normal user
        {
           return View::make('news.newspage', array('post' => $post))->nest('comments', 'news.comments_authenticated', array('post' => $post));
        }
    }
    else
    {
        return View::make('news.newspage', array('post' => $post))->nest('comments', 'news.comments_unauthenticated', array('post' => $post));
    }
})->where('id', '[0-9]+');


/*
|--------------------------------------------------------------------------
| User Pages
|--------------------------------------------------------------------------
*/

Route::group(array('prefix' => 'user', 'before' => 'auth'), function()
{
    Route::post('bookSubmission', 'BookController@newSubmission');      // The book submission form's ajax call
    Route::post('nameUpdate', 'UserController@nameUpdate');             // The profile form name section ajax call
    Route::post('passwordUpdate', 'UserController@passwordUpdate');     // The password section of the profile ajax call
    Route::post('getBookSales', 'BookController@getBookSales');

    // "Download Book" page
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

    // "Monthly Sales" page
    Route::get('monthlysales/{id}', function($id)
    {
        $book = Book::find($id);

        return View::make('user.monthlysales', array('book' => $book));
    });

    // "My Books" page
    Route::get('mybooks', function()
    {
         $books = DB::table('author')
                        ->join('book', 'author.book_id', '=', 'book.book_id')
                        ->join('book_status', 'book_status.status_id', '=', 'book.status_id')
                        ->where('author.email', '=', Auth::user()->email)
                        ->get();

        return View::make('user.mybooks', array('books' => $books));
    });

    // "My Purchases" page
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

    // "Profile" page
    Route::get('profile', function()
    {
        $userRole = DB::table('user_role')
                        ->where('role_id', '=', Auth::user()->role_id)
                        ->first();

        return View::make('user.profile',array('userRole' => $userRole));
    });

    // "Sales" page
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

    // "Submission" page
    Route::get('submission', function()
    {
        return View::make('user.submission');
    });

    // "Summary" page
    Route::get('summary', function()
    {
        return View::make('user.summary');
    });

    // "Transactions" page
    Route::get('transactions', function()
    {
        $payments = DB::table('user_payment')->get();

        return View::make('user.transactions', array('payments' => $payments));
    });

    // NOTE: This page is not created
    /*Route::get('receipt/{id}', function($id)
    {
        $book = Book::find($id);

        return View::make('user.receipt', array('book' => $book));
    });*/
});



/************************************************
*****   OTHER ROUTES STUFF
************************************************/
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
| Book Downloads
|--------------------------------------------------------------------------
*/
// NOTE: NEED TO FIND WHICH OF THESE IS THE CORRECT CONTROLLER TO LINK TO AND DELETE THE OTHER LINKING
Route::group(array('prefix' => 'download'), function()
{
    Route::get('final/{id}/{type}', 'DownloadController@downloadFinal');
    Route::get('submission/{id}/{type}', 'DownloadController@downloadSubmission');
    Route::get('sample/{id}/{type}', 'DownloadController@downloadSample');
});

Route::group(array('prefix' => 'download'), function()
{
    Route::get('final/{id}/{type}', 'BookController@downloadFinal');
    Route::get('submission/{id}/{type}', 'BookController@downloadSubmission');
    Route::get('sample/{id}/{type}', 'BookController@downloadSample');
});


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
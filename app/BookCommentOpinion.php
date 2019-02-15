<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
class BookCommentOpinion extends Model {


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'book_comment_opinion';

    protected $primaryKey = 'comment_id';

}

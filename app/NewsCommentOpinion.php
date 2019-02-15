<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
class NewsCommentOpinion extends Model {


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'news_comment_opinion';

    protected $primaryKey = 'comment_id';

}

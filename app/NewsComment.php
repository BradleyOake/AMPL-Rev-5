<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
class NewsComment extends Model {


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'news_comment';

    protected $primaryKey = 'comment_id';

    public function opinions()
    {
         return $this->hasMany('App\NewsCommentOpinion', 'comment_id', 'comment_id');
    }

    public function numberLiked()
    {
        return $this->opinions()->where('agreed', '=', 1)->count();
    }

    public function numberDisliked()
    {
         return $this->opinions()->where('agreed', '=', -1)->count();
    }

    public function numberReported()
    {
         return $this->opinions()->where('reported', '=', 1)->count();
    }
}

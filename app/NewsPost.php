<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsPost extends Model {


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'news_post';

    protected $primaryKey = 'news_id';

      public function comments()
    {
          return $this->hasMany('App\NewsComment', 'news_id', 'news_id');
    }


    public function numberComments()
    {
        return $this->comments()
            ->count();
    }


}

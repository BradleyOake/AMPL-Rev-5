<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'author';

    protected $primaryKey = 'book_id';
    
    public function user()
    {
        return $this->hasOne('App\User');
    }
}

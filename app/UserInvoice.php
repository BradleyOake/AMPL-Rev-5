<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInvoice extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_invoice';

    protected $primaryKey = 'sale_id';

     public function authorInvoice()
    {
        return $this->hasMany('App\AuthorInvoice', 'sale_id', 'sale_id');
    }

}

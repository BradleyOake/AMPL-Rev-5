<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class AuthorInvoice extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'author_invoice';

    protected $primaryKey = 'sale_id';


    public function invoice()
    {
        return $this->hasOne('App\UserInvoice');
    }

}

<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class UserPayment extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_payment';

    protected $primaryKey = 'payment_id';
}

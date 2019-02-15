<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Paper extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'paper';

    protected $primaryKey = 'paper_id';


    public function paperType() {
        return DB::table('paper_type')->where('paper_type', $this->paper_type)->pluck('paper_type_description');
    }

    public function paperUsage() {
        return DB::table('paper_usage')->where('paper_usage', $this->paper_usage)->pluck('paper_usage_description');
    }


}
?>

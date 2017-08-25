<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $table = 'expense';

    protected $primaryKey = 'id';

    protected $fillable = array(
        'title',
        'spend'
    );

    public $timestamps = false;


    public function add( $data = array() )
    {
        if( count($data) <= 0 )
        {
            return array(
                'success' => false,
                'header' => array('code' => 422),
                'message' => 'Wrong Input Data'
            );
        }

        $this->title = $data['title'];
        $this->description = '-';
        $this->spend = $data['spend'];
        $this->currency = $data['currency'];
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');

        try {
            $this->save();

            return array(
                'success' => true,
                'header' => array('code' => 200),
                'message' => 'Add Expense Already'
            );
        } catch (Exception $e) {

            return array(
                'success' => false,
                'header' => array('code' => 500),
                'message' => $e->getMessage()
            );
        }

    }



}

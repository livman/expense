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

        $this->user_id = $data['user_id'];
        $this->title = $data['title'];
        $this->description = (isset($data['description'])) ? $data['description'] : '';
        $this->spend = $data['spend'];
        $this->currency = $data['currency'];

        $time = new \DateTime(date('Y-m-d H:i:s'), new \DateTimeZone('UTC'));
        $time->setTimezone(new \DateTimeZone('Asia/Bangkok'));
        $time_custom = $time->format('Y-m-d H:i:s');

        print_r($time_custom); die;

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

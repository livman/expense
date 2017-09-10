<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Utils;
//use App\Helpers\Expense;

class Expense extends Model
{
    protected $table = 'expense';

    protected $primaryKey = 'id';

    protected $utilsHelper;

    protected $expenseHelper;

    protected $fillable = array(
        'title',
        'spend'
    );

    public $timestamps = false;

    public function __construct()
    {
        $this->utilsHelper = new Utils;
        $this->expenseHelper = new Helpers\Expense;
    }

    /**
     * Add expense to table
     *
     * @param  array  $data
     * @return array  
     */
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
        $this->created_at = $this->utilsHelper->convertTimezone();
        $this->updated_at = $this->utilsHelper->convertTimezone();

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

    /**
     * Get expense data
     *
     * @param  array  $data
     * @return array
     */
    public function get( $data = array() )
    {
        // prepare datetime format
        $from = $this->expenseHelper->validDateTimeFormat($data['condition']['start']);
        $to = $this->expenseHelper->validDateTimeFormat($data['condition']['end'], 1);

        try {

            $res = $this->where('user_id', $data['user_id'])->whereBetween('created_at', array($from, $to))->sum('spend');

            return array(
                'success' => true,
                'header' => array('code' => 200),
                'message' => 'Result OK',
                'data' => array(
                    'expense' => array(
                        'total' => $res,
                        'period_time' => array(
                            'start' => $from,
                            'end' => $to
                        )
                    )
                )
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

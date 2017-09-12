<?php


namespace App\Helpers;


class Expense
{
    /**
     *
     * @param  string    $dateTime
     * @param  int       $is_end
     * @return datetime
     */
    public function validDateTimeFormat( $dateTime = '', $is_end = 0 )
    {
        $dateTime = trim($dateTime);

        if( $dateTime == '' ) return date('Y-m-d H:i:s', time());

        $tmp = explode(' ', $dateTime);

        if ( count($tmp) > 1 ) return $dateTime;

        return ( !$is_end ) ? $dateTime .' 00:00:00' : $dateTime .' 23:59:59';
       
    }

    public function iterationExpenseCollection( $expenseCollection )
    {
        $total = 0;
        $tmp = array();
        foreach($expenseCollection as $item)
        {
            $total += floatval($item->_spend);

            $tmp[] = array(
                'title' => (isset($item->title)) ? $item->title : '',
                'description' => (isset($item->description)) ? $item->description : '',
                'spend' => number_format($item->_spend, 2),
                'time_period' => $item->_period
            );

        }

        return array('item' => $tmp, 'total' => number_format($total, 2));
    }

}
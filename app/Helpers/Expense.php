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

}
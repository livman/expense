<?php


namespace App\Helpers;


class Utils
{
    /**
     * Convert Timezone
     *
     * @param  int       $timestamp
     * @param  string    $regionTimezoneString
     * @param  string    $dateFormat
     * @return datetime
     */
    public function convertTimezone( $timestamp = 0, $regionTimezoneString = 'Asia/Bangkok', $dateFormat = 'Y-m-d H:i:s' )
    {
        if ( $timestamp == 0 ) $timestamp = time();

        $time = new \DateTime(date($dateFormat, $timestamp), new \DateTimeZone('UTC'));
        $time->setTimezone(new \DateTimeZone($regionTimezoneString));
        return $time->format($dateFormat);
    }

}
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

    /**
     *
     * @param  object    $expenseCollection
     * @return array
     */
    public function iterationExpenseCollection( $expenseCollection )
    {
        $total = 0;
        $total_row = count($expenseCollection);
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

        return array('item' => $tmp, 'total_spend' => number_format($total, 2), 'total_rows' => $total_row);
    }

    /**
     * Filter & Valid Input Data
     *
     *
     * @param  array    $input_data
     * @return array
     */
    public function filterInputGetExpense( $input_data = array() )
    {
        $prototype = array(
            'start' => array(
                'type' => 'datetime',
                'require' => true,
                'default' => date('Y-m-d H:i:s')
            ),
            'end' => array(
                'type' => 'datetime',
                'require' => true,
                'default' => date('Y-m-d H:i:s')
            ),
            'list_item' => array(
                'type' => 'boolean',
                'require' => false,
                'default' => 0,
                'ranges' => array(0, 1)
            ),
            'group_by' => array(
                'type' => 'string',
                'require' => false,
                'default' => 'm',
                'ranges' => array('y', 'm', 'd', 'a')
            ),
            'limit' => array(
                'type' => 'integer',
                'require' => false,
                'default' => 20,
                'ranges' => array(1, 50)
            ),
            'page' => array(
                'type' => 'integer',
                'require' => false,
                'default' => 1,
                'ranges' => array(1, 100000)
            ),
            'user_id' => array(
                'type' => 'integer',
                'require' => true
            ),
        );

        $res['result'] = true;
        $res['message'] = 'Data format is valid';

        foreach($prototype as $var => $item)
        {
            // Check require field
            if( $item['require'] )
            {
                if ( !isset($input_data[$var]) )
                {
                    $res['result'] = false;
                    $res['data'] = array();
                    $res['message'] = 'Param '. $var .' is required';
                    break;
                }
            }

            // Check datetime format
            if ( $item['type'] == 'datetime' )
            {
                // convert it through strtotime to get the date and back.
                if( ! $input_data[$var] == date('Y-m-d H:i:s', strtotime($input_data[$var])) )
                {
                    $res['result'] = false;
                    $res['data'] = array();
                    $res['message'] = 'Param '. $var .' is invalid datetime format';
                    break;
                }
            }

            // fill no require var
            if( !$item['require'] && ( !isset($input_data[$var]) || $input_data[$var] == '' )  )
            {
                $input_data[$var] = $item['default'];
            }

            // Limit ranges of field data
            if ( isset($item['ranges']) )
            {

                if ( count($item['ranges']) > 2 )
                {
                    // Available specific ranges
                    if( !in_array($input_data[$var], $item['ranges']) )
                    {
                        $res['result'] = false;
                        $res['data'] = array();
                        $res['message'] = 'Param '. $var .' is allow only [y/m/d/a]';
                        break;
                    }
                }
                else
                {
                    //Available period ranges
                    if ( $input_data[$var] < $item['ranges'][0] || $input_data[$var] > $item['ranges'][1] )
                    {
                        $res['result'] = false;
                        $res['data'] = array();
                        $res['message'] = 'Param '. $var .' is allow only ['. $item['ranges'][0] .' - '. $item['ranges'][1] .']';
                        break;
                    }

                }

            }

            $res['data'][$var] = $input_data[$var];

        }


        return $res;
    }

}
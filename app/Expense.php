<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Utils;
//use App\Helpers\Expense;
use Carbon\Carbon;
use DB;

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
     * @param  array  $input_data
     * @return array  
     */
    public function add( $input_data = array() )
    {
        $retFilter = $this->expenseHelper->filterInputAddExpense($input_data);

        if( !$retFilter['result'] )
        {
            return array(
                'success' => false,
                'header' => array('code' => 422),
                'message' => $retFilter['message']
            );
        }

        $data = $retFilter['data'];

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
                'message' => 'add_expense_already'
            );
        } catch (Exception $e) {

            return array(
                'success' => false,
                'header' => array('code' => 500),
                'message' => $e->getMessage()
            );
        }

    }

    protected function getExpenseCollection( $user_id, $from, $to )
    {
        return $this->where('user_id', $user_id)->whereBetween('created_at', array($from, $to));
    }

    protected function _groupBy( $expenseCollection, $condition = '' )
    {
        return $expenseCollection->groupBy(DB::raw($condition));
    }

    protected function _select( $expenseCollection, $condition = array() )
    {
        return $expenseCollection->selectRaw(implode(',', $condition));
    }

    protected function _orderBy( $expenseCollection, $field = '', $by = '' )
    {
        return $expenseCollection->orderBy($field, $by);
    }

    /**
     * Get expense data
     *
     * @param  array  $input_data
     * @return array
     */
    public function get( $input_data = array() )
    {

        $retFilter = $this->expenseHelper->filterInputGetExpense($input_data);

        if( !$retFilter['result'] )
        {
            return array(
                'success' => false,
                'header' => array('code' => 422),
                'data' => array(),
                'message' => $retFilter['message']
            );
        }

        // prepare datetime format
        $from = $this->expenseHelper->validDateTimeFormat($input_data['start']);
        $to = $this->expenseHelper->validDateTimeFormat($input_data['end'], 1);

        $data = $retFilter['data'];

        // init data
        $limit = $data['limit'];
        $page = $data['page'];
        $total_rows = 0;
        $total_spend = 0;

        try {
            // Get core collection expense
            $query = $this->getExpenseCollection($data['user_id'], $from, $to);


            $return_data = array();

            if ( $data['list_item'] == false )
            {
                $total_spend = number_format($query->sum('spend'), 2);
                $return_data['item'] = array();
            }
            else
            {
                switch ($data['group_by'])
                {
                    case 'y':
                        // grouping by years
                        $query = $this->_groupBy($query, 'YEAR(created_at)');
                        $query = $this->_select($query, array('sum(spend) as _spend', 'YEAR(created_at) as _period'));
                        $query = $this->_orderBy($query, '_period', 'ASC');
                        break;
                    case 'm':
                        // grouping by months
                        $query = $this->_groupBy($query, 'DATE_FORMAT(created_at, "%Y-%m")');
                        $query = $this->_select($query, array('sum(spend) as _spend', 'DATE_FORMAT(created_at, "%Y-%m") as _period'));
                        $query = $this->_orderBy($query, '_period', 'ASC');
                        break;
                    case 'd':
                        // grouping by date
                        $query = $this->_groupBy($query, 'DATE_FORMAT(created_at, "%Y-%m-%d")');
                        $query = $this->_select($query, array('sum(spend) as _spend', 'DATE_FORMAT(created_at, "%Y-%m-%d") as _period'));
                        $query = $this->_orderBy($query, '_period', 'ASC');
                        break;
                    default:
                        // get all
                        $query = $this->_select($query, array('title', 'description', 'spend as _spend', 'created_at as _period'));
                        $query = $this->_orderBy($query, '_period', 'ASC');
                }


                // Get row_total & total_spend
                $retTotal = $this->expenseHelper->iterationExpenseCollection($query->get());
                $total_rows = $retTotal['total_rows'];
                $total_spend = $retTotal['total_spend'];
                //$total_page = ceil($total_rows / $limit);

                // Paging data
                $offset =  $limit * ($page - 1);
                $query->offset($offset);
                $query->limit($limit);

                // Get item to response
                $return_data = $this->expenseHelper->iterationExpenseCollection($query->get());

            }

            return array(
                'success' => true,
                'header' => array('code' => 200),
                'message' => 'result_ok',
                'data' => array(
                    'expense' => array(
                        'list_item' => $data['list_item'],
                        'group_by' => $data['group_by'],
                        'period_time' => array(
                            'start' => $from,
                            'end' => $to
                        ),
                        'item' => $return_data['item'],
                        'total_spend' => $total_spend,
                        'paging' => array(
                            'index' => $page,
                            'item_per_page' => $limit,
                            'total_rows' => $total_rows
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

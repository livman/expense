<?php


namespace App\Http\Controllers;

use App\Expense;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Mockery\CountValidator\Exception;



class ExpenseController extends Controller
{

    /**
     * Add expense
     *
     * input document raw json
     *    {
     *      "title":       "string",
     *      "description": "string",
     *      "spend":       float,
     *      "currency":    "string"   [th/en/ etc.]
     *    }
     * @param  \Illuminate\Http\Request  $request
     * @return json
     */
    public function add(Request $request)
    {
        $data = $request->json()->all();
        $data['user_id'] = $request->user()->id;
        $expense = new Expense;
        $res = $expense->add($data);

        return response()->json([
            'success' => $res['success'],
            'message' => $res['message']
        ], $res['header']['code'] );
    }

    /**
     * Get expense
     *
     * input document raw json
     *    {
     *      "list_item":  boolean,
     *      "group_by" :  "string" [d/m/y]
     *      "page"     :  int
     *      "limit"    :  int
     *      "start"    : "datetime",
     *      "end":     : "datetime",
     *    }
     *
     * @param  \Illuminate\Http\Request  $request
     * @return json
     */
    public function get( Request $request )
    {
        $expense = new Expense;

        $data = $request->json()->all();

        // retrieve user_id from token
        $user_id = $request->user()->id;

        try {

            $res = $expense->get( array(
                'condition' => array(
                    'start' => $data['start'],
                    'end' => $data['end']
                ),
                'list_item' => $data['list_item'],
                'group_by' => $data['group_by'],
                'limit' => $data['limit'],
                'page' => $data['page'],
                'user_id' => $user_id
            ));

            return response()->json([
                'success' => $res['success'],
                'message' => $res['message'],
                'data' => $res['data']
            ], 200 );

        } catch (Exception $e) {

            return array(
                'success' => false,
                'header' => array('code' => 500),
                'message' => $e->getMessage()
            );
        }
    }


}
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
     * Add expense to table
     *
     * input document raw json
     *    {
     *      "title": "string",
     *      "description": "string",
     *      "spend": float,
     *      "currency": "string"  // type of spend th, en etc.
     *    }
     */
    public function add(Request $request)
    {
        $data = $request->json()->all();
        $expense = new Expense;
        $res = $expense->add($data);

        return response()->json([
            'success' => $res['success'],
            'message' => $res['message']
        ], $res['header']['code'] );
    }

    public function get(Request $request)
    {
        $option = $request->option;
        $value = $request->value;
        $expense = new Expense;

        try {

            $expense_total = $expense->where('user_id', 1)->sum('spend');
            return response()->json([
                'success' => true,
                'message' => 'Result OK',
                'data' => array(
                    'expense' => array('total' => $expense_total)
                )
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
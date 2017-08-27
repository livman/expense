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
        print_r($expense->get()->sum('spend'));

    }


}
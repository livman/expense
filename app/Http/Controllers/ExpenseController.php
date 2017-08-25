<?php


namespace App\Http\Controllers;

use App\Expense;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Mockery\CountValidator\Exception;

class ExpenseController extends Controller
{

    protected $parameters;

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



}
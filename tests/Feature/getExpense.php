<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Expense;
use App\Helpers\Expense as HelperExpense;

class getExpense extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    /*
    public function testExample()
    {
        $this->assertTrue(true);
    }
    */

    public function testFilterFieldNormalInputAddExpense()
    {
        $helperExpense = new HelperExpense;
        $input_data = array(
            'user_id' => 1,
            'title' => 'starbuck coffee',
            'spend' => 200.5
        );
        $res = $helperExpense->filterInputAddExpense($input_data);
        $this->assertEquals(true, $res['result'], json_encode($res));
    }

    public function testFilterFieldSpendIsStringInputAddExpense()
    {
        $helperExpense = new HelperExpense;
        $input_data = array(
            'user_id' => 1,
            'title' => 'starbuck coffee',
            'spend' => 'xxx'
        );
        $res = $helperExpense->filterInputAddExpense($input_data);
        $this->assertEquals(false, $res['result'], json_encode($res));
    }

    public function testFilterFieldCurrencyOutOfScopeInputAddExpense()
    {
        $helperExpense = new HelperExpense;
        $input_data = array(
            'user_id' => 1,
            'title' => 'starbuck coffee',
            'spend' => 200.50,
            'currency' => 'THB'
        );
        $res = $helperExpense->filterInputAddExpense($input_data);
        $this->assertEquals(false, $res['result'], json_encode($res));
    }


    /*
    public function testModelExpenseMethodAdd()
    {
        //$this->assertTrue(false);

        $expense = new Expense;
        $input_data = array(
            'user_id' => 1,
            'title' => 'starbuck coffee',
            'spend' => '180'
        );
        $res = $expense->add($input_data);
        $this->assertEquals(true, $res['success'], json_encode($res));


    }
    */




    /*
    public function testMy2()
    {
        $param = array(
            "list_item" => true,
              "group_by" => "",
              "page" => 4,
              "limit" => 3,
              "start" => "2017-08-01",
              "end" => "2017-09-30"
        );
        $header = array(
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjVkNjc2M2UzOTg0ODkyNTUyZmU2ZDgwMGJkMzNhZTM2ZWE5ZDRkNWMyNjJkOTFiMDI1ODFmNjgwNTQ5YWM4NjUxMTk1MWEzZTBmYjdhOTg1In0.eyJhdWQiOiIyIiwianRpIjoiNWQ2NzYzZTM5ODQ4OTI1NTJmZTZkODAwYmQzM2FlMzZlYTlkNGQ1YzI2MmQ5MWIwMjU4MWY2ODA1NDlhYzg2NTExOTUxYTNlMGZiN2E5ODUiLCJpYXQiOjE1MDUzODA1MzgsIm5iZiI6MTUwNTM4MDUzOCwiZXhwIjoxNTM2OTE2NTM4LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.I9Mv4gSs6NRj-nBc7QTULkSrw7sYsrCxTWmfYD8P0gEUZhmENWoAKZyFweTu3O830xbcQrX9tDL2wLp23z82irsjcmG_0KciozcZwXQuY_6HJj2HeKPjUeeedb3zIGpMNKl8H_9cItKu_wcTagJVBbzP6eyt6bmMxk7OoMgfVmLXyyGjZ-KbHMAhbzgS2NOy2j_JBpUQvl9VwHWUeoiBllU920kKZaY4o1rcyloaN_WWMjg9hueRNHYE4qHjYpFsEKI3GIcTUICmnFl5OOjCLZRtIY67qNUyQyRpdpjPVFG-G3CbEnnGMkGap_5brv_K4kb_TUCBqWJNerHXbZQG23uoMpoWKV-kYXnKBhIGloIPqVZfkIsAytvMQqx91uSwrnESp53wEgf014jY8ylWUnDA7vnCQ7sQG1Ab6O3B42h3pPaaPRiSeR--VjmeRTmXoBHxk11h_IusT7sRaYQ5ISMQybyieudgsvgLmeH9E_qH7yL3PQMpIdKPtiaQO_OgyOeZe_W0ZMjWF3StcKgGEKjfIiBrPH1KY5W8SHserRCkPqmab-I-vNIaL7t-ffOodZkbAjCPZHFe8IqkDjf17PNDI966OoYFxait-M-FJLhLCFXrYCr-h8DdSCCJRjGTCq9e7arSz3oH1XCnpBaxBWd-zVVwzCX5_0b8j3f5mwU'
        );
        $response = $this->json('POST', '/api/v1/get', $param, $header)->json();
        echo json_encode($response);

        //print_r($response); die;
        //$array = json_decode($response);
        //print_r($array); die;
    }
    */

}

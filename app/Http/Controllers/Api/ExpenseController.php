<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Expense;

class ExpenseController extends Controller
{
    Public function all_expenses(){
        $Expense_List=DB::table('expenses')
            ->join('budgets','budgets.b_id','expenses.budget_id')
            ->join('users','users.id','budgets.user_id')
            ->where('email','=',$_GET['email'])
            ->where('b_name','=',$_GET['b_name'])
            ->select('e_name','e_amount','e_flag','expenses.created_at')
            ->get();
        return response(['recordAdded' => $Expense_List]);
    }

    Public function add_expense(){
        $x=DB::table('users')
            ->join('budgets','budgets.user_id','users.id')
            ->join('expenses','expenses.budget_id','budgets.b_id')
            ->where("email" ,"=",$_GET['email'])
            ->where("b_name","=",$_GET['b_name'])
            ->where("e_name","=",$_GET['e_name'])
            ->get();
        if(sizeof($x) < 1){
            $user=DB::table('users')
                ->join('budgets','budgets.user_id','users.id')
                ->where("email" ,"=",$_GET['email'])
                ->where("b_name","=",$_GET['b_name'])
                ->get();
            foreach($user as $u){
                $add                = new Expense();
                $add->e_name        = $_GET['e_name'];
                $add->e_amount      = $_GET['e_amount'];
                $add->e_flag        = $_GET['e_flag'];
                $add->budget_id     = $u->b_id;
                $add->api_token     = 111;
                $add->save();
            }
            $recordAdded=DB::select(' SELECT
                                        expenses.e_name AS `e_name`,
                                        NULL AS `i_b_name`,
                                        expenses.e_amount AS `amount`,
                                        expenses.e_flag AS `flag`,
                                        expenses.created_at
                                      FROM expenses
                                      WHERE e_name = "'.$_GET['e_name'].'"
                                      ');
            /*$recordAdded=DB::table('expenses')
                ->where("e_name","=",$_GET['e_name'])
                ->select('e_name','Null As i_b_name','e_amount','e_flag','created_at')
                ->get();*/
            return response(["all_budget_data" => $recordAdded]);
        }
        else{
            return response(['all_budget_data' => []]);
        }
    }

    Public function delete_expense(){
        DB::table('expenses')
            ->join('budgets','budgets.b_id','expenses.budget_id')
            ->join('users','users.id','budgets.user_id')
            ->where('email' ,'=',$_GET['email'])
            ->where('b_name','=',$_GET['b_name'])
            ->where('e_name','=',$_GET['e_name'])
            ->delete();
        return "Record deleted successfully";
    }

    public function expense_flag_reverse(){
        $x=DB::table('expenses')
            ->join("budgets","budgets.b_id","expenses.budget_id")
            ->join("users","users.id","budgets.user_id")
            ->where('email' ,'=',$_GET['email'])
            ->where('b_name','=',$_GET['b_name'])
            ->where('e_name','=',$_GET['e_name'])
            ->update([
                'e_flag'=>$_GET['e_flag']
            ]);
        if($x){
            $budgets=DB::table('budgets')->where("b_name","=",$_GET['b_name'])->get();
            $e_arr=DB::table('budgets')
                ->join('users','users.id','budgets.user_id')
                ->join('expenses','expenses.budget_id','budgets.b_id')
                ->where("email" ,"=",$_GET['email'])
                ->where("b_name","=",$_GET['b_name'])
                ->select('b_amount','e_name','e_amount','e_flag')
                ->get();
            $i_b_arr=DB::table('budgets')
                ->join('users','users.id','budgets.user_id')
                ->join('increase_budgets','increase_budgets.budget_id','budgets.b_id')
                ->where("email" ,"=",$_GET['email'])
                ->where("b_name","=",$_GET['b_name'])
                ->select('b_amount','i_b_name','i_b_amount','i_b_flag')
                ->get();
            $remainingBalance=0;
            $totalExpenses=0;
            $totalBudget=0;
            foreach($budgets as $z) {
                $totalBudget = $z->b_amount;
                $remainingBalance = $z->b_amount;
            }
            foreach($i_b_arr as $i){
                if($i->i_b_flag == "true"){
                    $totalBudget        += $i->i_b_amount;
                    $remainingBalance   += $i->i_b_amount;
                }else{
                    $totalBudget        += 0;
                    $remainingBalance   += 0;
                }
            }
            foreach($e_arr as $e){
                if($e->e_flag == "true"){
                    $totalExpenses      += $e->e_amount;
                    $remainingBalance   -= $e->e_amount;
                }else{
                    $totalExpenses      += 0;
                    $remainingBalance   += 0;
                }
            }
            return response([
                'totalBudget'       => $totalBudget,
                'totalExpenses'     => $totalExpenses,
                'remainingBalance'  => $remainingBalance,
            ]);
        }

    }

}

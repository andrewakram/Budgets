<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Increase_budget;

class Increase_budgetController extends Controller
{
    Public function all_increase_budgets(){
        $Increase_Budget_List=DB::table('increase_budgets')
            ->join('budgets','budgets.b_id','increase_budgets.budget_id')
            ->join('users','users.id','budgets.user_id')
            ->where('email','=',$_GET['email'])
            ->where('b_name','=',$_GET['b_name'])
            ->select('i_b_name','i_b_amount','i_b_flag','increase_budgets.created_at')
            ->get();
        return response(['Increase_Budget_List' => $Increase_Budget_List]);
    }

    Public function add_increase_budget(){
        $x=DB::table('users')
            ->join('budgets','budgets.user_id','users.id')
            ->join('increase_budgets','increase_budgets.budget_id','budgets.b_id')
            ->where("email" ,"=",$_GET['email'])
            ->where("b_name","=",$_GET['b_name'])
            ->where("i_b_name","=",$_GET['i_b_name'])
            ->get();
        if(sizeof($x) < 1){
            $user=DB::table('users')
                ->join('budgets','budgets.user_id','users.id')
                ->where("email" ,"=",$_GET['email'])
                ->where("b_name","=",$_GET['b_name'])
                ->get();
            foreach($user as $u){
                $add                = new Increase_budget();
                $add->i_b_name      = $_GET['i_b_name'];
                $add->i_b_amount    = $_GET['i_b_amount'];
                $add->i_b_flag      = $_GET['i_b_flag'];
                $add->budget_id     = $u->b_id;
                $add->api_token     = 111;
                $add->save();
            }
            $recordAdded=DB::select(' SELECT
                                          NULL AS `e_name`,
                                          increase_budgets.i_b_name AS `i_b_name`,
                                          increase_budgets.i_b_amount AS `amount`,
                                          increase_budgets.i_b_flag AS `flag`,
                                          increase_budgets.created_at
                                      FROM increase_budgets
                                      WHERE i_b_name = "'.$_GET['i_b_name'].'"
                                      ');
            /*$recordAdded=DB::table('increase_budgets')
                ->where("i_b_name" ,"=",$_GET['i_b_name'])
                ->select('i_b_name','i_b_amount','i_b_flag','created_at')
                ->get();*/
            return response(["all_budget_data" => $recordAdded]);
        }
        else{
            return response(['all_budget_data' => []]);
        }
    }

    Public function delete_increase_budget(){
        DB::table('increase_budgets')
            ->join('budgets','budgets.b_id','increase_budgets.budget_id')
            ->join('users','users.id','budgets.user_id')
            ->where('email' ,'=',$_GET['email'])
            ->where('b_name','=',$_GET['b_name'])
            ->where('i_b_name','=',$_GET['i_b_name'])
            ->delete();
        return "Record deleted successfully";
    }
    public function increase_budget_flag_reverse(){
        $x=DB::table('increase_budgets')
            ->join("budgets","budgets.b_id","increase_budgets.budget_id")
            ->join("users","users.id","budgets.user_id")
            ->where('email' ,'=',$_GET['email'])
            ->where('b_name','=',$_GET['b_name'])
            ->where('i_b_name','=',$_GET['i_b_name'])
            ->update( ['i_b_flag'=>$_GET['i_b_flag'] ]);
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

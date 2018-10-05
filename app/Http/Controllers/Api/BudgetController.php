<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Budget;

class BudgetController extends Controller
{
    Public function all_budgets(){
        $Budget_List=DB::table('budgets')
            ->join('users','users.id','budgets.user_id')
            ->where('email','=',$_GET['email'])
            ->select('b_name','b_amount','budgets.created_at')
            ->get();
        return response(['Budget_List' => $Budget_List]);
    }

    Public function add_budget(){
        $x=DB::table('users')
            ->join('budgets','budgets.user_id','users.id')
            ->where("email","=",$_GET['email'])
            ->where("b_name","=",$_GET['b_name'])
            ->get();
        if(sizeof($x) < 1){
            $user=DB::table('users')->where("email","=",$_GET['email'])->get();
            foreach($user as $u){
                $add                = new Budget();
                $add->b_name        = $_GET['b_name'];
                $add->b_amount      = $_GET['b_amount'];
                $add->user_id       = $u->id;
                $add->api_token     = 111;
                $add->save();
            }
            $recordAdded=DB::table('budgets')
                ->where("b_name","=",$_GET['b_name'])
                ->select('b_name','b_amount','created_at')
                ->get();
            return response(["recordAdded" => $recordAdded]);
        }
        else{
            return response(['recordAdded' => []]);
        }
    }

    Public function delete_budget(){
        DB::table('budgets')
            ->join('users','users.id','budgets.user_id')
            ->where('email' ,'=',$_GET['email'])
            ->where('b_name','=',$_GET['b_name'])
            ->delete();
        return "Record deleted successfully";
    }

    Public function search_in_budgets(){
        $Budget_List = DB::table('budgets')
            ->join('users','users.id','budgets.user_id')
            ->where('email' , '='   , $_GET['email'])
            ->where('b_name', 'LIKE', '%'.$_GET['b_name'].'%')
            ->select('b_name','b_amount','budgets.created_at')
            ->get();
        if(sizeof($Budget_List)>0){
            return response(['Budget_List' => $Budget_List]);
        }else {
            return response(['Budget_List' => []]);
        }
    }

    Public function all_budget_data(){
        $email=$_GET['email'];
        $b_name=$_GET['b_name'];
        $all_budget_data=DB::select(' SELECT
                                        expenses.e_name,
                                        NULL AS `i_b_name`,
                                        expenses.e_amount AS `amount`,
                                        expenses.e_flag AS `flag`,
                                        expenses.created_at
                                      FROM expenses
                                      JOIN budgets ON expenses.budget_id = budgets.b_id
                                      JOIN users ON budgets.user_id = users.id
                                      WHERE email = "'.$email.'" AND b_name = "'.$b_name.'"
                                      UNION
                                      SELECT
                                          NULL AS `e_name`,
                                          increase_budgets.i_b_name,
                                          increase_budgets.i_b_amount AS `amount`,
                                          increase_budgets.i_b_flag AS `flag`,
                                          increase_budgets.created_at
                                      FROM increase_budgets
                                      JOIN budgets ON increase_budgets.budget_id = budgets.b_id
                                      JOIN users ON budgets.user_id = users.id
                                      WHERE email = "'.$email.'" AND b_name = "'.$b_name.'"
                                      ORDER BY created_at ');
        if(sizeof($all_budget_data)>0){
            return response(['all_budget_data'=>$all_budget_data]);
        }else{
            return response(['all_budget_data'=>[]]);
        }
    }




}

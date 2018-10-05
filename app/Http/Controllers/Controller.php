<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function admins(){
        Session_start();
        $admin_email=Session::get('email');
        if($admin_email) {
            return;
        } else {
            return redirect::to('/login')->send();
        }
    }


    //////////////////////////////////////////////////////////////////////////////
    /// This function related to service mobile (Api)
    //////////////////////////////////////////////////////////////////////////////

    public function calc(){
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
    ///////////////////////////////////////////////////


}

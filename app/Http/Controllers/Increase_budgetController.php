<?php

namespace App\Http\Controllers;

use App\Increase_budget;
use Illuminate\Http\Request;
use DB;
use Session;

class Increase_budgetController extends Controller
{
    public function add_increase_budget(){
        $this->admins();
        return view('layouts.increase_budgets.add_increase_budget');
    }

    public function all_increase_budgets(Request $request){
        $this->admins();
        $email=Session::get('email');
        $increase_budgets = Increase_budget::orderBy('increase_b_id','asc')
            ->join('budgets','budgets.b_id','increase_budgets.budget_id')
            ->join('users','users.id','budgets.user_id')
            ->where("email","=","$email")
            ->get();
        return view('layouts.increase_budgets.all_increase_budgets',['increase_budgets'=>$increase_budgets]);
    }

    public function add_new_increase_budget(Request $request){
        $this->admins();

        $data = $this->validate(request(),
            [
                'budgetId'              =>'required',
                'increaseBudgetName'    =>'required',
                'increaseBudgeAmount'   =>'required',
                'i_b_flag'              =>'required',
            ],[],
            [
                'budgetId'              =>'Budge Name',
                'increaseBudgetName'    =>'Increase Budge Name',
                'increaseBudgeAmount'   =>'Increase Budget Amount',
                'i_b_flag'              =>'Increase Budget Selection',
            ]
        );
        $email=Session::get('email');
        $i_b_name=DB::table('users')
                    ->join('budgets','budgets.user_id','users.id')
                    ->join('increase_budgets','increase_budgets.budget_id','budgets.b_id')
                    ->where("email","=","$email")
                    ->where("budget_id","=",request('budgetId'))
                    ->where("i_b_name" ,"=",request('increaseBudgetName'))
                    ->get();
        if(sizeof($i_b_name)>0){
            session()->flash('insert_message','Increase Budget Name Already Exists');
            return redirect('add_increase_budget');
        }else{
            $add                = new Increase_budget();
            $add->i_b_name      = request('increaseBudgetName');
            $add->i_b_amount    = request('increaseBudgeAmount');
            $add->i_b_flag      = request('i_b_flag');
            $add->budget_id     = request('budgetId');
            $add->api_token     = 111;
            $add->save();
            session()->flash('insert_message','Record added successfully');
            return redirect('add_increase_budget');
        }
    }

    public function edit_increase_budgets($increase_b_id){
        $this->admins();
        return view('layouts.increase_budgets.edit_increase_budgets');
    }

    public function update_increase_budget(Request $request,$increase_b_id) {
        $this->admins();
        $data = $this->validate(request(),
            [
                'budgetId'              =>'required',
                'increaseBudgetName'    =>'required',
                'increaseBudgetAmount'  =>'required',
                'i_b_flag'              =>'required',
            ],[],
            [
                'budgetId'              =>'Budge Name',
                'increaseBudgetName'    =>'Increase Budge Name',
                'increaseBudgetAmount'  =>'Increase Budget Amount',
                'i_b_flag'              =>'Increase Budget Selection',
            ]
        );

        DB::table('increase_budgets')
            ->where('increase_b_id', $increase_b_id)
            ->update([
                'budget_id'     =>request('budgetId'),
                'i_b_name'      =>request('increaseBudgetName'),
                'i_b_amount'    =>request('increaseBudgetAmount'),
                'i_b_flag'      =>request('i_b_flag'),
            ]);

        session()->flash('insert_message','Record updated successfully');
        return redirect('all_increase_budgets');
    }

    public function delete_increase_budget($increase_b_id)
    {
        $this->admins();
        DB::table('increase_budgets')
            ->where('increase_b_id',$increase_b_id)
            ->delete();
        return back();
    }
}

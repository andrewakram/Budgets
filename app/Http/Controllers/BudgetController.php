<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Budget;
use DB;
use Session;


class BudgetController extends Controller
{
    public function all_budgets(Request $request){
        $this->admins();
        $email=Session::get('email');
        $budgets = Budget::orderBy('b_id','asc')
            ->join('users','users.id','budgets.user_id')
            ->where("email","=","$email")
            ->get();
        return view('layouts.budgets.all_budgets',['budgets'=>$budgets]);
    }

    public function add_budget(){
        $this->admins();
        return view('layouts.budgets.add_budget');
    }

    public function add_new_budget(Request $request){
        $this->admins();

        $data = $this->validate(request(),
            [
                'budgetName'    =>'required',
                'budgetAmount'  =>'required',
            ],[],
            [
                'budgetName'    =>'Budget Name',
                'budgetAmount'  =>'Budget Amount',
            ]
        );
        $email=Session::get('email');
        $b_name=DB::table('users')
                    ->join('budgets','budgets.user_id','users.id')
                    ->where("email","=","$email")
                    ->where("b_name","=",request('budgetName'))
                    ->get();
        if(sizeof($b_name)>0){
            session()->flash('insert_message','Budget Name Already Exists');
            return redirect('add_budget');
        }else{
            $user=DB::table('users')->where("email","=","$email")->get();
            foreach($user as $u){
                $add                = new Budget();
                $add->b_name        = request('budgetName');
                $add->b_amount      = request('budgetAmount');
                $add->user_id       = $u->id;
                $add->api_token     =111;
                $add->save();
            }
            session()->flash('insert_message','Record added successfully');
            return redirect('add_budget');
        }
    }

    public function edit_budget($b_id){
        $this->admins();
        return view('layouts.budgets.edit_budget');
    }

    public function update_budget(Request $request,$b_id) {
        $this->admins();
        $data = $this->validate(request(),
            [
                'budgetName'    =>'required',
                'budgetAmount'  =>'required',
            ],[],
            [
                'budgetName'    =>'Budget Name',
                'budgetAmount'  =>'Budget Amount',
            ]
        );

            DB::table('budgets')
                ->where('b_id', $b_id)
                ->update([
                    'b_name'           =>request('budgetName'),
                    'b_amount'         =>request('budgetAmount'),
                ]);

        session()->flash('insert_message','Record updated successfully');
        return redirect('all_budgets');
    }

    public function delete_budget($b_id)
    {
        $this->admins();
        DB::table('budgets')
            ->where('b_id',$b_id)
            ->delete();
        return back();
    }

}

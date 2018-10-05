<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expense;
use DB;
use Session;

class ExpenseController extends Controller
{
    public function add_expense(){
        $this->admins();
        return view('layouts.expenses.add_expense');
    }

    public function all_expenses(Request $request){
        $this->admins();
        $email=Session::get('email');
        $expenses = Expense::orderBy('e_id','asc')
            ->join('budgets','budgets.b_id','=','expenses.budget_id')
            ->join('users','users.id','budgets.user_id')
            ->where("email","=","$email")
            ->get();
        return view('layouts.expenses.all_expenses',['expenses'=>$expenses]);
    }

    public function add_new_expense(Request $request){
        $this->admins();
        $data = $this->validate(request(),
            [
                'expenseName'    =>'required',
                'expenseAmount'  =>'required',
                'budgetId'       =>'required',
                'e_flag'         =>'required',
            ],[],
            [
                'expenseName'    =>'Expense Name',
                'expenseAmount'  =>'Expense Amount',
                'budgetId'       =>'Expense Name',
                'e_flag'         =>'Expense Selection',
            ]
        );
        $email=Session::get('email');
        $i_b_name=DB::table('users')
            ->join('budgets','budgets.user_id','users.id')
            ->join('expenses','expenses.budget_id','budgets.b_id')
            ->where("email","=","$email")
            ->where("budget_id","=",request('budgetId'))
            ->where("e_name" ,"=",request('expenseName'))
            ->get();
        if(sizeof($i_b_name)>0){
            session()->flash('insert_message','Expense Name Already Exists');
            return redirect('add_expense');
        }else{
            $add                = new Expense();
            $add->e_name        = request('expenseName');
            $add->e_amount      = request('expenseAmount');
            $add->e_flag        = request('e_flag');
            $add->budget_id     = request('budgetId');
            $add->api_token     = 111;
            $add->save();
            session()->flash('insert_message','Record added successfully');
            return redirect('add_expense');
        }
    }

    public function edit_expense($e_id){
        $this->admins();
        return view('layouts.expenses.edit_expense');
    }

    public function update_expense(Request $request,$e_id) {
        $this->admins();
        $data = $this->validate(request(),
            [
                'expenseName'    =>'required',
                'expenseAmount'  =>'required',
                'budgetId'       =>'required',
                'e_flag'         =>'required',
            ],[],
            [
                'expenseName'    =>'Expense Name',
                'expenseAmount'  =>'Expense Amount',
                'budgetId'       =>'Expense Name',
                'e_flag'         =>'Expense Selection',
            ]
        );

        DB::table('expenses')
            ->where('e_id', $e_id)
            ->update([
                'e_name'           =>request('expenseName'),
                'e_amount'         =>request('expenseAmount'),
                'budget_id'        =>request('budgetId'),
                'e_flag'           =>request('e_flag'),
            ]);

        session()->flash('insert_message','Record updated successfully');
        return redirect('all_expenses');
    }

    public function delete_expense($e_id)
    {
        $this->admins();
        DB::table('expenses')
            ->where('e_id',$e_id)
            ->delete();
        return back();
    }

}

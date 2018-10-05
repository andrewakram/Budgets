<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use Session;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        return view("layouts.signin.login");
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function forget_password() {
        return view("layouts.signin.forgetpass");
    }

    public function newPassword(){
        return view("layouts.signin.newpass");
    }

    public function login_newPassword(){
        $data = $this->validate(request(),
            [
                'email'         =>'required|email',
                'password'      =>'required|min:6|max:20|regex:/^.*(?=.{1,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/|',
                'c_password'    =>'required|same:password',
            ],[],
            [
                'email'         =>'Email must be like [example@example.com] &',
                'password'      =>'Password must contains at least 6 characters (at least one of a-z or A-Z and numbers and special characters) & digits &',
                'c_password'    =>'Password confirmation',
            ]
        );
        if(md5($_POST['password']) == md5($_POST['c_password'])){
            $user=DB::table('users')->where("email","=",$_POST['email'])->get();
            if(sizeof($user) > 0){
                DB::table('users')
                    ->where('email',"=",$_POST['email'])
                    ->update([
                        'password' => md5($_POST['password'])
                    ]);
                session_start();
                Session::put('email',$_POST['email']);
                return redirect('/');
            }else{
                session()->flash('insert_message','Email Not Found, Try again. . .');
                return redirect('/register');
            }
        }else{
            session()->flash('insert_message','Password Confirmation Error, Try again. . .');
            return redirect('/newPassword');
        }
    }

    public function logout(Request $request) {
        Session::flush();
        $_POST = array();
        return redirect('/login');
    }

    public function loginPage(){
        return view("layouts.signin.login");
    }

    public function login(Request $request){
        $data = $this->validate(request(),
            [
                'email'     =>'required',
                'password'  =>'required',
            ],[],
            [
                'email'     =>'email',
                'password'  =>'password',
            ]
        );
        $userData = DB::table('users')
            ->where("email",    "=", $_POST['email'])
            ->where("password",    "=", md5($_POST['password']))
            ->get();
        if(sizeof($userData) < 1){
            session()->flash('insert_message','Wrong Email or Password');
            return redirect('login');
        }else{
            session_start();
            Session::put('email',$_POST['email']);
            return view('layouts.parts.content');
        }
    }

    public function registerPage(){
        return view("layouts.signin.register");
    }

    public function register(){
        $data = $this->validate(request(),
            [
                'name'             =>'required|min:6||max:20|regex:/(?=[a-zA-Z])+(?=[0-9])*/',
                'email'            =>'required|email|unique:users',
                'password'         =>'required|min:6|max:20|regex:/^.*(?=.{1,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/|',
                'confirm_password' =>'required|same:password',
            ],[],
            [
                'name'             =>'Name must contains characters &',
                'email'            =>'Email must be like [example@example.com] &',
                'password'         =>'Password must contains at least 6 characters (at least one of a-z or A-Z and numbers and special characters) & digits &',
                'confirm_password' =>'Password confirmation',
            ]
        );
        if(md5($_POST['password']) == md5($_POST['confirm_password'])){
            $userData = DB::table('users')
                ->where("email",    "=", $_POST['email'])
                ->get();
            if(sizeof($userData) < 1){
                $api_token=111;

                $add                = new User();
                $add->name          = $_POST['name'];
                $add->email         = $_POST['email'];
                $add->password      = md5($_POST['password']);
                $add->api_token     = $api_token;
                $add->save();

                session_start();
                Session::put('email',$_POST['email']);

                return redirect('/');
            }else{
                session()->flash('insert_message','Email alrady exists, Try another email. . .');
                return redirect('/register');
            }
        }
        else{
            session()->flash('insert_message','Wrong Password Confirmation. . .');
            return redirect('/register');
        }
    }

    public function searchResult(){
        $this->admins();

        $search_budget_name = DB::table('budgets')
            ->join('users','users.id','budgets.user_id')
            ->where('b_name', 'LIKE', '%'.request("s").'%')
            ->where('email' , '='   , Session::get('email'))
            ->select('b_name','b_amount','budgets.created_at')
            ->get();

        $search_expense_name = DB::table('expenses')
            ->join('budgets','budgets.b_id','expenses.budget_id')
            ->join('users','users.id','budgets.user_id')
            ->where('email' , '='   , Session::get('email'))
            ->where('e_name', 'LIKE', '%'.request("s").'%')
            ->select('e_name','e_amount','expenses.created_at','b_name')
            ->get();

        $search_increase_budget_name = DB::table('increase_budgets')
            ->join('budgets','budgets.b_id','increase_budgets.budget_id')
            ->join('users','users.id','budgets.user_id')
            ->where('email' , '='   , Session::get('email'))
            ->where('i_b_name', 'LIKE', '%'.request("s").'%')
            ->select('i_b_name','i_b_amount','increase_budgets.created_at','b_name')
            ->get();

        if(sizeof($search_budget_name)>0 OR
            sizeof($search_expense_name)>0 OR
            sizeof($search_increase_budget_name)>0){
            return view('layouts.parts.searchResult',[
                'search_budget_name'            =>$search_budget_name,
                'search_expense_name'           =>$search_expense_name,
                'search_increase_budget_name'   =>$search_increase_budget_name
            ]);
        }else {
            return view('layouts.parts.content');
        }
    }

}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use Session;

class AdminController extends Controller
{
    public function content(){
        $this->admins();
        return view('layouts.parts.content');
    }

    public function content2(){
        $this->admins();
        return view('layouts.parts.content2');
    }

    public function all_users(){
        $users = DB::table('users')->orderBy('id','asc')->get();
        return view('layouts.users.all_users',['users'=>$users]);
    }

    public function add_user(){
        $this->admins();
        return view('layouts.users.add_user');
    }

    public function add_new_user(Request $request){
        $this->admins();
        $data = $this->validate(request(),
            [
                'userName'       =>'required',
                'userEmail'      =>'required',
                'userPassword'   =>'required',
            ],[],
            [
                'userName'       =>'User Name',
                'userEmail'      =>'User Email',
                'userPassword'   =>'User Password',
            ]
        );
        $user=DB::table('users')->where("email","=",request('userEmail'))->get();
            if(sizeof($user) > 0){
                session()->flash('insert_message','Email Already Exists');

                return redirect('add_budget');
            }else{
                $add            = new User();
                $add->name      = request('userName');
                $add->email     = request('userEmail');
                $add->password  = md5(request('userPassword'));
                $add->api_token =111;
                $add->save();
                session()->flash('insert_message','Record added successfully');
                return redirect('add_user');
            }
    }

    public function edit_user($id){
        $this->admins();
        return view('layouts.users.edit_user');
    }

    public function update_user(Request $request,$id) {
        $this->admins();
        $data = $this->validate(request(),
            [
                'userName'       =>'required',
                'userEmail'      =>'required',
            ],[],
            [
                'userName'       =>'User Name',
                'userEmail'      =>'User Email',
            ]
        );
        $user=DB::table('users')->where("email","=",request('userEmail'))->get();
        if(sizeof($user) > 0){
            session()->flash('insert_message','Email Already Exists');

            return redirect('all_users');
        }else{
            DB::table('users')
                ->where('id', $id)
                ->update([
                    'name'          =>request('userName'),
                    'email'         =>request('userEmail'),
                ]);

            session()->flash('insert_message','Record updated successfully');
            return redirect('all_users');
        }
    }

    public function delete_user($id)
    {
        $this->admins();
        DB::table('users')
            ->where('id',$id)
            ->delete();
        return back();
    }

}

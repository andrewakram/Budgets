<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Clickatell\Rest;
use Clickatell\ClickatellException;

class LgoinController extends Controller
{
    use RegistersUsers;

    protected function registerUser()
    {
        $api_token = 111;
        $userData = DB::table('users')
            ->where("email", "=", $_GET['email'])
            ->get();
        if (sizeof($userData) < 1) {
            $userData = User::create([
                'name' => $_GET['name'],
                'email' => $_GET['email'],
                'password' => md5($_GET['password']),
                'api_token' => $api_token,
            ]);
            return response(['userData' => [$userData]]);
        } else {
            return response(['userData' => []]);
        }
    }

    protected function loginUser()
    {
        $userData = DB::table('users')
            ->where("email"     , "=", $_GET['email'])
            ->where("password"  , "=", md5($_GET['password']))
            ->get();
        return response(['userData' => $userData]);
    }

    protected function upateUserData()
    {
        if($_GET['newName'] != null) {
            DB::table('users')
                ->where("email", "=", $_GET['email'])
                ->update([
                    'name' => $_GET['newName'],
                ]);
        }
        if($_GET['newEmail'] != null) {
            $email=DB::table('users')
                ->where("email", "=", $_GET['newEmail'])
                ->get();
            if(sizeof($email) > 0){
                return response(['userData' => []]);
            }else{
                DB::table('users')
                    ->where("email", "=", $_GET['email'])
                    ->update([
                        'email' => $_GET['newEmail'],
                    ]);
            }
        }
        if($_GET['newPassword'] != null) {
            DB::table('users')
                ->where("email"     , "=", $_GET['email'])
                ->update([
                    'password'      =>md5($_GET['newPassword']),
                ]);
        }

        $userData = DB::table('users')
            ->where("email"     , "=", $_GET['email'] )
            ->select('name','email','password')
            ->get();
        if(sizeof($userData) < 1){
            $userData = DB::table('users')
                ->where("email"     , "=", $_GET['newEmail'])
                ->select('name','email','password')
                ->get();
        }
        return response(['userData' => $userData]);
    }
}
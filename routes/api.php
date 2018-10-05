<?php

use Illuminate\Http\Request;
use App\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {

});

//login user
Route::get('/loginUser','Api\LgoinController@loginUser');

//register user
Route::get('/registerUser','Api\LgoinController@registerUser');

//sed message to an email to reset password
Route::get('/MessageResetPasswordSent', function(){
    $m=Mail::to($_GET['email'])->send(new App\mail\ChangePassword());
        return "success";
});

//updaet user data
Route::get('/upateUserData','Api\LgoinController@upateUserData');
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
//get all budgets for a user
Route::get('/all_budgets','Api\BudgetController@all_budgets');

//add budget for a user
Route::get('/add_budget','Api\BudgetController@add_budget');

//delete budget for a user
Route::get('/delete_budget','Api\BudgetController@delete_budget');

//search_in_budgets(name) for a user
Route::get('/search_in_budgets','Api\BudgetController@search_in_budgets');
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
//get all expenses for a budget user
Route::get('/all_expenses','Api\ExpenseController@all_expenses');

//add expense for a user
Route::get('/add_expense','Api\ExpenseController@add_expense');

//delete expense for a user
Route::get('/delete_expense','Api\ExpenseController@delete_expense');

//expense_flag_reverse
Route::get('/expense_flag_reverse','Api\ExpenseController@expense_flag_reverse');
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
//get all increase_budgets for a budget user
Route::get('/all_increase_budgets','Api\Increase_budgetController@all_increase_budgets');

//add increase_budget for a user
Route::get('/add_increase_budget','Api\Increase_budgetController@add_increase_budget');

//delete increase_budget for a user
Route::get('/delete_increase_budget','Api\Increase_budgetController@delete_increase_budget');

//increase_budget_flag_reverse
Route::get('/increase_budget_flag_reverse','Api\Increase_budgetController@increase_budget_flag_reverse');
////////////////////////////////////////////////////////////////////////
//display all_budget_data (expenses & increase_budgets) ordered by date.
Route::get('/all_budget_data','Api\BudgetController@all_budget_data');

////////////////////////////////////////////////////////////////////////
///calc
Route::get('/calc','Controller@calc');
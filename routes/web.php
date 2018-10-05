<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


//register & login pages
Route::get('/register', 'HomeController@registerPage');
Route::get('/login', 'HomeController@loginPage');

//register & login functions
Route::post('/register', 'HomeController@register');
Route::post('/login', 'HomeController@login');

//for redirect to forget_password page
Route::get('/forget_password', 'HomeController@forget_password');

//for redirect to new_password page
Route::get('/newPassword', 'HomeController@newPassword');

//login with new password
Route::post('/login_newPassword', 'HomeController@login_newPassword');

//send message reset password
Route::post('/MessageResetPasswordSent', function(){
    Mail::to(request("sendEmail"))->send(new App\mail\ChangePassword());
    session()->flash('insert_message','Message sent succssfully to your inbox');
    return redirect('/forget_password');
});

//logout
Route::get('/logout', 'HomeController@logout');

//go to index content page
Route::get('/',"AdminController@content");

//go to index2 content page
Route::get('/2',"AdminController@content2");

//go to search result page
Route::get('/searchResult',"HomeController@searchResult");

///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
//go to all_users page
Route::get('/all_users',"AdminController@all_users");

//go to add_user page
Route::get('/add_user',"AdminController@add_user");

//go to add_new_user
Route::post('/add_new_user',"AdminController@add_new_user");

//go to edit_user page
Route::get('/edit_user/{id}',"AdminController@edit_user");

//go to update_user
Route::post('/update_user/{id}',"AdminController@update_user");

//go to delete_budget
Route::get('/delete_user/{id}',"AdminController@delete_user");


///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
//go to all_budgets page
Route::get('/all_budgets',"BudgetController@all_budgets");

//go to add_budget page
Route::get('/add_budget',"BudgetController@add_budget");

//go to add_new_budget
Route::post('/add_new_budget',"BudgetController@add_new_budget");

//go to edit_budget page
Route::get('/edit_budget/{b_id}',"BudgetController@edit_budget");

//go to update_budget
Route::post('/update_budget/{b_id}',"BudgetController@update_budget");

//go to delete_budget
Route::get('/delete_budget/{b_id}',"BudgetController@delete_budget");

///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
//go to all_increase_budgets page
Route::get('/all_increase_budgets',"Increase_budgetController@all_increase_budgets");

//go to add_increase_budget page
Route::get('/add_increase_budget',"Increase_budgetController@add_increase_budget");

//go to add_new_increase_budget
Route::post('/add_new_increase_budget',"Increase_budgetController@add_new_increase_budget");

//go to edit_increase_budget page
Route::get('/edit_increase_budgets/{increase_b_id}',"Increase_budgetController@edit_increase_budgets");

//go to update_increase_budget
Route::post('/update_increase_budget/{increase_b_id}',"Increase_budgetController@update_increase_budget");

//go to delete_increase_budget
Route::get('/delete_increase_budget/{increase_b_id}',"Increase_budgetController@delete_increase_budget");

///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
//go to all_expenses page
Route::get('/all_expenses',"ExpenseController@all_expenses");

//go to add_expense page
Route::get('/add_expense',"ExpenseController@add_expense");

//go to add_new_expense
Route::post('/add_new_expense',"ExpenseController@add_new_expense");

//go to edit_expense page
Route::get('/edit_expense/{e_id}',"ExpenseController@edit_expense");

//go to update_expense
Route::post('/update_expense/{e_id}',"ExpenseController@update_expense");

//go to delete_expense
Route::get('/delete_expense/{e_id}',"ExpenseController@delete_expense");



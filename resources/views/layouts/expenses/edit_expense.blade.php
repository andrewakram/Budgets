@extends('index')
@section('edit_expense')


    <?php
    $x=Route::input('e_id');
    $expenses=DB::table('expenses')
        ->where('e_id', '=' ,"$x")->get();

    ?>

    @foreach ($expenses as $e)


        <div class="content-wrapper">
            <section class="content content-header">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"><b>Edit Expense: </b><b style="color:#337ab7;"># {{ Route::input('e_id') }}</b></h3>


                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif


                                @if(session()->has('insert_message'))
                                    <hr>
                                    <div class="alert alert-success">
                                        {{session()->get('insert_message')}}
                                    </div>
                                    <hr>
                                @endif


                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                            <form role="form" method="post" action="{{url('/update_expense/'.$e->e_id)}}" >
                                {{csrf_field()}}


                                <?php
                                $budgets=DB::table('budgets')
                                    ->join('users','users.id','budgets.user_id')
                                    ->where('email','=',Session::get('email'))
                                    ->get();
                                ?>

                                <div class="col-md-3"></div>
                                <div class="col-md-9 form-group">
                                    <label>Budget Name</label>
                                    <select name="budgetId" class="form-control select2" style="width: 100%;">
                                        <option value="">Choose your budget</option>
                                        @foreach($budgets as $b2)
                                            <option value="{{$b2->b_id}}" {{$b2->b_id == $e->budget_id?"selected":""}}>{{$b2->b_name}}</option>
                                        @endforeach
                                    </select>
                                </div>



                                <div class="box-body">
                                    <div class="form-group">
                                        <label>Expense Name</label>
                                        <input name="expenseName" value="{{$e->e_name}}" type="text" class="form-control" placeholder="Enter Expense Name">
                                    </div>
                                    <div class="form-group">
                                        <label>Expense Amount</label>
                                        <input name="expenseAmount" value="{{$e->e_amount}}" class="form-control" placeholder="Enter Expense Amount">
                                    </div>
                                    <div class="form-group">
                                        <label>Selected / Unselected</label>
                                        <select name="e_flag" class="form-control select2" style="width: 100%;">
                                            <option value="true" {{$e->e_flag == "true" ? "selected":""}}>Selected</option>
                                            <option value="false" {{$e->e_flag == "false" ? "selected":""}}>Unselected</option>
                                        </select>
                                    </div>


                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.box -->
                    </div>
                </div>
            </section>
        </div>


    @endforeach


@endsection
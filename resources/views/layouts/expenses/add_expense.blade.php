@extends('index')
@section('add_expense')

    <div class="content-wrapper">
        <section class="content content-header">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary col-md-6">
                        <h3 class="box-title"><b>Add New Expense</b></h3>
                        <div class="box-header with-border">






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
                        <form role="form" method="post" action="{{url('/add_new_expense')}}" >
                            {{csrf_field()}}


                            <?php
                            $email=Session::get('email');
                            $budgets=DB::table('budgets')
                                ->join('users','users.id','budgets.user_id')
                                ->where("email",'=',"$email")
                                ->get();
                            ?>


                            <div class="col-md-3">
                            </div>
                            <div class="col-md-9 form-group">
                                <label>Budget Name</label>
                                <select name="budgetId" class="form-control select2" style="width: 100%;">
                                        <option value="">Choose your budget</option>
                                    @foreach($budgets as $b)
                                        <option value="{{$b->b_id}}">{{$b->b_name}}</option>
                                    @endforeach
                                </select>
                            </div>



                            <div class="box-body">
                                <div class="form-group">
                                    <label>Expense Name</label>
                                    <input name="expenseName" type="text" class="form-control" placeholder="Enter Expense Name">
                                </div>
                                <div class="form-group">
                                    <label>Expense Amount</label>
                                    <input name="expenseAmount" class="form-control" placeholder="Enter Expense Amount">
                                </div>
                                <div class="form-group">
                                    <label>Selected / Unselected</label>
                                    <select name="e_flag" class="form-control select2" style="width: 100%;">
                                        <option value="true" selected>Selected</option>
                                        <option value="false">Unselected</option>
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


@endsection
@extends('index')
@section('edit_increase_budget')


    <?php
    $x=Route::input('increase_b_id');
    $increase_budget=DB::table('increase_budgets')
        ->where('increase_b_id', '=' ,"$x")->get();

    ?>

    @foreach ($increase_budget as $i)


        <div class="content-wrapper">
            <section class="content content-header">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"><b>Edit Increase Budget: </b><b style="color:#337ab7;"># {{ Route::input('increase_b_id') }}</b></h3>


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
                            <form role="form" method="post" action="{{url('/update_increase_budget/'.$i->increase_b_id)}}" >
                                {{csrf_field()}}


                                <?php
                                $budgets=DB::table('budgets')
                                    ->join('increase_budgets','increase_budgets.budget_id','budgets.b_id')
                                    ->join('users','users.id','budgets.user_id')
                                    ->where('email','=',Session::get('email'))
                                    ->get();
                                ?>

                                <div class="col-md-3"></div>
                                <div class="col-md-9 form-group">
                                    <label>Budget Name</label>
                                    <select name="budgetId" class="form-control select2" style="width: 100%;">
                                        <option value="">Choose your budget</option>
                                        @foreach($budgets as $bu)
                                            <option value="{{$bu->b_id}}" {{$bu->b_id == $i->budget_id?"selected":""}}>{{$bu->b_name}}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="box-body">
                                    <div class="form-group">
                                        <label>Increase Budget Name</label>
                                        <input name="increaseBudgetName" value="{{$i->i_b_name}}" type="text" class="form-control" placeholder="Enter Increase Budget Name">
                                    </div>
                                    <div class="form-group">
                                        <label>Increase Budget Amount</label>
                                        <input name="increaseBudgetAmount" value="{{$i->i_b_amount}}" class="form-control" placeholder="Enter Increase Budget Amount">
                                    </div>
                                    <div class="form-group">
                                        <label>Select / Unselect</label>
                                        <select name="i_b_flag" class="form-control select2" style="width: 100%;">
                                            <option value="true" {{$i->i_b_flag == "true"?"selected":""}}>Selected</option>
                                            <option value="false" {{$i->i_b_flag == "false"?"selected":""}}>Unselected</option>
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
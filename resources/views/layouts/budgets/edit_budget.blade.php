@extends('index')
@section('edit_budget')


    <?php
    $x=Route::input('b_id');
    $budget=DB::table('budgets')
        ->where('b_id', '=' ,"$x")->get();

    ?>

    @foreach ($budget as $b)


    <div class="content-wrapper">
        <section class="content content-header">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Edit Budget: </b><b style="color:#337ab7;"># {{ Route::input('b_id') }}</b></h3>


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
                        <form role="form" method="post" action="{{url('/update_budget/'.$b->b_id)}}" >
                            {{csrf_field()}}
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Budget Name</label>
                                    <input name="budgetName" value="{{$b->b_name}}" type="text" class="form-control" placeholder="Enter Budget Name">
                                </div>
                                <div class="form-group">
                                    <label>Budget Amount</label>
                                    <input name="budgetAmount" value="{{$b->b_amount}}" class="form-control" placeholder="Enter Budget Amount">
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
@extends('index')
@section('add_increase_budget')

    <div class="content-wrapper">
        <section class="content content-header">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Add New Increase Budget</b></h3>


    @if($errors->has('budgetId') or
    $errors->has('increaseBudgetName') or
    $errors->has('increaseBudgeAmount') or
    $errors->has('i_b_flag'))
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
<form role="form" method="post" action="{{url('/add_new_increase_budget')}}" >
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
            <option value="" selected>Choose your budget</option>
            @foreach($budgets as $b)
                <option value="{{$b->b_id}}">{{$b->b_name}}</option>
            @endforeach
        </select>
    </div>



    <div class="box-body">
        <div class="form-group">
            <label>Increase Budge Name</label>
            <input name="increaseBudgetName" type="text" class="form-control" placeholder="Enter Increase Budget Name">
        </div>
        <div class="form-group">
            <label>Increase Budget Amount</label>
            <input name="increaseBudgeAmount"  class="form-control" placeholder="Enter Increase Budget Amount">
        </div>
        <div class="form-group">
            <label>Select / Unselect</label>
            <select name="i_b_flag" class="form-control select2" style="width: 100%;">
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
@extends('index')
@section('add_budget')

<div class="content-wrapper">
    <section class="content content-header">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><b>Add New Budget</b></h3>


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
                    <form role="form" method="post" action="{{url('/add_new_budget')}}" >
                        {{csrf_field()}}
                        <div class="box-body">
                            <div class="form-group">
                                <label>Budget Name</label>
                                <input name="budgetName" type="text" class="form-control" placeholder="Enter Budget Name">
                            </div>
                            <div class="form-group">
                                <label>Budget Amount</label>
                                <input name="budgetAmount"  class="form-control" placeholder="Enter Budget Amount">
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
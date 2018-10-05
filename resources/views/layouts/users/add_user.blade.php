@extends('index')
@section('add_user')

    <div class="content-wrapper">
        <section class="content content-header">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Add New User</b></h3>


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
                        <form role="form" method="post" action="{{url('/add_new_user')}}" >
                            {{csrf_field()}}
                            <div class="box-body">
                                <div class="form-group">
                                    <label>User Name</label>
                                    <input name="userName" type="text" class="form-control" placeholder="Enter User Name">
                                </div>
                                <div class="form-group">
                                    <label>User Email</label>
                                    <input name="userEmail"  class="form-control" placeholder="Enter User Email">
                                </div>
                                <div class="form-group">
                                    <label>User Password</label>
                                    <input name="userPassword"  class="form-control" placeholder="Enter User Password">
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
@extends('index')
@section('edit_user')


    <?php
    $x=Route::input('id');
    $user=DB::table('users')
        ->where('id', '=' ,"$x")->get();

    ?>

    @foreach ($user as $u)


        <div class="content-wrapper">
            <section class="content content-header">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"><b>Edit User: </b><b style="color:#337ab7;"># {{ Route::input('id') }}</b></h3>


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
                            <form role="form" method="post" action="{{url('/update_user/'.$u->id)}}" >
                                {{csrf_field()}}
                                <div class="box-body">
                                    <div class="form-group">
                                        <label>User Name</label>
                                        <input name="userName" value="{{$u->name}}" type="text" class="form-control" placeholder="Enter User Name">
                                    </div>
                                    <div class="form-group">
                                        <label>User Email</label>
                                        <input name="userEmail" value="{{$u->email}}" class="form-control" placeholder="Enter User Email">
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
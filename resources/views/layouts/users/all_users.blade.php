@extends('index')
@section('all_users')


    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content content-header">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"><b>All Users</b></h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User Name</th>
                                    <th>User Email</th>
                                    <th>Date Created</th>
                                    <th>Date Updated</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($users as $user)
                                    <tr>
                                        <th>{{$user->id}}</th>
                                        <th><a href="#">{{$user->name}}</a></th>
                                        <th>{{$user->email}}</th>
                                        <th>{{$user->created_at}}</th>
                                        <th>{{$user->updated_at}}</th>
                                        <th><a href="{{URL::to('/edit_user/'.$user->id)}}" class="btn btn-info" id="">Edit</a></th>
                                        <th><a href="{{URL::to('/delete_user/'.$user->id)}}" class="btn btn-danger" id="deletes">Delete</a></th>

                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>User Name</th>
                                    <th>User Email</th>
                                    <th>Date Created</th>
                                    <th>Date Updated</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </section>
    </div>


@endsection
@extends('index')
@section('all_budgets')


<div class="content-wrapper">
    <!-- Main content -->
    <section class="content content-header">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><b>All Budgets</b></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Budget Name</th>
                                <th>Budget Amount</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($budgets as $budget)
                                <tr>
                                    <th><a>{{$budget->b_id}}</a></th>
                                    <th><a>{{$budget->b_name}}</a></th>
                                    <th><a>{{$budget->b_amount}}</a></th>
                                    <th><a href="{{URL::to('/edit_budget/'.$budget->b_id)}}" class="btn btn-info" id="">Edit</a></th>
                                    <th><a href="{{URL::to('/delete_budget/'.$budget->b_id)}}" class="btn btn-danger" id="deletes">Delete</a></th>

                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Budget Name</th>
                                <th>Budget Amount</th>
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
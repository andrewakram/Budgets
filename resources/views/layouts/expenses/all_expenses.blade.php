@extends('index')
@section('all_expenses')


    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content content-header">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"><b>All Expenses</b></h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Expense Name</th>
                                    <th>Expense Amount</th>
                                    <th>Selected / Unselected</th>
                                    <th>Budget Name</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($expenses as $expense)
                                    <tr>
                                        <th><a>{{$expense->e_id}}</a></th>
                                        <th><a>{{$expense->e_name}}</a></th>
                                        <th><a>{{$expense->e_amount}}</a></th>
                                        <th><a>{{$expense->e_flag == "true"?"selected":"unselected"}}</a></th>
                                        <th><a>{{$expense->b_name}}</a></th>
                                        <th><a href="{{URL::to('/edit_expense/'.$expense->e_id)}}" class="btn btn-info" id="">Edit</a></th>
                                        <th><a href="{{URL::to('/delete_expense/'.$expense->e_id)}}" class="btn btn-danger" id="deletes">Delete</a></th>

                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Expense Name</th>
                                    <th>Expense Amount</th>
                                    <th>Selected / Unselected</th>
                                    <th>Budget Name</th>
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
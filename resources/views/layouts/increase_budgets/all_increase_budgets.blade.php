@extends('index')
@section('all_increase_budgets')


    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content content-header">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"><b>All Increase Budgets</b></h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Increase Budget Name</th>
                                    <th>Increase Budget Amount</th>
                                    <th>Select / Unselect</th>
                                    <th>Budget Name</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($increase_budgets as $increase_budget)
                                    <tr>
                                        <th><a>{{$increase_budget->increase_b_id}}</a></th>
                                        <th><a>{{$increase_budget->i_b_name}}</a></th>
                                        <th><a>{{$increase_budget->i_b_amount}}</a></th>
                                        <th><a>{{$increase_budget->i_b_flag == "true"?"selected":"unselected"}}</a></th>
                                        <th><a>{{$increase_budget->b_name}}</a></th>
                                        <th><a href="{{URL::to('/edit_increase_budgets/'.$increase_budget->increase_b_id)}}" class="btn btn-info" id="">Edit</a></th>
                                        <th><a href="{{URL::to('/delete_increase_budget/'.$increase_budget->increase_b_id)}}" class="btn btn-danger" id="deletes">Delete</a></th>

                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Increase Budget Name</th>
                                    <th>Increase Budget Amount</th>
                                    <th>Select / Unselect</th>
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
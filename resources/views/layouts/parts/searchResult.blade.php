@extends('index')
@section('searchResult')


    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content content-header">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title"><b>Search Result Data</b></h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr><b><a> > > >Budgets > > ></a></b></tr>
                                <tr>
                                    <th>Budget Name</th>
                                    <th>Budget Amount</th>
                                    <th>Budget Date Created</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($search_budget_name as $b)
                                    <tr>
                                        <th><a>{{$b->b_name}}</a></th>
                                        <th><a>{{$b->b_amount}}</a></th>
                                        <th><a>{{$b->created_at}}</a></th>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>

                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr><b><a> > > >Expenses > > ></a></b></tr>
                                <tr>
                                    <th>Expenses Name</th>
                                    <th>Expenses Amount</th>
                                    <th>Expenses Date Created</th>
                                    <th>Budget Name</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($search_expense_name as $ex)
                                    <tr>
                                        <th><a>{{$ex->e_name}}</a></th>
                                        <th><a>{{$ex->e_amount}}</a></th>
                                        <th><a>{{$ex->created_at}}</a></th>
                                        <th><a>{{$ex->b_name}}</a></th>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>

                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr><b><a> > > >Incease Budgets > > ></a></b></tr>
                                <tr>
                                    <th>Incease Budgets Name</th>
                                    <th>Incease Budgets Amount</th>
                                    <th>Incease Budgets Date Created</th>
                                    <th>Budget Name</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($search_increase_budget_name as $i_b)
                                    <tr>
                                        <th><a>{{$i_b->i_b_name}}</a></th>
                                        <th><a>{{$i_b->i_b_amount}}</a></th>
                                        <th><a>{{$i_b->created_at}}</a></th>
                                        <th><a>{{$i_b->b_name}}</a></th>
                                    </tr>
                                @endforeach

                                </tbody>
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
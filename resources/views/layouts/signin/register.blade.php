<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Budget | Register</title>
    <style>
        body{
            background-color: #525252;
        }
        .centered-form{
            margin-top: 60px;
        }

        .centered-form .panel{
            background: rgba(255, 255, 255, 0.8);
            box-shadow: rgba(0, 0, 0, 0.3) 20px 20px 20px;
        }
    </style>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->
</head>
<body>

<br><br>
<div class="container">

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

    <div class="row centered-form">
        <div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Please, Type your data here <small>It's free!</small></h3>
                </div>
                <div class="panel-body">
                    <form role="form" method="post" action="{{url('/register')}}">
                    {{csrf_field()}}
                        <div class="form-group">
                            <input type="text" name="name" required id="name" class="form-control input-sm" placeholder="Name">
                        </div>

                        <div class="form-group">
                            <input type="email" name="email" required id="email" class="form-control input-sm" placeholder="Email Address">
                        </div>

                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input type="password" name="password" required id="password" class="form-control input-sm" placeholder="Password">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input type="password" name="confirm_password" required id="password_confirmation" class="form-control input-sm" placeholder="Confirm Password">
                                </div>
                            </div>
                        </div>

                        <input type="submit" value="Register" class="btn btn-info btn-block">
                        <br>
                        <a href="{{URL::to('/login')}}">Back</a>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
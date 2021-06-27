<!DOCTYPE html>
<html lang="en">

<head>


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="uS32J7T7RfmDVKHv6zr7m1MTk6e0kPlsCFJ9AsGk">


    <title>{{env('APP_NAME')}}</title>


    <link rel="stylesheet" href="vendor/icheck-bootstrap/icheck-bootstrap.min.css">


    <link rel="stylesheet" href="vendor/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="vendor/overlayScrollbars/css/OverlayScrollbars.min.css">


    <link rel="stylesheet" href="vendor/adminlte/dist/css/adminlte.min.css">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">


</head>

<body class="login-page">


<div class="login-box">


    <div class="login-logo">
        <a href="home">
            <b>{{env('APP_NAME')}}</b>
        </a>
    </div>
    <div class="card card-outline card-primary">
        <div class="card-header ">
            <h3 class="card-title float-none text-center">Register a new account</h3>
        </div>
        <div class="card-body login-card-body ">
            <form action="{{route('register')}}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" name="name" class="form-control "
                           value="" placeholder="Name" autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user "></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="surname" class="form-control "
                           value="" placeholder="Surname" autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control "
                           value="" placeholder="Email" autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope "></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control "
                           placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock "></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="vat" class="form-control "
                           placeholder="VAT number">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-wallet"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-5">
                        <button type=submit class="btn btn-block btn-flat btn-primary">
                            <span class="fas fa-sign-in-alt"></span>
                            Register
                        </button>
                    </div>
                </div>

            </form>
        </div>
        <div class="card-footer ">
            <p class="my-0">
                <a href="{{route('login.show')}}">Back to login</a>
            </p>
        </div>
    </div>
</div>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="vendor/adminlte/dist/js/adminlte.min.js"></script>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <style>
     body {width: 100%; height: 100%;}

        .logo  {background-image: url('/images/pandora-icon-32.png');
                    background-position: 25px center;
                    background-repeat: no-repeat;
                    font-family: Lato, Helvetica Neue, Helvetica; font-weight: bolder;
                     height: 50px; font-size: 26px;
                     margin: 15px 0 15px 0;

                    }
        .spanLogo {padding-left: 50px; color: #00BCD4; font-size: 1.4em;}

        .bg-gris {background-color: rgb(232,232,232)}
    </style>

</head>

<body>
<div class="col-sm-12 bg-gris">
<a class="col-sm-12 navbar-brand logo" href="/" ><span class="spanLogo">Pandora Soft</span></a>
</div>
<div class="container-fluid">
            @yield('content')
</div>
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>


</body>

</html>
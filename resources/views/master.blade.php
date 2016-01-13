<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/metisMenu.min.css">
    <link rel="stylesheet" href="/css/sb-admin-2.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/custom.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <link rel=”apple-touch-icon” href=”/logo-panatel-144x144.png”/>
    <link rel=”apple-touch-icon-precomposed” href=”/logo-panatel-144x144.png”/>
    <link rel="shortcut icon" href="/favicon.ico" /> 

    @yield('css')
    <style>

        .logo  {background-image: url('/images/pandora-icon-32.png');
                    background-position: 15px center;
                    background-repeat: no-repeat;
                    font-family: Lato, Helvetica Neue, Helvetica; font-weight: bolder;
                    width: 250px; height: 50px;text-align: right; font-size: 26px; margin: 10 0 0 15px;
                    }
        .spanLogo {margin-righ: 50px; color: #00BCD4}
    </style>
</head>

<body>

    <div id="wrapper">


        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

        @include('partials.nav')
        </nav>

        <div id="page-wrapper">
           <div class="container-fluid">
            @include('partials.flash')
            @yield('content')


           </div>


        </div>

        @yield('modal')
    </div>

    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/metisMenu.min.js"></script>
    <script src="/js/sb-admin-2.js"></script>

    <script>
        $( document ).ready(function() {
            $('div.alert').not('.alert-important').delay(2000).slideUp(250);
        }); // Fin del document.ready()
    </script>
    @yield('scripts')
</body>

</html>
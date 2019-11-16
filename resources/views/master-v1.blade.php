<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
<!-- Latest compiled and minified Bootsrap CSS -->
       <link rel="stylesheet" href="/css/bootstrap.css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Helvetica Neue, Helvetica';
            }
            h1, h2, h3 {
                font-family: 'Lato';
            }
            .container {
                text-align: left;
                display: table-cell;
                vertical-align: top;
            }

            .content {
                /*text-align: center;
                display: inline-block */;
            }

            .title {
                font-size: 96px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                @yield('content')
            </div>
            <div class="footer">
                @yield('footer')
            </div>
        </div>
    </body>
</html>

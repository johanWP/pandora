<!DOCTYPE hmtl>
<html lang="es-AR">
<head>
    <meta CHARSET="UTF-8">
    <title>Movimiento Rechazado</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
</head>
<body>

<div class="container-fluid">

    <div class="row">

        <div class="col-sm-10">
            <p class="h4">Hola!</p>
            <p>Lamentablemente uno de tus movimientos de equipos o materiales ha sido rechazado,
            a continuación puedes ver los detalles:</p>
        </div>

    </div>
    <div class="row">
        <div class="col-sm-10">
            <div class="table-responsive">
                <table class="table table-striped">
                    <tr>
                      <td>Fecha del movimiento:</td>
                      <td>{{ $created_at }}</td>
                    </tr>
                    <tr>
                      <td>Ticket</td>
                      <td>{{ $ticket }}</td>
                    </tr>
                    <tr>
                      <td>Almacén de origen</td>
                      <td>{{ $origen }}</td>
                    </tr>
                    <tr>
                      <td>Almacén de destino</td>
                      <td>{{ $destino }}</td>
                    </tr>
                    <tr>
                      <td>Cantidad</td>
                      <td>{{ $cantidad }}</td>
                    </tr>
                    <tr>
                      <td>Artículo</td>
                      <td>{{ $article }}</td>
                    </tr>
                    <tr>
                      <td>Nota:</td>
                      <td>{{ $nota }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</div>
</body>
</html>
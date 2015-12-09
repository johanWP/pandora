<!DOCTYPE hmtl>
<html lang="es-AR">
<head>
    <meta CHARSET="UTF-8">
    <title>Contacto</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
</head>
<body>
    <table class="table table-responsive">
      <tr>
        <td><b>Nombre:</b></td>
        <td>{!! $name !!}</td>
      </tr>
      <tr>
        <td><b>Email:</b></td>
        <td>{!! $email !!}</td>
      </tr>
      <tr>
        <td><b>Asunto</b></td>
        <td>{!! $subject !!}</td>
      </tr>
      <tr>
        <td><b>Mensaje:</b></td>
        <td>{!! $text !!}</td>
      </tr>
    </table>
</body>
</html>
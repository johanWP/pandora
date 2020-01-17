<?php
return array(
    "driver" => "smtp",
    "host" => "smtpout.secureserver.net",
    "port" => 465,
    "from" => array(
        "address" => "inventario@panatelcomm.com",
        "name" => "Panatel: Sistema de Inventario"
    ),
    "username" => "inventario@panatelcomm.com",
    "password" => "wwwinventario",
    "sendmail" => "/usr/sbin/sendmail -bs",
    "pretend" => false,
    "encryption" => env('MAIL_ENCRYPTION', 'ssl'),
);

<?php
return array(
    "driver" => "smtp",
    "host" => "smtpout.secureserver.net",
    "port" => 465,
    "from" => array(
        "address" => "inventario@panatelcomm.com",
        "name" => "Panatel Communications"
    ),
    "username" => "inventario@panatelcomm.com",
    "password" => "wwwinventario",
    "sendmail" => "/usr/sbin/sendmail -bs",
    "encryption" => "ssl",
    "pretend" => false
);


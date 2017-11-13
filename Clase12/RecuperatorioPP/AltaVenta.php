<?php

include "Usuario.php";
include "Helados.php";


Helado::AltaVenta($_POST["email"],$_POST["sabor"],$_POST["tipo"],$_POST["cantidad"]);



?>
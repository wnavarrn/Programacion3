<?php

include "Usuario.php";
include "Helados.php";


Helado::AltaConImagen($_POST["email"],$_POST["sabor"],$_POST["tipo"],$_POST["cantidad"]);



?>
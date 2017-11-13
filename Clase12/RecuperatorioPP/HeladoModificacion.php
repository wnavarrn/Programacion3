<?php

include "Usuario.php";
include "Helados.php";


$helado=new Helado($_POST["sabor"],$_POST["tipo"],$_POST["precio"],$_POST["cantidad"]);

Helado::ModificarHelado($helado);





?>
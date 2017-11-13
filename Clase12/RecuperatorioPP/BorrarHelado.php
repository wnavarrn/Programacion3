<?php

include "Clases/Usuario.php";
include "Clases/Helados.php";


$helado=new Helado($_POST["sabor"],$_POST["tipo"],$_POST["precio"],$_POST["cantidad"]);

Helado::BorrarHelado($helado);





?>
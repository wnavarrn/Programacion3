<?php

include "Clases/Helados.php";


$sabor=$_GET['sabor'];
$tipo= $_GET['tipo'];
$precio= $_GET['precio'];
$cantidad= $_GET['cantidad'];

$helado=new Helado($sabor,$tipo,$precio,$cantidad);

Helado::AltaHelado($helado);



?>
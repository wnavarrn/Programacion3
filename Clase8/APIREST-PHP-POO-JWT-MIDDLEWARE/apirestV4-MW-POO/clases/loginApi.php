<?php
require_once 'login.php';
require_once 'IApiUsable.php';

class loginApi extends login implements IApiUsable
{
 	public function TraerUno($request, $response, $args) {
         
        $nombre=$args['nombre'];
        $tipo=$args['tipo'];

    	$elUser=login::TraerUnUsuario($nombre,$tipo);
     	$newResponse = $response->withJson($elUser, 200);  
    	return $newResponse;
    }
}
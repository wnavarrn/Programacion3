<?php


//require '/clases/loginApi.php';
require 'login.php';

class MWparaAutentificar
{
 /**
   * @api {any} /MWparaAutenticar/  Verificar Usuario
   * @apiVersion 0.1.0
   * @apiName VerificarUsuario
   * @apiGroup MIDDLEWARE
   * @apiDescription  Por medio de este MiddleWare verifico las credeciales antes de ingresar al correspondiente metodo 
   *
   * @apiParam {ServerRequestInterface} request  El objeto REQUEST.
 * @apiParam {ResponseInterface} response El objeto RESPONSE.
 * @apiParam {Callable} next  The next middleware callable.
   *
   * @apiExample Como usarlo:
   *    ->add(\MWparaAutenticar::class . ':VerificarUsuario')
   */
	public function VerificarUsuario($request, $response, $next) {
         
		  if($request->isGet())
		  {
		     $response->getBody()->write('<p>NO necesita credenciales para los get </p>');
		     $response = $next($request, $response);
		  }
		  else
		  {
		    $response->getBody()->write('<p>verifico credenciales</p>');
		    $ArrayDeParametros = $request->getParsedBody();
		    $nombre=$ArrayDeParametros['nombre'];
		    $tipo=$ArrayDeParametros['tipo'];
		    if($tipo=="administrador")
		    {
		      $response->getBody()->write("<h3>Bienvenido $nombre </h3>");
		      $response = $next($request, $response);
		    }
		    else
		    {
		      $response->getBody()->write('<p>no tenes habilitado el ingreso</p>');
		    }  
		  }
		  $response->getBody()->write('<p>vuelvo del verificador de credenciales</p>');
		  return $response;   
	}

	public function ValidaUsuarioDB($request, $response, $next) {
		
		if($request->isGet())
		{
				$response->getBody()->write('<p>NO necesita credenciales para los get 111111111 </p>');

				$response = $next($request, $response);
		}
		else
		{
			$response->getBody()->write('<p>verifico credenciales</p>');

			$ArrayDeParametros = $request->getParsedBody();

			$nombre=$ArrayDeParametros['nombre'];

			$password=$ArrayDeParametros['password'];

			$elUser=login::TraerUnUsuario($nombre,$password);

			$perfil = strtolower($elUser->Tipo);
			var_dump($perfil);

			if($perfil =="administrador")
			{
				
				$response->getBody()->write("<h3>Bienvenido $nombre </h3>");
				
				$response = $next($request, $response);
			}
			else
			{
				$response->getBody()->write('<p>no tenes habilitado el ingreso</p>');
			}

		}
		$response->getBody()->write('<p>vuelvo del verificador de credenciales</p>');
		return $response;   
		}

	
	
	public function GetIp($request, $response, $next)
	{		
	/*	if($_SERVER["HTTP_X_FORWARDED_FOR"]) {*/
				// El usuario navega a través de un proxy
				$ip_proxy = $_SERVER["REMOTE_ADDR"]; // ip proxy
				//dispositivo
				//version navegador
				//sistema operativo- pais - 
				/*$ip_maquina = $_SERVER["HTTP_X_FORWARDED_FOR"]; // ip de la maquina
 			} else {
				$ip_maquina = $_SERVER["REMOTE_ADDR"]; // No se navega por proxy
			 }*/
	//var_dump($_SERVER);
		echo($ip_proxy);
		$response->getBody()->write('<p>vuelvo del verificador de credenciales</p>  '.$ip_proxy);
		return $response;   
	}

}
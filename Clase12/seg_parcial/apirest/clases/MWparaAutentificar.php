<?php

include_once "autentificadorJWT.php";
//require '/clases/loginApi.php';
//require 'login.php';

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

   //Verfico el token del usuario que hace la petision
   public function VerificarUsuario($request, $response, $next){

		$objDelaRespuesta= new stdclass();
		$objDelaRespuesta->respuesta="";

		//Si es get no valido nada
        if($request->isGet()){

            $response = $next($request, $response);
        }
        else{

			//si no - obtengo el token del cliente
			$arrayConToken = $request->getHeader('token');
			//lo guardo en la variable
			$token=$arrayConToken[0];
			//var_dump($token);
			//$objDelaRespuesta->esValido=true; 

			//si el token es vacio aviso antes de nada
			if(empty($token)|| $token=="")
			{
				$response->getBody()->write('<p>estpy aca</p>');
				//throw new Exception("El token se encuentra vacio.");
				//aviso que el toek se encuentra vacio
				$response->getBody()->write('<p>El TOKEN se encuentra vacio. Verificar</p>');

				return $response;
			} 
			else
			{
				 try{			
					AutentificadorJWT::verificarToken($token);
					$objDelaRespuesta->esValido=true;    
				}
				catch(Exception $e){
					// echo $e;
					$response->getBody()-> write($e);
					$response->getBody()->write('<p>Ocurrió un error al verificar el Token</p>');
					return $response;
					
				}
			
				//Si obtuve el TOKEN
				if($objDelaRespuesta->esValido)
				{						
					if($request->isPost())
					{		
						// el post para logeados			    
						$response = $next($request, $response);
					}
					else
					{
						$payload=autentificadorJWT::ObtenerData($token);			
						// DELETE,PUT para logeados y admin
						if($payload->perfil=="admin")
						{
							$response = $next($request, $response);
							if($response)
							{
								$objDelaRespuesta->respuesta="Se modificó el registro correctamente";
							}
							else
							{
								$objDelaRespuesta->respuesta="Ocurrió un error al modificar el registro";
							}
						}		           	
						else
						{	
							$objDelaRespuesta->respuesta="No se puede realizar la acción. Esta acción es para administradores del sistema";
						}
					}		          
				}    
				else
				{
					$objDelaRespuesta->respuesta="<p>no tenes habilitado el ingreso</p><br>";
					$objDelaRespuesta->respuesta="Solo usuarios registrados";
					$objDelaRespuesta->elToken=$token;

				}  

        }
        
			if($objDelaRespuesta->respuesta!="")
			{
				//var_dump($objDelaRespuesta);
				//$response->withJson($objDelaRespuesta, 401);  	
				$newResponse = $response->withJson($objDelaRespuesta, 200); 
				return $newResponse;
			}
		  		
		}

        $response->getBody()->write('<p>vuelvo del verificador de credenciales</p>');
		return $response; 
   }
	/*public function VerificarUsuario($request, $response, $next) {
         
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
	}*/

/*
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
			 
			$datos = array('mail' => $elUser->mail,'perfil' => $elUser->perfil,'perfil' => $elUser->dni);
					
			$token= AutentificadorJWT::CrearToken($datos);

			$objDelaRespuesta->esValido=true; 

			try 
			{
				//$token="";
				AutentificadorJWT::verificarToken($token);
				$objDelaRespuesta->esValido=true;      
			}
			catch (Exception $e) {      
				//guardar en un log
				$objDelaRespuesta->excepcion=$e->getMessage();
				$objDelaRespuesta->esValido=false;     
			}

			if($objDelaRespuesta->esValido)
			{						
				if($request->isPost())
				{		
					// el post sirve para todos los logeados			    
					$response = $next($request, $response);
				}
				else
				{
					$payload=AutentificadorJWT::ObtenerData($token);
					//var_dump($payload);
					// DELETE,PUT y DELETE sirve para todos los logeados y admin
					if($payload->perfil=="Administrador")
					{
						$response = $next($request, $response);
					}		           	
					else
					{	
						$objDelaRespuesta->respuesta="Solo administradores";
					}
				}		          
			}    
			else
			{
				//   $response->getBody()->write('<p>no tenes habilitado el ingreso</p>');
				$objDelaRespuesta->respuesta="Solo usuarios registrados";
				$objDelaRespuesta->elToken=$token;
			}  
		}

		if($objDelaRespuesta->respuesta!="")
		{
			$nueva=$response->withJson($objDelaRespuesta, 401);  
			return $nueva;
		}
		  
		 //$response->getBody()->write('<p>vuelvo del verificador de credenciales</p>');
		 return $response; 

	}
		
	*/

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

?>
<?php

//require 'Empleado.php';

class MWdatosUsuario
{
    public function ValidaAltaUsuario($request, $response, $next) {
			
			$response->getBody()->write('<p>verifico si existe el usuario</p>');
       
			$ArrayDeParametros = $request->getParsedBody();
            $nombre= $ArrayDeParametros['nombre'];
            $apellido= $ArrayDeParametros['apellido'];
            $dni= $ArrayDeParametros['dni'];
            $clave= $ArrayDeParametros['clave'];
            $perfil= $ArrayDeParametros['perfil'];
            $mail= $ArrayDeParametros['mail'];
            $turno= $ArrayDeParametros['turno'];

			$existe=empleado::BuscarUnEmpleado($dni);

			if($existe == 0)
			{	
                $response = $next($request, $response);								
			}
			else
			{          
                $response->getBody()->write('<p>El usuario no puede ser dado de Alta. Ya existe en el sistema</p>');		             
            }
                       
		    return $response; 
        }
        	
}

?>
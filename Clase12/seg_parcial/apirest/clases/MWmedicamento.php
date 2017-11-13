<?php

//require "medicamento.php";

class MWmedicamento
{
    public function OrderbyLaboratorio($request, $response, $next) {
    
        $response->getBody()->write('<p>NO necesita credenciales para los get </p>');
        /*var_dump("estoy aca");
        $todosLosMedicamentos=medicamento::TraerTodos();

        if(count($todosLosMedicamentos) > 0)
        {
            //los ordeno por laboratorio
            usort($todosLosMedicamentos, "cmp");
            $response = $response->withJson($todosLosMedicamentos, 200);  
        }else
        {
            $message = "No hay ningun medicamento en la lista";
            $response = $response->withJson($message, 200); 
        }
*/
    	return $response; 
		
    }
        	
}


?>
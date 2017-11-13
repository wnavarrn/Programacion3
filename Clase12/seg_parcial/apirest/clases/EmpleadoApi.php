<?php

include "Empleado.php";
require_once 'IApiUsable.php';

class EmpleadoApi extends Empleado implements IApiUsable
{
    //traigo un empleado - funciona
 	public function TraerUno($request, $response, $args) {
     	$id=$args['id'];
    	$elEmpleado=Empleado::TraerUnEmpleado($id);
     	$newResponse = $response->withJson($elEmpleado, 200);  
    	return $newResponse;
    }

    //traigo todos los empleados - funciona
    public function TraerTodos($request, $response, $args) {

        $todosLosEmpleados=Empleado::TraerTodosLosEmpleados();
     	$response = $response->withJson($todosLosEmpleados, 200);  
    	return $response; 
    }

    //inserto un empleado - funciona y guarda foto

    public function CargarUno($request, $response, $args) {

        //Obtengo la fecha actual
        $date = date('Y-m-d H:i:s');
        //Datos del cliente
     	$ArrayDeParametros = $request->getParsedBody();
        $nombre= $ArrayDeParametros['nombre'];
        $apellido= $ArrayDeParametros['apellido'];
        $dni= $ArrayDeParametros['dni'];
        $clave= $ArrayDeParametros['clave'];
        $perfil= $ArrayDeParametros['perfil'];
        $mail= $ArrayDeParametros['mail'];
        $turno= $ArrayDeParametros['turno'];
        //Seteo mi objeto    
        $miempleado = new Empleado();
        $miempleado->nombre=$nombre;
        $miempleado->apellido=$apellido;
        $miempleado->dni=$dni;
        $miempleado->clave=$clave;
        $miempleado->perfil=$perfil;
        $miempleado->mail=$mail;
        $miempleado->turno=$turno;
        $miempleado->fecha_creacion= $date;
        //Llamo al Metodo Insertar Empleado
        $idInsertado = $miempleado->InsertarEmpleadoParametros();
        //Una vez que tengo el Id del Empleado actualizo el nombre de la foto
      /*  if($idInsertado > 0)
        {
            $archivos = $request->getUploadedFiles();
            $destino="./fotosEmpleados/";

            $nombreAnterior=$archivos['foto']->getClientFilename();
            $extension= explode(".", $nombreAnterior);
    
            $extension=array_reverse($extension);
            //Armo el nombre de la foto con el Dni
            $archivos['foto']->moveTo($destino."foto_".$dni.$extension[0]);
            //Seteo la respuesta
            $response->getBody()->write("se guardo el empleado");
            
        }else
            //Seteo la respuesta
            $response->getBody()->write("Ocurrió un error al guardar el empleado");
    }*/
        
        return $response;
    }

    //borrar un empleado y funciona
      public function BorrarUno($request, $response, $args) {

     	$ArrayDeParametros = $request->getParsedBody();
        $id=$ArrayDeParametros['id'];

     	$empleado= new Empleado();
     	$empleado->id= $id;
     	$cantidadDeBorrados=$empleado->BorrarEmpleado();

     	$objDelaRespuesta= new stdclass();
	    $objDelaRespuesta->cantidad=$cantidadDeBorrados;
	    if($cantidadDeBorrados>0)
	    	{
	    		 $objDelaRespuesta->resultado="algo borro!!!";
	    	}
	    	else
	    	{
	    		$objDelaRespuesta->resultado="no Borro nada!!!";
	    	}
	    $newResponse = $response->withJson($objDelaRespuesta, 200);  
      	return $newResponse;
    }
     
     public function ModificarUno($request, $response, $args) {

         $date = date('Y-m-d H:i:s');
     	
     	$ArrayDeParametros = $request->getParsedBody();
   	
	    $miempleado = new Empleado();
	    $miempleado->id=$ArrayDeParametros['id'];
        $miempleado->nombre=$ArrayDeParametros['nombre'];
        $miempleado->nombre=$ArrayDeParametros['apellido'];
	    $miempleado->clave=$ArrayDeParametros['clave'];
        $miempleado->perfil=$ArrayDeParametros['perfil'];
        $miempleado->perfil=$ArrayDeParametros['mail'];
        $miempleado->turno=$ArrayDeParametros['turno'];
        $miempleado->fecha_creacion= $date;

	   	$resultado =$miempleado->ModificarEmpleadoParametros();
	   	$objDelaRespuesta= new stdclass();
	
        $objDelaRespuesta->resultado=$resultado;
        
		return $response->withJson($objDelaRespuesta, 200);		
    }

    public function BuscaDniEmpleado()
    {
        $ArrayDeParametros = $request->getParsedBody();
        $dni=$ArrayDeParametros['dni'];
     	$empleado= new Empleado();
     	$empleado->dni= $dni;
     	$cantidadDeEmpleados=$empleado->BuscarEmpleado();

     	$objDelaRespuesta= new stdclass();
	    $objDelaRespuesta->cantidad=$cantidadDeEmpleados;
	    if($cantidadDeEmpleados>0)
	    	{
	    		 $objDelaRespuesta->resultado= true;
	    	}
	    	else
	    	{
	    		$objDelaRespuesta->resultado= false;
	    	}
	    $newResponse = $response->withJson($objDelaRespuesta, 200);  
      	return $newResponse;
    }

}


?>
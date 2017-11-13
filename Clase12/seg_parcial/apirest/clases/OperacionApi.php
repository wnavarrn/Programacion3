<?php

include "Operacion.php";
require_once 'IApiUsable.php';

class OperacionApi extends Operacion implements IApiUsable
{
    //traigo una Operacion - funcionaA
 	public function TraerUno($request, $response, $args) {
     	$id=$args['id'];
    	$laOperacion=Operacion::TraerUnaOperacion($id);
     	$newResponse = $response->withJson($laOperacion, 200);  
    	return $newResponse;
    }

    //traigo todas las Operacions - funcionaA
    public function traerTodos($request, $response, $args) {

        $todasLasOperaciones=Operacion::TraerTodasLasOperaciones();
     	$response = $response->withJson($todasLasOperaciones, 200);  
    	return $response;
    }

    //inserto un Operacion - funciona y guarda foto
    public function CargarUno($request, $response, $args) {

        $date = date("Y-m-d H:i:s"); 

     	$ArrayDeParametros = $request->getParsedBody();
        $patente= $ArrayDeParametros['patente'];
        $color= $ArrayDeParametros['color'];
        $id_empleado_ingreso= $ArrayDeParametros['id_empleado_ingreso'];
        $fecha_hora_ingreso= $date;
   
        $miOperacion = new Operacion();
        $miOperacion->patente=$patente;
        $miOperacion->color=$color;
        $miOperacion->foto="foto_".$patente;
        $miOperacion->id_empleado_ingreso= $id_empleado_ingreso;
        $miOperacion->fecha_hora_ingreso= $date;
        $miOperacion->InsertarOperacionParametros();

        $archivos = $request->getUploadedFiles();
        $destino="./fotosVehiculos/";

        $nombreAnterior=$archivos['foto']->getClientFilename();
        $extension= explode(".", $nombreAnterior);
 
        $extension=array_reverse($extension);

        $archivos['foto']->moveTo($destino."foto_".$patente.".".$extension[0]);
        $response->getBody()->write("se guardo la Operacion");
        
        return $response;
    }

    //borrar un Operacion y funcionaA
      public function BorrarUno($request, $response, $args) {

     	$ArrayDeParametros = $request->getParsedBody();
        $id=$ArrayDeParametros['id'];

     	$Operacion= new Operacion();
     	$Operacion->id= $id;
     	$cantidadDeBorrados=$Operacion->BorrarOperacion();

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
         
         $date = date("Y-m-d H:i:s"); 
     	
     	$ArrayDeParametros = $request->getParsedBody();
   	
	    $miOperacion = new Operacion();
        $miOperacion->id=$ArrayDeParametros['id'];
        $miOperacion->color=$ArrayDeParametros['color'];
	    $miOperacion->patente=$ArrayDeParametros['patente'];
        $miOperacion->id_empleado_ingreso=$ArrayDeParametros['id_empleado_ingreso'];
        $miOperacion->fecha_hora_ingreso= $date;

	   	$resultado =$miOperacion->ModificarOperacionParametros();
	   	$objDelaRespuesta= new stdclass();
	
        $objDelaRespuesta->resultado=$resultado;
        
		return $response->withJson($objDelaRespuesta, 200);		
    }

}


?>

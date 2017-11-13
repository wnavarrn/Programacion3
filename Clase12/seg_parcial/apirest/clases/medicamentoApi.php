<?php

include "medicamento.php";
require_once 'IApiUsable.php';

class medicamentoApi extends medicamento implements IApiUsable
{
    //traigo un Medicamento - funciona
 	public function TraerUno($request, $response, $args) {
     	$id=$args['id'];
    	$elMedicamento=medicamento::TraerUnMedicamento($id);
     	$newResponse = $response->withJson($elMedicamento, 200);  
    	return $newResponse;
    }

    //traigo todos los Medicamentos
    public function TraerTodos($request, $response, $args) {

        $todosLosMedicamentos=medicamento::TraerTodosLosMedicamentos();

        if(count($todosLosMedicamentos) > 0)
        {
            $response = $response->withJson($todosLosMedicamentos, 200);  
        }else
        {
            $message = "No hay ningun medicamento en la lista";
            $response = $response->withJson($message, 200); 
        }

    	return $response; 
    }

      //traigo todos los Medicamentos ordendos por laboratorio
    public function TraerTodosByLab($request, $response, $args) {

            $todosLosMedicamentos=medicamento::TraerTodosLosMedicamentosPorLaboratorio();

            if(count($todosLosMedicamentos) > 0)
            {
                $response = $response->withJson($todosLosMedicamentos, 200);  
            }else
            {
                $message = "No hay ningun medicamento en la lista";
                $response = $response->withJson($message, 200); 
            }

    	return $response; 
    }

    //inserto un empleado - funciona y guarda foto

    public function CargarUno($request, $response, $args) {

     	$ArrayDeParametros = $request->getParsedBody();
        $nombre= $ArrayDeParametros['nombre'];
        $laboratorio= $ArrayDeParametros['laboratorio'];
        $precio= $ArrayDeParametros['precio'];
        //Seteo mi objeto    
        $mimed= new medicamento();
        $mimed->laboratorio=$laboratorio;
        $mimed->precio=$precio;
        $mimed->nombre=$nombre;
        //Llamo al Metodo Insertar Madicamento
        $idInsertado = $mimed->InsertarMedicamentoParametros();
        if($idInsertado > 0)
        {
             $response->getBody()->write("Se guardó el registro correctamente");
        }else
        {
             $response->getBody()->write("Ocurrió un error al guardar el registro");
        }
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

     	$mimed= new medicamento();
     	$mimed->id= $id;
     	$cantidadDeBorrados=$mimed->BorrarMedicamento();

     	$objDelaRespuesta= new stdclass();
	    $objDelaRespuesta->cantidad=$cantidadDeBorrados;
	    if($cantidadDeBorrados>0)
	    	{
	    		 $objDelaRespuesta->resultado="Medicamento borrado correctamente";
	    	}
	    	else
	    	{
	    		$objDelaRespuesta->resultado="No se puedo borrar el Medicamento";
	    	}
	    $newResponse = $response->withJson($objDelaRespuesta, 200);  
      	return $newResponse;
    }
     
     public function ModificarUno($request, $response, $args) {

        $date = date('Y-m-d H:i:s');
     	
     	$ArrayDeParametros = $request->getParsedBody();
            
        $id= $ArrayDeParametros['id']; 
        $nombre= $ArrayDeParametros['nombre'];
        $laboratorio= $ArrayDeParametros['laboratorio'];
        $precio= $ArrayDeParametros['precio'];

        $mimed= new medicamento();

        $mimed->id=$id;
        $mimed->nombre=$nombre;
        $mimed->laboratorio=$laboratorio;
        $mimed->precio=$precio;
       
        $resultado =$mimed->ModificarMedicamentoParametros();
         
        var_dump($resultado);

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
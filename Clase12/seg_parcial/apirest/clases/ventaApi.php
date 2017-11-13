<?php

include "venta.php";
//include "medicamento.php";

class ventaApi extends venta implements IApiUsable
{

    public function CargarUno($request, $response, $args) {

        $ArrayDeParametros = $request->getParsedBody();

        $idmedicamento= $ArrayDeParametros['idmedicamento'];
        $cliente= $ArrayDeParametros['cliente'];

        //voy a buscar el medicamento para ver si existe
        $medicamento = medicamento::TraerUnMedicamento($idmedicamento);

        if($medicamento)
        {
            //trabajo con al foto
                $archivos = $request->getUploadedFiles();
                $nombreAnterior=$archivos['foto']->getClientFilename();
                $extension= explode(".", $nombreAnterior);
                $extension=array_reverse($extension);

                
            //armo el nombre de la foto
            $nombreFoto = $medicamento->id . "_" . $medicamento->laboratorio.".".$extension[0];

            //Seteo mi objeto    
            $miventa= new venta();
            $miventa->cliente=$cliente;
            $miventa->idmedicamento=$idmedicamento;
            $miventa->foto=$nombreFoto;

            //Llamo al Metodo Insertar la venta en la base de datos
            $idInsertado = $miventa->InsertarVentaParametros();

            if($idInsertado > 0)
            {
                $response->getBody()->write("Se guardó el registro correctamente");
                //Guardo la foto
                $destino="./fotosVenta/";
                $archivos['foto']->moveTo($destino.$nombreFoto);

            }else
            {
                $response->getBody()->write("Ocurrió un error al guardar el registro");
            }
        }else
        {
            //Seteo la respuesta
            $response->getBody()->write("El medicamento ingresado no existe");
        }
        
        return $response;
    }
  
     public function ModificarUno($request, $response, $args) {


        $date = date('Y-m-d H:i:s');
     	
     	$ArrayDeParametros = $request->getParsedBody();
        $id= $ArrayDeParametros['id'];         
	    $idmedicamento= $ArrayDeParametros['idmedicamento'];
        $cliente= $ArrayDeParametros['cliente'];

        $miventa= new venta();
        $miventa->id=$id;
        $miventa->cliente=$cliente;
        $miventa->idmedicamento=$idmedicamento;

        //Primero me fijo si la venta a modificar existe
        $laventa = venta::TraerUnaVenta($id);
        var_dump($laventa);
        if($laventa)
        {
            //Obtengo el nombre de la foto
            $fotoAnterior = $laventa->foto;
            var_dump($fotoAnterior);  
             //voy a buscar el medicamento para ver si existe
            $medicamentoVendido = medicamento::TraerUnMedicamento($idmedicamento);

            if($medicamentoVendido)
            {           
                //armo el nombre de la foto con el id del medicamento actual
                $nombreFotoActual = $medicamentoVendido->id . "_" .$medicamentoVendido->laboratorio.".jpg";           
            }
            else
            {
                $response->getBody()->write("El medicamento ingresado no existe");
            }

            $resultado =$miventa->ModificarVentaParametros();
            
            //una vez modificado
            if($resultado)
            {
               
                var_dump($nombreFotoActual);              
                //verifo si el nombre de la foto anterior es el mismo nombre del nombre a formar ahora
                if($fotoAnterior == $nombreFotoActual)
                {
                    if(copy("./fotosVenta/".$fotoAnterior,"./fotosbackup/".$date."_".$nombreFotoActual))
                    {
                        unlink("./fotosVenta/".$fotoAnterior);
                    }
                }
            }
        
        }
        else
        {
            $response->getBody()->write("La venta que quiere modificar no existe");
        }
           
	   	$objDelaRespuesta= new stdclass();
	
        $objDelaRespuesta->resultado=$resultado;
        
		return $response->withJson($objDelaRespuesta, 200);		
    }



    public function TraerUno($request, $response, $args)
    {
        $resultado = "Metodo sin desarrollar";
	   	$objDelaRespuesta= new stdclass();
	
        $objDelaRespuesta->resultado=$resultado;
        
		return $response->withJson($objDelaRespuesta, 200);	
    } 

    public function TraerTodos($request, $response, $args)
    {
        $resultado = "Metodo sin desarrollar";
	   	$objDelaRespuesta= new stdclass();
	
        $objDelaRespuesta->resultado=$resultado;
        
		return $response->withJson($objDelaRespuesta, 200);	
    } 
   	
    public function BorrarUno($request, $response, $args)
    {
        $resultado = "Metodo sin desarrollar";
	   	$objDelaRespuesta= new stdclass();
	
        $objDelaRespuesta->resultado=$resultado;
        
		return $response->withJson($objDelaRespuesta, 200);	
    }
   
}


?>
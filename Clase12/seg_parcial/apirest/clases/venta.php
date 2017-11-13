<?php

class venta
{
    public $id;
    public $cliente;
    public $idmedicamento;
    public $foto;


    public function TraerUnaVenta($id)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select id, cliente, idmedicamento, foto from venta where id = $id");
			$consulta->execute();
			$ventaBuscada= $consulta->fetchObject('venta');
			return $ventaBuscada;	
    }

    public function InsertarVentaParametros()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
                $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into venta (cliente, idmedicamento, foto)
                values(:cliente,:idmedicamento,:foto)");
                $consulta->bindValue(':cliente',$this->cliente, PDO::PARAM_INT);
                $consulta->bindValue(':idmedicamento',$this->idmedicamento, PDO::PARAM_INT);
                $consulta->bindValue(':foto',$this->foto, PDO::PARAM_INT);				
                $consulta->execute();		
                return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

     public function ModificarVentaParametros()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				update venta 
                set cliente=:cliente,
                idmedicamento=:idmedicamento,
				foto=:foto            
                WHERE id=:id");
            $consulta->bindValue(':id',$this->id, PDO::PARAM_INT);
            $consulta->bindValue(':cliente',$this->cliente, PDO::PARAM_INT);
            $consulta->bindValue(':idmedicamento',$this->idmedicamento, PDO::PARAM_INT);
			$consulta->bindValue(':foto',$this->foto, PDO::PARAM_INT);
			return $consulta->execute();
    }

}



?>
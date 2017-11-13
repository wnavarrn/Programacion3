<?php

class medicamento
{
    public $id;
    public $nombre;
    public $laboratorio;
    public $precio;
  
    public function BorrarMedicamento()
    {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				delete 
				from medicamento 				
				WHERE id=:id");	
				$consulta->bindValue(':id',$this->id, PDO::PARAM_INT);		
				$consulta->execute();
				return $consulta->rowCount();
    } 

    public function TraerTodosLosMedicamentos()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select id, nombre, laboratorio, precio from medicamento");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "medicamento");	
    }

    public function TraerTodosLosMedicamentosPorLaboratorio()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select id, nombre, laboratorio, precio from medicamento order by laboratorio");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "medicamento");	
    }
    
    public function TraerUnMedicamento($id)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select id, nombre, laboratorio, precio from medicamento where id = $id");
			$consulta->execute();
			$empleadoBuscado= $consulta->fetchObject('medicamento');
			return $empleadoBuscado;	
    }

    public function InsertarMedicamentoParametros()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into medicamento (nombre, laboratorio, precio)
                values(:nombre,:laboratorio,:precio)");
                $consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_INT);
                $consulta->bindValue(':laboratorio',$this->laboratorio, PDO::PARAM_INT);
                $consulta->bindValue(':precio',$this->precio, PDO::PARAM_INT);				
				$consulta->execute();		
				return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public function ModificarMedicamentoParametros()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				update medicamento 
                set nombre=:nombre,
                laboratorio=:laboratorio,
				precio=:precio               
                WHERE id=:id");
            $consulta->bindValue(':id',$this->id, PDO::PARAM_INT);
            $consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_INT);
            $consulta->bindValue(':laboratorio',$this->laboratorio, PDO::PARAM_INT);
            $consulta->bindValue(':precio',$this->precio, PDO::PARAM_INT);
            
			return $consulta->execute();
    }

    public function GuardarEmpleado()
    {

    }

    //Lo utilizo en el Midlleware para validar el alta del usuario
    public static function BuscarUnEmpleado($dni)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select * from empleado where dni = $dni");
        $consulta->execute();
        return $consulta->rowCount();
    }
    
}




?>
<?php

class Operacion
{
    public $id;
    public $patente;
    public $color;
    public $foto;
    public $id_empleado_ingreso;
    public $fecha_hora_ingreso;
    public $id_empleado_salida;
    public $fecha_hora_salida;
    public $importe;
    public $tiempo;


    public function BorrarOperacion()
    {
         $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				delete 
				from operaciones 				
				WHERE id=:id");	
				$consulta->bindValue(':id',$this->id, PDO::PARAM_INT);		
				$consulta->execute();
				return $consulta->rowCount();
    } 

    public function TraerTodasLasOperaciones()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select id,patente,color,foto, id_empleado_ingreso,fecha_hora_ingreso,id_empleado_salida,importe,tiempo from operaciones");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Operacion");	
    }

    public function TraerUnaOperacion($id)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select id,patente,color,foto,id_empleado_ingreso,fecha_hora_ingreso,id_empleado_salida,importe,tiempo from operaciones where id = $id");
			$consulta->execute();
			$empleadoBuscado= $consulta->fetchObject('Operacion');
			return $empleadoBuscado;	
    }

    public function InsertarOperacionParametros()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into operaciones (patente,color,foto,id_empleado_ingreso,fecha_hora_ingreso)
                values(:patente,:color,:foto,:id_empleado_ingreso,:fecha_hora_ingreso)");
				$consulta->bindValue(':patente',$this->patente, PDO::PARAM_INT);
				$consulta->bindValue(':color', $this->color, PDO::PARAM_STR);
                $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
                $consulta->bindValue(':id_empleado_ingreso', $this->id_empleado_ingreso, PDO::PARAM_STR);
                $consulta->bindValue(':fecha_hora_ingreso', $this->fecha_hora_ingreso, PDO::PARAM_STR);
				$consulta->execute();		
				return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public function ModificarOperacionParametros()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				update operaciones 
                set patente=:patente,
                color=:color,
                id_empleado_ingreso=:id_empleado_ingreso,
                fecha_hora_ingreso=:fecha_hora_ingreso
                WHERE id=:id");
            $consulta->bindValue(':id',$this->id, PDO::PARAM_INT);
			$consulta->bindValue(':patente',$this->patente, PDO::PARAM_INT);
			$consulta->bindValue(':color',$this->color, PDO::PARAM_INT);
            $consulta->bindValue(':id_empleado_ingreso', $this->id_empleado_ingreso, PDO::PARAM_STR);
            $consulta->bindValue(':fecha_hora_ingreso', $this->fecha_hora_ingreso, PDO::PARAM_STR);
			return $consulta->execute();
    }

    public function GuardarEmpleado()
    {

    }

}
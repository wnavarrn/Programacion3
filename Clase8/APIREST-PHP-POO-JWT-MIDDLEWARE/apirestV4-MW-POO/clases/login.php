<?php

class Login
{
    public $id;
    public $Nombre;
	public $Password;
	public $Tipo;

    public static function TraerUnUsuario($nombre,$password) 
	{
		
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select Id ,Nombre, Password, Tipo from usuario  WHERE Nombre=? AND Password=?");
			$consulta->execute(array($nombre, $password));

			$UserBuscado= $consulta->fetchObject('login');

      		return $UserBuscado;				
		
	}
}
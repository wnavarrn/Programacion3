<?php

class usuario
{
	public $id;
	public $mail;
    public $nombre;
	public $apellido;
	public $perfil;

	//metodo que busca un usuario con los valores pasados por parametro
	//retorno un array del objeto encontrado
    public static function TraerUnUsuario($mail,$clave) 
	{
		
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select id ,mail, nombre, apellido, perfil from usuario  WHERE mail=? AND clave=?");
			$consulta->execute(array($mail, $clave));
			$UsuarioBuscado= $consulta->fetchObject('usuario');
      		return $UsuarioBuscado;				
		
	}
}
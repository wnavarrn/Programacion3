<?php

//Campos
protected _apellido;
protected _nombre;
protected _dni;
protected _sexo;

//Constructor
public function _construct($_apellido,$_nombre,$_dni,$_sexo)
{
    $this->apellido = $_apellido;
    $this->nombre = $_nombre;
    $this->dni = $_dni;
    $this->sexo=$_sexo;
}

public function getApellido($_apellido)
{
    return $this->$_apellido;
}

public function getDni($_dni)
{
    return $this->$_dni;
}

public function getNombre($_nombre)
{
    return $this->$_nombre;
}

public function getSexo($_sexo)
{
    return $this->$_sexo;
}

public function Hablar($_idioma)
{
    return $this->$_idioma;
}

public function toString()
{
    $_info = "<h1>Información de la persona:</h1>";
    $_info."Nombre: ". $this->getNombre();
    $_info."<br/> Apellido: ". $this->getApellido();
    $_info."<br/> Sexo: ". $this->getSexo();

    return $_info;
}




?>
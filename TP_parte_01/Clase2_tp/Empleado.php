<?php

//Campos
private $_legajo;
private $_sueldo;

//Constructor
public function _constructor($_apellido,$_nombre,$_dni,$_sexo,$_legajo,$_sueldo)
{
    parent::_constructor($_apellido,$_nombre,$_dni,$_sexo);
    $this->legajo = $_legajo;
    $this->sueldo = $_sueldo;
}

//Metodos
public function getLegajo($_legajo)
{
    return $this->$_legajo;
}

public function getSueldo($_sueldo)
{
    return $this->$_sueldo;
}

?>
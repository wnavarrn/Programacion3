<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
/*son requirimientos que nos dan
psr7
BRINDA LA VENTAJA DE REUTILIZAR CODO
VERFICACION IP, CAMBIO DE FORMATOS DE IMGENES, UN MONTON DE COSAS
Podemos crear nuestros metodos, son funciones que reciben el mismo callback
*/
use \Psr\Http\Message\ResponseInterface as Response;

require '../composer/vendor/autoload.php';
require '/clases/AccesoDatos.php';
require '/clases/cdApi.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

/*

¡La primera línea es la más importante! A su vez en el modo de 
desarrollo para obtener información sobre los errores
 (sin él, Slim por lo menos registrar los errores por lo que si está utilizando
  el construido en PHP webserver, entonces usted verá en la salida de la consola 
  que es útil).

  La segunda línea permite al servidor web establecer el encabezado Content-Length, 
  lo que hace que Slim se comporte de manera más predecible.

  aca sirve para filtrar por ejemplo una grilla. darle importancia al middleware
*/





$app = new \Slim\App(["settings" => $config]);

/* FUNCION MIDDELWARE*/
/**/
$VerificadorDeCredenciales = function ($request, $response, $next) {//tres parametros fundamentales

  if($request->isGet())
  {
     $response->getBody()->write('<p>NO necesita credenciales para los get</p>');
     //$next es el callback, para dar o no permisos para acceder. Llama al mismo puede ser otro middleware
     //o mi API
     $response = $next($request, $response);
  }
  else//si no es get es post
  {
    $response->getBody()->write('<p>verifico credenciales</p>');
    $ArrayDeParametros = $request->getParsedBody();
    $nombre=$ArrayDeParametros['nombre'];
    $tipo=$ArrayDeParametros['tipo'];
    if($tipo=="administrador")
    {
      $response->getBody()->write("<h3>Bienvenido $nombre </h3>");
      $response = $next($request, $response);
    }
    else
    {
      $response->getBody()->write('<p>no tenes habilitado el ingreso</p>');
    }  
  }  
  $response->getBody()->write('<p>vuelvo del verificador de credenciales</p>');
  return $response;  
};


/*LLAMADA A METODOS DE INSTANCIA DE UNA CLASE*/
  

$app->group('/cd', function () {
 
  $this->get('/', \cdApi::class . ':traerTodos');
 
  $this->get('/{id}', \cdApi::class . ':traerUno');

  $this->post('/', \cdApi::class . ':CargarUno');

  $this->delete('/', \cdApi::class . ':BorrarUno');

  $this->put('/', \cdApi::class . ':ModificarUno');
  
})->add($VerificadorDeCredenciales);//aca agrego la funcion middleware(esta es una forma para testear)


/* codifgo que se ejecuta antes que los llamados por la ruta*/
$app->add(function ($request, $response, $next) {
  $response->getBody()->write('<p>Antes de ejecutar UNO </p>');
  $response = $next($request, $response);
  $response->getBody()->write('<p>Despues de ejecutar UNO</p>');

  return $response;
});

$app->add(function ($request, $response, $next) {
  $response->getBody()->write('<p>Antes de ejecutar DOS </p>');
  $response = $next($request, $response);
  $response->getBody()->write('<p>Despues de ejecutar DOS</p>');

  return $response;
});
// despues de esto y llamando a la ruta cd/, el resultaso es este :
/*
Antes de ejecutar Dos ***
Antes de ejecutar UNO ***
TrearTodos
***Despues de ejecutar UNO
***Despues de ejecutar Dos
*/
/*habilito el CORS para todos*/
$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', 'http://localhost:4200')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});







$app->run();
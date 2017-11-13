<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../composer/vendor/autoload.php';
require 'clases/AccesoDatos.php';

require 'clases/usuario.php';
require 'clases/autentificadorJWT.php';

//require 'clases/EmpleadoApi.php';
//require 'clases/OperacionApi.php';

require 'clases/medicamentoApi.php';
require 'clases/ventaApi.php';

require 'clases/MWparaCORS.php';
require 'clases/MWmedicamento.php';

require 'clases/MWparaAutentificar.php';
//require 'clases/MWdatosUsuario.php';

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
*/

$app = new \Slim\App(["settings" => $config]);

/*LLAMADA A METODOS DE INSTANCIA DE UNA CLASE*/
// forma 1 con llamada a api rest.
/*$app->group('/ingreso', function () {
  $this->post('/', \loginApi::class . ':TraerUno');   
});*/

//forma 2 con funcion directa en el index
$app->post('/ingreso/', function (Request $request, Response $response) {    
    
	$token="";
  $ArrayDeParametros = $request->getParsedBody();
  
 //valido los datos ingresados
  if(isset( $ArrayDeParametros['mail']) && isset( $ArrayDeParametros['clave']) )
  {
      //obtengo los valores
      $mail=$ArrayDeParametros['mail'];
      $clave= $ArrayDeParametros['clave'];

      //le pego directamente a la clave login    
      $usuario = usuario::TraerUnUsuario($mail,$clave);
      if($usuario != null)
      {
        $datos=array('nombre'=>$usuario->nombre,'apellido'=>$usuario->apellido,'mail'=>$usuario->mail,'perfil'=>$usuario->perfil);
        $token= autentificadorJWT::CrearToken($datos);
        $retorno=array('datos'=> $datos, 'token'=>$token );
        $newResponse = $response->withJson( $retorno ,200); 
      }
      else
      {
        $retorno=array('error'=> "Usuario no valido" );
        $newResponse = $response->withJson( $retorno ,409); 
      }
  }else//retorno validacion
  {
        $retorno=array('error'=> "Faltan los datos del usuario y su clave" );
        $newResponse = $response->withJson( $retorno ,409); 
  }
 //Retorno el token formado
	return $newResponse;
});


/*LLAMADA A METODOS DE INSTANCIA DE LA CLASE MEDICAMENTO*/
//solo puede verlo un admin
$app->group('/medicamento', function () {
 
  //asi es normal
  $this->get('/', \medicamentoApi::class . ':traerTodos');
    
  //asi es ordenandolo ->add(\MWdatosUsuario::class . ':ValidaAltaUsuario');
  //$this->get('/', \medicamentoApi::class . ':traerTodos')->add(\MWmedicamento::class . ':OrderbyLaboratorio');

  $this->get('/ordenadoPorLaboratorio/', \medicamentoApi::class . ':TraerTodosByLab'); 
  
  $this->get('/{id}', \medicamentoApi::class . ':traerUno');

  $this->post('/', \medicamentoApi::class . ':CargarUno');

  $this->delete('/', \medicamentoApi::class . ':BorrarUno');

  $this->put('/', \medicamentoApi::class . ':ModificarUno');
     
})->add(\MWparaAutentificar::class . ':VerificarUsuario');



$app->group('/venta', function () {
 
  $this->post('/', \ventaApi::class . ':CargarUno');

  $this->put('/', \ventaApi::class . ':ModificarUno');
     
});


/*LLAMADA A METODOS DE INSTANCIA DE LA CLASE EMPLEADO*/
$app->group('/empleado', function () {
 
  $this->get('/', \EmpleadoApi::class . ':traerTodos');
    
  $this->get('/{id}', \EmpleadoApi::class . ':traerUno');

  $this->post('/', \EmpleadoApi::class . ':CargarUno')->add(\MWdatosUsuario::class . ':ValidaAltaUsuario');

  $this->delete('/', \EmpleadoApi::class . ':BorrarUno');

  $this->put('/', \EmpleadoApi::class . ':ModificarUno');
     
});

/*LLAMADA A METODOS DE INSTANCIA DE LA CLASE OPERACION*/
$app->group('/operacion', function () {
 
  $this->get('/', \OperacionApi::class . ':traerTodos');
 
  $this->get('/{id}', \OperacionApi::class . ':traerUno');

  $this->post('/', \OperacionApi::class . ':CargarUno');

  $this->delete('/', \OperacionApi::class . ':BorrarUno');

  $this->put('/', \OperacionApi::class . ':ModificarUno');
     
});

$app->run();

?>
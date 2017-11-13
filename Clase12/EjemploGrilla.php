<?php 
session_start();
if(isset($_SESSION['registrado']))
{
	require_once("clases/AccesoDatos.php");
	require_once("clases/cd.php");
	$arrayDeCds=cd::TraerTodoLosCds();
	echo "<h2> Bienvenido: ". $_SESSION['registrado']."</h2>";
 ?>
<table class="table"  style=" background-color: beige;">
	<thead>
		<tr>
			<th>Editar</th><th>Borrar</th><th>cantante</th><th>disco</th><th>año</th>
		</tr>
	</thead>
	<tbody>

		<?php 
foreach ($arrayDeCds as $cd) {
	echo"<tr>
			<td><a onclick='EditarCDCorrecto($cd->id)' class='btn btn-warning'> <span class='glyphicon glyphicon-pencil'>&nbsp;</span>Edit</a></td>
			<td><a onclick='EditarCDConError1($cd->id)' class='btn btn-warning'> <span class='glyphicon glyphicon-pencil'>&nbsp;</span>E1</a></td>
			<td><a onclick='EditarCDConError2($cd->id)' class='btn btn-warning'> <span class='glyphicon glyphicon-pencil'>&nbsp;</span>E2</a></td>
			
			<td><a onclick='BorrarCD($cd->id)' class='btn btn-danger'>   <span class='glyphicon glyphicon-trash'>&nbsp;</span>  Borrar</a></td>
			<td>$cd->cantante</td>
			<td>$cd->titulo</td>
			<td>$cd->año</td>
		</tr>   ";
}
		 ?>
	</tbody>
</table>

<?php 	}else	{
		echo "<h4 class='widgettitle'>No estas registrado</h4>";
	}
	 ?>
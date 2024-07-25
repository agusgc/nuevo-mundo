<?php
require_once("clase_seccion.php");

$mis_secciones=new seccion();

if(isset($_POST['agregar'])){
	$exito=$mis_secciones -> insertar($_POST);
	
	if($exito){
		echo("<script>alert('Sección agregada')</script>");
	}
	else{
		echo("<script>alert('No se pudo agregar la sección')</script>");
	}
}

?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Agregar sección</title>
	<link rel="stylesheet" href="../admin.css">
</head>
<body>
	<header>
		<a href="../admin.php">Inicio</a>
		<a href="listar_secciones.php">Ver registros</a>
	</header>
	<form method="post" action="agregar_seccion.php">
		<h1>Agregar sección</h1>
		
		<p><label for="seccion">Sección</label></p>
		<p><input type="text" name="seccion" id="seccion" required></p>
		
		<p><input type="submit" name="agregar" id="agregar" value="Agregar"></p>
	</form>
	
</body>
</html>
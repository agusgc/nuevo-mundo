<?php
require_once("clase_seccion.php");

$mis_secciones=new seccion();

if(isset($_GET['registro'])){
	extract($_GET);
	$esta_seccion=$mis_secciones -> obtener_registro($registro);
	extract($esta_seccion);
}

if(isset($_POST['editar'])){
	$exito=$mis_secciones -> editar($_POST);
	
	if($exito){
		echo("<script>alert('Sección editada')</script>");
	}
	else{
		echo("<script>alert('No se pudo editar la sección')</script>");
	}
	echo("<script>document.location.href='listar_secciones.php'</script>");
}

?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Modificar sección</title>
	<link rel="stylesheet" href="../admin.css">
</head>
<body>
	<header>
		<a href="../admin.php">Inicio</a>
		<a href="listar_secciones.php">Ver registros</a>
	</header>
	<form method="post" action="modificar_seccion.php">
		<h1>Modificar sección</h1>
		
		<p><label for="cod_seccion">Código sección</label></p>
		<p><input type="text" name="cod_seccion" id="cod_seccion" required value="<?php echo($cod_seccion); ?>" readonly></p>
		
		<p><label for="seccion">Sección</label></p>
		<p><input type="text" name="seccion" id="seccion" required value="<?php echo($seccion); ?>"></p>
		
		<p><input type="submit" name="editar" id="editar" value="Editar"></p>
	</form>	
</body>
</html>
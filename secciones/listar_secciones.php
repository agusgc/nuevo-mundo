<?php
require_once("clase_seccion.php");

$mis_secciones=new seccion();
$estas_secciones=$mis_secciones -> listar(0, 10);

if(isset($_GET['eliminar'])){
	extract($_GET);
	
	if($eliminar=="si"){
		echo("<script>var confirmar=confirm('¿Desea eliminar la sección ".$registro."?');
			if(confirmar === true){
				document.location.href='listar_secciones.php?eliminado=".$registro."'}
			else{document.location.href='listar_secciones.php';}
		</script>");
	}
}

if(isset($_GET['eliminado'])){
	extract($_GET);
	$exito=$mis_secciones -> eliminar($eliminado);
	
	if($exito){
		echo("<script>alert('Sección eliminada')</script>");
	}
	else{
		echo("<script>alert('No se pudo eliminar la sección')</script>");
	}
	echo("<script>document.location.href='listar_secciones.php'</script>");
}

if(isset($_GET['editar'])){
	extract($_GET);
	
	if($editar=="si"){
		header("Location: modificar_seccion.php?registro=$registro");
	}
}

if(isset($_GET['editado'])){
	extract($_GET);
	$exito=$mis_secciones -> editar($registro);
	
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
	<title>Lista de secciones</title>
	<link rel="stylesheet" href="../admin.css">
</head>
<body>
	<header>
		<a href="../admin.php">Inicio</a>
		<a href="agregar_seccion.php">Agregar sección</a>
	</header>
	<?php
		$mis_secciones -> mostrar_matriz($estas_secciones);
	?>
</body>
</html>
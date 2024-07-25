<?php
require_once("clase_noticia.php");

$mis_noticias=new noticia();
$estas_noticias=$mis_noticias -> listar(0, 10);

if(isset($_GET['eliminar'])){
	extract($_GET);
	
	if($eliminar=="si"){
		echo("<script>var confirmar=confirm('¿Desea eliminar la noticia ".$registro."?');
			if(confirmar === true){
				document.location.href='listar_noticias.php?eliminado=".$registro."&foto=".$foto."'}
			else{document.location.href='listar_noticias.php';}
		</script>");
	}
}

if(isset($_GET['eliminado'])){
	extract($_GET);
	$exito=$mis_noticias -> eliminar($eliminado, $foto);
	
	if($exito){
		echo("<script>alert('Noticia eliminada')</script>");
	}
	else{
		echo("<script>alert('No se pudo eliminar la noticia')</script>");
	}
	echo("<script>document.location.href='listar_noticias.php'</script>");
}

if(isset($_GET['editar'])){
	extract($_GET);
	
	if($editar=="si"){
		header("Location: modificar_noticia.php?registro=$registro");
	}
}

if(isset($_GET['editado'])){
	extract($_GET);
	$exito=$mis_noticias -> editar($registro);
	
	if($exito){
		echo("<script>alert('Noticia editada')</script>");
	}
	else{
		echo("<script>alert('No se pudo editar la noticia')</script>");
	}
	//echo("<script>document.location.href='listar_noticias.php'</script>");
}

?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Lista de noticias</title>
	<link rel="stylesheet" href="../admin.css">
</head>
<body>
	<header>
		<a href="../admin.php">Inicio</a>
		<a href="agregar_noticia.php">Agregar noticia</a>
	</header>
	<?php
		$mis_noticias -> mostrar_matriz($estas_noticias);
	?>
</body>
</html>

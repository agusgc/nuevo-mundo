<?php
require_once("clase_noticia.php");

$mis_noticias=new noticia();

if(isset($_POST['agregar'])){
	$exito=$mis_noticias -> insertar($_POST);
	
	if($exito){
		echo("<script>alert('Noticia agregada')</script>");
	}
	else{
		echo("<script>alert('No se pudo agregar la noticia')</script>");
	}
}

//Secciones
require_once("../secciones/clase_seccion.php");
$mis_secciones=new seccion();
$estas_secciones=$mis_secciones -> listar(0, 100);
extract($estas_secciones);

?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Agregar noticia</title>
	<link rel="stylesheet" href="../admin.css">
</head>
<body>
	<header>
		<a href="../admin.php">Inicio</a>
		<a href="listar_noticias.php">Ver registros</a>
	</header>
	<form method="post" action="agregar_noticia.php" enctype="multipart/form-data">
		<h1>Agregar noticia</h1>
		
		<p><label for="titulo">Título</label></p>
		<p><input type="text" name="titulo" id="titulo" required></p>
		
		<p><label for="texto">Texto</label></p>
		<p><textarea name="texto" id="texto" required></textarea></p>
		
		<p><label for="foto">Foto</label></p>
		<p class="input-foto"><input type="file" id="foto" name="foto" required accept="image/*"></p>

		<p><label for="video">Código de Video</label></p>
		<p><input type="text" name="video" id="video" value=""></p>

		<p><label for="seccion">Sección</label></p>
		<p><select name="seccion" id="seccion" required>
		<?php
			foreach ($estas_secciones as $value) {
				echo("<option value='$value[cod_seccion]'>$value[seccion]</option>");
			} 
		?>
			</select></p>
		<p><input type="submit" name="agregar" id="agregar" value="Agregar"></p>
	</form>
</body>
</html>
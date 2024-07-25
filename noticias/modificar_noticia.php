<?php
require_once("clase_noticia.php");

$mis_noticias=new noticia();

if(isset($_GET['registro'])){
	extract($_GET);
	$esta_noticia=$mis_noticias -> obtener_registro($registro);
	extract($esta_noticia);
}

if(isset($_POST['editar'])){
	$exito=$mis_noticias -> editar($_POST);
	
	if($exito){
		echo("<script>alert('Noticia editada')</script>");
	}
	else{
		echo("<script>alert('No se pudo editar la noticia')</script>");
	}
	echo("<script>document.location.href='listar_noticias.php'</script>");
}

require_once("../secciones/clase_seccion.php");
$mis_secciones=new seccion();
$estas_secciones=$mis_secciones -> listar(0, 100);
extract($estas_secciones);
?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Modificar noticia</title>
	<link rel="stylesheet" href="../admin.css">
</head>
<body>
	<header>
		<a href="../admin.php">Inicio</a>
		<a href="listar_noticias.php">Ver registros</a>
	</header>
	<form method="post" action="modificar_noticia.php" enctype="multipart/form-data">
		<h1>Editar noticia</h1>
		
		<input type="hidden" name="cod_noticia" id="cod_noticia" value="<?php echo($cod_noticia); ?>">
		
		<p><label for="titulo">Título</label></p>
		<p><input type="text" name="titulo" id="titulo" required value="<?php echo($titulo); ?>"></p>
		
		<p><label for="texto">Texto</label></p>
		<p><textarea name="texto" id="texto" required><?php echo($texto); ?></textarea></p>
		
		<p><label for="foto">Foto</label></p>
		<p><img src="../img/img-noticias/<?php echo($foto); ?>" alt="Foto">
			<?php echo($foto); ?></p>
		
		<p><input type="file" id="foto" name="foto" accept="image/*"></p>
		
		<input type="hidden" name="misma_foto" id="misma_foto" value="<?php echo($foto); ?>">
		
		<p><label for="video">Código de Video</label></p>
		<p><input type="text" name="video" id="video" value="<?php echo($video); ?>"></p>

		<p><label for="seccion">Sección</label></p>
		<p><select name="seccion" id="seccion" required>
		  <?php
			foreach ($estas_secciones as $value) {
				$selected = "";
				if($seccion == $value[cod_seccion]){
					$selected = "selected='selected'";
				}
				echo("<option value='$value[cod_seccion]' $selected>$value[seccion]</option>");
			}
		  ?>
	  	</select></p>
		
		<p><input type="submit" name="editar" id="editar" value="Editar"></p>
	</form>
</body>
</html>
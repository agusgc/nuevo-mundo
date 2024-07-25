<?php
require_once("noticias/clase_noticia.php");

$mis_noticias=new noticia();

if(isset($_GET['noticia'])){
	extract($_GET);
	$la_noticia=$mis_noticias -> listar_noticia($noticia);
	
	$dos_noticias=$mis_noticias -> listar(0, 2);
}

?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticia</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bitter:ital,wght@0,100..900;1,100..900&family=Hahmlet:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
	<?php include('componentes/header.php') ?>
	<main class="pagina-noticia">
		<div class="noticia-arriba">
			<?php $mis_noticias -> pagina_noticia($la_noticia); ?>
		</div>
		<div class="div-noticias">
			<?php $mis_noticias -> mostrar_noticia($dos_noticias); ?>
		</div>
	</main>
	<?php include('componentes/footer.php') ?>
	

</body>
</html>
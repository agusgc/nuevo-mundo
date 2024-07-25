<?php
require_once("noticias/clase_noticia.php");

$mis_noticias=new noticia();
$principal=$mis_noticias -> listar(0, 1);
$dos_noticias=$mis_noticias -> listar(1, 2);
$ultimas_noticias=$mis_noticias -> listar(1, 3);

?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Nuevo Mundo</title>
	<link rel="stylesheet" href="styles.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Bitter:ital,wght@0,100..900;1,100..900&family=Hahmlet:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
	<?php include('componentes/header.php') ?>
	<main class="home">
	<div class="div-principal">
		<?php
			$mis_noticias -> mostrar_principal($principal);
		?>
		<aside class="ultimas">
			<h3>Últimas noticias</h3>
			<ul>
				<?php $mis_noticias -> listar_ultimas_noticias($ultimas_noticias); ?>
			</ul>
			<a href="seccion.php?seccion=&page=0" class="ver-todas">Ver todas</a>
		</aside>
	</div>
	<div class="div-noticias">
		<?php $mis_noticias -> mostrar_noticia($dos_noticias); ?>
	</div>

	</main>
	<?php include('componentes/footer.php') ?>
</body>
</html>

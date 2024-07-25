<?php
require_once("noticias/clase_noticia.php");

$mis_noticias=new noticia();

if(isset($_GET['seccion'])){
	extract($_GET);
    $cantidad_todas = 4;
    $cantidad_seccion = 6;
    $nombre_seccion = $mis_noticias -> devolver_nombre_seccion($seccion);

    if($seccion==""){
        extract($_GET);
        $noticias=$mis_noticias -> listar($page*$cantidad_todas, $cantidad_todas);
        $nombre_seccion = "";
    }
    else{
        $noticias=$mis_noticias -> listar_seccion($page*$cantidad_seccion, $cantidad_seccion, $seccion);
    }
}

?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sección</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bitter:ital,wght@0,100..900;1,100..900&family=Hahmlet:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
    <?php include('componentes/header.php') ?>
    <main>
        <p class="nombre-seccion"><?php echo($nombre_seccion) ?></p>
        <div class="div-noticias">
		    <?php $mis_noticias -> mostrar_noticia($noticias); ?>
	    </div>
        <?php include('componentes/paginacion.php') ?>
    </main>
    <?php include('componentes/footer.php') ?>

</body>
</html>
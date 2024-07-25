<?php
require_once("secciones/clase_seccion.php");

$mis_secciones=new seccion();
$secciones=$mis_secciones -> listar(0, 20);
?>

<header>
	<div class="desplegable">
    	<p class="btn-secciones"><img src="img/menu.svg" alt="menu" class="icono"><span>Secciones</span></p>
		<ul class="desplegable-items">
			<?php $mis_secciones -> lista_menu($secciones); ?>
		</ul>
	</div>
	
    <h1><a href="index.php">Nuevo Mundo</a></h1>
</header>

<script>
	let boton = document.querySelector('.btn-secciones');
	let menu = document.querySelector('.desplegable-items');
	let muestra = false;

	boton.addEventListener('click', mostrar)

	function mostrar(){
    if (!muestra) {
        menu.style.display = 'block';
        muestra=true;
    }
    else{
        menu.style.display = 'none';
        muestra=false;
    }
}
</script>
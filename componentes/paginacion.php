<?php
    if ($page<0) {
        header("Location: seccion.php?seccion=$seccion&page=0");
    }
    else if (count($noticias) == 0) {
        header("Location: seccion.php?seccion=$seccion&page=".($page-1));
    }
?>

<div class="paginacion">
    <button class="atras">
        <?php echo("<a href='seccion.php?seccion=".$seccion."&page=".($page-1)."'>&#60;</a>")?>
    </button>
    <button class="adelante">
        <?php echo("<a href='seccion.php?seccion=".$seccion."&page=".($page+1)."'>&#62;</a>")?>
    </button>
</div>
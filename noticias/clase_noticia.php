<?php
if(file_exists("../secciones/clase_seccion.php")){
	require_once("../secciones/clase_seccion.php");
}
else{
	require_once("secciones/clase_seccion.php");
}

//Acortar texto
function acortar_texto($texto){
	if(strlen($texto)<=500){
		echo("<p class='texto'>".$texto."</p>");
	}
	else{
		$tamano = 350;
		$contador = 0;

		$arrayTexto = explode(' ',$texto);
		$texto = '';

		while($tamano >= strlen($texto) + strlen($arrayTexto[$contador])){
			$texto .= ' '.$arrayTexto[$contador];
			$contador++;
		}
		$texto.="...";
		return("<p class='texto'>".$texto."</p>");
	}
}

class noticia{
	//Base de datos
	const SERVIDOR = "localhost";
	const USUARIO = "root";
	const PASSWORD = "root";
	const BASE = "diario";
	
	//Conexión
	private function conectar(){
		$conexion = mysqli_connect(self::SERVIDOR, self::USUARIO, self::PASSWORD, self::BASE)or die("Error al tratar de establecer la conexión");
		return $conexion;
	}
	
	//Insertar
	public function insertar($datos){
		$conexion=self::conectar();
		extract($datos);
		
		$hoy = date("y-m-d");
		
		//Foto
		$clave = uniqid();
		$foto = $_FILES['foto'];
		$nombre_foto = $clave.$foto['name'];

		$sql="INSERT INTO noticias(titulo, texto, foto, seccion, fecha, video) VALUES ('$titulo', '$texto', '$nombre_foto', '$seccion', '$hoy', '$video')";

		//Guardar imagen
		$destino = "../img/img-noticias/" . basename($nombre_foto);

		if (!move_uploaded_file($foto['tmp_name'], $destino)) {
			echo "<script>alert(Error al mover el archivo)<script>";
		}
		
		//Ejecutar sentencia
		$resultado=mysqli_query($conexion, $sql);
		
		if($resultado){
				$exito=true;
			}
			else{
				$exito=false;
			}

		//Cerrar la conexión
		mysqli_close($conexion);
		
		return($exito);
	}
	
	//Listar
	public function listar($inicio, $cantidad){
		$conexion=self::conectar();
		
		if($conexion){
			$sql="SELECT * FROM noticias ORDER BY cod_noticia DESC LIMIT $inicio,$cantidad";
			$resultado=mysqli_query($conexion, $sql);
			
			if($resultado){
				$noticias=array();
				
				while($fila=mysqli_fetch_assoc($resultado)){
					array_push($noticias, $fila);
				}
			}
			mysqli_close($conexion);
		}
		return($noticias);
	}

	//Listar seccion
	public function listar_seccion($inicio, $cantidad, $seccion){
		$conexion=self::conectar();
		
		if($conexion){
			$sql="SELECT * FROM noticias WHERE seccion='$seccion' ORDER BY cod_noticia DESC LIMIT $inicio,$cantidad";
			$resultado=mysqli_query($conexion, $sql);
			
			if($resultado){
				$noticias=array();
				
				while($fila=mysqli_fetch_assoc($resultado)){
					array_push($noticias, $fila);
				}
			}
			mysqli_close($conexion);
		}
		return($noticias);
	}
	
	//Listar noticia
	public function listar_noticia($noticia){
		$conexion=self::conectar();
		
		if($conexion){
			$sql="SELECT * FROM noticias WHERE cod_noticia='$noticia'";
			$resultado=mysqli_query($conexion, $sql);
			
			if($resultado){
				$noticia=array();
				
				while($fila=mysqli_fetch_assoc($resultado)){
					array_push($noticia, $fila);
				}
			}
			mysqli_close($conexion);
		}
		return($noticia);
	}
	
	//Eliminar
	public function eliminar($codigo, $foto){
		$conexion=self::conectar();
		
		unlink("../img/img-noticias/".$foto);
		
		if($conexion){
			$sql="DELETE FROM noticias WHERE cod_noticia='$codigo'";
			$resultado=mysqli_query($conexion, $sql);
			
			if($resultado){
				$exito=true;
			}
			else{
				$exito=false;
			}
			mysqli_close($conexion);
		}
		return($exito);
	}
	
	//Editar
	public function obtener_registro($codigo){
		$conexion=self::conectar();
		
		if($conexion){
			$sql="SELECT * FROM noticias WHERE cod_noticia='$codigo'";
			$resultado=mysqli_query($conexion, $sql);
			
			if($resultado){
				$noticia=array();
				$noticia=mysqli_fetch_assoc($resultado);
			}
			mysqli_close($conexion);
		}
		return($noticia);
	}
	
	public function editar($datos){
		$conexion=self::conectar();
		extract($datos);
		$hoy = date("y-m-d");
	
		if($_FILES['foto']['name']==""){
			$nombre_foto = $misma_foto;
		}
		else{
			$clave = uniqid();
			$foto = $_FILES['foto'];
			$nombre_foto = $clave.$foto['name'];
			
			//Guardar imagen
			$destino = "../img/img-noticias/" . basename($nombre_foto);

			if (!move_uploaded_file($foto['tmp_name'], $destino)) {
				echo "<script>alert(Error al mover el archivo)<script>";
			}
			unlink("../img/img-noticias/".$misma_foto);
		}
		$sql="UPDATE noticias SET titulo='$titulo', texto='$texto', foto='$nombre_foto', seccion='$seccion', fecha='$hoy', video='$video' WHERE cod_noticia='$cod_noticia'";
		$resultado=mysqli_query($conexion, $sql);
		
		if($resultado){
				$exito=true;
			}
			else{
				$exito=false;
			}
		mysqli_close($conexion);
		return($exito);
	}
	
	//Secciones
	public function devolver_nombre_seccion($codigo_seccion){
		$this -> secciones=new seccion();
		$esta_seccion = $this->secciones->obtener_registro($codigo_seccion);
		$nombre_seccion = $esta_seccion['seccion'];
		return($nombre_seccion);
	}
	
	//Mostrar lista
	public function mostrar_matriz($datos){
		echo("<table cellspacing='0'>");
		echo("<tr class='encabezado'>
				<td>Código</td>
				<td>Título</td>
				<td>Foto</td>
				<td>Sección</td>	
				<td class='fecha-lista'>Fecha</td>
				<td>Editar</td>
				<td>Eliminar</td>
			</tr>");
		
		foreach ($datos as $value) {
			echo("<tr>");
			$guardar_codigo=true;
			
			foreach ($value as $clave => $item){
			 	if($clave=='seccion'){
					$nombre_seccion=$this->devolver_nombre_seccion($item);
					echo("<td>".$nombre_seccion."</td>");
				}elseif($clave=='texto'){
					echo(/*"<td class='tabla-texto'>".$item."</td>"*/"");
				}
				elseif($clave=='foto'){
					$foto=$item;
					echo("<td><img src='../img/img-noticias/".$foto."' class='img-lista'><p>".$foto."</p></td>");
				}
				elseif($clave=='video'){
					echo("");
				}
				else{
					echo("<td>".$item."</td>");
				}
				
				if($guardar_codigo){
					$codigo=$item;
					$guardar_codigo=false;
				}
			}
			echo("<td><a href='modificar_noticia.php?editar=si&registro=".$codigo."'><img src='../img/pencil.png' class='icono'></a></td>
			
			<td><a href='?eliminar=si&registro=".$codigo."&foto=".$foto."'><img src='../img/delete.png' class='icono'></a></td>");
			echo("</tr>");
        }
		echo("</table>");
	}
	
	//Mostrar noticia
	public function mostrar_noticia($datos){
	
		foreach ($datos as $value) {
			$nombre_seccion=$this->devolver_nombre_seccion($value['seccion']);
			
			echo("
				<div class='noticia'>
					<h3>".$value['titulo']."</h3>
					<div class='noticia-int'>
						<img src='img/img-noticias/".$value['foto']."'>
						<div>
							".acortar_texto($value['texto'])."
							<a href='noticia.php?noticia=".$value['cod_noticia']."' class='leer-mas'>Leer más +</a>
						</div>
					</div>
					<div class='info-noticia'>
						<p>".$nombre_seccion."</p>
						<p>".$value['fecha']."</p>
					</div>
				</div>
			");
        }
	}

	//Mostrar noticia principal
	public function mostrar_principal($datos){
	
		foreach ($datos as $value) {
			$nombre_seccion=$this->devolver_nombre_seccion($value['seccion']);
			
			echo("
				<div class='principal'>
					<h2>".$value['titulo']."</h2>
					<div class='noticia-int'>
						<div>
							".acortar_texto($value['texto'])."						
							<a href='noticia.php?noticia=".$value['cod_noticia']."' class='leer-mas'>Leer más +</a>
						</div>
						<div>
							<img src='img/img-noticias/".$value['foto']."'>
							<div class='info-noticia'>
								<p>".$nombre_seccion."</p>
								<p>".$value['fecha']."</p>
							</div>
						</div>
					</div>
				</div>
			");
        }
	}

	//Ultimas noticias
	public function listar_ultimas_noticias($datos){
		foreach ($datos as $value) {
			echo("<li><a href='noticia.php?noticia=".$value['cod_noticia']."'>".$value['titulo']."</a></li>");
		}
	}
	
	//Página noticia
	public function pagina_noticia($datos){
		foreach ($datos as $value) {
			$nombre_seccion=$this->devolver_nombre_seccion($value['seccion']);
			$video = "";

			if ($value['video']!="") {
				$video="<iframe width='560' height='315' 
					src='https://www.youtube.com/embed/".$value['video']."' title='YouTube video player' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share' referrerpolicy='strict-origin-when-cross-origin' allowfullscreen></iframe>";
			}

			echo("
				<div class='noticia'>
				<h2>".$value['titulo']."</h2>
				<div class='info-noticia'>
					<p>".$nombre_seccion."</p>
					<p>".$value['fecha']."</p>
				</div>
				<img src='img/img-noticias/".$value['foto']."'>
				<div>
					<pre>".$value['texto']."</pre>
					".$video."
					<p>Nuevo Mundo</p>
				</div>
			</div>
			");
		}
	}

}

?>



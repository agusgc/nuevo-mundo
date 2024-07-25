<?php
class seccion{
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
		
		$sql="INSERT INTO secciones(seccion) VALUES ('$seccion')";

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
			$sql="SELECT * FROM secciones LIMIT $inicio,$cantidad";
			$resultado=mysqli_query($conexion, $sql);
			
			if($resultado){
				$secciones=array();
				
				while($fila=mysqli_fetch_assoc($resultado)){
					array_push($secciones, $fila);
				}
			}
			mysqli_close($conexion);
		}
		return($secciones);
	}
	
	//Eliminar
	public function eliminar($codigo){
		$conexion=self::conectar();
		
		if($conexion){
			$sql="DELETE FROM secciones WHERE cod_seccion='$codigo'";
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
			$sql="SELECT * FROM secciones WHERE cod_seccion='$codigo'";
			$resultado=mysqli_query($conexion, $sql);
			
			if($resultado){
				$seccion=array();
				$seccion=mysqli_fetch_assoc($resultado);
			}
			mysqli_close($conexion);
		}
		return($seccion);
	}
	
	public function editar($datos){
		$conexion=self::conectar();
		extract($datos);

		$sql="UPDATE secciones SET seccion='$seccion' WHERE cod_seccion='$cod_seccion'";
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
	
	//Mostrar
	public function mostrar_matriz($datos){
		echo("<table cellspacing='0'>");
		echo("<tr class='encabezado'>
				<td>Código</td>
				<td>Sección</td>
				<td>Editar</td>
				<td>Eliminar</td>
			</tr>");
		
		foreach ($datos as $value) {
			echo("<tr>");
			$guardar_codigo=true;
			
			foreach ($value as $clave => $item){
			 /* if($clave=='seccion'){
					$nombre_seccion=$this->devolver_nombre_seccion($item);
					echo("<td>".$nombre_seccion."</td>");
				}else{
					echo("<td>".$item."</td>");
				} */
				echo("<td>".$item."</td>");
				
				
				if($guardar_codigo){
					$codigo=$item;
					$guardar_codigo=false;
				}
			}
			echo("<td><a href='modificar_seccion.php?editar=si&registro=".$codigo."'><img src='../img/pencil.png' class='icono'></a></td>
			
			<td><a href='?eliminar=si&registro=".$codigo."'><img src='../img/delete.png' class='icono'></a></td>");
			echo("</tr>");
        }
		echo("</table>");
	}

	//Menú
	public function lista_menu($datos){
		foreach ($datos as $value) {
			echo("<li><a href='seccion.php?seccion=".$value['cod_seccion']."&page=0'>".$value['seccion']."</a></li>");
		}
	}
	
}

?>
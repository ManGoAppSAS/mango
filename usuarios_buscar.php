<?php
//nombre de la sesion, inicio de la sesión y conexion con la base de datos
include ("sis/nombre_sesion.php");

//verifico si la sesión está creada y si no lo está lo envio al logueo
if (!isset($_SESSION['correo']))
{
    header("location:logueo.php");
}
?>

<?php
//variables de la sesion
include ("sis/variables_sesion.php");
?>

<?php
//variable de búsqueda
if(isset($_POST['busqueda'])) $busqueda = $_POST['busqueda']; elseif(isset($_GET['busqueda'])) $busqueda = $_GET['busqueda']; else $busqueda = null;
?>

<?php
//consulto los usuario
if (isset($busqueda))
{
    //consulto el local previamente para la busqueda
    $consulta_previa = $conexion->query("SELECT local_id FROM local WHERE local like '%$busqueda%'");

    if ($filas_previa = $consulta_previa->fetch_assoc())
    {
        $local_id = $filas_previa['local_id'];
    }
    else
    {
        $local_id = null;
    }

	$consulta = mysqli_query($conexion, "SELECT usuario_id, estado, nombres, apellidos, tipo, imagen, imagen_nombre, local_id FROM usuario WHERE (correo LIKE '%$busqueda%' or nombres LIKE '%$busqueda%' or apellidos LIKE '%$busqueda%' or CONCAT(nombres, ' ', apellidos) LIKE '%$busqueda%' or tipo LIKE '%$busqueda%' or local_id LIKE '$local_id') and estado = 'activo' ORDER BY nombres, apellidos");

	if ($consulta->num_rows == 0)
    {       
        ?>
        
        <section class="rdm-lista">
            <article class="rdm-lista--item-sencillo">
                <div class="rdm-lista--izquierda-sencillo">
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--mensaje">No se ha encontrado <?php echo preg_replace("/$busqueda/i", "<span class='rdm-resaltado'>\$0</span>", $busqueda); ?></h2>
                    </div>
                </div>
            </article>
        </section>

    <?php
    }
    else 
    {		
        ?>  
        
        <section class="rdm-lista">        

        <?php

		//La variable $resultado contiene el array que se genera en la consulta, así que obtenemos los datos y los mostramos en un bucle
		while($fila = mysqli_fetch_array($consulta))
		{
		  	$usuario_id = $fila['usuario_id'];            
            $nombres = $fila['nombres'];
            $apellidos = $fila['apellidos'];
            $tipo = $fila['tipo'];
            $imagen = $fila['imagen'];
            $imagen_nombre = $fila['imagen_nombre'];
            $local_id = $fila['local_id'];

            $nombre_completo = "$nombres $apellidos";            

            //color de fondo segun la primer letra
            $primera_letra = "$nombres";
            include ("sis/avatar_color.php");

            //consulto el avatar
            if ($imagen == "no")
            {
                $imagen = '<div class="rdm-lista--avatar-color" style="background-color: '.$avatar_color_fondo.'">'.strtoupper(substr($nombres, 0, 1)).'</div>';
            }
            else
            {
                $imagen = "img/avatares/usuarios-$usuario_id-$imagen_nombre-m.jpg";
                $imagen = '<div class="rdm-lista--avatar" style="background-image: url('.$imagen.');"></div>';
            }

            //consulto el local
            $consulta2 = $conexion->query("SELECT * FROM local WHERE local_id = $local_id");

            if ($filas2 = $consulta2->fetch_assoc())
            {
                $local = ucfirst($filas2['local']);
                $local = "$tipo en $local";
            }
            else
            {
                $local = "$tipo";
            }
            ?>

            <a href="usuarios_detalle.php?usuario_id=<?php echo "$usuario_id"; ?>">
                <article class="rdm-lista--item-doble">
                    <div class="rdm-lista--izquierda">
                        <div class="rdm-lista--contenedor">
                            <?php echo "$imagen"; ?>
                        </div>
                        <div class="rdm-lista--contenedor">
                            <h2 class="rdm-lista--titulo"><?php echo preg_replace("/$busqueda/i", "<span class='rdm-resaltado'>\$0</span>", ucwords($nombre_completo)); ?></h2>
                            <h2 class="rdm-lista--texto-secundario"><?php echo preg_replace("/$busqueda/i", "<span class='rdm-resaltado'>\$0</span>", ucfirst($local)); ?></h2>
                        </div>
                    </div>                    
                </article>
            </a>

            <?php
        }

        ?>

        </section>

        <?php
    }
}
?>
<h2 class="rdm-lista--titulo-largo">Agregados</h2>
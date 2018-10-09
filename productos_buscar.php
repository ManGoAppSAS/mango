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
//consulto los productos
if (isset($busqueda))
{
    //consulto la categoria previamente para la busqueda
    $consulta_previa = $conexion->query("SELECT categoria_id FROM categoria WHERE categoria like '%$busqueda%'");

    if ($filas_previa = $consulta_previa->fetch_assoc())
    {
        $categoria_id = $filas_previa['categoria_id'];
    }
    else
    {
        $categoria_id = null;
    }

	$consulta = mysqli_query($conexion, "SELECT * FROM producto WHERE (producto LIKE '%$busqueda%' or tipo LIKE '%$busqueda%' or descripcion LIKE '%$busqueda%' or categoria_id LIKE '$categoria_id') and estado = 'activo' ORDER BY producto");

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
		  	$producto_id = $fila['producto_id'];
            $producto = $fila['producto'];
            $imagen = $fila['imagen'];
            $imagen_nombre = $fila['imagen_nombre'];
            $categoria_id = $fila['categoria_id'];

            //color de fondo segun la primer letra
            $primera_letra = "$producto";
            include ("sis/avatar_color.php");

            //consulto el avatar
            if ($imagen == "no")
            {
                $imagen = '<div class="rdm-lista--avatar-color" style="background-color: '.$avatar_color_fondo.'">'.strtoupper(substr($producto, 0, 1)).'</div>';
            }
            else
            {
                $imagen = "img/avatares/productos-$producto_id-$imagen_nombre-m.jpg";
                $imagen = '<div class="rdm-lista--avatar" style="background-image: url('.$imagen.');"></div>';
            }

            //consulto la categoria
            $consulta2 = $conexion->query("SELECT * FROM categoria WHERE categoria_id = $categoria_id");

            if ($filas2 = $consulta2->fetch_assoc())
            {
                $categoria = $filas2['categoria'];
            }
            else
            {
                $categoria = "No se ha asignado una categoria";
            }
            ?>

            <a href="productos_detalle.php?producto_id=<?php echo "$producto_id"; ?>">
                <article class="rdm-lista--item-doble">
                    <div class="rdm-lista--izquierda">
                        <div class="rdm-lista--contenedor">
                            <?php echo "$imagen"; ?>
                        </div>
                        <div class="rdm-lista--contenedor">
                            <h2 class="rdm-lista--titulo"><?php echo preg_replace("/$busqueda/i", "<span class='rdm-resaltado'>\$0</span>", ucfirst($producto)); ?></h2>
                            <h2 class="rdm-lista--texto-secundario"><?php echo preg_replace("/$busqueda/i", "<span class='rdm-resaltado'>\$0</span>", ucfirst($categoria)); ?></h2>
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
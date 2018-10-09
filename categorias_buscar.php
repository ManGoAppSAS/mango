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
//consulto los locales
if (isset($busqueda))
{
    $consulta = $conexion->query("SELECT * FROM categoria WHERE (categoria LIKE '%$busqueda%' or tipo LIKE '%$busqueda%') and estado = 'activo' ORDER BY categoria");

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

		while ($fila = $consulta->fetch_assoc()) 
		{
		  	$categoria_id = $fila['categoria_id'];
            $categoria = $fila['categoria'];
            $tipo = $fila['tipo'];
            $imagen = $fila['imagen'];
            $imagen_nombre = $fila['imagen_nombre'];

            //consulto la cantidad de productos
            $consulta_productos = $conexion->query("SELECT * FROM producto WHERE categoria_id = '$categoria_id'");
            $total_productos = $consulta_productos->num_rows;

            //color de fondo segun la primer letra
            $primera_letra = "$categoria";
            include ("sis/avatar_color.php");

            //consulto el avatar
            if ($imagen == "no")
            {
                $imagen = '<div class="rdm-lista--avatar-color" style="background-color: '.$avatar_color_fondo.'">'.strtoupper(substr($categoria, 0, 1)).'</div>';
            }
            else
            {
                $imagen = "img/avatares/categorias-$categoria_id-$imagen_nombre-m.jpg";
                $imagen = '<div class="rdm-lista--avatar" style="background-image: url('.$imagen.');"></div>';
            }
            ?>

            <a href="categorias_detalle.php?categoria_id=<?php echo "$categoria_id"; ?>">
                <article class="rdm-lista--item-doble">
                    <div class="rdm-lista--izquierda">
                        <div class="rdm-lista--contenedor">
                            <?php echo "$imagen"; ?>
                        </div>
                        <div class="rdm-lista--contenedor">
                            <h2 class="rdm-lista--titulo"><?php echo preg_replace("/$busqueda/i", "<span class='rdm-resaltado'>\$0</span>", ucfirst($categoria)); ?></h2>
                            <h2 class="rdm-lista--texto-secundario"><?php echo preg_replace("/$busqueda/i", "<span class='rdm-resaltado'>\$0</span>", ($total_productos)); ?> <?php echo preg_replace("/$busqueda/i", "<span class='rdm-resaltado'>\$0</span>", ucfirst($tipo)); ?></h2>
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
<h2 class="rdm-lista--titulo-largo">Agregadas</h2>
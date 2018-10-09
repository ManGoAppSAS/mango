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
//consulto los descuentos
if (isset($busqueda))
{
    $consulta = mysqli_query($conexion, "SELECT * FROM descuento WHERE (descuento LIKE '%$busqueda%' or porcentaje LIKE '%$busqueda%' or aplica LIKE '%$busqueda%') and estado = 'activo' ORDER BY descuento");

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
		  	$descuento_id = $fila['descuento_id'];
            $descuento = $fila['descuento'];
            $porcentaje = $fila['porcentaje'];
            $aplica = $fila['aplica'];

            //color de fondo segun la primer letra
            $primera_letra = "$descuento";
            include ("sis/avatar_color.php");

            //consulto el avatar
            $imagen = '<div class="rdm-lista--avatar-color" style="background-color: '.$avatar_color_fondo.'">'.strtoupper(substr($descuento, 0, 1)).'</div>';
            ?>

            <a href="descuentos_detalle.php?descuento_id=<?php echo "$descuento_id"; ?>">
                <article class="rdm-lista--item-doble">
                    <div class="rdm-lista--izquierda">
                        <div class="rdm-lista--contenedor">
                            <?php echo "$imagen"; ?>
                        </div>
                        <div class="rdm-lista--contenedor">
                            <h2 class="rdm-lista--titulo"><?php echo preg_replace("/$busqueda/i", "<span class='rdm-resaltado'>\$0</span>", ucwords($descuento)); ?></h2>
                            <h2 class="rdm-lista--texto-secundario"><?php echo preg_replace("/$busqueda/i", "<span class='rdm-resaltado'>\$0</span>", ($porcentaje)) ?>% en <?php echo preg_replace("/$busqueda/i", "<span class='rdm-resaltado'>\$0</span>", ucwords($aplica)); ?></h2>
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
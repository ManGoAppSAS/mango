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

	$consulta = mysqli_query($conexion, "SELECT *  FROM plantilla_factura WHERE (titulo LIKE '%$busqueda%' or encabezado LIKE '%$busqueda%' or local_id LIKE '$local_id') and estado = 'activo' ORDER BY titulo");

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
		  	$plantilla_factura_id = $fila['plantilla_factura_id'];
            $titulo = $fila['titulo'];
            $local_id = $fila['local_id'];

            //color de fondo segun la primer letra
            $primera_letra = "$titulo";
            include ("sis/avatar_color.php");

            //consulto el avatar
            $imagen = '<div class="rdm-lista--avatar-color" style="background-color: '.$avatar_color_fondo.'">'.strtoupper(substr($titulo, 0, 1)).'</div>';

            //consulto el local
            $consulta2 = $conexion->query("SELECT * FROM local WHERE local_id = $local_id");

            if ($filas2 = $consulta2->fetch_assoc())
            {
                $local = ucfirst($filas2['local']);
            }
            else
            {
                $local = "";
            }
            ?>

            <a href="plantillas_factura_detalle.php?plantilla_factura_id=<?php echo "$plantilla_factura_id"; ?>">
                <article class="rdm-lista--item-doble">
                    <div class="rdm-lista--izquierda-sencillo">
                        <div class="rdm-lista--contenedor">
                            <?php echo "$imagen"; ?>
                        </div>
                        <div class="rdm-lista--contenedor">
                            <h2 class="rdm-lista--titulo"><?php echo preg_replace("/$busqueda/i", "<span class='rdm-resaltado'>\$0</span>", ucfirst($titulo)); ?></h2>
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
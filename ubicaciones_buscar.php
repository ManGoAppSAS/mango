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

	$consulta = mysqli_query($conexion, "SELECT ubicacion_id, ubicacion, ubicada, tipo, local_id FROM ubicacion WHERE (ubicacion LIKE '%$busqueda%' or ubicada LIKE '%$busqueda%' or tipo LIKE '%$busqueda%' or local_id LIKE '$local_id') and estado = 'activo' ORDER BY ubicacion");

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
		  	$ubicacion_id = $fila['ubicacion_id'];
            $ubicacion = $fila['ubicacion'];
            $ubicada = $fila['ubicada'];
            $tipo = $fila['tipo'];
            $local_id = $fila['local_id'];

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

            //muestro el icono según el tipo de ubicación
            if ($tipo == "barra")
            {
                $imagen = '<div class="rdm-lista--icono"><div class="rdm-lista--icono"><i class="zmdi zmdi-cocktail zmdi-hc-2x"></i></div></div>';
            }
            else
            {
                if ($tipo == "caja")
                {
                    $imagen = '<div class="rdm-lista--icono"><div class="rdm-lista--icono"><i class="zmdi zmdi-laptop zmdi-hc-2x"></i></div></div>';
                }
                else
                {
                    if ($tipo == "habitacion")
                    {
                        $imagen = '<div class="rdm-lista--icono"><div class="rdm-lista--icono"><i class="zmdi zmdi-hotel zmdi-hc-2x"></i></div></div>';
                    }
                    else
                    {
                        if ($tipo == "mesa")
                        {
                            $imagen = '<div class="rdm-lista--icono"><div class="rdm-lista--icono"><i class="zmdi zmdi-cutlery zmdi-hc-2x"></i></div></div>';
                        }
                        else
                        {
                            if ($tipo == "persona")
                            {
                                $imagen = '<div class="rdm-lista--icono"><div class="rdm-lista--icono"><i class="zmdi zmdi-face zmdi-hc-2x"></i></div></div>';
                            }
                            else
                            {
                                if ($tipo == "domicilio")
                                {
                                    $imagen = '<div class="rdm-lista--icono"><div class="rdm-lista--icono"><i class="zmdi zmdi-bike zmdi-hc-2x"></i></div></div>';
                                }
                                else
                                {
                                    $imagen = '<div class="rdm-lista--icono"><div class="rdm-lista--icono"><i class="zmdi zmdi-seat zmdi-hc-2x"></i></div></div>';
                                }
                            }
                        }
                    }
                }
            }
            ?>

            <a href="ubicaciones_detalle.php?ubicacion_id=<?php echo "$ubicacion_id"; ?>">
                <article class="rdm-lista--item-doble">
                    <div class="rdm-lista--izquierda">
                        <div class="rdm-lista--contenedor">
                            <?php echo "$imagen"; ?>
                        </div>
                        <div class="rdm-lista--contenedor">
                            <h2 class="rdm-lista--titulo"><?php echo preg_replace("/$busqueda/i", "<span class='rdm-resaltado'>\$0</span>", ucwords($ubicacion)); ?></h2>
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
<h2 class="rdm-lista--titulo-largo">Agregadas</h2>
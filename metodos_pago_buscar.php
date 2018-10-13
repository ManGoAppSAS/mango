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
//consulto los impuestos
if (isset($busqueda))
{
    $consulta = mysqli_query($conexion, "SELECT * FROM metodo_pago WHERE (metodo LIKE '%$busqueda%' or tipo LIKE '%$busqueda%') and estado = 'activo' ORDER BY metodo");

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
		  	$metodo_pago_id = $fila['metodo_pago_id'];
            $metodo = $fila['metodo'];
            $tipo = $fila['tipo'];

            //color de fondo segun la primer letra
            $avatar_id = $metodo_pago_id;
            $avatar_nombre = "$metodo";

            include ("sis/avatar_color.php");

            //consulto el avatar
            if ($tipo == "bono")
            {
                $imagen = '<div class="rdm-lista--avatar-color" style="background-color: hsl('.$ab_hue.', '.$ab_sat.', '.$ab_lig.'); color: hsl('.$at_hue.', '.$at_sat.', '.$at_lig.');"><i class="zmdi zmdi-card-membership zmdi-hc-2x"></i></div>';
            }
            else
            {
                if ($tipo == "canje")
                {
                    $imagen = '<div class="rdm-lista--avatar-color" style="background-color: hsl('.$ab_hue.', '.$ab_sat.', '.$ab_lig.'); color: hsl('.$at_hue.', '.$at_sat.', '.$at_lig.');"><i class="zmdi zmdi-refresh-alt zmdi-hc-2x"></i></div>';
                }
                else
                {
                    if ($tipo == "cheque")
                    {
                        $imagen = '<div class="rdm-lista--avatar-color" style="background-color: hsl('.$ab_hue.', '.$ab_sat.', '.$ab_lig.'); color: hsl('.$at_hue.', '.$at_sat.', '.$at_lig.');"><i class="zmdi zmdi-square-o zmdi-hc-2x"></i></div>';
                    }
                    else
                    {
                        if ($tipo == "efectivo")
                        {
                            $imagen = '<div class="rdm-lista--avatar-color" style="background-color: hsl('.$ab_hue.', '.$ab_sat.', '.$ab_lig.'); color: hsl('.$at_hue.', '.$at_sat.', '.$at_lig.');"><i class="zmdi zmdi-money-box zmdi-hc-2x"></i></div>';
                        }
                        else
                        {
                            if ($tipo == "consignacion")
                            {
                                $imagen = '<div class="rdm-lista--avatar-color" style="background-color: hsl('.$ab_hue.', '.$ab_sat.', '.$ab_lig.'); color: hsl('.$at_hue.', '.$at_sat.', '.$at_lig.');"><i class="zmdi zmdi-balance zmdi-hc-2x"></i></div>';
                            }
                            else
                            {
                                if ($tipo == "transferencia")
                                {
                                    $imagen = '<div class="rdm-lista--avatar-color" style="background-color: hsl('.$ab_hue.', '.$ab_sat.', '.$ab_lig.'); color: hsl('.$at_hue.', '.$at_sat.', '.$at_lig.');"><i class="zmdi zmdi-smartphone-iphone zmdi-hc-2x"></i></div>';
                                }
                                else
                                {
                                    $imagen = '<div class="rdm-lista--avatar-color" style="background-color: hsl('.$ab_hue.', '.$ab_sat.', '.$ab_lig.'); color: hsl('.$at_hue.', '.$at_sat.', '.$at_lig.');"><i class="zmdi zmdi-card zmdi-hc-2x"></i></div>'; 
                                }

                            }
                        }
                    }
                }
            }
            ?>

            <a href="metodos_pago_detalle.php?metodo_pago_id=<?php echo "$metodo_pago_id"; ?>">
                <article class="rdm-lista--item-doble">
                    <div class="rdm-lista--izquierda">
                        <div class="rdm-lista--contenedor">
                            <?php echo "$imagen"; ?>
                        </div>
                        <div class="rdm-lista--contenedor">
                            <h2 class="rdm-lista--titulo"><?php echo preg_replace("/$busqueda/i", "<span class='rdm-resaltado'>\$0</span>", ucfirst($metodo)); ?></h2>
                            <h2 class="rdm-lista--texto-secundario"><?php echo preg_replace("/$busqueda/i", "<span class='rdm-resaltado'>\$0</span>", ucfirst($tipo)); ?></h2>
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
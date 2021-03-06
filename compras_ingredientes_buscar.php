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
if(isset($_POST['compra_id'])) $compra_id = $_POST['compra_id']; elseif(isset($_GET['compra_id'])) $compra_id = $_GET['compra_id']; else $compra_id = null;
?>

<?php
//consulto los ingredientes
if (isset($busqueda))
{

    //consulto el proveedor previamente para la busqueda
    $consulta_previa = $conexion->query("SELECT * FROM proveedor WHERE proveedor like '%$busqueda%'");

    if ($filas_previa = $consulta_previa->fetch_assoc())
    {
        $proveedor_id = $filas_previa['proveedor_id'];
    }
    else
    {
        $proveedor_id = null;
    }

    $consulta = mysqli_query($conexion, "SELECT * FROM ingrediente WHERE (ingrediente LIKE '%$busqueda%' or proveedor_id LIKE '$proveedor_id') and estado = 'activo' and tipo = 'comprado' ORDER BY ingrediente");	

	//Si no existe ninguna fila que sea igual a $consultaBusqueda, entonces mostramos el siguiente mensaje
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
            $ingrediente_id = $fila['ingrediente_id'];
            $ingrediente = $fila['ingrediente'];
            $unidad_compra = $fila['unidad_compra'];
            $costo_unidad_compra = $fila['costo_unidad_compra'];

            $proveedor_id = $fila['proveedor_id'];

            //color de fondo segun la primer letra
            $avatar_id = $ingrediente_id;
            $avatar_nombre = "$ingrediente";

            include ("sis/avatar_color.php");
            
            //consulto el avatar
            $imagen = '<div class="rdm-lista--avatar-color" style="background-color: hsl('.$ab_hue.', '.$ab_sat.', '.$ab_lig.'); color: hsl('.$at_hue.', '.$at_sat.', '.$at_lig.');"><span class="rdm-lista--avatar-texto">'.strtoupper(substr($avatar_nombre, 0, 1)).'</span></div>';

            //consulto el proveedor
            $consulta2 = $conexion->query("SELECT * FROM proveedor WHERE proveedor_id = $proveedor_id");

            if ($filas2 = $consulta2->fetch_assoc())
            {
                $proveedor = $filas2['proveedor'];
            }
            else
            {
                $proveedor = "";
            }

            //consulto si este ingrediente ya esta en la compra
            $consulta3 = $conexion->query("SELECT * FROM compra_ingrediente WHERE compra_id = $compra_id and ingrediente_id = '$ingrediente_id'");

            if ($filas3 = $consulta3->fetch_assoc())
            {
                $compra_ingrediente_id = $filas3['compra_ingrediente_id'];
                $cantidad_enviada = $filas3['cantidad_enviada'];
            }
            else
            {
                $cantidad_enviada = 0;
            }
            ?>
            
            <article class="rdm-lista--item-doble">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <?php echo "$imagen"; ?>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo"><?php echo preg_replace("/$busqueda/i", "<span class='rdm-resaltado'>\$0</span>", ucfirst($ingrediente)); ?></h2>
                        <h2 class="rdm-lista--texto-secundario">$<?php echo preg_replace("/$busqueda/i", "<span class='rdm-resaltado'>\$0</span>", number_format($costo_unidad_compra, 2, ",", ".")); ?> x <?php echo preg_replace("/$busqueda/i", "<span class='rdm-resaltado'>\$0</span>", ucfirst($unidad_compra)); ?></h2>
                        <h2 class="rdm-lista--texto-secundario"><?php echo preg_replace("/$busqueda/i", "<span class='rdm-resaltado'>\$0</span>", ucfirst($proveedor)); ?></h2>
                    </div>

                </div>

                <?php if ($cantidad_enviada == 0) { ?>

                <div class="rdm-lista--derecha-sencillo">
                    <a href="" data-toggle="modal" data-target="#dialogo_agregar" data-busqueda="<?php echo ucfirst($busqueda) ?>" data-ingrediente="<?php echo ucfirst($ingrediente) ?>" data-ingrediente_id="<?php echo "$ingrediente_id"; ?>" data-unidad_compra="<?php echo ucfirst($unidad_compra) ?>" data-proveedor="<?php echo ucfirst($proveedor) ?>" data-compra_id="<?php echo ucfirst($compra_id) ?>"><div class="rdm-lista--icono"><i class="zmdi zmdi-plus-circle-o zmdi-hc-2x" style="color: rgba(0, 0, 0, 0.6)"></i></div></a>
                </div>

                <?php } else { ?>

                <div class="rdm-lista--derecha">
                    <a href="" data-toggle="modal" data-target="#dialogo_editar" data-busqueda="<?php echo ucfirst($busqueda) ?>" data-ingrediente="<?php echo ucfirst($ingrediente) ?>" data-ingrediente_id="<?php echo "$ingrediente_id"; ?>" data-unidad_compra="<?php echo ucfirst($unidad_compra) ?>" data-cantidad_enviada="<?php echo ucfirst($cantidad_enviada) ?>" data-compra_ingrediente_id="<?php echo ucfirst($compra_ingrediente_id) ?>" data-proveedor="<?php echo ucfirst($proveedor) ?>"><div class="rdm-lista--icono"><i class="zmdi zmdi-edit zmdi-hc-2x" style="color: rgba(0, 0, 0, 0.6)"></i></div></a>

                    <a href="" data-toggle="modal" data-target="#dialogo_eliminar" data-busqueda="<?php echo ucfirst($busqueda) ?>" data-compra_ingrediente_id="<?php echo ($compra_ingrediente_id) ?>" data-ingrediente="<?php echo ucfirst($ingrediente); ?>"><div class="rdm-lista--icono"><i class="zmdi zmdi-minus-circle-outline zmdi-hc-2x" style="color: rgba(0, 0, 0, 0.6)"></i></div></a>
                </div>

                <?php } ?>
            </article>                       


            <?php
        }

        ?>

        </section>

        <?php
    }
}
?>
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
if(isset($_POST['producto_id'])) $producto_id = $_POST['producto_id']; elseif(isset($_GET['producto_id'])) $producto_id = $_GET['producto_id']; else $producto_id = null;
?>

<?php
//consulto los componentes
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

    $consulta = mysqli_query($conexion, "SELECT * FROM componente WHERE (componente LIKE '%$busqueda%' or proveedor_id LIKE '$proveedor_id') and estado = 'activo' and tipo = 'comprado' ORDER BY componente");	

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
            $componente_id = $fila['componente_id'];
            $componente = $fila['componente'];
            $unidad_minima = $fila['unidad_minima'];
            $unidad_compra = $fila['unidad_compra'];
            $costo_unidad_minima = $fila['costo_unidad_minima'];
            $costo_unidad_compra = $fila['costo_unidad_compra'];

            $proveedor_id = $fila['proveedor_id'];

            //color de fondo segun la primer letra
            $avatar_id = $componente_id;
            $avatar_nombre = "$componente";

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
            ?>

            
                <article class="rdm-lista--item-doble">
                    <div class="rdm-lista--izquierda">
                        <div class="rdm-lista--contenedor">
                            <?php echo "$imagen"; ?>
                        </div>
                        <div class="rdm-lista--contenedor">
                            <h2 class="rdm-lista--titulo"><?php echo preg_replace("/$busqueda/i", "<span class='rdm-resaltado'>\$0</span>", ucfirst($componente)); ?></h2>
                            <h2 class="rdm-lista--texto-secundario">$<?php echo preg_replace("/$busqueda/i", "<span class='rdm-resaltado'>\$0</span>", number_format($costo_unidad_minima, 2, ",", ".")); ?> x <?php echo preg_replace("/$busqueda/i", "<span class='rdm-resaltado'>\$0</span>", ucfirst($unidad_minima)); ?> • <?php echo preg_replace("/$busqueda/i", "<span class='rdm-resaltado'>\$0</span>", ucfirst($proveedor)); ?></h2>
                        </div>

                    </div>
                    <div class="rdm-lista--derecha-sencillo">
                        <a href="" data-toggle="modal" data-target="#dialogo_agregar" data-componente="<?php echo ucfirst($componente) ?>" data-componente_id="<?php echo "$componente_id"; ?>" data-unidad_minima="<?php echo ucfirst($unidad_minima) ?>"><div class="rdm-lista--icono"><i class="zmdi zmdi-plus zmdi-hc-2x" style="color: rgba(0, 0, 0, 0.6)"></i></div></a>
                    </div>
                </article>
                       


            <?php
        }

        ?>

        </section>

        <?php
    }
}
?>

<h2 class="rdm-lista--titulo-largo">Componentes agregados</h2>
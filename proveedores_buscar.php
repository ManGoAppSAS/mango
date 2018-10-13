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
    $consulta = $conexion->query("SELECT * FROM proveedor WHERE (proveedor LIKE '%$busqueda%' or documento_numero LIKE '%$busqueda%' or tipo LIKE '%$busqueda%' or contacto LIKE '%$busqueda%' or telefono LIKE '%$busqueda%' or correo LIKE '%$busqueda%' or cuenta_bancaria LIKE '%$busqueda%') and estado = 'activo' ORDER BY proveedor");

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
		  	$proveedor_id = $fila['proveedor_id'];
            $proveedor = $fila['proveedor'];
            $telefono = $fila['telefono'];
            $imagen = $fila['imagen'];
            $imagen_nombre = $fila['imagen_nombre'];

            //color de fondo segun la primer letra
            $avatar_id = $proveedor_id;
            $avatar_nombre = "$proveedor";

            include ("sis/avatar_color.php");
            
            //consulto el avatar
            if ($imagen == "no")
            {
                $imagen = '<div class="rdm-lista--avatar-color" style="background-color: hsl('.$ab_hue.', '.$ab_sat.', '.$ab_lig.'); color: hsl('.$at_hue.', '.$at_sat.', '.$at_lig.');"><span class="rdm-lista--avatar-texto">'.strtoupper(substr($avatar_nombre, 0, 1)).'</span></div>';
            }
            else
            {
                $imagen = "img/avatares/proveedores-$proveedor_id-$imagen_nombre-m.jpg";
                $imagen = '<div class="rdm-lista--avatar" style="background-image: url('.$imagen.');"></div>';
            }
            ?>

            <a href="proveedores_detalle.php?proveedor_id=<?php echo "$proveedor_id"; ?>">
                <article class="rdm-lista--item-doble">
                    <div class="rdm-lista--izquierda-sencillo">
                        <div class="rdm-lista--contenedor">
                            <?php echo "$imagen"; ?>
                        </div>
                        <div class="rdm-lista--contenedor">
                            <h2 class="rdm-lista--titulo"><?php echo preg_replace("/$busqueda/i", "<span class='rdm-resaltado'>\$0</span>", ucfirst($proveedor)); ?></h2>
                            <h2 class="rdm-lista--texto-secundario"><?php echo preg_replace("/$busqueda/i", "<span class='rdm-resaltado'>\$0</span>", ucfirst($telefono)); ?></h2>
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
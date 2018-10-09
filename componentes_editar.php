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
//capturo las variables que pasan por URL o formulario
if(isset($_POST['componente_id'])) $componente_id = $_POST['componente_id']; elseif(isset($_GET['componente_id'])) $componente_id = $_GET['componente_id']; else $componente_id = null;
?>

<?php
//consulto la información del componente
$consulta = $conexion->query("SELECT * FROM componente WHERE componente_id = '$componente_id'");

if ($fila = $consulta->fetch_assoc()) 
{
    $componente_id = $fila['componente_id'];
    
    $componente = $fila['componente'];
    $unidad_minima = $fila['unidad_minima'];
    $unidad_compra = $fila['unidad_compra'];
    $costo_unidad_minima = $fila['costo_unidad_minima'];
    $costo_unidad_compra = $fila['costo_unidad_compra'];

    $proveedor_id = $fila['proveedor_id'];

    //consulto el proveedor
    $consulta_proveedor = $conexion->query("SELECT * FROM proveedor WHERE proveedor_id = '$proveedor_id'");           

    if ($fila = $consulta_proveedor->fetch_assoc()) 
    {
        $proveedor_g = ucfirst($fila['proveedor']);
        $proveedor_g = "<option value='$proveedor_id'>$proveedor_g</option>";
    }
    else
    {
        $proveedor_g = "<option value=''></option>";
    }
}
else
{
    header("location:componentes_ver.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Componente - ManGo!</title>
    <?php
    //información del head
    include ("partes/head.php");
    //fin información del head
    ?>
</head>
<body>

<header class="rdm-toolbar--contenedor">
    <div class="rdm-toolbar--fila">
        <div class="rdm-toolbar--izquierda">
            <a href="componentes_detalle.php?componente_id=<?php echo "$componente_id"; ?>"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Componente</h2>
        </div>
        <div class="rdm-toolbar--derecha" id="abrir_modal">
            <div class="rdm-toolbar--icono-derecha"><i class="zmdi zmdi-delete zmdi-hc-2x"></i></div>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <h2 class="rdm-lista--titulo-largo">Editar</h2>

    <form action="componentes_detalle.php" method="post" enctype="multipart/form-data">

        <section class="rdm-formulario">

            <input type="hidden" name="componente_id" value="<?php echo "$componente_id"; ?>" />
            
            <?php
            //consulto y muestro los proveedores
            $consulta = $conexion->query("SELECT * FROM proveedor WHERE estado = 'activo' ORDER BY proveedor");

            //sin no hay regisros creo un input hidden con id 1
            if ($consulta->num_rows == 0)
            {
                ?>

                <input type="hidden" id="1" name="proveedor_id" value="1">

                <?php
            }
            else
            {
                //si solo hay un registro muestro un input hidden con el id
                if ($consulta->num_rows == 1)
                {
                    while ($fila = $consulta->fetch_assoc()) 
                    {
                        $proveedor_id = $fila['proveedor_id'];
                        $proveedor = $fila['proveedor'];
                    }
                    ?>
                        
                    <input type="hidden" id="<?php echo ($proveedor_id) ?>" name="proveedor_id" value="<?php echo ($proveedor_id) ?>">

                    <?php
                    
                }
                else
                {
                    ?>

                    <p class="rdm-formularios--label"><label for="proveedor_id">Proveedor*</label></p>
                    <p><select id="proveedor_id" name="proveedor_id" required autofocus>

                    <?php
                    //si hay mas de un registro los muestro todos menos el proveedor que acabe de guardar
                    $consulta = $conexion->query("SELECT * FROM proveedor WHERE proveedor_id != $proveedor_id and estado = 'activo' ORDER BY proveedor");

                    ?>
                        
                    <?php echo "$proveedor_g"; ?>

                    <?php
                    while ($fila = $consulta->fetch_assoc()) 
                    {
                        $proveedor_id = $fila['proveedor_id'];
                        $proveedor = $fila['proveedor'];
                        ?>

                        <option value="<?php echo "$proveedor_id"; ?>"><?php echo ucfirst($proveedor) ?></option>

                        <?php
                    }
                    ?>

                    </select></p>
                    <p class="rdm-formularios--ayuda">Proveedor que vende el componente</p>
                    
                    <?php
                }
            }
            ?>

            <p class="rdm-formularios--label"><label for="componente">Nombre*</label></p>
            <p><input type="text" id="componente" name="componente" value="<?php echo "$componente"; ?>" required autofocus /></p>
            <p class="rdm-formularios--ayuda">Nombre del componente</p>
            
            <p class="rdm-formularios--label"><label for="unidad_compra">Unidad de compra*</label></p>
            <p><select id="unidad_compra" name="unidad_compra" required>
                <option value="<?php echo "$unidad_compra"; ?>"><?php echo $unidad_compra ?></option>
                <option value="">---------</option>
                <option value="g">Gramo (g)</option>
                <option value="ml">Mililitro (ml)</option>
                <option value="mm">Milimetro (mm)</option>
                <option value="">---------</option>
                <option value="kg">Kilogramo (kg)</option>
                <option value="l">Litro (l)</option>
                <option value="m">Metro (m)</option>
                <option value="">---------</option>
                <option value="arroba 12.5 kg">arroba 12.5 kg</option>
                <option value="bulto 25 kg">bulto 25 kg</option>
                <option value="bulto 50 kg">bulto 50 kg</option>
                <option value="">---------</option>
                <option value="botella 375 ml">botella 375 ml</option>
                <option value="botella 750 ml">botella 750 ml</option>
                <option value="botella 1500 ml">botella 1500 ml</option>
                <option value="garrafa 2000 ml">garrafa 2000 ml</option>
                <option value="">---------</option>
                <option value="galon 3.7 l">galon 3.7 l</option>
                <option value="botella 3 l">botella 3 l</option>
                <option value="botella 5 l">botella 5 l</option>
                <option value="botellon 18 l">botellon 18 l</option>
                <option value="botellon 20 l">botellon 20 l</option>
                <option value="">---------</option>
                <option value="unid">unid</option>
                <option value="par">par</option>
                <option value="trio">trio</option>
                <option value="decena">decena</option>
                <option value="docena">docena</option>
                <option value="quincena">quincena</option>
                <option value="treintena">treintena</option>
                <option value="centena">centena</option>
            </select></p>
            <p class="rdm-formularios--ayuda">Unidad de compra del componente</p>

            <p class="rdm-formularios--label"><label for="costo_unidad_compra">Costo unidad de compra*</label></p>
            <p><input type="number" id="costo_unidad_compra" name="costo_unidad_compra" value="<?php echo "$costo_unidad_compra"; ?>" step="any" required /></p>
            <p class="rdm-formularios--ayuda">Costo de la unidad de compra</p>  
            
            <button type="submit" class="rdm-boton--fab" name="editar" value="si"><i class="zmdi zmdi-check zmdi-hc-2x"></i></button>

    </section>

    </form>

    <div id="dialogo" class="rdm-tarjeta--modal">     
        <div class="rdm-tarjeta--modal-contenido">
            <div class="rdm-tarjeta--primario-largo">
                <h1 class="rdm-tarjeta--titulo-largo">¿Eliminar componente?</h1>
            </div>
            <div class="rdm-tarjeta--cuerpo">
                ¿Deseas eliminar <b><?php echo ($componente); ?></b>?
            </div>
            <br>
            <div class="rdm-tarjeta--acciones-derecha">
                <button class="rdm-boton--plano" id="cerrar_modal">Cancelar</button>
                <a href="componentes_ver.php?eliminar=si&componente_id=<?php echo "$componente_id"; ?>"><button class="rdm-boton--resaltado">Eliminar</button></a>
            </div>
        </div>
    </div>

<footer></footer>

<script type="text/javascript">
    var modal = document.getElementById('dialogo');
    var btn = document.getElementById("abrir_modal");
    var span = document.getElementById("cerrar_modal");
    btn.onclick = function() {
        modal.style.display = "block";
    }
    span.onclick = function() {
        modal.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

</body>
</html>
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
if(isset($_POST['categoria_id'])) $categoria_id = $_POST['categoria_id']; elseif(isset($_GET['categoria_id'])) $categoria_id = $_GET['categoria_id']; else $categoria_id = null;
?>

<?php
//consulto la información de la categoria
$consulta = $conexion->query("SELECT * FROM categoria WHERE categoria_id = '$categoria_id'");

if ($fila = $consulta->fetch_assoc()) 
{
    $categoria_id = $fila['categoria_id'];
    $categoria = $fila['categoria'];
    $tipo = $fila['tipo'];
    $adicion = $fila['adicion'];
    $imagen = $fila['imagen'];
    $imagen_nombre = $fila['imagen_nombre'];
}
else
{
    header("location:categorias_ver.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Categoría - ManGo!</title>
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
            <a href="categorias_detalle.php?categoria_id=<?php echo "$categoria_id"; ?>"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Categoría</h2>
        </div>        
        <div class="rdm-toolbar--derecha" id="abrir_modal">
            <div class="rdm-toolbar--icono-derecha"><i class="zmdi zmdi-delete zmdi-hc-2x"></i></div>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <h2 class="rdm-lista--titulo-largo">Editar</h2>

    <form action="categorias_detalle.php" method="post" enctype="multipart/form-data">

        <section class="rdm-formulario">
    
            <input type="hidden" name="action" value="image" />
            <input type="hidden" name="categoria_id" value="<?php echo "$categoria_id"; ?>" />
            <input type="hidden" name="imagen" value="<?php echo "$imagen"; ?>" />
            <input type="hidden" name="imagen_nombre" value="<?php echo "$imagen_nombre"; ?>" />

            <p class="rdm-formularios--label"><label for="categoria">Nombre*</label></p>
            <p><input type="text" id="categoria" name="categoria" value="<?php echo "$categoria"; ?>" required autofocus /></p>
            <p class="rdm-formularios--ayuda">Nombre de la categoría</p>
            
            <p class="rdm-formularios--label"><label for="tipo">Tipo*</label></p>
            <p><select id="tipo" name="tipo" required>
                <option value="<?php echo "$tipo"; ?>"><?php echo ucfirst($tipo) ?></option>
                <option value=""></option>
                <option value="productos">Productos</option>
                <option value="servicios">Servicios</option>
            </select></p>
            <p class="rdm-formularios--ayuda">Tipo de categoría</p>
            
            <?php
            //atributo checked
            if ($adicion == "si")
            {
                $adicion_checked = "checked";
            }
            else
            {
                $adicion_checked = "";
            }
            ?>
    
            <p class="rdm-formularios--label"><label for="adicion">Adiciones*</label></p>
            <p class="rdm-formularios--checkbox">
                <input type="checkbox" id="adicion" name="adicion" class="rdm-formularios--switch" value="si" <?php echo "$adicion_checked"; ?>>
                <label for="adicion" class="rdm-formularios--switch-label">
                    <span class="rdm-formularios--switch-encendido">Si</span>
                    <span class="rdm-formularios--switch-apagado">No</span>
                </label>
            </p>
            <p class="rdm-formularios--ayuda">¿Esta categoría es de adiciones?</p>

            <p class="rdm-formularios--label"><label for="archivo">Imagen</label></p>
            <p><input type="file" id="archivo" name="archivo" /></p>
            <p class="rdm-formularios--ayuda">Usa una imagen para identificarlo</p>

            <button type="submit" class="rdm-boton--fab" name="editar" value="si"><i class="zmdi zmdi-check zmdi-hc-2x"></i></button>

        </section>
    
    </form>

    <div id="dialogo" class="rdm-tarjeta--modal">
        <div class="rdm-tarjeta--modal-contenido">
            <div class="rdm-tarjeta--primario-largo">
                <h1 class="rdm-tarjeta--titulo-largo">¿Eliminar categoría?</h1>
            </div>
            <div class="rdm-tarjeta--cuerpo">
                ¿Deseas eliminar <b><?php echo ($categoria); ?></b>?
            </div>
            <br>
            <div class="rdm-tarjeta--acciones-derecha">
                <button class="rdm-boton--plano" id="cerrar_modal">Cancelar</button>
                <a href="categorias_ver.php?eliminar=si&categoria_id=<?php echo "$categoria_id"; ?>"><button class="rdm-boton--resaltado">Eliminar</button></a>
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
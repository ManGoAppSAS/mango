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
//variables de la conexion, sesion y subida
include ("sis/variables_sesion.php");
include('sis/subir.php');

$carpeta_destino = (isset($_GET['dir']) ? $_GET['dir'] : 'img/avatares');
$dir_pics = (isset($_GET['pics']) ? $_GET['pics'] : $carpeta_destino);
?>

<?php
//variables de subida
if(isset($_POST['agregar'])) $agregar = $_POST['agregar']; elseif(isset($_GET['agregar'])) $agregar = $_GET['agregar']; else $agregar = null;
if(isset($_POST['editar'])) $editar = $_POST['editar']; elseif(isset($_GET['editar'])) $editar = $_GET['editar']; else $editar = null;
if(isset($_POST['archivo'])) $archivo = $_POST['archivo']; elseif(isset($_GET['archivo'])) $archivo = $_GET['archivo']; else $archivo = null;

//variables del formulario
if(isset($_POST['ingrediente_producido_preparacion_id'])) $ingrediente_producido_preparacion_id = $_POST['ingrediente_producido_preparacion_id']; elseif(isset($_GET['ingrediente_producido_preparacion_id'])) $ingrediente_producido_preparacion_id = $_GET['ingrediente_producido_preparacion_id']; else $ingrediente_producido_preparacion_id = null;
if(isset($_POST['ingrediente_producido_id'])) $ingrediente_producido_id = $_POST['ingrediente_producido_id']; elseif(isset($_GET['ingrediente_producido_id'])) $ingrediente_producido_id = $_GET['ingrediente_producido_id']; else $ingrediente_producido_id = null;
if(isset($_POST['paso'])) $paso = $_POST['paso']; elseif(isset($_GET['paso'])) $paso = $_GET['paso']; else $paso = null;
if(isset($_POST['preparacion'])) $preparacion = $_POST['preparacion']; elseif(isset($_GET['preparacion'])) $preparacion = $_GET['preparacion']; else $preparacion = null;

//variables del mensaje
if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;

//variables de la imagen
if(isset($_POST['imagen'])) $imagen = $_POST['imagen']; elseif(isset($_GET['imagen'])) $imagen = $_GET['imagen']; else $imagen = null;
if(isset($_POST['imagen_nombre'])) $imagen_nombre = $_POST['imagen_nombre']; elseif(isset($_GET['imagen_nombre'])) $imagen_nombre = $_GET['imagen_nombre']; else $imagen_nombre = null;
?>

<?php
//agregar el paso de la preparacion
if ($agregar == 'si')
{
    if (!(isset($archivo)) && ($_FILES['archivo']['type'] == "image/jpeg") || ($_FILES['archivo']['type'] == "image/png"))
    {
        $imagen = "si";
    }
    else
    {
        $imagen = "no";
    }

    $consulta = $conexion->query("SELECT * FROM ingrediente_producido_preparacion WHERE preparacion = '$preparacion' and ingrediente_producido_id = '$ingrediente_producido_id'");

    if ($consulta->num_rows == 0)
    {
        $imagen_ref = "preparacion";

        $insercion = $conexion->query("INSERT INTO ingrediente_producido_preparacion values ('', '$ahora', '', '', '$sesion_id', '', '', 'activo', '$paso', '$preparacion', '$imagen', '$ahora_img', '$ingrediente_producido_id')");

        $mensaje = "Paso de preparación agregado";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";

        $id = $conexion->insert_id;
        $ingrediente_producido_preparacion_id = $id;

        //si han cargado el archivo subimos la imagen
        include('imagenes_subir.php');
    }
    else
    {
        $mensaje = "El paso de preparación ya existe, no es posible agregarlo de nuevo";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "error";
    }
}
?>





<?php
//actualizo la información del paso
if ($editar == "si")
{
    if (!(isset($archivo)) && ($_FILES['archivo']['type'] == "image/jpeg") || ($_FILES['archivo']['type'] == "image/png"))
    {
        $imagen = "si";
        $imagen_nombre = $ahora_img;
        $imagen_ref = "preparacion";
        $id = $ingrediente_producido_preparacion_id;

        //si han cargado el archivo subimos la imagen
        include('imagenes_subir.php');
    }
    else
    {
        $imagen = $imagen;
        $imagen_nombre = $imagen_nombre;
    }
    
    $actualizar = $conexion->query("UPDATE ingrediente_producido_preparacion SET fecha_mod = '$ahora', usuario_mod = '$sesion_id', preparacion = '$preparacion', imagen = '$imagen', imagen_nombre = '$imagen_nombre' WHERE ingrediente_producido_preparacion_id = '$ingrediente_producido_preparacion_id'");    

    if ($actualizar)
    {
        $mensaje = "Cambios guardados";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";
    }     
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Preparación - ManGo!</title>    
    <?php
    //información del head
    include ("partes/head.php");
    //fin información del head
    ?>

</head>
<body <?php echo $body_snack; ?>>

<header class="rdm-toolbar--contenedor">
    <div class="rdm-toolbar--fila">
        <div class="rdm-toolbar--izquierda">
            <a href="ingredientes_producidos_detalle.php?ingrediente_producido_id=<?php echo "$ingrediente_producido_id"; ?>#preparacion"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Preparación</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">



    <?php
    //consulto la composicion de este ingrediente producido
    $consulta = $conexion->query("SELECT * FROM ingrediente_producido_preparacion WHERE ingrediente_producido_id = '$ingrediente_producido_id' and estado = 'activo' ORDER BY fecha_alta ASC");

    if ($consulta->num_rows == 0)
    {
        $paso = 0;

        ?>

        <h2 class="rdm-lista--titulo-largo">Preparación</h2>

        <section class="rdm-lista">
            
            <article class="rdm-lista--item-doble">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--avatar"><div class="rdm-lista--icono"><i class="zmdi zmdi-info zmdi-hc-2x"></i></div></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Vacio</h2>
                        <h2 class="rdm-lista--texto-secundario">No se han agregado pasos de preparación</h2>
                    </div>
                </div>
            </article>

            <div class="rdm-tarjeta--separador"></div>

            

        </section>

        
        <?php
    }
    else
    {   ?>

        <a id="preparacion">

        <h2 class="rdm-lista--titulo-largo">Pasos</h2>

        <section class="rdm-lista"> 

        <?php

        while ($fila = $consulta->fetch_assoc())
        {
            //datos de la composicion
            $ingrediente_producido_preparacion_id = $fila['ingrediente_producido_preparacion_id'];
            $paso = $fila['paso'];
            $preparacion = $fila['preparacion'];
            $ingrediente_producido_id = $fila['ingrediente_producido_id'];

            $imagen = $fila['imagen'];
            $imagen_nombre = $fila['imagen_nombre'];            

            //color de fondo segun la primer letra
            $avatar_id = $ingrediente_producido_preparacion_id;
            $avatar_nombre = "$paso";

            include ("sis/avatar_color.php");

            //consulto la imagen de la preparacion
            if ($imagen == "no")
            {
                $imagen_preparacion = "";
            }
            else
            {
                $imagen_preparacion = "img/avatares/preparacion-$ingrediente_producido_preparacion_id-$imagen_nombre.jpg";
                $imagen_preparacion = '<div class="rdm-tarjeta--media-cuadrado" style="background-image: url('.$imagen_preparacion.');"></div>';
            }
            
            ?>


                <div class="rdm-lista--item-doble">
                    <div class="rdm-lista--izquierda">
                        <div class="rdm-lista--contenedor">
                            <div class="rdm-lista--avatar-color" style="background-color: hsl(<?php echo $sca ?>, 50%, 80%); color: hsl(<?php echo $sca ?>, 80%, 30%);"><span class="rdm-lista--avatar-texto"><?php echo "$paso"; ?></span></div>
                        </div>
                        <div class="rdm-lista--contenedor">
                            <h2 class="rdm-lista--titulo">Paso <?php echo ($paso); ?></h2>
                            <h2 class="rdm-lista--texto-secundario"><?php echo ucfirst($preparacion); ?></h2>

                        </div>
                    </div>

                    <div class="rdm-lista--derecha">
                        <a href="" data-toggle="modal" data-target="#dialogo_editar" data-paso="<?php echo ucfirst($paso) ?>" data-ingrediente_producido_preparacion_id="<?php echo ucfirst($ingrediente_producido_preparacion_id) ?>" data-imagen="<?php echo ucfirst($imagen) ?>" data-imagen_nombre="<?php echo ucfirst($imagen_nombre) ?>" data-preparacion="<?php echo "$preparacion"; ?>"><div class="rdm-lista--icono"><i class="zmdi zmdi-edit zmdi-hc-2x" style="color: rgba(0, 0, 0, 0.6)"></i></div></a>

                        
                    </div>
                </div>   
                <?php echo "$imagen_preparacion"; ?>         

            
            
        <?php
        }
        ?>

        </section>

    <?php
    }
    ?>

















    
</main>

<div id="rdm-snackbar--contenedor">
    <div class="rdm-snackbar--fila">
        <div class="rdm-snackbar--primario-<?php echo $mensaje_tema; ?>">
            <h2 class="rdm-snackbar--titulo"><?php echo "$mensaje"; ?></h2>
        </div>
    </div>
</div>

<footer>
    
    <a data-toggle="modal" data-target="#dialogo_agregar" data-busqueda="<?php echo ucfirst($busqueda) ?>" data-ingrediente="<?php echo ucfirst($ingrediente) ?>" data-ingrediente_id="<?php echo "$ingrediente_id"; ?>" data-unidad_minima="<?php echo ucfirst($unidad_minima) ?>">
       <button class="rdm-boton--fab" name="agregar" value="si"><i class="zmdi zmdi-plus zmdi-hc-2x"></i></button> 

    </a>


</footer>


<!--dialogo para agregar el ingrediente-->

<div class="modal" id="dialogo_agregar" tabindex="-1" role="dialog">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="rdm-tarjeta--primario-largo">
                <h1 class="rdm-tarjeta--titulo-largo">
                    Agregar paso
                </h1>
            </div>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">

                <div class="rdm-tarjeta--cuerpo">
                    Agrega un paso para la preparación
                </div>

                <div class="rdm-tarjeta--modal-cuerpo">
                    

                    <input type="hidden" name="ingrediente_producido_id" value="<?php echo "$ingrediente_producido_id"; ?>" />
                    <input type="hidden" name="action" value="image" />

                    <?php $paso = $paso + 1; ?>

                    <input type="hidden" name="paso" value="<?php echo "$paso"; ?>" />

                    <p class="rdm-formularios--label"><label for="preparacion">Descripción</label></p>
                    <p><textarea id="preparacion" name="preparacion" required></textarea></p>
                    <p class="rdm-formularios--ayuda">Escribe el paso de la preparación</p>

                    <p class="rdm-formularios--label"><label for="archivo">Imagen</label></p>
                    <p><input type="file" id="archivo" name="archivo" /></p>
                    <p class="rdm-formularios--ayuda">Usa una imagen descriptiva</p>


                </div>            

                <div class="rdm-tarjeta--acciones-derecha">
                    <button class="rdm-boton--plano" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="rdm-boton--plano-resaltado" name="agregar" value="si">Agregar</button> 
                </div>

            </form>
          
        </div>
    </div>
</div>

<script>
$('#dialogo_agregar').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) 
  var busqueda = button.data('busqueda') 
  var ingrediente = button.data('ingrediente') 
  var ingrediente_id = button.data('ingrediente_id') 
  var unidad_minima = button.data('unidad_minima')
  var modal = $(this)
  modal.find('.busqueda').val(busqueda)
  modal.find('.ingrediente').text('' + ingrediente + '')
  modal.find('.ingrediente_id').val(ingrediente_id)
  modal.find('.unidad_minima').text('' + unidad_minima + '')
})
</script>













<!--dialogo para agregar el ingrediente-->

<div class="modal" id="dialogo_editar" tabindex="-1" role="dialog">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="rdm-tarjeta--primario-largo">
                <h1 class="rdm-tarjeta--titulo-largo">
                    Actualizar paso
                </h1>
            </div>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">

                <div class="rdm-tarjeta--cuerpo">
                    Edita este paso para la preparación
                </div>

                <div class="rdm-tarjeta--modal-cuerpo">
                    

                    <input type="hidden" class="ingrediente_producido_preparacion_id" name="ingrediente_producido_preparacion_id" value="" />
                    <input type="hidden" name="ingrediente_producido_id" value="<?php echo "$ingrediente_producido_id"; ?>" />
                    <input type="hidden" name="action" value="image" />

                    <input type="hidden" class="imagen" name="imagen" value="" />
                    <input type="hidden" class="imagen_nombre" name="imagen_nombre" value="" />

                    <input type="hidden" class="paso" name="paso" />

                    <p class="rdm-formularios--label"><label for="preparacion">Descripción</label></p>
                    <p><textarea id="preparacion" class="preparacion" name="preparacion" required></textarea></p>
                    <p class="rdm-formularios--ayuda">Escribe el paso de la preparación</p>

                    <p class="rdm-formularios--label"><label for="archivo">Imagen</label></p>
                    <p><input type="file" id="archivo" name="archivo" /></p>
                    <p class="rdm-formularios--ayuda">Usa una imagen descriptiva</p>


                </div>            

                <div class="rdm-tarjeta--acciones-derecha">
                    <button class="rdm-boton--plano" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="rdm-boton--plano-resaltado" name="editar" value="si">actualizar</button> 
                </div>

            </form>
          
        </div>
    </div>
</div>

<script>
$('#dialogo_editar').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) 
  var ingrediente_producido_preparacion_id = button.data('ingrediente_producido_preparacion_id') 
  var paso = button.data('paso') 
  var preparacion = button.data('preparacion') 
  var imagen = button.data('imagen') 
  var imagen_nombre = button.data('imagen_nombre') 
  var modal = $(this)
  modal.find('.ingrediente_producido_preparacion_id').val(ingrediente_producido_preparacion_id)
  modal.find('.paso').val(paso)
  modal.find('.preparacion').val(preparacion)
  modal.find('.imagen').val(imagen)
  modal.find('.imagen_nombre').val(imagen_nombre)
})
</script>

<script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js"></script>
<script>$(document).ready(function() { $('body').bootstrapMaterialDesign(); });</script>

</body> 
</html>
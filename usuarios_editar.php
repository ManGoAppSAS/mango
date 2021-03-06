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
if(isset($_POST['usuario_id'])) $usuario_id = $_POST['usuario_id']; elseif(isset($_GET['usuario_id'])) $usuario_id = $_GET['usuario_id']; else $usuario_id = null;
?>

<?php
//consulto la información del usuario
$consulta = $conexion->query("SELECT * FROM usuario WHERE usuario_id = '$usuario_id'");

if ($fila = $consulta->fetch_assoc()) 
{
    $usuario_id = $fila['usuario_id'];
    
    $nombres = $fila['nombres'];
    $apellidos = $fila['apellidos'];
    $documento_tipo = $fila['documento_tipo'];
    $documento_numero = $fila['documento_numero'];
    $tipo = $fila['tipo'];
    $correo = $fila['correo'];
    $contrasena = $fila['contrasena'];

    $telefono = $fila['telefono'];
    $telefono_emergencia = $fila['telefono_emergencia'];
    $direccion = $fila['direccion'];
    $fecha_nacimiento = $fila['fecha_nacimiento'];
    $porcentaje_comision = $fila['porcentaje_comision'];

    $imagen = $fila['imagen'];
    $imagen_nombre = $fila['imagen_nombre'];

    $local_id = $fila['local_id'];

    //consulto el local
    $consulta_local = $conexion->query("SELECT * FROM local WHERE local_id = '$local_id'");           

    if ($fila = $consulta_local->fetch_assoc()) 
    {
        $local_id_g = $fila['local_id'];
        $local_g = $fila['local'];
        $local_g = "<option value='$local_id_g'>$local_g</option>";
    }
    else
    {
        $local_id_g = 0;
        $local_g = "<option value=''>No se ha asignado un local</option>";
    }
}
else
{
    header("location:usuarios_ver.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Usuario - ManGo!</title>
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
            <a href="usuarios_detalle.php?usuario_id=<?php echo "$usuario_id"; ?>"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Usuario</h2>
        </div>
        <div class="rdm-toolbar--derecha">
            <div class="rdm-toolbar--icono-derecha">
                <a href="" data-toggle="modal" data-target="#dialogo" data-dato1="<?php echo ucfirst($usuario_id) ?>" data-dato2="<?php echo "$nombres"; ?> <?php echo "$apellidos"; ?>"><div class="rdm-lista--icono"><i class="zmdi zmdi-delete zmdi-hc-2x"></i></div></a>
            </div>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <h2 class="rdm-lista--titulo-largo">Editar</h2>

    <form action="usuarios_detalle.php" method="post" enctype="multipart/form-data">

        <section class="rdm-formulario">
        
            <input type="hidden" name="action" value="image" />
            <input type="hidden" name="usuario_id" value="<?php echo "$usuario_id"; ?>" />
            <input type="hidden" name="imagen" value="<?php echo "$imagen"; ?>" />
            <input type="hidden" name="imagen_nombre" value="<?php echo "$imagen_nombre"; ?>" />
            
            <?php
            //consulto y muestro los locales
            $consulta = $conexion->query("SELECT * FROM local WHERE estado = 'activo' ORDER BY local");

            //sin no hay regisros creo un input hidden con id 1
            if ($consulta->num_rows == 0)
            {
                ?>

                <input type="hidden" id="1" name="local_id" value="1">

                <?php
            }
            else
            {
                //si solo hay un registro muestro un input hidden con el id
                if ($consulta->num_rows == 1)
                {
                    while ($fila = $consulta->fetch_assoc()) 
                    {
                        $local_id = $fila['local_id'];
                        $local = $fila['local'];
                    }
                    ?>
                        
                    <input type="hidden" id="<?php echo ($local_id) ?>" name="local_id" value="<?php echo ($local_id) ?>">

                    <?php
                    
                }
                else
                {
                    ?>

                    <p class="rdm-formularios--label"><label for="local_id">Local*</label></p>
                    <p><select id="local_id" name="local_id" required autofocus>

                    <?php
                    //si hay mas de un registro los muestro todos menos el local que acabe de guardar
                    $consulta = $conexion->query("SELECT * FROM local WHERE local_id != $local_id and estado = 'activo' ORDER BY local");

                    ?>
                        
                    <?php echo "$local_g"; ?>

                    <?php
                    while ($fila = $consulta->fetch_assoc()) 
                    {
                        $local_id = $fila['local_id'];
                        $local = $fila['local'];
                        ?>

                        <option value="<?php echo "$local_id"; ?>"><?php echo ucfirst($local) ?></option>

                        <?php
                    }
                    ?>

                    </select></p>
                    <p class="rdm-formularios--ayuda">Local al que se relaciona el usuario</p>
                    
                    <?php
                }
            }
            ?>

            <p class="rdm-formularios--label"><label for="nombres">Nombres*</label></p>
            <p><input type="text" id="nombres" name="nombres" value="<?php echo "$nombres"; ?>" spellcheck="false" required /></p>
            <p class="rdm-formularios--ayuda">Nombres del usuario</p>
            
            <p class="rdm-formularios--label"><label for="apellidos">Apellidos*</label></p>
            <p><input type="text" id="apellidos" name="apellidos" value="<?php echo "$apellidos"; ?>" spellcheck="false" required /></p>
            <p class="rdm-formularios--ayuda">Apellidos del usuario</p>

            <p class="rdm-formularios--label"><label for="documento_tipo">Tipo de documento*</label></p>
            <p><select id="documento_tipo" name="documento_tipo" required>
                <option value="<?php echo "$documento_tipo"; ?>"><?php echo ucfirst($documento_tipo) ?></option>
                <option value=""></option>
                <option value="CC">CC</option>
                <option value="cedula extranjeria">Cédula de extranjería</option>
                <option value="NIT">NIT</option>
                <option value="pasaporte">Pasaporte</option>
                <option value="TI">TI</option>
            </select></p>
            <p class="rdm-formularios--ayuda">Tipo de documento, CC, NIT, TI, etc.</p>

            <p class="rdm-formularios--label"><label for="documento_numero">Documento*</label></p>
            <p><input type="number" id="documento_numero" name="documento_numero" value="<?php echo "$documento_numero"; ?>" required /></p>
            <p class="rdm-formularios--ayuda">Documento de identificación del usuario</p>

            <p class="rdm-formularios--label"><label for="tipo">Tipo*</label></p>
            <p><input type="text" id="tipo" name="tipo" value="<?php echo "$tipo"; ?>" spellcheck="false" required /></p>
            <p class="rdm-formularios--ayuda">Tipo de usuario, socio, administrador, vendedor, etc.</p>                        
            
            <p class="rdm-formularios--label"><label for="correo">Correo electrónico*</label></p>
            <p><input type="email" id="correo" name="correo" value="<?php echo "$correo"; ?>" spellcheck="false" required  /></p>
            <p class="rdm-formularios--ayuda">Correo electrónico para ingresar a ManGo!</p>
            
            <p class="rdm-formularios--label"><label for="contrasena">Contraseña*</label></p>
            <p><input type="text" id="contrasena" name="contrasena" value="<?php echo "$contrasena"; ?>" required /></p>
            <p class="rdm-formularios--ayuda">Contraseña para ingresar a ManGo!</p>        

            <p class="rdm-formularios--label"><label for="telefono">Teléfono</label></p>
            <p><input type="number" id="telefono" name="telefono" value="<?php echo "$telefono"; ?>"  /></p>
            <p class="rdm-formularios--ayuda">Teléfono del usuario</p>

            <p class="rdm-formularios--label"><label for="telefono_emergencia">Teléfono de emergencia</label></p>
            <p><input type="number" id="telefono_emergencia" name="telefono_emergencia" value="<?php echo "$telefono_emergencia"; ?>"  /></p>
            <p class="rdm-formularios--ayuda">Teléfono de en caso de emergencia</p>

            <p class="rdm-formularios--label"><label for="direccion">Dirección</label></p>
            <p><input type="text" id="direccion" name="direccion" value="<?php echo "$direccion"; ?>" spellcheck="false"  /></p>
            <p class="rdm-formularios--ayuda">Dirección del usuario</p>

            <p class="rdm-formularios--label"><label for="fecha_nacimiento">Fecha de nacimiento</label></p>
            <p><input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo "$fecha_nacimiento"; ?>" spellcheck="false" /></p>
            <p class="rdm-formularios--ayuda">Fecha de nacimiento del usuario</p>

            <p class="rdm-formularios--label"><label for="porcentaje_comision">Comisión de ventas</label></p>
            <p><input type="number" min="0" max="100" id="porcentaje_comision" name="porcentaje_comision" value="<?php echo "$porcentaje_comision"; ?>" step="any" required /></p>
            <p class="rdm-formularios--ayuda">Valor del porcentaje sin símbolos o guiones</p>

            <p class="rdm-formularios--label"><label for="archivo">Imagen</label></p>
            <p><input type="file" id="archivo" name="archivo" /></p>
            <p class="rdm-formularios--ayuda">Usa una imagen para identificarlo</p>
            
            <button type="submit" class="rdm-boton--fab" name="editar" value="si"><i class="zmdi zmdi-check zmdi-hc-2x"></i></button>

        </section>

    </form>    

<footer></footer>

<!--dialogo para eliminar-->

<div class="modal" id="dialogo" tabindex="-1" role="dialog">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="rdm-tarjeta--primario-largo">
                <h1 class="rdm-tarjeta--titulo-largo">
                    Eliminar usuario
                </h1>
            </div>

            <form action="usuarios_ver.php" method="post" enctype="multipart/form-data">

                <div class="rdm-tarjeta--cuerpo">
                    ¿Desea eliminar <b><span class="modal-texto-dato2"></span></b>?
                </div>

                <div class="rdm-tarjeta--modal-cuerpo">
                    <input type="hidden" class="modal-input1" name="usuario_id" value="">
                </div>            

                <div class="rdm-tarjeta--acciones-derecha">
                    <button class="rdm-boton--plano" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="rdm-boton--plano-resaltado" name="eliminar" value="si">Eliminar</button>                    
                </div>

            </form>
          
        </div>
    </div>
</div>

<script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js"></script>
<script>$(document).ready(function() { $('body').bootstrapMaterialDesign(); });</script>

<script>
$('#dialogo').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) 
  var dato1 = button.data('dato1') 
  var dato2 = button.data('dato2') 
  var modal = $(this)
  modal.find('.modal-texto-dato1').text('' + dato1 + '')
  modal.find('.modal-texto-dato2').text('' + dato2 + '')
  modal.find('.modal-input1').val(dato1)
})
</script>

</body>
</html>
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
if(isset($_POST['proveedor_id'])) $proveedor_id = $_POST['proveedor_id']; elseif(isset($_GET['proveedor_id'])) $proveedor_id = $_GET['proveedor_id']; else $proveedor_id = null;
?>

<?php
//consulto la información del proveedor
$consulta = $conexion->query("SELECT * FROM proveedor WHERE proveedor_id = '$proveedor_id'");

if ($fila = $consulta->fetch_assoc()) 
{
    $proveedor_id = $fila['proveedor_id'];
    
    $proveedor = $fila['proveedor'];
    $documento_tipo = $fila['documento_tipo'];
    $documento_numero = $fila['documento_numero'];
    $tipo = $fila['tipo'];
    $correo = $fila['correo'];  
    $contacto = $fila['contacto'];  
    $telefono = $fila['telefono'];  
    $direccion = $fila['direccion'];  
    $cuenta_bancaria = $fila['cuenta_bancaria'];

    $imagen = $fila['imagen'];
    $imagen_nombre = $fila['imagen_nombre'];
}
else
{
    header("location:proveedores_ver.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Proveedor - ManGo!</title>
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
            <a href="proveedores_detalle.php?proveedor_id=<?php echo "$proveedor_id"; ?>"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Proveedor</h2>
        </div>
        <div class="rdm-toolbar--derecha" id="abrir_modal">
            <div class="rdm-toolbar--icono-derecha"><i class="zmdi zmdi-delete zmdi-hc-2x"></i></div>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <h2 class="rdm-lista--titulo-largo">Editar</h2>

    <form action="proveedores_detalle.php" method="post" enctype="multipart/form-data">

        <section class="rdm-formulario">
        
            <input type="hidden" name="action" value="image" />
            <input type="hidden" name="proveedor_id" value="<?php echo "$proveedor_id"; ?>" />
            <input type="hidden" name="imagen" value="<?php echo "$imagen"; ?>" />
            <input type="hidden" name="imagen_nombre" value="<?php echo "$imagen_nombre"; ?>" />
            
            <p class="rdm-formularios--label"><label for="proveedor">Nombre*</label></p>
            <p><input type="text" id="proveedor" name="proveedor" value="<?php echo "$proveedor"; ?>" spellcheck="false" required autofocus /></p>
            <p class="rdm-formularios--ayuda">Nombre del proveedor</p>           

            <p class="rdm-formularios--label"><label for="documento_tipo">Tipo de documento*</label></p>
            <p><select id="documento_tipo" name="documento_tipo" required>
                <option value="<?php echo "$documento_tipo"; ?>"><?php echo ucfirst($documento_tipo) ?></option>
                <option value=""></option>
                <option value="CC">CC</option>
                <option value="cedula extranjeria">Cédula de extranjería</option>
                <option value="NIT">NIT</option>
                <option value="pasaporte">Pasaporte</option>
                <option value="RUT">RUT</option>
                <option value="TI">TI</option>
            </select></p>
            <p class="rdm-formularios--ayuda">Tipo de documento, CC, NIT, TI, etc.</p>

            <p class="rdm-formularios--label"><label for="documento_numero">Documento*</label></p>
            <p><input type="number" id="documento_numero" name="documento_numero" value="<?php echo "$documento_numero"; ?>" required /></p>
            <p class="rdm-formularios--ayuda">Documento de identificación del usuario</p>

            <p class="rdm-formularios--label"><label for="tipo">Tipo</label></p>
            <p><input type="text" id="tipo" name="tipo" value="<?php echo "$tipo"; ?>" spellcheck="false" /></p>
            <p class="rdm-formularios--ayuda">Tipo de proveedor, carnes, licores, empaques, etc.</p>            
            
            <p class="rdm-formularios--label"><label for="correo">Correo electrónico</label></p>
            <p><input type="email" id="correo" name="correo" value="<?php echo "$correo"; ?>" spellcheck="false" /></p>
            <p class="rdm-formularios--ayuda">Correo electrónico de contacto</p>
            
            <p class="rdm-formularios--label"><label for="contacto">Contacto</label></p>
            <p><input type="text" id="contacto" name="contacto" value="<?php echo "$contacto"; ?>" /></p>
            <p class="rdm-formularios--ayuda">Nombre de la persona encargada de facturación o pedidos</p>

            <p class="rdm-formularios--label"><label for="telefono">Teléfono</label></p>
            <p><input type="number" id="telefono" name="telefono" value="<?php echo "$telefono"; ?>" /></p>
            <p class="rdm-formularios--ayuda">Teléfono del proveedor</p>

            <p class="rdm-formularios--label"><label for="direccion">Dirección</label></p>
            <p><input type="text" id="direccion" name="direccion" value="<?php echo "$direccion"; ?>" spellcheck="false"  /></p>
            <p class="rdm-formularios--ayuda">Dirección del proveedor</p>

            <p class="rdm-formularios--label"><label for="cuenta_bancaria">Cuenta bancaria</label></p>
            <p><input type="text" id="cuenta_bancaria" name="cuenta_bancaria" value="<?php echo "$cuenta_bancaria"; ?>" spellcheck="false" /></p>
            <p class="rdm-formularios--ayuda">Número, tipo y banco</p>

            <p class="rdm-formularios--label"><label for="archivo">Imagen</label></p>
            <p><input type="file" id="archivo" name="archivo" /></p>
            <p class="rdm-formularios--ayuda">Usa una imagen para identificarlo</p>
            
            <button type="submit" class="rdm-boton--fab" name="editar" value="si"><i class="zmdi zmdi-check zmdi-hc-2x"></i></button>

    </section>

    </form>

    <div id="dialogo" class="rdm-tarjeta--modal">     
        <div class="rdm-tarjeta--modal-contenido">
            <div class="rdm-tarjeta--primario-largo">
                <h1 class="rdm-tarjeta--titulo-largo">¿Eliminar proveedor?</h1>
            </div>
            <div class="rdm-tarjeta--cuerpo">
                ¿Deseas eliminar <b><?php echo ($proveedor); ?></b>?
            </div>
            <br>
            <div class="rdm-tarjeta--acciones-derecha">
                <button class="rdm-boton--plano" id="cerrar_modal">Cancelar</button>
                <a href="proveedores_ver.php?eliminar=si&proveedor_id=<?php echo "$proveedor_id"; ?>"><button class="rdm-boton--resaltado">Eliminar</button></a>
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
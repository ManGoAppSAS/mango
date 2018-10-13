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
//variable para eliminar
if(isset($_POST['eliminar'])) $eliminar = $_POST['eliminar']; elseif(isset($_GET['eliminar'])) $eliminar = $_GET['eliminar']; else $eliminar = null;

//variable de consulta
if(isset($_POST['busqueda'])) $busqueda = $_POST['busqueda']; elseif(isset($_GET['busqueda'])) $busqueda = $_GET['busqueda']; else $busqueda = null;

//capturo las variables que pasan por URL o formulario
if(isset($_POST['local_id'])) $local_id = $_POST['local_id']; elseif(isset($_GET['local_id'])) $local_id = $_GET['local_id']; else $local_id = null;

if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php
//elimino el local
if ($eliminar == 'si')
{
    $consulta_usuarios = $conexion->query("SELECT * FROM usuario WHERE local_id = '$local_id'");
    if ($consulta_usuarios->num_rows == 0)
    {
        $borrar = $conexion->query("UPDATE local SET fecha_baja = '$ahora', usuario_baja = '$sesion_id', estado = 'eliminado' WHERE local_id = '$local_id'");

        if ($borrar)
        {
            $mensaje = "Local eliminado";
            $body_snack = 'onLoad="Snackbar()"';
            $mensaje_tema = "aviso";
        }
        
    }
    else
    {
        $mensaje = "No es posible eliminar el local por que aún tiene usuarios relacionados";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Locales - ManGo!</title>
    <?php
    //información del head
    include ("partes/head.php");
    //fin información del head
    ?>

    <script>
    $(document).ready(function() {
        $("#resultadoBusqueda").html('');
    });

    function buscar() {
        var textoBusqueda = $("input#busqueda").val();
     
         if (textoBusqueda != "") {
            $.post("locales_buscar.php", {busqueda: textoBusqueda}, function(mensaje) {
                $("#resultadoBusqueda").html(mensaje);
             }); 
         } else { 
            $("#resultadoBusqueda").html('');
            };
    };
    </script>
</head>
<body <?php echo $body_snack; ?>>

<header class="rdm-toolbar--contenedor">
    <div class="rdm-toolbar--fila">
        <div class="rdm-toolbar--izquierda">
            <a href="ajustes.php#locales"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Locales</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <?php
    //consulto los locales              
    $consulta = $conexion->query("SELECT local_id, local, tipo, direccion, imagen, imagen_nombre FROM local WHERE estado = 'activo' ORDER BY local");

    if ($consulta->num_rows == 0)
    {
        ?>        

        <div class="rdm-vacio--caja">
            <i class="zmdi zmdi-alert-circle-o zmdi-hc-4x"></i>
            <p class="rdm-tipografia--subtitulo1">No se han agregado locales</p>
            <p class="rdm-tipografia--cuerpo1--margen-ajustada">Los locales son todos los puntos de venta que puedes tener en tu negocio, por ejemplo: punto de venta Bogotá, punto de venta Medellín, punto de venta barrio poblado, punto de venta centro comercial del norte, etc.</p>
        </div>

        <?php
    }
    else
    {
        ?>        
            
        <input type="search" name="busqueda" id="busqueda" value="<?php echo "$busqueda"; ?>" placeholder="Buscar" maxlength="30" autofocus autocomplete="off" onKeyUp="buscar();" onFocus="buscar();" />

        <div id="resultadoBusqueda"></div>

        <section class="rdm-lista">

        <?php
        while ($fila = $consulta->fetch_assoc()) 
        {
            $local_id = $fila['local_id'];
            $local = $fila['local'];
            $direccion = $fila['direccion'];
            $imagen = $fila['imagen'];
            $imagen_nombre = $fila['imagen_nombre'];

            //color de fondo segun la primer letra
            $avatar_id = $local_id;
            $avatar_nombre = "$local";

            include ("sis/avatar_color.php");
            
            //consulto el avatar
            if ($imagen == "no")
            {
                $imagen = '<div class="rdm-lista--avatar-color" style="background-color: hsl('.$ab_hue.', '.$ab_sat.', '.$ab_lig.'); color: hsl('.$at_hue.', '.$at_sat.', '.$at_lig.');"><span class="rdm-lista--avatar-texto">'.strtoupper(substr($avatar_nombre, 0, 1)).'</span></div>';
            }
            else
            {
                $imagen = "img/avatares/locales-$local_id-$imagen_nombre-m.jpg";
                $imagen = '<div class="rdm-lista--avatar" style="background-image: url('.$imagen.');"></div>';
            }
            ?>

            <a href="locales_detalle.php?local_id=<?php echo "$local_id"; ?>">
                <article class="rdm-lista--item-doble">
                    <div class="rdm-lista--izquierda-sencillo">
                        <div class="rdm-lista--contenedor">
                            <?php echo "$imagen"; ?>
                        </div>
                        <div class="rdm-lista--contenedor">
                            <h2 class="rdm-lista--titulo"><?php echo ucfirst("$local"); ?></h2>
                            <h2 class="rdm-lista--texto-secundario"><?php echo ucfirst($direccion); ?></h2>
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
    
    <a href="locales_agregar.php"><button class="rdm-boton--fab" ><i class="zmdi zmdi-plus zmdi-hc-2x"></i></button></a>

</footer>

</body>
</html>
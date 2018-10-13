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
if(isset($_POST['metodo_pago_id'])) $metodo_pago_id = $_POST['metodo_pago_id']; elseif(isset($_GET['metodo_pago_id'])) $metodo_pago_id = $_GET['metodo_pago_id']; else $metodo_pago_id = null;

if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php
//elimino el metodo de pago
if ($eliminar == 'si')
{
    $borrar = $conexion->query("UPDATE metodo_pago SET fecha_baja = '$ahora', usuario_baja = '$sesion_id', estado = 'eliminado' WHERE metodo_pago_id = '$metodo_pago_id'");

    if ($borrar)
    {
        $mensaje = "Método de pago eliminado";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";
    }
    else
    {
        $mensaje = "No es posible eliminar el método de pago";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Métodos de pago - ManGo!</title>
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
            $.post("metodos_pago_buscar.php", {busqueda: textoBusqueda}, function(mensaje) {
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
            <a href="ajustes.php#metodos_pago"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Métodos de pago</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <?php
    //consulto los métodos de pago
    $consulta = $conexion->query("SELECT * FROM metodo_pago WHERE estado = 'activo' ORDER BY metodo");

    if ($consulta->num_rows == 0)
    {
        ?>        

        <div class="rdm-vacio--caja">
            <i class="zmdi zmdi-alert-circle-o zmdi-hc-4x"></i>
            <p class="rdm-tipografia--subtitulo1">No se han agregado métodos de pago</p>
            <p class="rdm-tipografia--cuerpo1--margen-ajustada">Los métodos de pago son los diferentes medios de cambio que recibes en tu negocio cuando tus clientes hacen una compra, por ejemplo: efectivo, tarjeta crédito, cheque, canje de servicios, etc.</p>
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
                            <h2 class="rdm-lista--titulo"><?php echo ucfirst($metodo); ?></h2>
                            <h2 class="rdm-lista--texto-secundario"><?php echo ucfirst($tipo); ?></h2>
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
    
    <a href="metodos_pago_agregar.php"><button class="rdm-boton--fab" ><i class="zmdi zmdi-plus zmdi-hc-2x"></i></button></a>

</footer>

</body>
</html>
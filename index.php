<?php
//nombre de la sesion, inicio de la sesión y conexion con la base de datos
include ("sis/nombre_sesion.php");
include ("sis/variables_sesion.php");

//verifico si la sesión está creada y si no lo está lo envio al logueo
if (!isset($_SESSION['correo']))
{
    header("location:logueo.php");
}
?>

<?php
// detalles de contacto
$consulta = $conexion->query("SELECT * FROM usuario WHERE usuario_id = $sesion_id and estado = 'activo'");
$fila = $consulta->fetch_assoc();
$telefono=$fila['telefono'];
$direccion=$fila['direccion'];

//url para buton de pagar en correo
$url_pagar="http://localhost/laboratorio/mango/cuenta_pago.php";

// Mandar un correo si su cuenta va a vencer
// buscar para ultimo pago Aceptada en baso de datos
$result = $conexion->query("SELECT  cliente_pago_id, fecha_alta,  max(fecha_alta) FROM cliente_pago WHERE cuenta_id=$sesion_id && pago_resultado='Aceptada'");

// buscar para la fecha de crecion de cuenta
$result2 = $conexion->query("SELECT  * FROM usuario WHERE usuario_id=$sesion_id");
$row2 = $result2->fetch_array(MYSQLI_ASSOC);
$fecha_creacion = $row2['fecha_alta'];

// calcular dias desde cuando se creo la cuenta
$fecha1 = new DateTime($fecha_creacion);
$fecha_ahora = new DateTime($ahora);
$dia_desde_creacion = $fecha1->diff($fecha_ahora);
$dia_desde_creacion=intval($dia_desde_creacion->format('%a'));

// convertir en un objeto
if($result!=false){
  $row = $result->fetch_array(MYSQLI_ASSOC);
  $fecha_ultimo_pago = $row['fecha_alta'];
}
else{
  $fecha_ultimo_pago = 0;
}

// subtract today's date from last payment or creation date  in days
if($fecha_ultimo_pago!=0){
  $fecha_pago =  new DateTime($fecha_ultimo_pago);
  $ultimo_pago_dias = $fecha_pago->diff($fecha_ahora);
  $ultimo_pago_dias=intval($ultimo_pago_dias->format('%a'));
}else{
  $ultimo_pago_dias=$dia_desde_creacion;
}
echo $dia_desde_creacion;
echo $ultimo_pago_dias;

?>
<?php
// cambiar el contacto de correo si no ha pagado
switch (true) {

  case  ($ultimo_pago_dias >=25 && $ultimo_pago_dias < 30):
    $asunto = 'Recordatorio: no pasó el pago de ManGo! App Premium';
    $cuerpo = '
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <title>Correo</title>
        <meta charset="utf-8" />
    </head>
    <body style="background: #fff;
                color: #333;
                font-size: 15px;
                font-weight: 300;">';

    $cuerpo .= '<p> <font color="red"> Volvamos a intentarlo </font><br></p>
    <p>No está pasando tu pago de ManGo! App Premium.<br>
    Esto podría deberse a que:<br>
    <ul>
      <li> Hay un problema con tu banco.</li>
      <li> Tu tarjeta de pago ha vencido.</li>
      <li> No hay fondos suficientes en tu cuenta.</li>
    </ul><br>
    Te pedimos que revises esta situación y que actualices tus datos de pago si es necesario.
    </p><br>';
    $cuerpo .='<form action="'.$url_pagar.'">
              <input type="submit" value="Pagar" />
              </form>';


    $cuerpo .= '
    </body>
    </html>';

  break;

  break;
  case  ($ultimo_pago_dias >=30 && $ultimo_pago_dias < 35):
    $asunto ='Perderás tu ManGo! App Premium en '.(5 - ($ultimo_pago_dias-30)).' días' ;
    $cuerpo = '
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <title>Correo</title>
        <meta charset="utf-8" />
    </head>
    <body style="background: #fff;
                color: #333;
                font-size: 15px;
                font-weight: 300;">';

    $cuerpo .= '<p> <font color="red">Sigamos juntos</font><br></p>
    <p>Te hemos enviado varios correos porque no logramos procesar tu pago de ManGo! App Premium.<br>
    Para mantener todo activo, actualiza tus datos de pago en los próximos '.(5-($ultimo_pago_dias-30));
    $cuerpo .= ' días.</p><br>';
    $cuerpo .='<form action="'.$url_pagar.'">
              <input type="submit" value="Pagar" />
              </form>';



    $cuerpo .= '
    </body>
    </html>';

  break;
  case  ($ultimo_pago_dias>=35):
    $asunto = 'recuerda para tener todas las ventajas de ManGo! app premium, solo debes de ir a ajustes, suscripcion, y pago.';
    $cuerpo = '
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <title>Correo</title>
        <meta charset="utf-8" />
    </head>
    <body style="background: #fff;
                color: #333;
                font-size: 15px;
                font-weight: 300;">';

    $cuerpo .= '<p><font color="red">nos apena que no puedas seguir con nuestro servicio.</font><br></p>
    <p>Como no pudimos tomar tu pago, hemos puesto tu suscripción en pausa por el momento.<br>
    Podrás seguir disfrutando del sistema POS en la parte de ventas.<br><br>
    La buena noticia es que ManGo! App Premium solo está a un clic de distancia.
    </p><br>';
    $cuerpo .='<form action="'.$url_pagar.'">
              <input type="submit" value="Pagar" />
              </form>';

    $cuerpo .= '
    </body>
    </html>';
  break;

  default:
  break;
}

// texto para correo para mandar en primer mes
$asunto_primer_mes ='recordatorio de que es gratis durante el primer mes';
$cuerpo_primer_mes = '
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Correo</title>
    <meta charset="utf-8" />
</head>
<body style="background: #fff;
            color: #333;
            font-size: 15px;
            font-weight: 300;">';

$cuerpo_primer_mes .= '<p>pagando premium tendras acceso ilimitado a todos los reportes
                       graficas y producciones que quieras sin limite.</p><br>';
$cuerpo_primer_mes .='<form action="'.$url_pagar.'">
           <input type="submit" value="Pagar" />
          </form>';
$cuerpo_primer_mes .= '
</body>
</html>';


//funcion de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

    $mail = new PHPMailer(true);
    try {
        //configuracion del servidor que envia el correo
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'mangoapp.co;mail.mangoapp.co';
        $mail->SMTPAuth = true;
        $mail->Username = 'notificaciones@mangoapp.co';
        $mail->Password = 'renacimiento';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        //Enviado por
        $mail->setFrom('notificaciones@mangoapp.co', ucfirst($sesion_local));

        //Destinatario
        //change for actual version
        $mail->addAddress($sesion_correo);

        //Responder a
        $mail->addReplyTo('notificaciones@mangoapp.co', 'ManGo! App');

        //Contenido del correo
        $mail->isHTML(true);

        //asigno asunto y cuerpo a las variables de la funcion
        $mail->Subject = $asunto;
        $mail->Body    = $cuerpo;

        // Activo condificacción utf-8
        $mail->CharSet = 'UTF-8';
        //ejecuto la funcion y envio el correo si necesita pagar
        if($ultimo_pago_dias >=25 && $ultimo_pago_dias <= 35){
          if($_SESSION["correo_envio"]==0){
            $mail->send();
            // insert query
            $insercion = $conexion->query("INSERT INTO cliente_cuenta VALUES ('','$ahora','','','$sesion_id','','', 'activo', '', '','$sesion_documento_tipo', '$sesion_documento_numero','$sesion_tipo', '$sesion_correo','', '$telefono' , '$direccion')");
           }
           $_SESSION["correo_envio"]=1;
        }

        // mandar un correo  para el primer mes de Subscripcion
        // en las primeros 5 dias
        if($dia_desde_creacion<=5){
         if($_SESSION["correo_envio_primero"]==0){
            $mail->Subject = $asunto_primer_mes;
            $mail->Body    = $cuerpo_primer_mes;
            $mail->CharSet = 'UTF-8';
            $mail->send();
            echo 'correo primer mes envio';
            $_SESSION["correo_envio_primero"]=1;
          }
        }

    }
    catch (Exception $e){

    };

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Inicio - ManGo!</title>
    <?php
    //información del head
    include ("partes/head.php");
    ?>
</head>
<body>

<header class="rdm-toolbar--contenedor">
    <div class="rdm-toolbar--fila">
        <div class="rdm-toolbar--izquierda">

        </div>
        <div class="rdm-toolbar--centro">
            <a href="index.php"><h2 class="rdm-toolbar--titulo-centro"><span class="logo_img"></span> ManGo!</h2></a>
        </div>
        <div class="rdm-toolbar--derecha">

        </div>
    </div>

    <div class="rdm-toolbar--fila-tab">
        <div class="rdm-toolbar--izquierda">
            <a href="logueo_salir.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-power zmdi-hc-2x"></i></div> <span class="rdm-tipografia--leyenda">Salir</span></a>
        </div>

        <div class="rdm-toolbar--centro">
            <a href="ventas_ubicaciones.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-inbox zmdi-hc-2x"></i></div> <span class="rdm-tipografia--leyenda">Nueva Venta</span></a>
        </div>

        <div class="rdm-toolbar--derecha">
            <a href="ajustes.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-settings zmdi-hc-2x"></i></div> <span class="rdm-tipografia--leyenda">Ajustes</span></a>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar-tabs">

    <section class="rdm-tarjeta">

        <div class="rdm-tarjeta--primario">
            <div class="rdm-tarjeta--primario-contenedor">
                <?php echo "$sesion_imagen"; ?>
            </div>

            <div class="rdm-tarjeta--primario-contenedor">
                <h1 class="rdm-tarjeta--titulo"><?php echo ucwords($sesion_nombres) ?> <?php echo ucwords($sesion_apellidos) ?></h1>
                <h2 class="rdm-tarjeta--subtitulo"><?php echo ucfirst($sesion_tipo);?> en <?php echo ucfirst($sesion_local);?></h2>
            </div>
        </div>

        <?php echo $sesion_local_imagen; ?>

    </section>

    <h2 class="rdm-lista--titulo-largo">Actividades</h2>

    <section class="rdm-lista-sencillo">

        <a class="ancla" name="ventas"></a>

        <a href="ventas_ubicaciones.php">

            <article class="rdm-lista--item-doble">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--avatar"><div class="rdm-lista--icono"><i class="zmdi zmdi-inbox zmdi-hc-2x"></i></div></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Ventas</h2>
                        <h2 class="rdm-lista--texto-secundario">Hacer o continuar una venta</h2>
                    </div>
                </div>

            </article>

        </a>

        <a class="ancla" name="cuentas_cobrar"></a>

        <a href="cuentas_cobrar_ver.php">

            <article class="rdm-lista--item-doble">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--avatar"><div class="rdm-lista--icono"><i class="zmdi zmdi-long-arrow-down zmdi-hc-2x"></i></div></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Cuentas por cobrar</h2>
                        <h2 class="rdm-lista--texto-secundario">Gestionar las cuentas por cobrar</h2>
                    </div>
                </div>

            </article>

        </a>

    </section>

</main>

<footer></footer>

</body>
</html>

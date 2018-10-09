<?php
//nombre de la sesion, inicio de la sesión y conexion con la base de datos
include("sis/nombre_sesion.php");



//verifico si la sesión está creada y si no lo está lo envio al logueo
if (!isset($_SESSION['correo'])){
    header("location:logueo.php");
}


//variables de la sesion
include ("sis/variables_sesion.php");
  // var dump the reference for the ePayco server
  //var_dump($_REQUEST);

  // create php variable for reference id
  $x_ref_payco = $_REQUEST['ref_payco'];

  // initialize curl request to ePayco server
  $curl = curl_init();
  // set url
   curl_setopt($curl, CURLOPT_URL, "https://secure.epayco.co/validation/v1/reference/".$x_ref_payco);
  // return data
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

  // Do not check the SSL certificates
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

  // Fetch the URL and save the content in $html variable
  $html = curl_exec($curl);

  // decode JSON into php object
  $result=json_decode($html,true);

  // close cURL
  curl_close($curl);

  // create a php variable for each key in data variable sent by cURL
  foreach($result as $key=>$value) {
            if($key=='data'){
              foreach($value as $data_key=>$data_value){
                //echo  $data_key."= ".$data_value;
                ${$data_key} = $data_value;
              }
            }
          }

  // insert record into mango database
  // create username variable
  $user_name = $x_customer_name." ".$x_customer_lastname;

  // escape string values
  $x_extra1 = mysqli_real_escape_string($conexion , $x_extra1) ;
  $x_customer_email = mysqli_real_escape_string($conexion , $x_customer_email );
  $x_ref_payco = mysqli_real_escape_string($conexion , $x_ref_payco );
  $user_name = mysqli_real_escape_string($conexion , $user_name );
  $x_type_payment = mysqli_real_escape_string($conexion , $x_type_payment  );
  $x_response = mysqli_real_escape_string($conexion , $x_response );

  // insert payment record
  $insercion = $conexion->query("INSERT INTO cliente_pago VALUES ('', '$ahora', '', '', '$sesion_id', '', '', 'activo','$x_customer_email','$user_name','$x_id_factura','$x_type_payment','$x_response','$x_extra2','$x_extra3','$x_amount','$x_extra1')");

?>

<?php
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
        $mail->addAddress($x_customer_email);

        //Responder a
        $mail->addReplyTo('notificaciones@mangoapp.co', 'ManGo! App');

        //Contenido del correo
        $mail->isHTML(true);

        //Asunto
        $asunto = "Recibo de venta No ".$x_id_factura." por $".$x_amount;

                //Cuerpo
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

                $cuerpo .= '<br>
                            <section class="rdm-factura--imprimir" style="background-color: #fff; border: 1px solid #E0E0E0; box-sizing: border-box; margin: 0 auto; margin-bottom: 1em; width: 100%; max-width: 400px; padding: 1.25em 0em; font-size: 1em; letter-spacing: 0.04em; line-height: 1.75em; box-shadow: none;">


                                <article class="rdm-factura--contenedor--imprimir" style="width: 90%; margin: 0px auto;">

                                    <div class="rdm-factura--texto" style="text-align: center; width: 100%;">
                                        <h3>' .'Factura de suscripción mensual' . ' ' . $x_id_factura . '</h3>
                                        <h3>' . 'ManGo! App' . '<br>
                                    </div>';


                        $cuerpo .= '<div class="rdm-factura--texto" style="text-align: center; width: 100%;">
                                        <h3>' . $x_transaction_date. '</h3>
                                    </div>';




                        $cuerpo .= '<p class="rdm-factura--izquierda" style="display: inline-block; text-align: left; width: 69%;"><b>Descripción</b></p>
                                                        <p class="rdm-factura--derecha" style="display: inline-block; text-align: right; width: 29%;"><b>Valor</b></p>';


                                                $cuerpo .= '<section class="rdm-factura--item" style="border-bottom: dashed 1px #555; display: block; padding: 0.2em 0em 0em 0em;">

                                                                <div class="rdm-factura--izquierda" style="display: inline-block; text-align: left; width: 69%;">' . ' ManGo! suscripción'. ' x ' . ucfirst($x_extra2) . '</div>
                                                                <div class="rdm-factura--derecha" style="display: inline-block; text-align: right; width: 29%;">$' . number_format($x_amount, 0, ",", ".") . '</div>';


                                                $cuerpo .= '</section>';


                                    $cuerpo .= '<br>

                                                    <section class="rdm-factura--item" style="border-bottom: dashed 1px #555; display: block; padding: 0.2em 0em 0em 0em;">
                                                        <div class="rdm-factura--izquierda" style="display: inline-block; text-align: left; width: 69%;"><b>TOTAL A PAGAR</b></div>
                                                        <div class="rdm-factura--derecha" style="display: inline-block; text-align: right; width: 29%;"><b>$' . number_format($x_amount, 0, ",", ".") . '</b></div>
                                                    </section>';

                                        $cuerpo .= '<br>

                                                    <section class="rdm-factura--item" style="border-bottom: dashed 1px #555; display: block; padding: 0.2em 0em 0em 0em;">

                                                        <div class="rdm-factura--izquierda" style="display: inline-block; text-align: left; width: 69%;">Tipo de pago</div>
                                                        <div class="rdm-factura--derecha" style="display: inline-block; text-align: right; width: 29%;">' . ucfirst($x_type_payment) . '</div>

                                                        <div class="rdm-factura--izquierda" style="display: inline-block; text-align: left; width: 69%;"> Estado de Pago</div>
                                                        <div class="rdm-factura--derecha" style="display: inline-block; text-align: right; width: 29%;"> <b>' .$x_response. '</b> </div>

                                                    </section>';

                                        $cuerpo .= '<br>

                                                    <div class="rdm-factura--texto" style="text-align: center; width: 100%;">
                                                        <h3>' .'gracias por su compra'. '</h3>
                                                    </div>';


                                        $cuerpo .= '<br>
                                                    <br><div style="border-top: 1px solid #E0E0E0; padding: 0; width: 100%; "></div>

                                                    <p>En <b>' .'ManGo! '. '</b> queremos un mundo mejor, gracias por usar una factura electrónica. Al no usar papel se evita no solo la tala de árboles, sino también se ahorra en la cantidad de agua necesaria para transformar esa madera en papel.</p>';


                                        $cuerpo .= '<div class="rdm-factura--texto" style="text-align: center; width: 100%;">
                                                        <p>Enviado por tecnología <a href="http://www.mangoapp.co"><b>ManGo!</b></a></p>
                                                    </div>

                                            </article>
                                        </section>
                                        <br>';

                $cuerpo .= '
                </body>
                </html>';

        //asigno asunto y cuerpo a las variables de la funcion
        $mail->Subject = $asunto;
        $mail->Body    = $cuerpo;

        // Activo condificacción utf-8
        $mail->CharSet = 'UTF-8';

        //ejecuto la funcion y envio el correo
        $mail->send();

        // redirect user to homepage
        header( "refresh:5; index.php" );


    }
    catch (Exception $e)
    {
        echo 'Mensaje no pudo ser enviado: ', $mail->ErrorInfo;
        header( "refresh:5; index.php" );
    }


?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Formulario Pruebas Respuesta</title>
  <!-- Bootstrap -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body>
  <header id="main-header" style="margin-top:20px">
    <div class="row">
      <div class="col-lg-12 franja">
        <img class="center-block" src="https://369969691f476073508a-60bf0867add971908d4f26a64519c2aa.ssl.cf5.rackcdn.com/btns/epayco/logo1.png" style="">
      </div>
    </div>
  </header>
  <div class="container">
    <div class="row" style="margin-top:20px">
      <div class="col-lg-8 col-lg-offset-2 ">
        <h4 style="text-align:left"> Respuesta de la Transacción </h4>
        <hr>
      </div>
      <div class="col-lg-8 col-lg-offset-2 ">
        <div class="table-responsive">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <td>Referencia</td>
                <td id="referencia"><?php echo $x_id_factura; ?></td>
              </tr>
              <tr>
                <td class="bold">Fecha</td>
                <td id="fecha" class=""><?php echo $x_fecha_transaccion; ?></td>
              </tr>
              <tr>
                <td>Respuesta</td>
                <td id="respuesta"><?php echo  $x_response;?> </td>
              </tr>
              <tr>
                <td>Motivo</td>
                <td id="motivo" ><?php echo $x_response_reason_text;?></td>
              </tr>
              <tr>
                <td class="bold">Banco</td>
                <td class="" id="banco"> <?php echo $x_bank_name; ?> </td>
              </tr>
              <tr>
                <td class="bold">Recibo</td>
                <td id="recibo"><?php echo $x_transaction_id; ?></td>
              </tr>
              <tr>
                <td class="bold">Total</td>
                <td class="" id="total"><?php echo $x_amount." ".$x_currency_code; ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <footer>
    <div class="row">
      <div class="container">
        <div class="col-lg-8 col-lg-offset-2">
          <img src="https://369969691f476073508a-60bf0867add971908d4f26a64519c2aa.ssl.cf5.rackcdn.com/btns/epayco/pagos_procesados_por_epayco_260px.png" style="margin-top:10px; float:left"> <img src="https://369969691f476073508a-60bf0867add971908d4f26a64519c2aa.ssl.cf5.rackcdn.com/btns/epayco/credibancologo.png"
            height="40px" style="margin-top:10px; float:right">
        </div>
      </div>
    </div>
  </footer>
</body>
</html>

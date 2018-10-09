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

$consulta = $conexion->query("SELECT * FROM local WHERE estado = 'activo'");
$locales_total = $consulta->num_rows;
$total_amount=60000*$locales_total;
//$id_pago_ultimo = $conexion->->insert_id

 $result= $conexion->query("SELECT MAX(cliente_pago_id) FROM cliente_pago");
 $row = $result->fetch_array(MYSQLI_NUM);
 $id_count=(int) $row[0];
 $id_count=$id_count+1;
 $factura_num=strval($sesion_id).strval($id_count);
 $usario_nombre = ucwords($sesion_nombres)." ".ucwords($sesion_apellidos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Hacer mi pago - ManGo!</title>
    <?php
    //información del head
    include ("partes/head.php");
    //fin información del head
    ?>

    <script type="text/javascript" src="https://checkout.epayco.co/checkout.js">  </script>

    <script>
        function handlePayment(){
          var loc = window.location.href;
          var dir = loc.substring(0, loc.lastIndexOf('/'));
          console.log(dir);

            var handler = ePayco.checkout.configure({
                  key: '30672119c602aac954c98ad3d6f3fbe9',
                  test: true,
                })

            var data={
            //Parametros compra (obligatorio)
            name: "Tecnología ManGo! App",
            description: "Subscripcion mensual",
            invoice: "<?php echo "$factura_num";?>",
            currency: "cop",
            amount: <?php echo "$total_amount";?>,
            tax_base: "0",
            tax: "19",
            country: "co",
            lang: "es",
            //Onpage="false" - Standard="true"
            external: "false",
            //Atributos opcionales
            // cliente_id
            extra1: <?php echo  "$sesion_id";?>,
            //cantidad (locales)
            extra2: <?php echo  "$locales_total";?>,
            // costo para unidad
            extra3:"60000",
            response: dir+"/cuenta_pago_respuesta.php",

          //Atributos cliente
            name_billing: "<?php echo $usario_nombre;?>"

        }

        handler.open(data)
    }
    </script>
</head>
<body>

<header class="rdm-toolbar--contenedor">
    <div class="rdm-toolbar--fila">
        <div class="rdm-toolbar--izquierda">
            <a href="ajustes.php#pago"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Hacer mi pago</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <section class="rdm-tarjeta">

        <div class="rdm-tarjeta--primario-largo">
            <h1 class="rdm-tarjeta--titulo-largo">Hacer mi pago</h1>
            <h2 class="rdm-tarjeta--subtitulo-largo">Subtitulo largo</h2>
        </div>

        <div class="rdm-tarjeta--cuerpo">
            Haz aqui comodamente el pago de tu servcio de ManGo!
        </div>

        <div class="rdm-tarjeta--acciones-izquierda">
            <button class="rdm-boton--resaltado" onclick="handlePayment()">Pagar</button>
        </div>

    </section>

</main>

<div id="rdm-snackbar--contenedor">
    <div class="rdm-snackbar--fila">
        <div class="rdm-snackbar--primario-<?php echo $mensaje_tema; ?>">
            <h2 class="rdm-snackbar--titulo"><?php echo "$mensaje"; ?></h2>
        </div>
    </div>
</div>

<footer>



</footer>

</body>
</html>

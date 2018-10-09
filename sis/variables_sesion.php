<?php
//declaro las variables que pasan por formulario o URL
$sesion_id = $_SESSION['id'];
$correo = $_SESSION['correo'];
?>

<?php 
//consulto las variables de la sesion
$consulta = $conexion->query("SELECT * FROM usuario WHERE usuario_id = $sesion_id and estado = 'activo'");

if ($consulta->num_rows == 0)
{
    //si hay una sesion creada la destruyo y lo envio al logueo
    session_unset();
    session_destroy();
    header("location:logueo.php?caso=4&correo=$correo");

}
else
{
    while ($fila = $consulta->fetch_assoc())
    {
        $sesion_id = $fila['usuario_id'];
        $sesion_nombres = $fila['nombres'];
        $sesion_apellidos = $fila['apellidos'];
        $sesion_documento_tipo = $fila['documento_tipo'];
        $sesion_documento_numero = $fila['documento_numero'];
        $sesion_tipo = $fila['tipo'];
        $sesion_correo = $fila['correo'];
        $sesion_contrasena = $fila['contrasena'];
        $sesion_imagen = $fila['imagen'];
        $sesion_imagen_nombre = $fila['imagen_nombre'];

        $sesion_local_id = $fila['local_id'];
        
        //consulto la imagen del usuario
        if ($sesion_imagen == "no")
        {
            $sesion_imagen = '<div class="rdm-lista--icono"><i class="zmdi zmdi-account zmdi-hc-2x"></i></div>';
        }
        else
        {
            $sesion_imagen = "img/avatares/usuarios-$sesion_id-$sesion_imagen_nombre.jpg";
            $sesion_imagen = '<div class="rdm-lista--avatar" style="background-image: url('.$sesion_imagen.');"></div>';
        }

        //consulto el local
        $consulta2 = $conexion->query("SELECT * FROM local WHERE local_id = $sesion_local_id");

        if ($fila2 = $consulta2->fetch_assoc())
        {
            $sesion_local = $fila2['local'];
            $sesion_local_imagen = $fila2['imagen'];
            $sesion_local_imagen_nombre = $fila2['imagen_nombre'];

        }
        else
        {
            $sesion_local = "ningún local";
            $sesion_local_imagen = "no";
            $sesion_local_imagen_nombre = "";
        }

        //consulto la imagen del local
        if ($sesion_local_imagen == "no")
        {
            $sesion_local_imagen = "";
        }
        else
        {
            $sesion_local_imagen = "img/avatares/locales-$sesion_local_id-$sesion_local_imagen_nombre.jpg";
            $sesion_local_imagen = '<div class="rdm-tarjeta--media-index" style="background-image: url('.$sesion_local_imagen.');"></div>';

        }
    }
}
?>

<?php
//zona horaria
date_default_timezone_set('America/Bogota');
$ahora = date("Y-m-d H:i:s");
$hoy = date("Y-m-d");
$ahora_img = date("YmdHis");
?>
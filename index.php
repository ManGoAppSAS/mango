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

        <?php echo "$ventas"; ?>

        <a class="ancla" name="ventas"></a>
        
        <a href="">

            <article class="rdm-lista--item-sencillo">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--icono"><i class="zmdi zmdi-inbox zmdi-hc-2x"></i></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Ventas</h2>
                        <h2 class="rdm-lista--texto-secundario">Hacer o continuar una venta</h2>
                    </div>
                </div>
                
            </article>

        </a>

        
        <?php echo "$cuentas_cobrar"; ?>        

        <a class="ancla" name="cuentas_cobrar"></a>
        
        <a href="">

            <article class="rdm-lista--item-sencillo">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--icono"><i class="zmdi zmdi-long-arrow-down zmdi-hc-2x"></i></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Cuentas por cobrar</h2>
                        <h2 class="rdm-lista--texto-secundario">Gestionar las cuentas por cobrar</h2>
                    </div>
                </div>
                
            </article>

        </a>

        <?php echo "$zonas_entregas"; ?>

        <a class="ancla" name="zonas"></a>

        <a href="">         

            <article class="rdm-lista--item-sencillo">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--icono"><i class="zmdi zmdi-assignment-o zmdi-hc-2x"></i></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Zonas de entregas</h2>
                        <h2 class="rdm-lista--texto-secundario">Mostrar zonas de entrega</h2>
                    </div>
                </div>
                
            </article>

        </a>          

        <?php echo "$compras"; ?>

        <a class="ancla" name="despachos"></a>

        <a href="">

        <article class="rdm-lista--item-sencillo">
            <div class="rdm-lista--izquierda">
                <div class="rdm-lista--contenedor">
                    <div class="rdm-lista--icono"><i class="zmdi zmdi-truck zmdi-hc-2x"></i></div>
                </div>
                <div class="rdm-lista--contenedor">
                    <h2 class="rdm-lista--titulo">Compras</h2>
                    <h2 class="rdm-lista--texto-secundario">Hacer o continuar una compra</h2>
                </div>
            </div>
            
        </article>

        </a>

         <?php echo "$produccion"; ?>

        <a class="ancla" name="producciones"></a>

        <a href="">     

        <article class="rdm-lista--item-sencillo">
            <div class="rdm-lista--izquierda">
                <div class="rdm-lista--contenedor">
                    <div class="rdm-lista--icono"><i class="zmdi zmdi-invert-colors zmdi-hc-2x"></i></div>
                </div>
                <div class="rdm-lista--contenedor">
                    <h2 class="rdm-lista--titulo">Producciones</h2>
                    <h2 class="rdm-lista--texto-secundario">Hacer o continuar una producción</h2>
                </div>
            </div>
            
        </article>

        </a>

        

        <a class="ancla" name="inventario"></a>

        <a href="">          

            <article class="rdm-lista--item-sencillo">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--icono"><i class="zmdi zmdi-storage zmdi-hc-2x"></i></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Inventario</h2>
                        <h2 class="rdm-lista--texto-secundario">Ver inventario y recibir despachos</h2>
                    </div>
                </div>
                
            </article>

        </a>

        

        <a class="ancla" name="gastos"></a>

        <a href="">

            <article class="rdm-lista--item-sencillo">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--icono"><i class="zmdi zmdi-balance-wallet zmdi-hc-2x"></i></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Gastos</h2>
                        <h2 class="rdm-lista--texto-secundario">Agregar y consultar gastos</h2>
                    </div>
                </div>
                
            </article>

        </a>

              

        <a class="ancla" name="clientes"></a>

        <a href="">            

            <article class="rdm-lista--item-sencillo">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--icono"><i class="zmdi zmdi-favorite zmdi-hc-2x"></i></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Clientes</h2>
                        <h2 class="rdm-lista--texto-secundario">Ver clientes</h2>
                    </div>
                </div>
                
            </article>

        </a>

        

        <a class="ancla" name="reportes"></a>

        <a href="">

            <article class="rdm-lista--item-sencillo">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--icono"><i class="zmdi zmdi-chart-donut zmdi-hc-2x"></i></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Reportes</h2>
                        <h2 class="rdm-lista--texto-secundario">Consultar los datos de mi negocio</h2>
                    </div>
                </div>
                
            </article>

        </a>

       

    </section>

</main>
   
<footer></footer>

</body>
</html>
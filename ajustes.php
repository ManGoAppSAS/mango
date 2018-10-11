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
    <title>Ajustes - ManGo!</title>
    <?php
    //información del head
    include ("partes/head.php");
    //fin información del head <meta http-equiv="refresh" content="20" >
    ?>
</head>
<body>

<header class="rdm-toolbar--contenedor">
    <div class="rdm-toolbar--fila">
        <div class="rdm-toolbar--izquierda">
            <a href="index.php#ajustes"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Ajustes</h2>
        </div>        
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <a id="logistica">
    <h2 class="rdm-lista--titulo-largo">Logística</h2>

    <section class="rdm-lista">

        <?php
        //consulto el total de locales agregados
        $consulta = $conexion->query("SELECT * FROM local WHERE estado = 'activo'");
        $locales_total = $consulta->num_rows;
        ?>        

        <a class="ancla" name="locales"></a>
        <a href="locales_ver.php">
            <article class="rdm-lista--item-doble">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--avatar"><div class="rdm-lista--icono"><i class="zmdi zmdi-store zmdi-hc-2x"></i></div></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Locales</h2>

                        <?php
                        //consulto los locales              
                        $consulta = $conexion->query("SELECT local FROM local WHERE estado = 'activo' ORDER BY fecha_mod DESC LIMIT 3");

                        if ($consulta->num_rows != 0)
                        {
                        ?>
                            <h2 class="rdm-lista--texto-secundario">

                            <?php                            
                            while ($fila = $consulta->fetch_assoc())
                            {
                                $local = $fila['local'];

                                echo ucfirst(substr($local, 0, 15)).'... ';
                            }
                            ?>

                            </h2>

                        <?php
                        }
                        else
                        {
                        ?>
                        
                        <h2 class="rdm-lista--texto-secundario">Vacío</h2>

                        <?php
                        }
                        ?>

                    </div>
                </div>
                <div class="rdm-lista--derecha">
                    <div class="rdm-lista--contador"><h2 class="rdm-lista--texto-contador"><?php echo $locales_total; ?>37</h2></div>
                </div>
            </article>
        </a>

        <?php
        //consulto el total de usuarios agregados
        $consulta = $conexion->query("SELECT * FROM usuario WHERE estado = 'activo'");
        $usuarios_total = $consulta->num_rows;
        ?>

        <a class="ancla" name="usuarios"></a>
        <a href="usuarios_ver.php">
            <article class="rdm-lista--item-doble">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--avatar"><div class="rdm-lista--icono"><i class="zmdi zmdi-account-circle zmdi-hc-2x"></i></div></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Usuarios</h2>

                        <?php
                        //consulto los usuarios              
                        $consulta = $conexion->query("SELECT nombres, apellidos FROM usuario WHERE estado = 'activo' ORDER BY fecha_mod DESC LIMIT 3");

                        if ($consulta->num_rows != 0)                            
                        {
                        ?>
                            <h2 class="rdm-lista--texto-secundario">

                            <?php
                            while ($fila = $consulta->fetch_assoc()) 
                            {
                                $nombres = $fila['nombres'];
                                $apellidos = $fila['apellidos'];

                                $nombre = "$nombres $apellidos";

                                echo ucwords(substr($nombre, 0, 15)).'... ';
                            }
                            ?>

                            </h2>

                        <?php
                        }
                        else
                        {
                        ?>
                        
                        <h2 class="rdm-lista--texto-secundario">Vacío</h2>

                        <?php
                        }
                        ?>

                    </div>
                </div>
                <div class="rdm-lista--derecha">
                    <div class="rdm-lista--contador"><h2 class="rdm-lista--texto-contador"><?php echo $usuarios_total; ?></h2></div>
                </div>
            </article>
        </a>

        <?php
        //consulto el total de ubicaciones agregadas
        $consulta = $conexion->query("SELECT * FROM ubicacion WHERE estado = 'activo'");
        $ubicaciones_total = $consulta->num_rows;
        ?>

        <a class="ancla" name="ubicaciones"></a>
        <a href="ubicaciones_ver.php">
            <article class="rdm-lista--item-doble">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--avatar"><div class="rdm-lista--icono"><i class="zmdi zmdi-seat zmdi-hc-2x"></i></div></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Ubicaciones</h2>

                        <?php
                        //consulto los usuarios              
                        $consulta = $conexion->query("SELECT ubicacion FROM ubicacion WHERE estado = 'activo' ORDER BY fecha_mod DESC LIMIT 3");

                        if ($consulta->num_rows != 0)                            
                        {
                        ?>
                            <h2 class="rdm-lista--texto-secundario">

                            <?php
                            while ($fila = $consulta->fetch_assoc()) 
                            {
                                $ubicacion = $fila['ubicacion'];

                                echo ucwords(substr($ubicacion, 0, 15)).'... ';
                            }
                            ?>

                            </h2>

                        <?php
                        }
                        else
                        {
                        ?>
                        
                        <h2 class="rdm-lista--texto-secundario">Vacío</h2>

                        <?php
                        }
                        ?>

                    </div>
                </div>
                <div class="rdm-lista--derecha">
                    <div class="rdm-lista--contador"><h2 class="rdm-lista--texto-contador"><?php echo $ubicaciones_total; ?></h2></div>
                </div>
            </article>
        </a>

        <?php
        //consulto el total de zonas de entrega agregadas
        $consulta = $conexion->query("SELECT * FROM zona_entrega WHERE estado = 'activo'");
        $zonas_entregas_total = $consulta->num_rows;
        ?>

        <a class="ancla" name="zonas"></a>
        <a href="zonas_entrega_ver.php">
            <article class="rdm-lista--item-doble">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--avatar"><div class="rdm-lista--icono"><i class="zmdi zmdi-file-text zmdi-hc-2x"></i></div></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Zonas de entrega</h2>

                        <?php
                        //consulto los usuarios              
                        $consulta = $conexion->query("SELECT zona_entrega FROM zona_entrega WHERE estado = 'activo' ORDER BY fecha_mod DESC LIMIT 3");

                        if ($consulta->num_rows != 0)                            
                        {
                        ?>
                            <h2 class="rdm-lista--texto-secundario">

                            <?php
                            while ($fila = $consulta->fetch_assoc()) 
                            {
                                $zona_entrega = $fila['zona_entrega'];

                                echo ucwords(substr($zona_entrega, 0, 15)).'... ';
                            }
                            ?>

                            </h2>

                        <?php
                        }
                        else
                        {
                        ?>
                        
                        <h2 class="rdm-lista--texto-secundario">Vacío</h2>

                        <?php
                        }
                        ?>

                    </div>
                </div>
                <div class="rdm-lista--derecha">
                    <div class="rdm-lista--contador"><h2 class="rdm-lista--texto-contador"><?php echo $zonas_entregas_total; ?></h2></div>
                </div>
            </article>
        </a>

    </section>

    <a id="impuestos">
    <h2 class="rdm-lista--titulo-largo">Financiero</h2>

    <section class="rdm-lista">

        <?php
        //consulto el total de impuestos agregados
        $consulta = $conexion->query("SELECT * FROM impuesto WHERE estado = 'activo'");
        $impuestos_total = $consulta->num_rows;
        ?>        

        <a class="ancla" name="impuestos"></a>
        <a href="impuestos_ver.php">
            <article class="rdm-lista--item-doble">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--avatar"><div class="rdm-lista--icono"><i class="zmdi zmdi-book zmdi-hc-2x"></i></div></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Impuestos</h2>

                        <?php
                        //consulto los impuestos              
                        $consulta = $conexion->query("SELECT impuesto FROM impuesto WHERE estado = 'activo' ORDER BY fecha_mod DESC LIMIT 3");

                        if ($consulta->num_rows != 0)
                        {
                        ?>
                            <h2 class="rdm-lista--texto-secundario">

                            <?php                            
                            while ($fila = $consulta->fetch_assoc())
                            {
                                $impuesto = $fila['impuesto'];

                                echo ucfirst(substr($impuesto, 0, 15)).'... ';
                            }
                            ?>

                            </h2>

                        <?php
                        }
                        else
                        {
                        ?>
                        
                        <h2 class="rdm-lista--texto-secundario">Vacío</h2>

                        <?php
                        }
                        ?>

                    </div>
                </div>
                <div class="rdm-lista--derecha">
                    <div class="rdm-lista--contador"><h2 class="rdm-lista--texto-contador"><?php echo $impuestos_total; ?></h2></div>
                </div>
            </article>
        </a>

        <?php
        //consulto el total de metodos de pago agregados
        $consulta = $conexion->query("SELECT * FROM metodo_pago WHERE estado = 'activo'");
        $metodos_pago_total = $consulta->num_rows;
        ?>        

        <a class="ancla" name="metodos_pago"></a>
        <a href="metodos_pago_ver.php">
            <article class="rdm-lista--item-doble">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--avatar"><div class="rdm-lista--icono"><i class="zmdi zmdi-card zmdi-hc-2x"></i></div></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Métodos de pago</h2>

                        <?php
                        //consulto los metodos de pago              
                        $consulta = $conexion->query("SELECT metodo FROM metodo_pago WHERE estado = 'activo' ORDER BY fecha_mod DESC LIMIT 3");

                        if ($consulta->num_rows != 0)
                        {
                        ?>
                            <h2 class="rdm-lista--texto-secundario">

                            <?php                            
                            while ($fila = $consulta->fetch_assoc())
                            {
                                $metodo = $fila['metodo'];

                                echo ucfirst(substr($metodo, 0, 15)).'... ';
                            }
                            ?>

                            </h2>

                        <?php
                        }
                        else
                        {
                        ?>
                        
                        <h2 class="rdm-lista--texto-secundario">Vacío</h2>

                        <?php
                        }
                        ?>

                    </div>
                </div>
                <div class="rdm-lista--derecha">
                    <div class="rdm-lista--contador"><h2 class="rdm-lista--texto-contador"><?php echo $metodos_pago_total; ?></h2></div>
                </div>
            </article>
        </a>

        <?php
        //consulto el total de descuentos agregados
        $consulta = $conexion->query("SELECT * FROM descuento WHERE estado = 'activo'");
        $descuentos_total = $consulta->num_rows;
        ?>        

        <a class="ancla" name="descuentos"></a>
        <a href="descuentos_ver.php">
            <article class="rdm-lista--item-doble">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--avatar"><div class="rdm-lista--icono"><i class="zmdi zmdi-card-giftcard zmdi-hc-2x"></i></div></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Descuentos</h2>

                        <?php
                        //consulto los descuentos            
                        $consulta = $conexion->query("SELECT descuento FROM descuento WHERE estado = 'activo' ORDER BY fecha_mod DESC LIMIT 3");

                        if ($consulta->num_rows != 0)
                        {
                        ?>
                            <h2 class="rdm-lista--texto-secundario">

                            <?php                            
                            while ($fila = $consulta->fetch_assoc())
                            {
                                $descuento = $fila['descuento'];

                                echo ucfirst(substr($descuento, 0, 15)).'... ';
                            }
                            ?>

                            </h2>

                        <?php
                        }
                        else
                        {
                        ?>
                        
                        <h2 class="rdm-lista--texto-secundario">Vacío</h2>

                        <?php
                        }
                        ?>

                    </div>
                </div>
                <div class="rdm-lista--derecha">
                    <div class="rdm-lista--contador"><h2 class="rdm-lista--texto-contador"><?php echo $descuentos_total; ?></h2></div>
                </div>
            </article>
        </a>

        <?php
        //consulto el total de plantillas de factura agregadas
        $consulta = $conexion->query("SELECT * FROM plantilla_factura WHERE estado = 'activo'");
        $plantillas_factura_total = $consulta->num_rows;
        ?>        

        <a class="ancla" name="plantillas"></a>
        <a href="plantillas_factura_ver.php">
            <article class="rdm-lista--item-doble">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--avatar"><div class="rdm-lista--icono"><i class="zmdi zmdi-receipt zmdi-hc-2x"></i></div></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Plantillas de factura</h2>

                        <?php
                        //consulto las plantillas de factura            
                        $consulta = $conexion->query("SELECT titulo FROM plantilla_factura WHERE estado = 'activo' ORDER BY fecha_mod DESC LIMIT 3");

                        if ($consulta->num_rows != 0)
                        {
                        ?>
                            <h2 class="rdm-lista--texto-secundario">

                            <?php                            
                            while ($fila = $consulta->fetch_assoc())
                            {
                                $titulo = $fila['titulo'];

                                echo ucfirst(substr($titulo, 0, 15)).'... ';
                            }
                            ?>

                            </h2>

                        <?php
                        }
                        else
                        {
                        ?>
                        
                        <h2 class="rdm-lista--texto-secundario">Vacío</h2>

                        <?php
                        }
                        ?>

                    </div>
                </div>
                <div class="rdm-lista--derecha">
                    <div class="rdm-lista--contador"><h2 class="rdm-lista--texto-contador"><?php echo $plantillas_factura_total; ?></h2></div>
                </div>
            </article>
        </a>

    </section>



















    <a id="categorias">
    <h2 class="rdm-lista--titulo-largo">Portafolio</h2>

    <section class="rdm-lista">

        <?php
        //consulto el total de categorias agregadas
        $consulta = $conexion->query("SELECT * FROM categoria WHERE estado = 'activo'");
        $categorias_total = $consulta->num_rows;
        ?>        

        <a class="ancla" name="impuestos"></a>
        <a href="categorias_ver.php">
            <article class="rdm-lista--item-doble">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--avatar"><div class="rdm-lista--icono"><i class="zmdi zmdi-labels zmdi-hc-2x"></i></div></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Categorías</h2>

                        <?php
                        //consulto las categorias              
                        $consulta = $conexion->query("SELECT categoria FROM categoria WHERE estado = 'activo' ORDER BY fecha_mod DESC LIMIT 3");

                        if ($consulta->num_rows != 0)
                        {
                        ?>
                            <h2 class="rdm-lista--texto-secundario">

                            <?php                            
                            while ($fila = $consulta->fetch_assoc())
                            {
                                $categoria = $fila['categoria'];

                                echo ucfirst(substr($categoria, 0, 15)).'... ';
                            }
                            ?>

                            </h2>

                        <?php
                        }
                        else
                        {
                        ?>
                        
                        <h2 class="rdm-lista--texto-secundario">Vacío</h2>

                        <?php
                        }
                        ?>

                    </div>
                </div>
                <div class="rdm-lista--derecha">
                    <div class="rdm-lista--contador"><h2 class="rdm-lista--texto-contador"><?php echo $categorias_total; ?></h2></div>
                </div>
            </article>
        </a>

        <?php
        //consulto el total de productos
        $consulta = $conexion->query("SELECT * FROM producto WHERE estado = 'activo'");
        $productos_total = $consulta->num_rows;
        ?>        

        <a class="ancla" name="productos"></a>
        <a href="productos_ver.php">
            <article class="rdm-lista--item-doble">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--avatar"><div class="rdm-lista--icono"><i class="zmdi zmdi-label zmdi-hc-2x"></i></div></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Productos</h2>

                        <?php
                        //consulto los productos        
                        $consulta = $conexion->query("SELECT producto FROM producto WHERE estado = 'activo' ORDER BY fecha_mod DESC LIMIT 3");

                        if ($consulta->num_rows != 0)
                        {
                        ?>
                            <h2 class="rdm-lista--texto-secundario">

                            <?php                            
                            while ($fila = $consulta->fetch_assoc())
                            {
                                $producto = $fila['producto'];

                                echo ucfirst(substr($producto, 0, 15)).'... ';
                            }
                            ?>

                            </h2>

                        <?php
                        }
                        else
                        {
                        ?>
                        
                        <h2 class="rdm-lista--texto-secundario">Vacío</h2>

                        <?php
                        }
                        ?>

                    </div>
                </div>
                <div class="rdm-lista--derecha">
                    <div class="rdm-lista--contador"><h2 class="rdm-lista--texto-contador"><?php echo $productos_total; ?></h2></div>
                </div>
            </article>
        </a>        

    </section>


    <a id="categorias">
    <h2 class="rdm-lista--titulo-largo">Inventario</h2>

    <section class="rdm-lista">

        <?php
        //consulto el total de proveedores
        $consulta = $conexion->query("SELECT * FROM proveedor WHERE estado = 'activo'");
        $proveedores_total = $consulta->num_rows;
        ?>        

        <a class="ancla" name="proveedores"></a>
        <a href="proveedores_ver.php">
            <article class="rdm-lista--item-doble">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--avatar"><div class="rdm-lista--icono"><i class="zmdi zmdi-truck zmdi-hc-2x"></i></div></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Proveedores</h2>

                        <?php
                        //consulto los proveedores              
                        $consulta = $conexion->query("SELECT proveedor FROM proveedor WHERE estado = 'activo' ORDER BY fecha_mod DESC LIMIT 3");

                        if ($consulta->num_rows != 0)
                        {
                        ?>
                            <h2 class="rdm-lista--texto-secundario">

                            <?php                            
                            while ($fila = $consulta->fetch_assoc())
                            {
                                $proveedor = $fila['proveedor'];

                                echo ucfirst(substr($proveedor, 0, 15)).'... ';
                            }
                            ?>

                            </h2>

                        <?php
                        }
                        else
                        {
                        ?>
                        
                        <h2 class="rdm-lista--texto-secundario">Vacío</h2>

                        <?php
                        }
                        ?>

                    </div>
                </div>
                <div class="rdm-lista--derecha">
                    <div class="rdm-lista--contador"><h2 class="rdm-lista--texto-contador"><?php echo $proveedores_total; ?></h2></div>
                </div>
            </article>
        </a>

        <?php
        //consulto el total de compoenentes comprados
        $consulta = $conexion->query("SELECT * FROM componente WHERE tipo = 'comprado' and estado = 'activo'");
        $componentes_total = $consulta->num_rows;
        ?>        

        <a class="ancla" name="componentes"></a>
        <a href="componentes_ver.php">
            <article class="rdm-lista--item-doble">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--avatar"><div class="rdm-lista--icono"><i class="zmdi zmdi-widgets zmdi-hc-2x"></i></div></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Componentes</h2>

                        <?php
                        //consulto los componentes        
                        $consulta = $conexion->query("SELECT componente FROM componente WHERE tipo = 'comprado' and estado = 'activo' ORDER BY fecha_mod DESC LIMIT 3");

                        if ($consulta->num_rows != 0)
                        {
                        ?>
                            <h2 class="rdm-lista--texto-secundario">

                            <?php                            
                            while ($fila = $consulta->fetch_assoc())
                            {
                                $componente = $fila['componente'];

                                echo ucfirst(substr($componente, 0, 15)).'... ';
                            }
                            ?>

                            </h2>

                        <?php
                        }
                        else
                        {
                        ?>
                        
                        <h2 class="rdm-lista--texto-secundario">Vacío</h2>

                        <?php
                        }
                        ?>

                    </div>
                </div>
                <div class="rdm-lista--derecha">
                    <div class="rdm-lista--contador"><h2 class="rdm-lista--texto-contador"><?php echo $componentes_total; ?></h2></div>
                </div>
            </article>
        </a>

        <?php
        //consulto el total de productores
        $consulta = $conexion->query("SELECT * FROM productor WHERE estado = 'activo'");
        $productores_total = $consulta->num_rows;
        ?>        

        <a class="ancla" name="productores"></a>
        <a href="productores_ver.php">
            <article class="rdm-lista--item-doble">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--avatar"><div class="rdm-lista--icono"><i class="zmdi zmdi-city zmdi-hc-2x"></i></div></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Productores</h2>

                        <?php
                        //consulto los proveedores              
                        $consulta = $conexion->query("SELECT productor FROM productor WHERE estado = 'activo' ORDER BY fecha_mod DESC LIMIT 3");

                        if ($consulta->num_rows != 0)
                        {
                        ?>
                            <h2 class="rdm-lista--texto-secundario">

                            <?php                            
                            while ($fila = $consulta->fetch_assoc())
                            {
                                $productor = $fila['productor'];

                                echo ucfirst(substr($productor, 0, 15)).'... ';
                            }
                            ?>

                            </h2>

                        <?php
                        }
                        else
                        {
                        ?>
                        
                        <h2 class="rdm-lista--texto-secundario">Vacío</h2>

                        <?php
                        }
                        ?>

                    </div>
                </div>
                <div class="rdm-lista--derecha">
                    <div class="rdm-lista--contador"><h2 class="rdm-lista--texto-contador"><?php echo $productores_total; ?></h2></div>
                </div>
            </article>
        </a>

        <?php
        //consulto el total de compoenentes producidos
        $consulta = $conexion->query("SELECT * FROM componente WHERE tipo = 'producido' and estado = 'activo'");
        $componentes_total = $consulta->num_rows;
        ?>        

        <a class="ancla" name="componentes_producidos"></a>
        <a href="componentes_producidos_ver.php">
            <article class="rdm-lista--item-doble">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--avatar"><div class="rdm-lista--icono"><i class="zmdi zmdi-view-dashboard zmdi-hc-2x"></i></div></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Componentes producidos</h2>

                        <?php
                        //consulto los componentes        
                        $consulta = $conexion->query("SELECT componente FROM componente WHERE tipo = 'producido' and estado = 'activo' ORDER BY fecha_mod DESC LIMIT 3");

                        if ($consulta->num_rows != 0)
                        {
                        ?>
                            <h2 class="rdm-lista--texto-secundario">

                            <?php                            
                            while ($fila = $consulta->fetch_assoc())
                            {
                                $componente = $fila['componente'];

                                echo ucfirst(substr($componente, 0, 15)).'... ';
                            }
                            ?>

                            </h2>

                        <?php
                        }
                        else
                        {
                        ?>
                        
                        <h2 class="rdm-lista--texto-secundario">Vacío</h2>

                        <?php
                        }
                        ?>

                    </div>
                </div>
                <div class="rdm-lista--derecha">
                    <div class="rdm-lista--contador"><h2 class="rdm-lista--texto-contador"><?php echo $componentes_total; ?></h2></div>
                </div>
            </article>
        </a>  

    </section>








    <a id="categorias">
    <h2 class="rdm-lista--titulo-largo">Suscripción y pago</h2>

    <section class="rdm-lista">

        <?php
        //consulto el total de proveedores
        $consulta = $conexion->query("SELECT * FROM proveedor WHERE estado = 'activo'");
        $proveedores_total = $consulta->num_rows;
        ?>        

        <a class="ancla" name="pago"></a>
        <a href="cuenta_pago.php">
            <article class="rdm-lista--item-doble">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--avatar"><div class="rdm-lista--icono"><i class="zmdi zmdi-card zmdi-hc-2x"></i></div></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Hacer mi pago</h2>                        
                        <h2 class="rdm-lista--texto-secundario">Haz tu pago aquí</h2>                       

                    </div>
                </div>
                <div class="rdm-lista--derecha">
                    
                </div>
            </article>
        </a>

        

          

    </section>

</main>
   
<footer></footer>



</body>
</html>
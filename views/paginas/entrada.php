<?php 
    use Model\Admin;
?>
<main class="contenedor seccion contenido-centrado">
        <div class="texto-entrada">
            <h1><?php echo $entrada -> getTitulo(); ?></h1>
            <?php 
                $usuario = Admin::buscarPorId($entrada ->getUsuarioId());                            
            ?>
            <p>Escrito el: <span><?php echo $entrada -> getCreado(); ?></span> por <span><?php echo escaparSanitizarHTML($usuario -> getApodo()); ?></span> </p>
        </div>
        <img loading="lazy" src="/imagenes/<?php echo $entrada -> getImagen(); ?>" alt="Imagen de la propiedad">        
        <div class="resumen-propiedad alinear-centro">
            <p>
                <?php 
                    echo escaparSanitizarHTML($entrada -> getContenido());
                ?>
            </p>
        </div>
</main>
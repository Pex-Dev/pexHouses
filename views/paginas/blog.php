<?php 
    use Model\Admin;
?>
<main class="contenedor seccion contenido-centrado">
        <h1>Nuestro Blog</h1>        
        <?php foreach($entradas as $entrada): ?>
            <article class="entrada-blog">
                <div class="imagen">
                    <img loading="lazy" width="500" height="300"  src="<?php echo '/imagenes/'.$entrada -> getImagen();?>" alt="Imagen de la entrada">
                </div>
                <div class="texto-entrada">
                    <a href="/entrada<?php echo '?id='.$entrada -> getId(); ?>">
                        <h4><?php echo $entrada -> getTitulo(); ?></h4>
                        <?php 
                            $usuario = Admin::buscarPorId($entrada ->getUsuarioId());                            
                        ?>
                        <p>Escrito el: <span><?php echo $entrada -> getCreado(); ?></span> por <span><?php echo escaparSanitizarHTML($usuario -> getApodo()); ?></span> </p>
                    </a>
                    <p>
                    <?php
                        $descripcionCorta = substr( escaparSanitizarHTML($entrada -> getContenido()), 0, 450);
                        echo $descripcionCorta."...";
                    ?>
                    </p>
                </div>
            </article>
        <?php endforeach; ?>
</main>
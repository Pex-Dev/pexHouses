<?php 
use Model\Admin;
?>
<main class="contenedor seccion propiedades-slider">
    <!-- MOSTRAR ANUNCIOS -->
    <div class="slider-title">
        <div>
            <h1>Nuestras Propiedades</h1>   
        </div>         
    </div>
    <?php
        include '../includes/templates/slider_propiedades.php'; 
    ?>
    <div class="ver-todas alinear-centro">
        <a href="/propiedades" class="boton-verde">Lista de Propiedades</a>
    </div>
</main>
    
    <section class="imagen-contacto ">
        <h2>Encuentra la casa de tus sueños</h2>
        <p>LLena el formulario para ponerte en contacto con un asesor</p>
        <a href="contacto.php" class="boton-amarillo">Contactános</a>
    </section>
    <div class="contenedor seccion seccion-inferior">
        <section class="blog">
            <h3>Nuestro Blog</h3>
            <?php foreach($entradas as $entrada): ?>
                <article class="entrada-blog">
                    <div class="imagen">
                        <img loading="lazy" width="500" height="250"  src="<?php echo '/imagenes/'.$entrada -> getImagen();?>" alt="Imagen de la entrada">
                    </div>
                    <div class="texto-entrada">
                        <a href="/entrada<?php echo '?id='.$entrada -> getId(); ?>">
                            <h4><?php echo escaparSanitizarHTML($entrada -> getTitulo()); ?></h4>
                            <?php 
                                $usuario = Admin::buscarPorId($entrada ->getUsuarioId());
                            ?>
                            <p>Escrito el: <span><?php echo $entrada -> getCreado(); ?></span> por <span><?php echo $usuario -> getApodo(); ?></span> </p>
                        </a>
                        <p><?php 
                            $descripcionCorta = substr( escaparSanitizarHTML($entrada -> getContenido()), 0, 220);
                            echo $descripcionCorta."...";                        
                        ?></p>
                    </div>
                </article>
            <?php endforeach ?>
        </section>
        <section class="testimoniales">
            <h3>Testimoniales</h3>
            <div class="testimonial">
                <blockquote>
                    Quede encantado con mi nueva casa, es hermosa y tiene 3 estacionamientos que mejor xd. El personal es muy amigable, ¡me regalaron una camiseta rosada!
                </blockquote>               
            </div>
            <div class="testimonial-persona">
                <p>Fabian Aguilar</p>
                <picture>
                <source srcset="build/img/person_icon.webp" type="image/webp">
                <img loading="lazy" src="build/img/person_icon.jpeg" alt="Imagen sobre nosotros">
            </picture>
            </div>
        </section>
    </div>
    <section class="seccion contenedor">        
        <h2>Porque usar PEXHOUSES</h2>
        <div class="iconos-nosotros">
            <div class="icono">
                <img loading="lazy" src="build/img/icono1.svg" alt="Icono Seguridad">
                <h3>Seguridad</h3>
                <p>Nuestro servicio garantiza la seguridad de tus transacciones con sistemas de encriptación avanzados y medidas de protección de datos, brindándote tranquilidad en cada paso.</p>
            </div>
            <div class="icono">
                <img loading="lazy" src="build/img/icono2.svg" alt="Icono Precio">
                <h3>Precio</h3>
                <p>Encontrarás en nuestro servicio una combinación perfecta entre calidad y precio, con tarifas competitivas que se ajustan a tu presupuesto, sin sacrificar la excelencia en el servicio.</p>
            </div>
            <div class="icono">
                <img loading="lazy" src="build/img/icono3.svg" alt="Icono Tiempo">
                <h3>Tiempo</h3>
                <p>Simplificamos tu búsqueda de bienes raíces con una plataforma diseñada para ahorrar tu valioso tiempo, proporcionándote resultados precisos y relevantes de manera rápida y eficiente.</p>
            </div>
        </div>
    </section>
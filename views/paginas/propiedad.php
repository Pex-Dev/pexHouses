<main class="contenedor seccion contenido-centrado">
        <h1><?php echo escaparSanitizarHTML($propiedad -> getTitulo()); ?></h1>
        <div class="anuncio-detalles">
            <img loading="lazy" src="/imagenes/<?php echo $propiedad -> getImagen()?>" alt="Imagen de la propiedad">
            <div class="resumen-propiedad alinear-centro">
                <p class="precio">$<?php echo round($propiedad -> getPrecio()); ?></p>
                <ul class="iconos-caracteristicas">
                    <li>
                        <img loading="lazy" src="build/img/icono_wc.svg" alt="Icono Baños">
                        <p><?php echo $propiedad -> getWc(); ?></p>
                    </li>
                    <li>
                        <img loading="lazy" src="build/img/icono_estacionamiento.svg" alt="Icono Estacionamientos">
                        <p><?php echo $propiedad -> getEstacionamiento(); ?></p>
                    </li>
                    <li>
                        <img loading="lazy" src="build/img/icono_dormitorio.svg" alt="Icono Dormitorios">
                        <p><?php echo $propiedad -> getHabitaciones(); ?></p>
                    </li>
                </ul>
                <p>
                    <?php echo escaparSanitizarHTML($propiedad -> getDescripcion()); ?>
                </p>
            </div>
        </div>
</main>
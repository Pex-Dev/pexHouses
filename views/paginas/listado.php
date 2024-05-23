<div class="contenedor-anuncios">
    <?php foreach($propiedades as $propiedad) : ?>
    <div class="anuncio">
        <img loading="lazy" width="500" height="300"  src="<?php echo '/imagenes/'.$propiedad -> getImagen();?>" alt="">
        <div class="contenido-anuncio">
            <div class="titulo-descripcion">
                <h3><?php echo  escaparSanitizarHTML($propiedad -> getTitulo()); ?></h3>
                <p class="descripcion">
                <?php 
                    $puntos = '';
                    if(strlen(escaparSanitizarHTML($propiedad -> getDescripcion()))>182){
                        $puntos = '...';
                    }
                    $descripcionCorta = substr( escaparSanitizarHTML($propiedad -> getDescripcion()), 0, 182);
                    echo $descripcionCorta.$puntos;
                ?>
                </p>
            </div>
            <div class="info-propiedad">
                <p class="precio">$<?php echo round($propiedad -> getPrecio()); ?></p>
                <ul class="iconos-caracteristicas">
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="Icono Baños">
                        <p><?php echo $propiedad -> getWc(); ?></p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="Icono Estacionamientos">
                        <p><?php echo $propiedad -> getEstacionamiento(); ?></p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="Icono Dormitorios">
                        <p><?php echo $propiedad -> getHabitaciones(); ?></p>
                    </li>
                </ul>
                 <a href="/propiedad?id=<?php echo $propiedad -> getId(); ?>" class="boton-amarillo-block">Ver Propiedad</a>
            </div>            
            </div>
   </div><!-- anuncio --> 
   <?php endforeach; ?>           
</div>

<div class="slider">
    <div class="left-arrow"></div>
    <div class="slider--inner">
        <?php foreach($propiedades as $propiedad) : ?>
            <img src="<?php echo '/imagenes/'.$propiedad -> getImagen();?>" alt="Imagen de la propiedad" onclick="window.location.href='/propiedad?id=<?php echo $propiedad -> getId(); ?>'">          
        <?php endforeach; ?>   
    </div>
    <div class="right-arrow"></div>
</div>
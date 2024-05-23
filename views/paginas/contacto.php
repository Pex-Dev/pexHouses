<main class="contenedor seccion">
    <?php if($mensajeRespuesta){ ?>
            <p class="alerta exito "><?php echo $mensajeRespuesta; ?></p>
    <?php } 
        foreach($errores as $error):
    ?> 
        <div class="alerta error" >
            <?php echo $error; ?>
        </div>
    <?php 
        endforeach;
    ?>
    
        <h1>Contacto</h1>
        <picture>
            <source srcset="build/img/destacada3.jpg" type="image/jpg">
            <source srcset="build/img/destacada3.webp" type="image/webp">
            <img loading="lazy"  src="build/img/destacada3.jpg" alt="Imagen contacto">
        </picture>
        <h2>LLene el formulario de contacto</h2>
        <form class="formulario" action="/contacto" method="POST">
            <fieldset>
                <legend>Información Personal</legend>
                <label for="nombre">Nombre</label>
                <input id="nombre" type="text" placeholder="Tu Nombre" name="contacto[nombre]" value="<?php echo $nombre; ?>">
                
                
                <label for="mensaje">Mensaje</label>
                <textarea id="mensaje" type="text" name="contacto[mensaje]" ><?php echo $mensaje; ?></textarea>
            </fieldset>

            <fieldset>
                <legend>Información sobre la propiedad</legend>

                <label for="opciones">Vende o Compra:</label>                
                <select id="opciones" name="contacto[tipo]" >
                    <option value="" disabled selected>--Seleccione--</option>
                    <option value="Compra" 
                    <?php
                         if($tipo==='Compra'){
                            echo 'selected';
                         }
                    ?>>Compra</option>
                    <option value="Vende"
                    <?php
                         if($tipo==='Vende'){
                            echo 'selected';
                         }
                    ?>>Vende</option>
                </select>

                <label for="presupuesto">Precio o Presupuesto</label>
                <input id="presupuesto" type="number" placeholder="Tu Precio o Presupuesto" name="contacto[precio]" value="<?php echo $precio; ?>">
            </fieldset>

            <fieldset>
                <legend>Contaco</legend>
                <p>Como desea ser contactado</p>
                <div class="forma-contacto">
                    <label for="contactar-telefono">teléfono</label>
                    <input type="radio" value="telefono" id="contactar-telefono" name="contacto[contacto]">
                    <label for="contactar-email">E-mail</label>
                    <input type="radio" value="email" id="contactar-email" name="contacto[contacto]">
                </div>
                <div id="contacto"></div>
                
             </fieldset>
             <input type="submit" value="Enviar" class="boton-verde">
        </form>
</main>
<?php 

use Model\Propiedad;

if($_SESSION['nivel']<1){
    header('location:/admin');
}
?>
<main class="contenedor seccion">
        <h1>Crear Propiedad</h1>
        <a href="/admin" class="boton-amarillo">Volver</a>

        <?php foreach($errores as $error){ ?>
            <div class="alerta error" >
                <?php echo $error; ?>
            </div>
        <?php } ?>

        <form action="" class="formulario" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Información General</legend>

                <label for="titulo">Titulo:</label>
                <input 
                type="text" 
                id="titulo" 
                name="titulo" 
                value="<?php echo $titulo ?>" 
                placeholder="Titulo de la propiedad">

                <label for="precio">Precio:</label>
                <input 
                type="number" 
                id="precio" 
                name="precio" 
                value="<?php echo $precio ?>" 
                placeholder="Precio de la propiedad"
                min="10000000" 
                max="999999999"
                >

                <label for="imagen">Imagen:</label>
                <input 
                type="file" 
                id="imagen" 
                accept="image/jpeg, image/png"
                name="imagen">

                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" ><?php echo $descripcion ?></textarea>
            </fieldset>
            <fieldset>
                <legend>Información Propiedad</legend>

                <label for="habitaciones">Habitaciones:</label>
                <input 
                type="number" 
                id="habitaciones" 
                name="habitaciones" 
                value="<?php echo $habitaciones ?>" 
                placeholder="Ej: 3" 
                min="1" 
                max="9">
            
                <label for="wc">Baños:</label>
                <input 
                type="number" 
                id="wc" 
                name="wc" 
                value="<?php echo $wc ?>" 
                placeholder="Ej: 2" 
                min="1" 
                max="9">

                <label for="estacionamientos">Estacionamientos:</label>
                <input 
                type="number" 
                id="estacionamientos" 
                name="estacionamiento" 
                value="<?php echo $estacionamiento ?>" 
                placeholder="Ej: 1" 
                min="1" 
                max="9">
            </fieldset>
            <fieldset>
                <legend>Vendedor</legend>
                
                <select name="vendedor">
                    <option se value="">--Seleccionar--</option>
                    <?php foreach($vendedores as $vendedor):?>
                         <option 
                            <?php 
                                if($vendedores_id === $vendedor -> getId()){
                                    echo 'selected';
                                }
                            ?>
                            value="<?php echo $vendedor -> getId(); ?>">
                            <?php echo escaparSanitizarHTML($vendedor -> getNombre()).' '.escaparSanitizarHTML($vendedor -> getApellido()); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </fieldset>
            <input type="submit" name="" id="" class="boton-verde" value="Crear Propiedad">
        </form>
    </main>
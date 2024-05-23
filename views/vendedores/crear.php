<?php 
if($_SESSION['nivel']<2){
    header('location:/admin');
}
?>

<main class="contenedor seccion">
        <h1>Crear Vendedor</h1>
        <a href="/admin" class="boton-amarillo">Volver</a>

        <?php foreach($errores as $error){ ?>
        <div class="alerta error" >
            <?php echo $error; ?>
        </div>
        <?php } ?>

        <form action="" class="formulario" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Información General</legend>

                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $nombre ?>" placeholder="Tu nombre">

                <label for="apellido">Apellidos:</label>
                <input type="text" id="apellido" name="apellido" value="<?php echo $apellido ?>" placeholder="Tu apellido">
            </fieldset>
            <fieldset>
                <legend>Información Adicional</legend>
                <label for="telefono">Telefono:</label>
                <input type="tel" id="telefono" name="telefono" value="<?php echo $telefono ?>" placeholder="Tu telefono">

            </fieldset>
            <input type="submit" name="" id="" class="boton-verde" value="Crear Vendedor">
        </form>
    </main>
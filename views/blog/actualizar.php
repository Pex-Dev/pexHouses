<?php 
    if($_SESSION['nivel'] < 0){
        header('location:/admin');
    }
?>
<main class="contenedor seccion">
        <h1>Crear nueva entrada</h1>
        <a href="/admin" class="boton-amarillo">Volver</a>

        <?php foreach($errores as $error){ ?>
        <div class="alerta error" >
            <?php echo $error; ?>
        </div>
        <?php } ?>

        <form action="" class="formulario" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Nueva entrada</legend>

                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name="titulo" value="<?php echo $titulo ?>" placeholder="Titulo de la entrada">

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png">
                <div class="actualizar-imagen">
                    <div>
                        <label>Imagen Actual:</label>
                        <img src="/imagenes/<?php echo $imagenEntrada; ?>" alt="">
                    </div>
                </div>

                <label for="contenido">Coontenido:</label>
                <textarea id="contenido" name="contenido" ><?php echo $contenido ?></textarea>

            </fieldset>
            <input type="submit" name="" id="" class="boton-verde" value="Actualizar Entrada">
        </form>
</main>
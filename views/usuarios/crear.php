<?php 
if($_SESSION['nivel']<2){
    header('location:/admin');
}
?>
<main class="contenedor seccion">
        <h1>Crear Usuario</h1>
        <a href="/admin" class="boton-amarillo">Volver</a>

        <?php foreach($errores as $error){ ?>
        <div class="alerta error" >
            <?php echo $error; ?>
        </div>
        <?php } ?>

        <form action="" class="formulario" method="POST" >
            <fieldset>
                <legend>Información del Usuario</legend>

                <label for="apodo">Apodo:</label>
                <input type="text" id="apodo" name="apodo" value="<?php echo $apodo ?>" placeholder="Tu apodo">

                <label for="email">Correo:</label>
                <input type="email" id="email" name="email" value="<?php echo $email ?>" placeholder="Tu email">

                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" value="<?php echo $password ?>">

                <label for="nivel">Nivel:</label>
                <select name="nivel" id="nivel">
                    <option  value="">--Seleccionar--</option>
                    <option  value="2">Administrador</option>
                    <option  value="1">Vendedor</option>
                    <option  value="0">Escritor de Contenido</option>
                </select>                
            </fieldset>
            <input type="submit" name="" id="" class="boton-verde" value="Crear Usuario">
        </form>
    </main>
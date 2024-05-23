
<main class="contenedor seccion">
    <h1>Iniciar Sesión</h1>
    <?php foreach($errores as $error){ ?>
        <div class="alerta error" >
            <?php echo $error; ?>
        </div>
        <?php } ?>
    <form class="formulario login"method="POST" action="/login">
        <fieldset>
        <legend>Email y Contraseña</legend>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Tu Email" require value="<?php echo $email; ?>">

            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" placeholder="Tu Contraseña" require value="<?php echo $password; ?>">

            <input type="submit" class="boton boton-verde" value="Iniciar Sesión">
        </fieldset>        
    </form>
</main>   



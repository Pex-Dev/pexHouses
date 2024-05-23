<main class="contenedor seccion">
    <h1>Bienvenido/a <?php echo $_SESSION['usuario']; ?></h1>   
    
    
    <?php if(intval($resultado)===1):?>
            <p class="alerta exito"> <?php echo $tipo;  ?> Ingresado/a Exitosamente</p>
    <?php endif; 
    if(intval($resultado)===2):?>
            <p class="alerta exito"><?php echo $tipo;  ?> Actualizado/a Exitosamente</p>
    <?php endif; 
    if(intval($resultado)===3):?>
            <p class="alerta exito"><?php echo $tipo;  ?> Eliminado/a Exitosamente</p>
    <?php endif; ?>
    
    <?php if($_SESSION['nivel']>0): ?>
        <h2>Propiedades</h2>
        <div class="opciones admin">
            <a href="/propiedades/crear" class="boton-verde">Crear Nueva Propiedad</a>
        </div>
        <div class="contenedor-tabla">
            <table class="propiedades">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titulo</th>
                        <th>Imagen</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($propiedades):
                            foreach($propiedades as $propiedad):
                    ?>
                        <tr>
                            <td>
                                <?php echo $propiedad -> getId(); ?>
                            </td>
                            <td>
                                <?php echo escaparSanitizarHTML( $propiedad -> getTitulo()); ?>
                            </td>
                            <td>
                                <img src="<?php echo '../imagenes/'.$propiedad -> getImagen(); ?>" alt="Imagen de la propiedad">  
                            </td>
                            <td>
                                <?php echo '$'.round(intval($propiedad -> getPrecio())) ?>
                            </td>
                            <td>
                                <a class="boton-verde-block" href="/propiedades/actualizar?id=<?php echo $propiedad -> getId(); ?>">Actualizar</a>
                                <form method="POST" class="w-100" action ="/propiedades/eliminar">
                                    <input type="hidden" name="id" value="<?php echo $propiedad -> getId(); ?>">
                                    <input type="hidden" name="tipo" value="propiedad">
                                    <input type="submit" class="boton-rojo-block" value="Eliminar">                                
                                </form>                            
                            </td>
                        </tr>                    
                    <?php
                        endforeach; 
                    endif;
                    ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
    <?php if($_SESSION['nivel']==2): ?>
        <h2>Vendedores</h2>
        <div class="opciones admin">
            <a href="/vendedores/crear" class="boton-verde">Crear Nuevo Vendedor</a>
        </div>
        <div class="contenedor-tabla">
            <table class="propiedades">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>Telefono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($vendedores):
                            foreach($vendedores as $vendedor):
                    ?>
                        <tr>
                            <td>
                                <?php echo $vendedor -> getId(); ?>
                            </td>
                            <td>
                                <?php echo escaparSanitizarHTML( $vendedor -> getNombre()." ".$vendedor -> getApellido()); ?>
                            </td>
                            <td>
                                <p><?php echo escaparSanitizarHTML( $vendedor -> getTelefono()); ?></p>
                            </td>
                            <td>
                                <a class="boton-verde-block" href="/vendedores/actualizar?id=<?php echo $vendedor -> getId();  ?>" >Actualizar</a>
                                <form method="POST" class="w-100" action="/vendedores/eliminar">
                                    <input type="hidden" name="id" value="<?php echo $vendedor -> getId(); ?>">
                                    <input type="hidden" name="tipo" value="vendedor">
                                    <input type="submit" class="boton-rojo-block" value="Eliminar">                                
                                </form>                                
                            </td>
                        </tr>                    
                    <?php
                        endforeach; 
                    endif;
                    ?>
                </tbody>
            </table>
        </div> 
    <?php endif; ?>
    <?php if($_SESSION['nivel']>=0): ?>
        <h2>Blog</h2>
        <div class="opciones admin">
            <a href="/blog/crear" class="boton-verde">Crear Nuevo Entrada de blog</a>
        </div>
        <div class="contenedor-tabla">
        <table class="propiedades">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titulo</th>
                        <th>Foto</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($entradas):
                            foreach($entradas as $entrada):
                    ?>
                        <tr>
                            <td>
                                <?php echo $entrada -> getId(); ?>
                            </td>
                            <td>
                                <?php echo escaparSanitizarHTML( $entrada -> getTitulo()); ?>
                            </td>
                            <td>
                                <img src="<?php echo '../imagenes/'.$entrada -> getImagen(); ?>" alt="Imagen del la entrada de blog">  
                            </td>
                            <td>
                                <a class="boton-verde-block" href="/blog/actualizar?id=<?php echo $entrada -> getId();  ?>" >Actualizar</a>
                                <form method="POST" class="w-100" action="/blog/eliminar">
                                    <input type="hidden" name="id" value="<?php echo $entrada -> getId(); ?>">
                                    <input type="hidden" name="tipo" value="entrada">
                                    <input type="submit" class="boton-rojo-block" value="Eliminar">                                
                                </form>                                
                            </td>
                        </tr>                    
                    <?php
                        endforeach; 
                    endif;
                    ?>
                </tbody>
            </table>
        </div> 
    <?php endif; ?>
    
</main>
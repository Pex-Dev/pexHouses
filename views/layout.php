<?php
//VER SI USUARIO ESTA LOGEADO
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$auth = $_SESSION['login'] ?? null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raíces</title>
    <link rel="stylesheet" href="../build/css/app.css">
</head>
<body>
    <header class="header <?php echo $inicio ? 'inicio' : ''; ?> ">
            <div class="contenedor contenido-header">
                <div class="barra">
                    <div class="barra-contenido">
                        <a href="/">         
                            <picture class="logo">
                                <source srcset="/build/img/pexhouses.webp" type="image/webp">
                                <img loading="lazy" src="/build/img/pexhouses.png" alt="">
                            </picture>           
                        </a>
                        <div class="mobile-menu">
                            <img src="/build/img/barras.svg" alt="Icono Menu Responsive">
                        </div>
                    </div>
                    
                    <div class="derecha">
                        
                        <nav class="navegacion">
                            <a href="/nosotros">Nosotros</a>
                            <a href="/propiedades">Propiedades</a>
                            <a href="/blog">Blog</a>
                            <a href="/contacto">Contacto</a>
                            <?php if(!$auth): ?>
                                <a href="/login">Administración</a>    
                            <?php endif; ?>
                            <?php if($auth): ?>
                                <a href="/admin">Administración</a>    
                                <a href="/logout">Cerrar Sesión</a>    
                            <?php endif; ?>
                            <img class="dark-mode-boton" src="/build/img/dark-mode.svg" alt="Boton modo oscuro">
                        </nav>
                    </div>
                    
                </div><!-- .barra -->
                <?php 
                    if(isset($inicio)){
                        if($inicio) {
                           
                        } 
                    }
                    
                ?>         
            </div>
    </header>
    <?php 
    
    if(isset($contenido)){
        echo $contenido;
    }
    
    $anio = date('Y');
    ?>
    <footer class="footer seccion">
            <div class="contenedor contenedor-footer">
                <nav class="navegacion">
                    <a href="/nosotros">Nosotros</a>
                    <a href="/propiedades">Propiedades</a>
                    <a href="/blog">Blog</a>
                    <a href="/contacto">Contacto</a>
                </nav>
            </div>
            <p class="copyright">Todos los derechos Reservados <?php echo $anio; ?> &copy;</p>
    </footer>
    <script src="../build/js/bundle.min.js"></script>
</body>
</html>
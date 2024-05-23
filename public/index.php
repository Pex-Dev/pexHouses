<?php 
require_once __DIR__ . '/../includes/app.php';

use Controller\LoginController;
use MVC\Router;
use Controller\PropiedadController;
use Controller\VendedorController;
use Controller\PaginasController;
use Controller\AdminController;
use Controller\EntradasController;

$router = new Router();
//PRIVADO
$router -> get('/admin',[PropiedadController::class,'index']);
$router -> get('/propiedades/crear',[PropiedadController::class,'crear']);
$router -> post('/propiedades/crear',[PropiedadController::class,'crear']);
$router -> get('/propiedades/actualizar',[PropiedadController::class,'actualizar']);
$router -> post('/propiedades/actualizar',[PropiedadController::class,'actualizar']);
$router -> post('/propiedades/eliminar',[PropiedadController::class,'eliminar']);

$router -> get('/vendedores/crear',[VendedorController::class,'crear']);
$router -> post('/vendedores/crear',[VendedorController::class,'crear']);
$router -> get('/vendedores/actualizar',[VendedorController::class,'actualizar']);
$router -> post('/vendedores/actualizar',[VendedorController::class,'actualizar']);
$router -> post('/vendedores/eliminar',[VendedorController::class,'eliminar']);

$router -> get('/usuarios/crear',[AdminController::class,'crear']);
$router -> post('/usuarios/crear',[AdminController::class,'crear']);
$router -> get('/blog/crear',[EntradasController::class,'crear']);
$router -> post('/blog/crear',[EntradasController::class,'crear']);
$router -> get('/blog/actualizar',[EntradasController::class,'actualizar']);
$router -> post('/blog/actualizar',[EntradasController::class,'actualizar']);
$router -> post('/blog/eliminar',[EntradasController::class,'eliminar']);

//PUBLICO
$router -> get('/',[PaginasController::class,'index']);
$router -> get('/nosotros',[PaginasController::class,'nosotros']);
$router -> get('/propiedades',[PaginasController::class,'propiedades']);
$router -> get('/propiedad',[PaginasController::class,'propiedad']);
$router -> get('/blog',[EntradasController::class,'index']);
$router -> get('/entrada',[PaginasController::class,'entrada']);
$router -> get('/contacto',[PaginasController::class,'contacto']);
$router -> post('/contacto',[PaginasController::class,'contacto']);

//LOGIN
$router -> get('/login',[LoginController::class,'login']);
$router -> post('/login',[LoginController::class,'login']);
$router -> get('/logout',[LoginController::class,'logout']);

$router->comprobarRutas();
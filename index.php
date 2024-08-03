<?php
session_start();
require_once 'autoload.php'; //para tener acceso a todos lo controladores(todas las clases)
require_once 'config/parameters.php';
require_once 'config/db.php';
require_once 'helpers/utils.php';
require_once  'views/layout/header.php';
require_once  'views/layout/sidebar.php';

// Conexion base de datos 


function show_error(){
    $error = new errorController();
    $error->index();
}

//el GET del enlace es el : /?controller=usuario y aqui ya lo nombre Controller con &action= para usar ejecutar los metodos (solo es una variable que se usa mas abajo)


if(isset($_GET['controller'])){
    $nombre_controlador = $_GET['controller'].'Controller';

}elseif(!isset($_GET['controller']) && !isset($_GET['action'])){ //si no estan 
    $nombre_controlador = controller_default;  //lo mandara a este ProductoController.php

}else{
    show_error();
    exit();
}

if(class_exists($nombre_controlador)){ // si la clase existe
    $controlador = new $nombre_controlador(); //crea un objeto de esa clase 

    //el methodo  existe dentro de el controlador
    if(isset($_GET['action']) && method_exists($controlador, $_GET['action'])){ 
        $action = $_GET['action'];
        $controlador->$action(); 
    }elseif(!isset($_GET['controller']) && !isset($_GET['action'])){
        $action_default = action_default;
        $controlador->$action_default(); 

    }else{
        show_error();
    }
}else{
    show_error();
}
require_once  'views/layout/footer.php';

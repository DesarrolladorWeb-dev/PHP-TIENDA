<?php
function controllers_autoload($classname){
    // Esto entra a la carpeta de controladores y hacemos un include a cada uno 
    include 'controllers/'. $classname . '.php';
}
spl_autoload_register('controllers_autoload');

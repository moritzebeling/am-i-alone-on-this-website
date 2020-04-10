<?php

define( 'DS' , DIRECTORY_SEPARATOR );
define( 'ROOT' , $_SERVER['DOCUMENT_ROOT'] );

date_default_timezone_set( 'Europe/Berlin' );

require_once 'functions.php';

spl_autoload_register(function ($class_name) {
    require_once 'classes' .DS. $class_name . '.php';
});

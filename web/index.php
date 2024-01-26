<?php
//automatically loads Classes from lib directory
spl_autoload_register(function ($class) {
    include_once('lib/' . $class . '.php');
});

$application = new Application();
$application->start();
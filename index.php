<?php

declare(strict_types=1);

require_once('src/Utils/debug.php');
$config = require_once('config/config.php');

spl_autoload_register(function(string $name){
    $name = str_replace('\\','/',$name);
    $name = str_replace('App/','',$name);
    $path = "src/$name.php";
    require_once($path);
});


use Throwable;
use App\Request;
use App\Controller\NoteController;
use App\Controller\AbstractController;
use App\Exception\AppException;
use App\Exception\StorageException;
use App\Exception\ConfigurationException;


$request =  new Request($_GET,$_POST,$_SERVER);
try
{
    AbstractController::initConfig($config);
    (new NoteController($request))->run();
}
catch(StorageException $ex)
{
    echo '<h1>Wystąpił błąd w aplikacji [StorageException]</h1>';
    echo '<h3>' . $ex->getMessage() . '</h3>';
}
catch(ConfigurationException $ex)
{
    echo '<h1>Wystąpił błąd w aplikacji [ConfigurationException]</h1>';
    echo '<h3>' . $ex->getMessage() . '</h3>';
}
catch(AppException $ex)
{
    echo '<h1>Wystąpił błąd w aplikacji [AppException]</h1>';
    echo '<h3>' . $ex->getMessage() . '</h3>';
}
catch(Throwable $e)
{
   echo '<h1>Wystąpił błąd w aplikacji</h1>';
   dump($e);
}





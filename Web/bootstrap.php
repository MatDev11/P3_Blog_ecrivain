<?php
const DEFAULT_APP = 'Frontend';



// Si l'application n'est pas valide, on va charger l'application par défaut qui se chargera de générer une erreur 404

//if (!isset($_GET['app'])|| !file_exists(__DIR__.'/App/'.$_GET['app']))
if (!isset($_GET['app'])) //|| !file_exists(__DIR__.'\App\\'.$_GET['app']))
{
    $_GET['app'] = DEFAULT_APP;
}

// On commence par inclure la classe nous permettant d'enregistrer nos autoload
require __DIR__.'/../lib/core/SplClassLoader.php';

// On va ensuite enregistrer les autoloads correspondant
$FramLoader = new SplClassLoader('core', __DIR__.'/../lib');
$FramLoader->register();

$appLoader = new SplClassLoader('App', __DIR__.'/..');
$appLoader->register();

$modelLoader = new SplClassLoader('Model', __DIR__.'/../App');
$modelLoader->register();
//**********************************
$modelLoader = new SplClassLoader('Services', __DIR__.'/../App');
$modelLoader->register();
//*************************************
$entityLoader = new SplClassLoader('Entity', __DIR__.'/../App');
$entityLoader->register();

$formBuilderLoader = new SplClassLoader('FormBuilder', __DIR__.'/../App');
$formBuilderLoader->register();


// on instancie la classe

$appClass = 'App\\'.$_GET['app'].'\\'.$_GET['app'].'Application';



$app = new $appClass;

$app->run();
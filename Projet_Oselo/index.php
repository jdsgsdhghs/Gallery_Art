<?php



session_name('PROJET');
session_start();

date_default_timezone_set('Europe/Paris');

require_once('autoload.php');

$app=new Manager\Application;

$app->Launch();

$model=new Model\ModelArtwork();
// var_dump($model->selectAll());

// echo Manager\Config::DBNAME;
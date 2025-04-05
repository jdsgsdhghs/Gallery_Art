<?php

final class Autoload{

  public static function nameAutoload($name)  {
    $fichier=str_replace('\\','/',$name).'.php';
    require($fichier);  
  }
}

spl_autoload_register(array('Autoload','nameAutoload'));
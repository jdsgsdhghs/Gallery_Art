<?php

namespace Manager;
class PDOManager{

  private static $pdo=null;

  
private function __construct(){
if (is_null(self::$pdo) )
  self::$pdo= new \PDO(
    'mysql:host='.Config::HOST.';charset=utf8;dbname='.Config::DBNAME,
    'root',
    '',
    array(
      \PDO::ATTR_DEFAULT_FETCH_MODE=>\PDO::FETCH_OBJ
    )
    );
}
public static function getPDO()  {
  $instance =new self;
   
  return $instance::$pdo;
}
}


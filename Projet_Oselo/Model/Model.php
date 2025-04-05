<?php
namespace Model;

use Manager\PDOManager;

abstract class Model{
protected $pdo;
protected $IDTable;
protected $nomTable;
public function __construct() {
  $this->pdo = PDOManager::getPDO();
}

public function selectAll()  {
  $stmt=$this->pdo->prepare("SELECT * FROM ". $this->nomTable);
  $stmt->execute();
  return $stmt->fetchAll();
}

public function selectById($id) {
  $stmt=$this->pdo->prepare("SELECT * FROM ". $this->nomTable ." WHERE ". $this->IDTable ." = $id");
  $stmt->execute();
  return $stmt->fetch();
}
}
<?php

namespace Controller;
Use Manager; 
class Controller{
protected $model;
  public function render($view,$param = array()) {
    extract($param);
    require_once('View/header.html');
    require_once('View/'.$view);
    require_once('View/footer.html');
  }
}
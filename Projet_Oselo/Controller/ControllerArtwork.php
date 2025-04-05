<?php
namespace Controller;

use Model;


class ControllerArtwork extends Controller{
  public function __construct(){
    $this->model=new Model\ModelArtwork;
  }
  public function view($id){
    $params=[
      'title'=>'Nom',
      'artwork'=>$this->model->selectById($id)
      ];
    
    $this->render('artwork/fiche.html',$params);
  }
}
<?php

namespace Model;
class ModelArtwork extends Model{
public function __construct() {
  Parent::__construct();
  $this->IDTable='id_artwork';
  $this->nomTable='artwork';
}

}
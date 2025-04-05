<?php
// Include controller
include_once '../../controllers/ArtworkController.php';

// Initialize controller
// Crée une nouvelle instance de la classe WarehouseController
$controller = new ArtworkController();

// Display artwork list
$controller->index();
?>
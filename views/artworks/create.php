<?php
// Include controller
include_once '../../controllers/ArtworkController.php';

// Initialize controller
$controller = new ArtworkController();

// Display create form
$controller->create();
?>
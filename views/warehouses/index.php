<?php
// Include controller
include_once '../../controllers/WarehouseController.php';

// Initialize controller
$controller = new WarehouseController();

// Display warehouse list
$controller->index();
?>
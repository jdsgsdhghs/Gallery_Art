<?php
// Include controller
include_once '../../controllers/WarehouseController.php';

// Check if form was submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Initialize controller
    $controller = new WarehouseController();
    
    // Store new warehouse
    $controller->store($_POST);
} else {
    // Redirect to index if form was not submitted
    header("Location: index.php");
    exit();
}
?>
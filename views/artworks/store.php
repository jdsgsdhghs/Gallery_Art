<?php
// Include controller
include_once '../../controllers/ArtworkController.php';

// Check if form was submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Initialize controller
    $controller = new ArtworkController();
    
    // Store new artwork
    $controller->store($_POST);
} else {
    // Redirect to index if form was not submitted
    header("Location: index.php");
    exit();
}
?>
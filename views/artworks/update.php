<?php
// Include controller
include_once '../../controllers/ArtworkController.php';

// Check if form was submitted
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    // Initialize controller
    $controller = new ArtworkController();
    
    // Update artwork
    $controller->update($_POST);
} else {
    // Redirect to index if form was not submitted or ID is missing
    header("Location: index.php");
    exit();
}
?>
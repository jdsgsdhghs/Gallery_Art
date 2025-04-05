<?php
// Include controller
include_once '../../controllers/ArtworkController.php';

// Check if ID is set
if(isset($_GET['id']) && !empty($_GET['id'])) {
    // Initialize controller
    $controller = new ArtworkController();
    
    // Delete artwork
    $controller->delete($_GET['id']);
} else {
    // Redirect to index if ID is not set
    header("Location: index.php");
    exit();
}
?>
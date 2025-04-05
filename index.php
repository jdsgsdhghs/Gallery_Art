<?php
// Titre de la page
$page_title = "Galerie Oselo - Admin Dashboard";
$base_url = "./";

// Inclusion du header
include_once 'includes/header.php';

// Connexion base de données + modèles
include_once 'config/database.php';
include_once 'models/Artwork.php';
include_once 'models/Warehouse.php';

$database = new Database();
$db = $database->getConnection();

$artwork = new Artwork($db);
$warehouse = new Warehouse($db);
?>

<div class="container">
    <div class="jumbotron text-center">
        <h1 class="display-4">Welcome to Galerie Oselo Administration</h1>
        <p class="lead">Manage artworks and warehouses from this dashboard.</p>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Artworks</h3>
                </div>
                <div class="panel-body">
                    <?php
                    $stmt = $artwork->readAll();
                    $artwork_count = $stmt->rowCount();
                    echo "<p>Total artworks: <strong>{$artwork_count}</strong></p>";
                    ?>
                    <a href="views/artworks/index.php" class="btn btn-primary">Manage Artworks</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Warehouses</h3>
                </div>
                <div class="panel-body">
                    <?php
                    $stmt = $warehouse->readAll();
                    $warehouse_count = $stmt->rowCount();
                    echo "<p>Total warehouses: <strong>{$warehouse_count}</strong></p>";
                    ?>
                    <a href="views/warehouses/index.php" class="btn btn-primary">Manage Warehouses</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>

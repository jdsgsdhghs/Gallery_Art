<?php
// inclure les objets
include_once '../../config/database.php';
include_once '../../models/Artwork.php';
include_once '../../models/Warehouse.php';

class ArtworkController {
    // Database connection and objects
    private $db;
    private $artwork;
    private $warehouse;

    // Constructeur
    public function __construct() {
        // instance de la base de données
        $database = new Database();
        $this->db = $database->getConnection();

        // Initialiser les objets
        $this->artwork = new Artwork($this->db);
        $this->warehouse = new Warehouse($this->db);
    }

    // Liste des artworks
    public function index() {
        // Query artworks
        $stmt = $this->artwork->readAll();
        $num = $stmt->rowCount();

        // Set page title
        $page_title = "Manage Artworks";
        $base_url = "../..";

        // Include header
        include_once '../../includes/header.php';

        // Start output buffering
        ob_start();
        
        // Display artworks if any
        if($num > 0) {
            echo "<div class='container'>";
            echo "<div class='row'>";
            echo "<div class='col-md-12'>";
            
            echo "<div class='page-header'>";
            echo "<h1>Artworks</h1>";
            echo "</div>";
            
            echo "<a href='create.php' class='btn btn-primary mb-3'>Add New Artwork</a>";
            
            echo "<div class='table-responsive'>";
            echo "<table class='table table-striped table-bordered'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Title</th>";
            echo "<th>Artist</th>";
            echo "<th>Year</th>";
            echo "<th>Dimensions</th>";
            echo "<th>Warehouse</th>";
            echo "<th>Actions</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                
                echo "<tr>";
                echo "<td>{$id}</td>";
                echo "<td>{$title}</td>";
                echo "<td>{$artist_name}</td>";
                echo "<td>{$year}</td>";
                echo "<td>{$width} x {$height}</td>";
                echo "<td>" . ($warehouse_name ? $warehouse_name : "Not assigned") . "</td>";
                echo "<td>";
                echo "<a href='show.php?id={$id}' class='btn btn-info btn-sm'>View</a> ";
                echo "<a href='edit.php?id={$id}' class='btn btn-primary btn-sm'>Edit</a> ";
                echo "<a href='#' onclick='deleteArtwork({$id})' class='btn btn-danger btn-sm'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
            
            echo "</tbody>";
            echo "</table>";
            echo "</div>"; // table-responsive
            
            echo "</div>"; // col-md-12
            echo "</div>"; // row
            echo "</div>"; // container
            
            // JavaScript for delete confirmation
            echo "<script>
            function deleteArtwork(id) {
                if(confirm('Are you sure you want to delete this artwork?')) {
                    window.location.href = 'delete.php?id=' + id;
                }
            }
            </script>";
        } else {
            echo "<div class='container'>";
            echo "<div class='row'>";
            echo "<div class='col-md-12'>";
            
            echo "<div class='page-header'>";
            echo "<h1>Artworks</h1>";
            echo "</div>";
            
            echo "<a href='create.php' class='btn btn-primary mb-3'>Add New Artwork</a>";
            
            echo "<div class='alert alert-info'>No artworks found.</div>";
            
            echo "</div>"; // col-md-12
            echo "</div>"; // row
            echo "</div>"; // container
        }
        
        $output = ob_get_clean();
        echo $output;
        
        // Include footer
        include_once '../../includes/footer.php';
    }

    // Voir le detailles d'un artwork 
    public function show($id) {
        // Set artwork ID and read its details
        $this->artwork->id = $id;
        $this->artwork->readOne();

        // changer la page title
        $page_title = "Artwork Details: " . $this->artwork->title;
        $base_url = "../..";

        // Include header
        include_once '../../includes/header.php';

        // Start output buffering
        ob_start();
        
        echo "<div class='container'>";
        echo "<div class='row'>";
        echo "<div class='col-md-12'>";
        
        echo "<div class='page-header'>";
        echo "<h1>Artwork Details</h1>";
        echo "</div>";
        
        echo "<div class='panel panel-primary'>";
        echo "<div class='panel-heading'>";
        echo "<h3 class='panel-title'>{$this->artwork->title}</h3>";
        echo "</div>";
        echo "<div class='panel-body'>";
        
        echo "<div class='row'>";
        echo "<div class='col-md-6'>";
        echo "<p><strong>Artist:</strong> {$this->artwork->artist_name}</p>";
        echo "<p><strong>Year:</strong> {$this->artwork->year}</p>";
        echo "<p><strong>Dimensions:</strong> {$this->artwork->width} x {$this->artwork->height}</p>";
        echo "<p><strong>Warehouse:</strong> " . ($this->artwork->warehouse_id ? $this->getWarehouseName($this->artwork->warehouse_id) : "Not assigned") . "</p>";
        echo "</div>"; // col-md-6
        echo "</div>"; // row
        
        echo "</div>"; // panel-body
        echo "<div class='panel-footer'>";
        echo "<a href='index.php' class='btn btn-default'>Back to List</a> ";
        echo "<a href='edit.php?id={$id}' class='btn btn-primary'>Edit</a> ";
        echo "<a href='#' onclick='deleteArtwork({$id})' class='btn btn-danger'>Delete</a>";
        echo "</div>"; // panel-footer
        echo "</div>"; // panel
        
        echo "</div>"; // col-md-12
        echo "</div>"; // row
        echo "</div>"; // container
        
        // JavaScript for delete confirmation
        echo "<script>
        function deleteArtwork(id) {
            if(confirm('Are you sure you want to delete this artwork?')) {
                window.location.href = 'delete.php?id=' + id;
            }
        }
        </script>";
        
        $output = ob_get_clean();
        echo $output;
        
        // Include footer
        include_once '../../includes/footer.php';
    }

    // Create artwork form
    public function create() {
        // Set page title
        $page_title = "Add New Artwork";
        $base_url = "../..";

        // Get all warehouses for dropdown
        $warehouse_stmt = $this->warehouse->readAll();

        // Include header
        include_once '../../includes/header.php';

        // Start output buffering
        ob_start();
        
        echo "<div class='container'>";
        echo "<div class='row'>";
        echo "<div class='col-md-12'>";
        
        echo "<div class='page-header'>";
        echo "<h1>Add New Artwork</h1>";
        echo "</div>";
        
        echo "<form action='store.php' method='post'>";
        
        echo "<div class='form-group'>";
        echo "<label for='title'>Title</label>";
        echo "<input type='text' class='form-control' id='title' name='title' required>";
        echo "</div>";
        
        echo "<div class='form-group'>";
        echo "<label for='artist_name'>Artist</label>";
        echo "<input type='text' class='form-control' id='artist_name' name='artist_name' required>";
        echo "</div>";
        
        echo "<div class='form-group'>";
        echo "<label for='year'>Year</label>";
        echo "<input type='number' class='form-control' id='year' name='year' required>";
        echo "</div>";
        
        echo "<div class='row'>";
        echo "<div class='col-md-6'>";
        echo "<div class='form-group'>";
        echo "<label for='width'>Width</label>";
        echo "<input type='number' step='0.01' class='form-control' id='width' name='width' required>";
        echo "</div>";
        echo "</div>"; // col-md-6
        
        echo "<div class='col-md-6'>";
        echo "<div class='form-group'>";
        echo "<label for='height'>Height</label>";
        echo "<input type='number' step='0.01' class='form-control' id='height' name='height' required>";
        echo "</div>";
        echo "</div>"; // col-md-6
        echo "</div>"; // row
        
        echo "<div class='form-group'>";
        echo "<label for='warehouse_id'>Warehouse</label>";
        echo "<select class='form-control' id='warehouse_id' name='warehouse_id'>";
        echo "<option value=''>Not assigned</option>";
        
        while($warehouse_row = $warehouse_stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($warehouse_row);
            echo "<option value='{$id}'>{$name}</option>";
        }
        
        echo "</select>";
        echo "</div>";
        
        echo "<div class='form-group'>";
        echo "<button type='submit' class='btn btn-primary'>Save</button> ";
        echo "<a href='index.php' class='btn btn-default'>Cancel</a>";
        echo "</div>";
        
        echo "</form>";
        
        echo "</div>"; // col-md-12
        echo "</div>"; // row
        echo "</div>"; // container
        
        $output = ob_get_clean();
        echo $output;
        
        // Include footer
        include_once '../../includes/footer.php';
    }

    // Store artwork
    public function store($data) {
        // Set artwork values
        $this->artwork->title = $data['title'];
        $this->artwork->artist_name = $data['artist_name'];
        $this->artwork->year = $data['year'];
        $this->artwork->width = $data['width'];
        $this->artwork->height = $data['height'];
        $this->artwork->warehouse_id = !empty($data['warehouse_id']) ? $data['warehouse_id'] : null;

        // Create the artwork
        if($this->artwork->create()) {
            header("Location: index.php?success=1");
        } else {
            header("Location: create.php?error=1");
        }
    }

    // Edit artwork form
    public function edit($id) {
        // Set artwork ID and read its details
        $this->artwork->id = $id;
        $this->artwork->readOne();

        // Get all warehouses for dropdown
        $warehouse_stmt = $this->warehouse->readAll();

        // Set page title
        $page_title = "Edit Artwork: " . $this->artwork->title;
        $base_url = "../..";

        // Include header
        include_once '../../includes/header.php';

        // Start output buffering
        ob_start();
        
        echo "<div class='container'>";
        echo "<div class='row'>";
        echo "<div class='col-md-12'>";
        
        echo "<div class='page-header'>";
        echo "<h1>Edit Artwork</h1>";
        echo "</div>";
        
        echo "<form action='update.php' method='post'>";
        echo "<input type='hidden' name='id' value='{$id}'>";
        
        echo "<div class='form-group'>";
        echo "<label for='title'>Title</label>";
        echo "<input type='text' class='form-control' id='title' name='title' value='{$this->artwork->title}' required>";
        echo "</div>";
        
        echo "<div class='form-group'>";
        echo "<label for='artist_name'>Artist</label>";
        echo "<input type='text' class='form-control' id='artist_name' name='artist_name' value='{$this->artwork->artist_name}' required>";
        echo "</div>";
        
        echo "<div class='form-group'>";
        echo "<label for='year'>Year</label>";
        echo "<input type='number' class='form-control' id='year' name='year' value='{$this->artwork->year}' required>";
        echo "</div>";
        
        echo "<div class='row'>";
        echo "<div class='col-md-6'>";
        echo "<div class='form-group'>";
        echo "<label for='width'>Width</label>";
        echo "<input type='number' step='0.01' class='form-control' id='width' name='width' value='{$this->artwork->width}' required>";
        echo "</div>";
        echo "</div>"; // col-md-6
        
        echo "<div class='col-md-6'>";
        echo "<div class='form-group'>";
        echo "<label for='height'>Height</label>";
        echo "<input type='number' step='0.01' class='form-control' id='height' name='height' value='{$this->artwork->height}' required>";
        echo "</div>";
        echo "</div>"; // col-md-6
        echo "</div>"; // row
        
        echo "<div class='form-group'>";
        echo "<label for='warehouse_id'>Warehouse</label>";
        echo "<select class='form-control' id='warehouse_id' name='warehouse_id'>";
        echo "<option value=''>Not assigned</option>";
        
        while($warehouse_row = $warehouse_stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($warehouse_row);
            $selected = ($id == $this->artwork->warehouse_id) ? "selected" : "";
            echo "<option value='{$id}' {$selected}>{$name}</option>";
        }
        
        echo "</select>";
        echo "</div>";
        
        echo "<div class='form-group'>";
        echo "<button type='submit' class='btn btn-primary'>Update</button> ";
        echo "<a href='index.php' class='btn btn-default'>Cancel</a>";
        echo "</div>";
        
        echo "</form>";
        
        echo "</div>"; // col-md-12
        echo "</div>"; // row
        echo "</div>"; // container
        
        $output = ob_get_clean();
        echo $output;
        
        // Include footer
        include_once '../../includes/footer.php';
    }

    // Update artwork
    public function update($data) {
        // Set artwork values
        $this->artwork->id = $data['id'];
        $this->artwork->title = $data['title'];
        $this->artwork->artist_name = $data['artist_name'];
        $this->artwork->year = $data['year'];
        $this->artwork->width = $data['width'];
        $this->artwork->height = $data['height'];
        $this->artwork->warehouse_id = !empty($data['warehouse_id']) ? $data['warehouse_id'] : null;

        // Update the artwork
        if($this->artwork->update()) {
            header("Location: index.php?success=2");
        } else {
            header("Location: edit.php?id={$data['id']}&error=1");
        }
    }

    // Delete artwork
    public function delete($id) {
        // Set artwork ID
        $this->artwork->id = $id;

        // Delete the artwork
        if($this->artwork->delete()) {
            header("Location: index.php?success=3");
        } else {
            header("Location: index.php?error=1");
        }
    }

    // Helper methods
    private function getWarehouseName($warehouse_id) {
        $this->warehouse->id = $warehouse_id;
        if($this->warehouse->readOne()) {
            return $this->warehouse->name;
        }
        return "Unknown";
    }
}
?>
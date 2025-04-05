<?php
// Include database and object files
include_once '../../config/database.php';
include_once '../../models/Warehouse.php';
include_once '../../models/Artwork.php';

class WarehouseController {
    // Database connection and objects
    private $db;
    private $warehouse;
    private $artwork;

    // Constructor
    public function __construct() {
        // Get database connection
        $database = new Database();
        $this->db = $database->getConnection();

        // Initialize objects
        $this->warehouse = new Warehouse($this->db);
        $this->artwork = new Artwork($this->db);
    }

    // List all warehouses
    public function index() {
        // Query warehouses
        $stmt = $this->warehouse->readAll();
        $num = $stmt->rowCount();

        // Set page title
        $page_title = "Manage Warehouses";
        $base_url = "../..";

        // Include header
        include_once '../../includes/header.php';

        // Start output buffering
        ob_start();
        
        // Display warehouses if any
        if($num > 0) {
            echo "<div class='container'>";
            echo "<div class='row'>";
            echo "<div class='col-md-12'>";
            
            echo "<div class='page-header'>";
            echo "<h1>Warehouses</h1>";
            echo "</div>";
            
            echo "<a href='create.php' class='btn btn-primary mb-3'>Add New Warehouse</a>";
            
            echo "<div class='table-responsive'>";
            echo "<table class='table table-striped table-bordered'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Name</th>";
            echo "<th>Address</th>";
            echo "<th>Artworks</th>";
            echo "<th>Actions</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                
                echo "<tr>";
                echo "<td>{$id}</td>";
                echo "<td>{$name}</td>";
                echo "<td>{$address}</td>";
                echo "<td>{$artwork_count}</td>";
                echo "<td>";
                echo "<a href='show.php?id={$id}' class='btn btn-info btn-sm'>View</a> ";
                echo "<a href='edit.php?id={$id}' class='btn btn-primary btn-sm'>Edit</a> ";
                echo "<a href='#' onclick='deleteWarehouse({$id})' class='btn btn-danger btn-sm'>Delete</a>";
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
            function deleteWarehouse(id) {
                if(confirm('Are you sure you want to delete this warehouse? All artworks will be unassigned.')) {
                    window.location.href = 'delete.php?id=' + id;
                }
            }
            </script>";
        } else {
            echo "<div class='container'>";
            echo "<div class='row'>";
            echo "<div class='col-md-12'>";
            
            echo "<div class='page-header'>";
            echo "<h1>Warehouses</h1>";
            echo "</div>";
            
            echo "<a href='create.php' class='btn btn-primary mb-3'>Add New Warehouse</a>";
            
            echo "<div class='alert alert-info'>No warehouses found.</div>";
            
            echo "</div>"; // col-md-12
            echo "</div>"; // row
            echo "</div>"; // container
        }
        
        $output = ob_get_clean();
        echo $output;
        
        // Include footer
        include_once '../../includes/footer.php';
    }

    // Show warehouse details
    public function show($id) {
        // Set warehouse ID and read its details
        $this->warehouse->id = $id;
        $this->warehouse->readOne();

        // Get artworks in this warehouse
        $artwork_stmt = $this->artwork->readByWarehouse($id);
        $artwork_count = $artwork_stmt->rowCount();

        // Set page title
        $page_title = "Warehouse Details: " . $this->warehouse->name;
        $base_url = "../..";

        // Include header
        include_once '../../includes/header.php';

        // Start output buffering
        ob_start();
        
        echo "<div class='container'>";
        echo "<div class='row'>";
        echo "<div class='col-md-12'>";
        
        echo "<div class='page-header'>";
        echo "<h1>Warehouse Details</h1>";
        echo "</div>";
        
        echo "<div class='panel panel-primary'>";
        echo "<div class='panel-heading'>";
        echo "<h3 class='panel-title'>{$this->warehouse->name}</h3>";
        echo "</div>";
        echo "<div class='panel-body'>";
        
        echo "<div class='row'>";
        echo "<div class='col-md-6'>";
        echo "<p><strong>Address:</strong> {$this->warehouse->address}</p>";
        echo "</div>"; // col-md-6
        echo "</div>"; // row
        
        echo "<h4>Artworks in this Warehouse</h4>";
        
        if($artwork_count > 0) {
            echo "<div class='table-responsive'>";
            echo "<table class='table table-striped table-bordered'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Title</th>";
            echo "<th>Artist</th>";
            echo "<th>Year</th>";
            echo "<th>Dimensions</th>";
            echo "<th>Actions</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            
            while($row = $artwork_stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                
                echo "<tr>";
                echo "<td>{$id}</td>";
                echo "<td>{$title}</td>";
                echo "<td>{$artist_name}</td>";
                echo "<td>{$year}</td>";
                echo "<td>{$width} x {$height}</td>";
                echo "<td>";
                echo "<a href='../artworks/show.php?id={$id}' class='btn btn-info btn-sm'>View</a> ";
                echo "<a href='../artworks/edit.php?id={$id}' class='btn btn-primary btn-sm'>Edit</a>";
                echo "</td>";
                echo "</tr>";
            }
            
            echo "</tbody>";
            echo "</table>";
            echo "</div>"; // table-responsive
        } else {
            echo "<div class='alert alert-info'>No artworks in this warehouse.</div>";
        }
        
        echo "</div>"; // panel-body
        echo "<div class='panel-footer'>";
        echo "<a href='index.php' class='btn btn-default'>Back to List</a> ";
        echo "<a href='edit.php?id={$id}' class='btn btn-primary'>Edit</a> ";
        echo "<a href='#' onclick='deleteWarehouse({$id})' class='btn btn-danger'>Delete</a>";
        echo "</div>"; // panel-footer
        echo "</div>"; // panel
        
        echo "</div>"; // col-md-12
        echo "</div>"; // row
        echo "</div>"; // container
        
        // JavaScript for delete confirmation
        echo "<script>
        function deleteWarehouse(id) {
            if(confirm('Are you sure you want to delete this warehouse? All artworks will be unassigned.')) {
                window.location.href = 'delete.php?id=' + id;
            }
        }
        </script>";
        
        $output = ob_get_clean();
        echo $output;
        
        // Include footer
        include_once '../../includes/footer.php';
    }

    // Create warehouse form
    public function create() {
        // Set page title
        $page_title = "Add New Warehouse";
        $base_url = "../..";

        // Include header
        include_once '../../includes/header.php';

        // Start output buffering
        ob_start();
        
        echo "<div class='container'>";
        echo "<div class='row'>";
        echo "<div class='col-md-12'>";
        
        echo "<div class='page-header'>";
        echo "<h1>Add New Warehouse</h1>";
        echo "</div>";
        
        echo "<form action='store.php' method='post'>";
        
        echo "<div class='form-group'>";
        echo "<label for='name'>Name</label>";
        echo "<input type='text' class='form-control' id='name' name='name' required>";
        echo "</div>";
        
        echo "<div class='form-group'>";
        echo "<label for='address'>Address</label>";
        echo "<textarea class='form-control' id='address' name='address' rows='3' required></textarea>";
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

    // Store warehouse
    public function store($data) {
        // Set warehouse values
        $this->warehouse->name = $data['name'];
        $this->warehouse->address = $data['address'];

        // Create the warehouse
        if($this->warehouse->create()) {
            header("Location: index.php?success=1");
        } else {
            header("Location: create.php?error=1");
        }
    }

    // Edit warehouse form
    public function edit($id) {
        // Set warehouse ID and read its details
        $this->warehouse->id = $id;
        $this->warehouse->readOne();

        // Set page title
        $page_title = "Edit Warehouse: " . $this->warehouse->name;
        $base_url = "../..";

        // Include header
        include_once '../../includes/header.php';

        // Start output buffering
        ob_start();
        
        echo "<div class='container'>";
        echo "<div class='row'>";
        echo "<div class='col-md-12'>";
        
        echo "<div class='page-header'>";
        echo "<h1>Edit Warehouse</h1>";
        echo "</div>";
        
        echo "<form action='update.php' method='post'>";
        echo "<input type='hidden' name='id' value='{$id}'>";
        
        echo "<div class='form-group'>";
        echo "<label for='name'>Name</label>";
        echo "<input type='text' class='form-control' id='name' name='name' value='{$this->warehouse->name}' required>";
        echo "</div>";
        
        echo "<div class='form-group'>";
        echo "<label for='address'>Address</label>";
        echo "<textarea class='form-control' id='address' name='address' rows='3' required>{$this->warehouse->address}</textarea>";
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

    // Update warehouse
    public function update($data) {
        // Set warehouse values
        $this->warehouse->id = $data['id'];
        $this->warehouse->name = $data['name'];
        $this->warehouse->address = $data['address'];

        // Update the warehouse
        if($this->warehouse->update()) {
            header("Location: index.php?success=2");
        } else {
            header("Location: edit.php?id={$data['id']}&error=1");
        }
    }

    // Delete warehouse
    public function delete($id) {
        // Set warehouse ID
        $this->warehouse->id = $id;

        // Delete the warehouse
        if($this->warehouse->delete()) {
            header("Location: index.php?success=3");
        } else {
            header("Location: index.php?error=1");
        }
    }
}
?>
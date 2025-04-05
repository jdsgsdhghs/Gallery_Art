<?php
class Warehouse {
    // Database connection and table name
    private $conn;
    private $table_name = "warehouses";

    // Object properties
    public $id;
    public $name;
    public $address;
    public $created_at;
    public $updated_at;

    // Constructor with DB connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Read all warehouses
    public function readAll() {
        $query = "SELECT w.id, w.name, w.address, w.created_at, w.updated_at,
                  COUNT(a.id) as artwork_count
                  FROM " . $this->table_name . " w
                  LEFT JOIN artworks a ON w.id = a.warehouse_id
                  GROUP BY w.id
                  ORDER BY w.id DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Create warehouse
    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                  SET name=:name, address=:address";
        
        $stmt = $this->conn->prepare($query);

        
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->address = htmlspecialchars(strip_tags($this->address));

        
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":address", $this->address);

        // Execute query
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Read one warehouse
    public function readOne() {
        $query = "SELECT w.id, w.name, w.address, w.created_at, w.updated_at
                  FROM " . $this->table_name . " w
                  WHERE w.id = ?
                  LIMIT 0,1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->name = $row['name'];
            $this->address = $row['address'];
            $this->created_at = $row['created_at'];
            $this->updated_at = $row['updated_at'];
            return true;
        }
        return false;
    }

    // Update warehouse
    public function update() {
        $query = "UPDATE " . $this->table_name . "
                  SET name=:name, address=:address
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);

        
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->address = htmlspecialchars(strip_tags($this->address));

        
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":address", $this->address);

        // Execute query
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete warehouse
    public function delete() {
        // First update artworks to set warehouse_id to NULL
        $query = "UPDATE artworks SET warehouse_id = NULL WHERE warehouse_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        // Then delete the warehouse
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
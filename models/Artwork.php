<?php
class Artwork {
    // Database connection and table name
    private $conn;
    private $table_name = "artworks";

    // Object properties
    public $id;
    public $title;
    public $year;
    public $artist_name;
    public $width;
    public $height;
    public $warehouse_id;
    public $created_at;
    public $updated_at;

    // Constructor with DB connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Read all artworks
    public function readAll() {
        $query = "SELECT a.id, a.title, a.year, a.artist_name, a.width, a.height, 
                  a.warehouse_id, a.created_at, a.updated_at, w.name as warehouse_name
                  FROM " . $this->table_name . " a
                  LEFT JOIN warehouses w ON a.warehouse_id = w.id
                  ORDER BY a.id DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Create artwork
    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                  SET title=:title, year=:year, artist_name=:artist_name, 
                  width=:width, height=:height, warehouse_id=:warehouse_id";
        
        $stmt = $this->conn->prepare($query);

        
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->year = htmlspecialchars(strip_tags($this->year));
        $this->artist_name = htmlspecialchars(strip_tags($this->artist_name));
        $this->width = htmlspecialchars(strip_tags($this->width));
        $this->height = htmlspecialchars(strip_tags($this->height));
        $this->warehouse_id = $this->warehouse_id ? htmlspecialchars(strip_tags($this->warehouse_id)) : null;

        
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":year", $this->year);
        $stmt->bindParam(":artist_name", $this->artist_name);
        $stmt->bindParam(":width", $this->width);
        $stmt->bindParam(":height", $this->height);
        $stmt->bindParam(":warehouse_id", $this->warehouse_id);

        // Execute query
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Read one artwork
    public function readOne() {
        $query = "SELECT a.id, a.title, a.year, a.artist_name, a.width, a.height, 
                  a.warehouse_id, a.created_at, a.updated_at, w.name as warehouse_name
                  FROM " . $this->table_name . " a
                  LEFT JOIN warehouses w ON a.warehouse_id = w.id
                  WHERE a.id = ?
                  LIMIT 0,1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->title = $row['title'];
            $this->year = $row['year'];
            $this->artist_name = $row['artist_name'];
            $this->width = $row['width'];
            $this->height = $row['height'];
            $this->warehouse_id = $row['warehouse_id'];
            $this->created_at = $row['created_at'];
            $this->updated_at = $row['updated_at'];
            return true;
        }
        return false;
    }

    // Update artwork
    public function update() {
        $query = "UPDATE " . $this->table_name . "
                  SET title=:title, year=:year, artist_name=:artist_name, 
                  width=:width, height=:height, warehouse_id=:warehouse_id
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);

        
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->year = htmlspecialchars(strip_tags($this->year));
        $this->artist_name = htmlspecialchars(strip_tags($this->artist_name));
        $this->width = htmlspecialchars(strip_tags($this->width));
        $this->height = htmlspecialchars(strip_tags($this->height));
        $this->warehouse_id = $this->warehouse_id ? htmlspecialchars(strip_tags($this->warehouse_id)) : null;

        
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":year", $this->year);
        $stmt->bindParam(":artist_name", $this->artist_name);
        $stmt->bindParam(":width", $this->width);
        $stmt->bindParam(":height", $this->height);
        $stmt->bindParam(":warehouse_id", $this->warehouse_id);

        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete artwork
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Get artworks by warehouse
    public function readByWarehouse($warehouse_id) {
        $query = "SELECT a.id, a.title, a.year, a.artist_name, a.width, a.height, 
                  a.warehouse_id, a.created_at, a.updated_at
                  FROM " . $this->table_name . " a
                  WHERE a.warehouse_id = ?
                  ORDER BY a.id DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $warehouse_id);
        $stmt->execute();

        return $stmt;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : "Galerie Oselo"; ?></title>
    
    <!-- Google Fonts - Lato -->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    
    <!-- CSS stylesheets -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo isset($base_url) ? $base_url : ''; ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo isset($base_url) ? $base_url : ''; ?>/assets/css/responsive.css">
</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo isset($base_url) ? $base_url : ''; ?>/index.php">Galerie Oselo</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="<?php echo isset($base_url) ? $base_url : ''; ?>/index.php">Home</a></li>
                    <li><a href="<?php echo isset($base_url) ? $base_url : ''; ?>/views/artworks/index.php">Artworks</a></li>
                    <li><a href="<?php echo isset($base_url) ? $base_url : ''; ?>/views/warehouses/index.php">Warehouses</a></li>
                </ul>
            </div>
        </div>
    </nav>
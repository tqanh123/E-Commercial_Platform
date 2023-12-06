
<<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h3 class="mt-4">Select a Category</h3>
        <div class="list-group mt-3">
            <a href="ViewProducts.php?category=electronics" class="list-group-item list-group-item-action">Electronics</a>
            <a href="ViewProducts.php?category=clothing" class="list-group-item list-group-item-action">Clothing</a>
            <a href="ViewProducts.php?category=books" class="list-group-item list-group-item-action">Books</a>
            <a href="ViewProducts.php?category=<?php echo urlencode('home & garden'); ?>" class="list-group-item list-group-item-action">home & garden</a>
            <a href="ViewProducts.php?category=<?php echo urlencode('sports & outdoors'); ?>" class="list-group-item list-group-item-action">Sports & Outdoors</a>

    </div>
</body>
</html>


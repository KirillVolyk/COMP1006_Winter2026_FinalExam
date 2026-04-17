<?php require "includes/header.php" ?>
<main>
  <h2 class="mb-4"> Image Gallery - The One and Only</h2>
</main>
</body>
</html>

<?php 
    //get newest images first

    $sql = "SELECT id, title, description, filename, created_at
            FROM images
            ORDER BY created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="container mt-4">
    <h1 class="mb-4">Our Products</h1>

</main>

<?php require "includes/footer.php" ?>
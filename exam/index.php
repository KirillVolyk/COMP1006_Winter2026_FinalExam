<?php 
require "includes/connect.php";
require "includes/header.php"; 
?>
<main>
    <h2 class="mb-4"> Image Gallery - The One and Only</h2>
    <div class="container mt-4">
        <h1 class="mb-4">Our Products</h1>
    </div>
</main>

<?php 
    //get newest images first

    $sql = "SELECT id, name, description, image_path, created_at
            FROM images
            ORDER BY created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $images = $stmt->fetchAll();
?>

  <?php if (empty($images)): ?>
    <p>No images yet.</p>
  <?php else: ?>
    <div class="row">
      <?php foreach ($images as $image): ?>
        <div class="col-md-4 mb-4">
          <div class="card">
            <img src="<?= htmlspecialchars($image['image_path']); ?>" class="card-img-top gallery-img" alt="<?= htmlspecialchars($image['name']); ?>">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($image['name']); ?></h5>
              <p class="card-text"><?= htmlspecialchars($image['description']); ?></p>
              <small class="text-muted"><?= htmlspecialchars($image['created_at']); ?></small>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

<?php require "includes/footer.php" ?>
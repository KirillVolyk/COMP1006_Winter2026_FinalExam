<?php
// Make sure the user is logged in before they can access this page
require "includes/auth.php";

// Connect to the database
require "includes/connect.php";

// Show the admin-style header/navigation
require "includes/admin_header.php";

// Array for validation errors
$errors = [];

// Success message
$success = "";

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get and sanitize form values
    $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS));
    $description = trim(filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS));

    // This will store the image path for the database
    $imagePath = null;

    // Validate product name
    if ($name === '') {
        $errors[] = "Image name is required.";
    }

    // Validate description
    if ($description === '') {
        $errors[] = "Image description is required.";
    }

    // Handle file upload
    if (isset($_FILES['image_image']) && $_FILES['image_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = "assets/";
        $fileExtension = pathinfo($_FILES['image_image']['name'], PATHINFO_EXTENSION);
        $filename = bin2hex(random_bytes(16)) . "." . $fileExtension;
        $imagePath = $uploadDir . $filename;
        
        // Move uploaded file to assets directory
        if (!move_uploaded_file($_FILES['image_image']['tmp_name'], $imagePath)) {
            $errors[] = "Failed to upload image.";
        }
    } else {
        $errors[] = "Please select an image to upload.";
    }

    // If there are no errors, insert the product into the database
    if (empty($errors)) {
        $sql = "INSERT INTO images (name, description, image_path)
                VALUES (:name, :description, :image_path)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image_path', $imagePath);
        $stmt->execute();

        $success = "Image added successfully!";
    }
}
?>

<main class="container mt-4">
    <h1>Add Image</h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <h3>Please fix the following:</h3>
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($success !== ""): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($success); ?>
        </div>
    <?php endif; ?>
    <!--enctype="multipart/form-data" required for uploads, will not send properly if not included -->
    <form method="post" enctype="multipart/form-data" class="mt-3">
        <label for="name" class="form-label">Image Name</label>
        <input
            type="text"
            id="name"
            name="name"
            class="form-control mb-3"
            required
        >

        <label for="description" class="form-label">Description</label>
        <textarea
            id="description"
            name="description"
            class="form-control mb-3"
            rows="4"
            required
        ></textarea>

        <label for="image_image" class="form-label">Image</label>
        <input
            type="file"
            id="image_image"
            name="image_image"
            class="form-control mb-4"
            accept=".jpg,.jpeg,.png,.webp"
        >

        <button type="submit" class="btn btn-primary">Add Image</button>
    </form>
</main>

<?php require "includes/footer.php"; ?>
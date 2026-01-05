<?php
function uploadFile($file) {

    $allowedTypes = ["application/pdf", "image/jpeg", "image/png"];

    if (!in_array($file["type"], $allowedTypes)) {
        throw new Exception("Invalid file type. Only PDF, JPG, PNG allowed");
    }

    if ($file["size"] > 2 * 1024 * 1024) {
        throw new Exception("File size must be under 2MB");
    }


    $extension = pathinfo($file["name"], PATHINFO_EXTENSION);


    $newName = time() . "." . $extension;
    $destination = "uploads/" . $newName;

    if (!move_uploaded_file($file["tmp_name"], $destination)) {
        throw new Exception("Upload failed");
    }

    return "File uploaded successfully";
}

$message = "";

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $message = uploadFile($_FILES["portfolio"]);
    }
} catch (Exception $e) {
    $message = $e->getMessage();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Upload Portfolio</title>
</head>
<body>
<?php include "header.php"; ?>

<h2>Upload Portfolio File</h2>

<p><?php echo $message; ?></p>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="portfolio"><br><br>
    <button type="submit">Upload</button>
</form>

<a href="index.php">Back to Home</a>


<?php include "footer.php"; ?>
</body>
</html>
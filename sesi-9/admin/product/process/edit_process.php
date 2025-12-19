<?php
 include '../../../config/koneksi_pdo.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $category = $_POST['category'];
    
        // Data validation
        if (empty($id) || empty($name) || empty($price) || empty($description) || empty($category)) {
            die("All fields are required.");
        }
    
        // Initialize image filename variable
        $newFileName = null;
    
        // Handle file upload if a new file is provided
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['image']['tmp_name'];
            $fileName = $_FILES['image']['name'];
            $fileSize = $_FILES['image']['size'];
            $fileType = $_FILES['image']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
    
            // Sanitize file name
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
    
            // Check if the file has one of the allowed extensions
            $allowedfileExtensions = ['jpg', 'gif', 'png', 'jpeg', 'webp'];
            if (in_array($fileExtension, $allowedfileExtensions)) {
                // Directory in which the uploaded file will be moved
                $uploadFileDir = '../../../uploaded_files/';
                $dest_path = $uploadFileDir . $newFileName;
    
                if (!move_uploaded_file($fileTmpPath, $dest_path)) {
                    die("There was some error moving the file to upload directory.");
                }else{
                    // delete old image file
                    try {
                        $stmt = $pdo->prepare("SELECT image FROM products WHERE id = :id");
                        $stmt->execute(['id' => $id]);
                        $product = $stmt->fetch(PDO::FETCH_ASSOC);
                        if ($product && !empty($product['image'])) {
                            $oldImagePath = $uploadFileDir . $product['image'];
                            if (file_exists($oldImagePath)) {
                                unlink($oldImagePath);
                            }
                        }
                    } catch (PDOException $e) {
                        die("Error deleting old image: " . $e->getMessage());
                    }
                }
            } else {
                die("Upload failed. Allowed file types: " . implode(',', $allowedfileExtensions));
            }
        }
    
        // Update database record
        try {
            if ($newFileName) {
                // If a new image was uploaded, update the image field as well
                $sql = "UPDATE products SET name = :name, description = :description, price = :price, category = :category, image = :image WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':name' => $name,
                    ':description' => $description,
                    ':price' => $price,
                    ':category' => $category,
                    ':image' => $newFileName,
                    ':id' => $id
                ]);
            } else {
                // If no new image, do not update the image field
                $sql = "UPDATE products SET name = :name, description = :description, price = :price, category = :category WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':name' => $name,
                    ':description' => $description,
                    ':price' => $price,
                    ':category' => $category,
                    ':id' => $id
                ]);
            }
            // Redirect back to the product list page after processing with success message
            header("Location: ../index.php?message=Product+updated+successfully");
            exit();
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    } else {
        echo "Invalid request method.";
    }
?>
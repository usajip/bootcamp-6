<?php
    // proses.php - handle form submission from index.php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form data
        $name = $_POST['name'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $category = $_POST['category'];

        //data validation
        if(empty($name) || empty($price) || empty($description) || empty($category)) {
            die("All fields are required.");
        }

        // Handle file upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['image']['tmp_name'];
            $fileName = $_FILES['image']['name'];
            $fileSize = $_FILES['image']['size'];
            $fileType = $_FILES['image']['type'];
            // jersey.jpg ==> ['jersey', 'jpg']
            $fileNameCmps = explode(".", $fileName); // Split file name by dot
            $fileExtension = strtolower(end($fileNameCmps));

            // Sanitize file name
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

            // Check if the file has one of the allowed extensions
            $allowedfileExtensions = ['jpg', 'gif', 'png', 'jpeg', 'webp'];
            if (in_array($fileExtension, $allowedfileExtensions)) {
                // Directory in which the uploaded file will be moved
                $uploadFileDir = './uploaded_files/';
                $dest_path = $uploadFileDir . $newFileName;

                if(move_uploaded_file($fileTmpPath, $dest_path)) {
                    echo "File is successfully uploaded.<br>";
                } else {
                    echo "There was some error moving the file to upload directory.<br>";
                }
            } else {
                echo "Upload failed. Allowed file types: " . implode(',', $allowedfileExtensions) . "<br>";
            }
        } else {
            echo "No file uploaded or there was an upload error.<br>";
        }

        //php code to insert data into database

        include 'koneksi_pdo.php';
        try {
            $sql = "INSERT INTO products (name, description, price, category, image) VALUES (:name, :description, :price, :category, :image)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':description' => $description,
                ':price' => $price,
                ':category' => $category,
                ':image' => $newFileName
            ]);
            echo "Data berhasil disimpan ke database.<br>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<br>";
        }

        // Display submitted data
        echo "<h2>Submitted Data:</h2>";
        echo "Nama Produk: " . htmlspecialchars($name) . "<br>";
        echo "Harga Produk: " . htmlspecialchars($price) . "<br>";
        echo "Deskripsi Produk: " . htmlspecialchars($description) . "<br>";
        echo "Kategori Produk: " . htmlspecialchars($category) . "<br>";
        echo "Gambar Produk: <img src='uploaded_files/" . htmlspecialchars($newFileName) . "' alt='Product Image'><br>";
    } else {
        echo "Invalid request method.";
    }
?>
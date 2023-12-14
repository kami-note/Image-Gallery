<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    

    include('db.php');
    include('config.php');

    function generateUniqueFilename($fileExtension) {
        return md5(uniqid() . time()) . '.' . $fileExtension;
    }

    function processUpload() {
        global $conn;
        global $directory;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $targetDir = $directory;
            $fileTypeInDatabase = '';

            if (isset($_FILES["file"]) && is_uploaded_file($_FILES["file"]["tmp_name"])) {
                $uploadedFileExtension = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));
                $targetFile = $targetDir . generateUniqueFilename($uploadedFileExtension);
            
                $allowedImageTypes = ["image/jpg", "image/jpeg", "image/png"];
                $allowedGifType = "image/gif";

                $fileExtension = '';
            
                if ($uploadedFileExtension == 'gif'){
                        $fileExtension = 'gif';
                }else{
                    $fileExtension = 'image';
                }
            
                if ($_FILES["file"]["size"] > 2000000) {
                    echo "Sorry, your file is too big.";
                    return;
                }

                if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
                    $fileName = basename($targetFile);
                    $description = $_POST["description"];
                    $tags = $_POST["tags"];
                    $owner = isset($_SESSION['username']) ? $_SESSION['username'] : '';

                    $sql = "INSERT INTO images (filename, description, tags, type, owner) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sssss", $targetFile, $description, $tags, $fileExtension, $owner);

                    echo "Incerido " . $uploadedFileExtension;

                    if ($stmt->execute()) {
                        echo "The file " . htmlspecialchars($fileName) . " has been sent successfully.";
                        header("Location: " . $_SERVER['REQUEST_URI']);
                        exit();
                    } else {
                        echo "Error inserting data: " . $stmt->error;
                        echo "Debug info: ";
                        var_dump($stmt->error_list);
                    }

                    $stmt->close();
                } else {
                    echo "Sorry, there was an error uploading your file.";
                    echo "Debug info: ";
                    var_dump($_FILES["file"]["error"]);
                }
            } else {
                echo "Sorry, no files were uploaded.";
            }
        }
    }

    function filterPages($filter, $page, $perPage, $conn) {
        $offset = ($page - 1) * $perPage;

        // Determine sorting order based on filter
        $sorting = ($filter == 'recent') ? 'ORDER BY id DESC' : 'ORDER BY id ASC';

        // Get filter values from GET parameters
        $tag = isset($_GET['tags']) ? $_GET['tags'] : '';
        $type = isset($_GET['type']) ? $_GET['type'] : '';

        // Initialize WHERE clauses
        $tagClause = '';
        $typeClause = '';

        // Build WHERE clauses based on filter values
        if ($tag !== '') {
            $tagClause = "AND LOWER(tags) LIKE LOWER('%$tag%')";
        }

        if ($type !== '') {
            $typeClause = "AND type = '$type'";
        }

        // Build and execute the SQL query
        $selectSql = "SELECT * FROM images WHERE 1 $tagClause $typeClause $sorting LIMIT $offset, $perPage";
        $result = $conn->query($selectSql);

        return array('result' => $result, 'tagClause' => $tagClause, 'typeClause' => $typeClause);
    }

    $filter = isset($_GET['filter']) ? $_GET['filter'] : 'recent';
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

    // Call the filterPages function
    $filterPagesResult = filterPages($filter, $currentPage, $perPage, $conn);

    // Access the result, tagClause, and typeClause
    $result = $filterPagesResult['result'];
    $tagClause = $filterPagesResult['tagClause'];
    $typeClause = $filterPagesResult['typeClause'];

    $totalRecords = $conn->query("SELECT COUNT(*) as total FROM images WHERE 1 $tagClause $typeClause")->fetch_assoc()['total'];
    $totalPages = ceil($totalRecords / $perPage);

    processUpload();

?>

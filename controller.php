<?php
 // Controller.php

 error_reporting(E_ALL);
 ini_set('display_errors', 1);
 

include('db.php');
include('config.php');

function generateUniqueFilename($fileExtension) {
    return md5(uniqid() . time()) . '.' . $fileExtension;
}

function processUpload() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $targetDir = 'public/images/uploads/';
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
                echo "Desculpe, seu arquivo é muito grande.";
                return;
            }

            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
                $fileName = basename($targetFile);
                $description = $_POST["description"];
                $tags = $_POST["tags"];

                $sql = "INSERT INTO images (filename, description, tags, type) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss", $targetFile, $description, $tags, $fileExtension);

                echo "Incerido " . $uploadedFileExtension;

                if ($stmt->execute()) {
                    echo "O arquivo " . htmlspecialchars($fileName) . " foi enviado com sucesso.";
                    header("Location: " . $_SERVER['REQUEST_URI']);
                    exit();
                } else {
                    echo "Erro ao inserir dados: " . $stmt->error;
                    echo "Debug info: ";
                    var_dump($stmt->error_list);
                }

                $stmt->close();
            } else {
                echo "Desculpe, houve um erro ao enviar o seu arquivo.";
                echo "Debug info: ";
                var_dump($_FILES["file"]["error"]);
            }
        } else {
            echo "Desculpe, nenhum arquivo foi enviado.";
        }
    }
}

processUpload();

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'recent';
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($currentPage - 1) * $perPage;

$sorting = ($filter == 'recent') ? 'ORDER BY id DESC' : 'ORDER BY id ASC';

$tag = isset($_GET['tags']) ? $_GET['tags'] : '';
$tagClause = ($tag !== '') ? "AND LOWER(tags) LIKE LOWER('%$tag%')" : '';

$type = isset($_GET['type']) ? $_GET['type'] : '';
$typeClause = ($type !== '') ? "AND type = '$type'" : '';

$selectSql = "SELECT * FROM images WHERE 1 $tagClause $typeClause $sorting LIMIT $offset, $perPage";
$result = $conn->query($selectSql);

$totalRecords = $conn->query("SELECT COUNT(*) as total FROM images WHERE 1 $tagClause $typeClause")->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $perPage);
?>

<?php
    include 'db.php';

    if(isset($_GET['imageid'])) {
        $imageID = $_GET['imageid'];
        
        $imageID = intval($imageID);
    
        $checkIDSql = "SELECT COUNT(*) as count FROM `images` WHERE `id` = $imageID";
        $checkIDResult = mysqli_query($conn, $checkIDSql);
    
        if (!$checkIDResult) {
            die("ID verification error:" . mysqli_error($conn));
        }
    
        $countRow = mysqli_fetch_assoc($checkIDResult);
        $idCount = $countRow['count'];
    
        if ($idCount == 0) {
            die("ID not found in database.");
        }
    } else {
        header("Location: index.php");
        exit();
    }

    $sql = "SELECT `fileName`, `description`, `tags` FROM `images` WHERE `id` = $imageID";

    $result = mysqli_query($conn, $sql);
    
    if (!$result) {
        die("Query error:" . mysqli_error($conn));
    }
    
    $row = mysqli_fetch_assoc($result);
    $fileName = $row['fileName'];
    $description = $row['description'];
    $tags = $row['tags'];
    
    mysqli_free_result($result);
    
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image</title>
    <link rel="stylesheet" href="styles\styles.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div>
        <?php
        echo "<img src=\"$fileName\" alt=\"Imagem\">";
        echo "<h1>$description</h1>";
        echo "<div class='center relative inline-block select-none whitespace-nowrap rounded-lg bg-red-500 py-2 px-3.5 align-baseline font-sans text-xs font-bold uppercase leading-none text-white'>
        <div class='mt-px'>$tags</div></div>"
        ?>
    </div>
</body>
</html>
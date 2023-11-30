<?php
    include 'controller.php';
    include 'config.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="scripts/alpinejs.js" defer></script>
    <script src="scripts/masonry.pkgd.min.js"></script>
    <script src="scripts/init.js"></script>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <header class="flex backdrop-blur-3xl bg-white/30 sm:px-60 px-5 border-b sm:pt-4 pt-4 pb-4 sticky top-0 z-30">
        <div class="border border-gray-300 rounded-lg overflow-hidden">
            <form class="relative mx-auto text-gray-600 flex" method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="flex items-center">
                    <input class="border-0 bg-white h-10 px-5 pr-16 text-sm focus:outline-none" type="text" name="tags" id="tags" placeholder="Search by Tag" value="<?php echo isset($_GET['tags']) ? $_GET['tags'] : ''; ?>">
                    
                    <select class="border-0 bg-white h-10 px-5 pr-4 text-sm focus:outline-none" name="type" id="type">
                        <option value="image" <?php echo (isset($_GET['type']) && $_GET['type'] == 'image') ? 'selected' : ''; ?>>Image</option>
                        <option value="gif" <?php echo (isset($_GET['type']) && $_GET['type'] == 'gif') ? 'selected' : ''; ?>>GIF</option>
                    </select>
                </div>
                
                <button class="border-0 bg-white h-10 px-5 pr-4 text-sm focus:outline-none" type="submit" value="Filter">
                    <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px" height="512px">
                        <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.920,2.162,0.920  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.080,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                    </svg>
                </button>
            </form>
        </div>
    </header>
    <div class="mx-auto p-4">
        <h1 class="text-2xl font-semibold mb-4">Image Gallery</h1>
        <div x-data="{ isOpen: false }">
            <button @click="isOpen = true" class="bg-blue-500 text-white p-2 rounded-md hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue active:bg-blue-800">
                Add New Image
            </button>
            <div x-show="isOpen" @click="isOpen = false" class="fixed inset-0 bg-black opacity-50 z-50"></div>
            <div x-show="isOpen" class="fixed inset-0 flex items-center justify-center z-50">
                <div class="bg-white p-6 rounded-md shadow-md max-w-md relative">
                    <h2 class="text-2xl font-semibold mb-4">Add New Image:</h2>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" id="uploadForm">
                        <div class="mb-4">
                            <label for="file" class="block text-gray-700 text-sm font-bold mb-2">Image:</label>
                            <input type="file" name="file" id="file" accept="image/*" required class="border border-gray-300 p-2 w-full rounded-md focus:outline-none focus:border-blue-500">
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                            <textarea name="description" id="description" class="border border-gray-300 p-2 w-full rounded-md resize-none focus:outline-none focus:border-blue-500"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="tags" class="block text-gray-700 text-sm font-bold mb-2">Tag:</label>
                            <input type="text" name="tags" id="tags" required class="border border-gray-300 p-2 w-full rounded-md focus:outline-none focus:border-blue-500">
                        </div>

                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="bg-blue-500 text-white p-2 rounded-md hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue" x-on:click="submitForm">Add Image</button>
                            <button type="button" @click="isOpen = false" class="ml-2 text-gray-500 hover:text-gray-700 focus:outline-none">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="filter">Filter by:</label>
                <select name="filter" id="filter" onchange="this.form.submit()">
                    <option value="recent" <?php echo ($filter == 'recent') ? 'selected' : ''; ?>>Most Recent</option>
                    <option value="old" <?php echo ($filter == 'old') ? 'selected' : ''; ?>>Oldest</option>
                </select>
            </form>
        </div>
        <div id="image-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="image-item">';
                    echo '<a href="image.php?imageid=' . $row['id'] . '">';
                    echo '<img src="' . $row['filename'] . '" alt="Image">';
                    echo '</a>';
                    echo '</div>';
                }
            } else {
                echo "No records found.";
            }
            ?>
        </div>
        <div class="pagination mt-4">
            <?php
            for ($i = 1; $i <= $totalPages; $i++) {
                echo '<a href="?page=' . $i . '&filter=' . $filter . '" ' . ($currentPage == $i ? 'class="active"' : '') . '>' . $i . '</a>';
            }
            ?>
        </div>
    </div>
    <script src="scripts/terminate.js"></script>
</body>
</html>

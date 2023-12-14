<?php
session_start();
include('db.php');

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clientName = $_POST["user"];
    $clientPassword = $_POST["password"] = hash('sha256', $_POST["password"]);
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection error: " . $conn->connect_error);
    }

    // Use prepared statements to prevent SQL injection
    $query = "SELECT * FROM user WHERE `name` = ? AND `password` = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $clientName, $clientPassword);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $clientName;
        header("location: index.php");
        exit();
    } else {
        $error_message = "Invalid credentials. Please try again.";
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <section class="container mx-auto flex h-screen items-center justify-center">
        <div class="w-11/12 md:w-2/3 lg:w-1/2 xl:w-1/3 bg-neutral-light p-4 md:p-8 rounded-lg shadow-lg">
            <h2 class="text-neutral-dark text-center text-lg md:text-xl font-semibold mb-4">Sign in with credentials</h2>
            <form method="post">
                <div class="mb-3 md:mb-4">
                    <label for="user" class="block text-neutral-dark text-sm font-semibold mb-1 md:mb-2">User</label>
                    <input type="text" name="user" id="user" required class="w-full px-3 py-2 placeholder-neutral-light text-neutral-dark bg-white rounded focus:outline-none focus:shadow-outline" placeholder="User">
                </div>
                <div class="mb-3 md:mb-4">
                    <label for="password" class="block text-neutral-dark text-sm font-semibold mb-1 md:mb-2">Password</label>
                    <input type="password" name="password" id="password" required class="w-full px-3 py-2 placeholder-neutral-light text-neutral-dark bg-white rounded focus:outline-none focus:shadow-outline" placeholder="Password">
                </div>
                <div class="text-center">
                    <button class="bg-neutral-darker text-neutral-dark active:bg-neutral-dark text-sm font-semibold uppercase px-4 md:px-6 py-2 md:py-3 rounded shadow hover:shadow-lg focus:outline-none focus:shadow-outline w-full" type="submit">Sign In</button>
                </div>
            </form>
            <p class="text-error text-center mt-3 md:mt-4"><?php echo $error_message; ?></p>
            <div class="flex flex-wrap mt-4 md:mt-6">
                <div class="w-full md:w-1/2 text-center md:text-left mb-2 md:mb-0">
                    <a href="#" class="text-neutral-medium text-sm">Forgot password?</a>
                </div>
                <div class="w-full md:w-1/2 text-center md:text-right">
                    <a href="#" class="text-neutral-medium text-sm">Create new account</a>
                </div>
            </div>
        </div>
    </section>
</body>
</html>

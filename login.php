<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clientName = $_POST["user"];
    $clientPassword = $_POST["password"];

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
        echo "Invalid credentials. Please try again.";
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
    <section class="absolute w-full h-full top-0">
        <div class="absolute top-0 w-full h-full bg-orange-200" style="background-image: url('https://demos.creative-tim.com/tailwindcss-starter-project/static/media/register_bg_2.2fee0b50.png'); background-size: 100%; background-repeat: no-repeat;"></div>
        <div class="container mx-auto px-4 h-full">
            <div class="flex content-center items-center justify-center h-full">
                <div class="w-full lg:w-4/12 px-4 pt-32">
                    <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-gray-300 border-0">
                        <div class="flex-auto px-4 mt-5 lg:px-10 py-10 pt-0">
                            <div class="text-gray-500 text-center mb-3 font-bold"><small>Sign in with credentials</small></div>
                            <form method="post">
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-gray-700 text-xs font-bold mb-2" for="grid-user">User</label>
                                    <input type="text" name="user" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full" placeholder="User" style="transition: all 0.15s ease 0s;">
                                </div>
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-gray-700 text-xs font-bold mb-2" for="grid-password">Password</label>
                                    <input type="password" name="password" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full" placeholder="Password" style="transition: all 0.15s ease 0s;">
                                </div>
                                <div class="text-center mt-6">
                                    <button class="bg-gray-900 text-white active:bg-gray-700 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 w-full" type="submit" style="transition: all 0.15s ease 0s;">Sign In</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="flex flex-wrap mt-6">
                        <div class="w-1/2"><a href="#" class="text-gray-300"><small>Forgot password?</small></a></div>
                        <div class="w-1/2 text-right"><a href="#" class="text-gray-300"><small>Create new account</small></a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>

<?php 
include 'miumiuconn.php';

// Get user input
$username = isset($_POST['aduser']) ? $_POST['aduser'] : "";
$password = isset($_POST['adpass']) ? $_POST['adpass'] : "";

// Check if both username and password are provided
if (!empty($username) && !empty($password)) {
    $stmt = $conn->prepare("SELECT aduser, adpass FROM `registration admin` WHERE aduser = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Check if the user is found
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($fetchedUsername, $hashedPassword);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashedPassword)) {
            session_start();

            // Set session variables
            $_SESSION['aduser'] = $fetchedUsername;
            $_SESSION['authenticateAdmin'] = true;

            echo "<script>alert('Successfully Login!'); window.location.href = 'http://localhost/miumiu/menu%20admin/page.php';</script>";
            exit();
        } else {
            // Invalid password
            echo "<script>alert('Invalid username or password. Please try again.'); window.location.href = 'http://localhost/miumiu/Admin/sign%20in%20admin/sign%20In%20Admin.php';</script>";
            exit();
        }
    } else {
        // Invalid username
        echo "<script>alert('Invalid username or password. Please try again.'); window.location.href = 'http://localhost/miumiu/Admin/sign%20in%20admin/sign%20In%20Admin.php';</script>";
        exit();
    }
}
?>
<?php
include "miumiuconn.php";

// Fixed admin code
$fixedCode = '010203';

// Check if "adcode" key is set in the $_POST array
if (isset($_POST["adcode"])) {
    $userInputCode = $_POST["adcode"];

    // Check fixed code
    if ($userInputCode !== $fixedCode) {
        echo "<script>alert('Admin code does not match. Please enter the correct code.'); window.location.href = 'http://localhost/miumiu/Admin/Registration%20Admin/RegistrationAdmin.html';</script>";
        exit();
    } else {
        // Rest of your code for processing the form
        $name = $_POST["name"];
        $username = $_POST["aduser"];
        $staff_ID = $_POST["staff_ID"];
        $email = $_POST["ademail"];
        $adnum = $_POST["adphoneno"];
        $password = $_POST["adpass"];
        $confirmpassword = $_POST["adconfirmpass"];

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $hashPassword = password_hash($confirmpassword, PASSWORD_DEFAULT);

        // Use prepared statement to prevent SQL injection
        $insertQuery = "INSERT INTO `registration admin` (name, aduser, staff_ID, ademail, adphoneno, adpass, adconfirmpass, adcode) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("ssssssss", $name, $username, $staff_ID, $email, $adnum, $hashedPassword, $hashPassword, $fixedCode);

        if ($insertStmt->execute()) {
            echo "<script>alert('New Admin record created successfully'); window.location.href = 'http://localhost/miumiu/Admin/sign%20in%20admin/sign%20In%20Admin.php';</script>";
            exit();
        } else {
            error_log("Error: " . $insertStmt->error);
            echo "<script>alert('Error creating admin record. Please try again later.'); window.location.href = 'http://localhost/miumiu/Admin/Registration%20Admin/RegistrationAdmin.html';</script>";
            exit();
        }
    }
} else {
    // Handle the case when "adcode" is not set in the form submission
    echo "<script>alert('Admin code is required.'); window.location.href = 'http://localhost/miumiu/Admin/Registration%20Admin/RegistrationAdmin.html';</script>";
    exit();
}
?>

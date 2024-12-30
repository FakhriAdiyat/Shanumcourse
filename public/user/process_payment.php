<?php
// process_payment.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize inputs
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $province = $_POST['province'];
    $dana_phone = $_POST['dana_phone'];
    $dana_account_number = $_POST['dana_account_number']; // Get Dana account number

    // Handle file upload
    $payment_proof = $_FILES['payment_proof'];
    $upload_dir = 'uploads/'; // Set your upload directory
    $filename = basename($payment_proof['name']);
    $upload_file = $upload_dir . $filename;
    
    // Validate file type (allowing images and PDF only)
    $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];
    if (in_array($payment_proof['type'], $allowed_types)) {
        if (move_uploaded_file($payment_proof['tmp_name'], $upload_file)) {
            // File uploaded successfully, now save the data in the database
            $conn = new mysqli('localhost', 'root', '', 'db_connection'); // Database connection
            
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepare and bind the SQL query
            $stmt = $conn->prepare("INSERT INTO payments (email, province, dana_phone, dana_account_number, payment_proof) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $email, $province, $dana_phone, $dana_account_number, $upload_file);

            // Execute the statement
            if ($stmt->execute()) {
                echo "Payment processed successfully!";
            } else {
                echo "Error: " . $stmt->error;
            }
            
            // Close the connection
            $stmt->close();
            $conn->close();
        } else {
            echo "Failed to upload payment proof. Please try again.";
        }
    } else {
        echo "Invalid file type. Only JPG, PNG, and PDF files are allowed.";
    }
}
?>

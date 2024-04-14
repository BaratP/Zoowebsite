<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $file_path = "../storage/users.txt";
    if (!file_exists($file_path)) {
        die("User data file not found."); // Handle file not found error
    }

    $file = fopen($file_path, "r");
    if ($file === false) {
        die("Error opening user data file."); // Handle file open error
    }

    $valid = false;
    while (($line = fgets($file)) !== false) {
        list($storedUser, $storedHash) = explode(',', trim($line));
        if ($username == $storedUser && password_verify($password, $storedHash)) {
            $valid = true;
            break;
        }
    }

    fclose($file);

    if ($valid) {
        header("Location: index.php"); // Redirect to a logged-in page
        exit();
    } else {
        echo "<p style='color: red; text-align: center;'>Érvénytelen felhasználónév vagy jelszó</p>";
    }
}
?>

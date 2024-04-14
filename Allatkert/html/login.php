<?php
$error_message = ""; // Hibaüzenet inicializálása

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $file_path = "users.txt";
    if (!file_exists($file_path)) {
        $error_message = "User data file not found."; // Hibaüzenet beállítása
    }

    $file = fopen($file_path, "r");
    if ($file === false) {
        $error_message = "Error opening user data file."; // Hibaüzenet beállítása
    }

    $valid = false;
    while (($line = fgets($file)) !== false) {
        list($storedUser, $storedEmail, $storedHash) = explode('|', trim($line));
        if ($username == $storedUser && password_verify($password, $storedHash)) {
            $valid = true;
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $storedUser;
            break;
        }
    }

    fclose($file);

    if ($valid) {
        header("Location: ../index.php");
        exit();
    } else {
        $error_message = "Érvénytelen felhasználónév vagy jelszó"; // Hibaüzenet beállítása
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../css/kozos.css">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
<nav class="nav">
    <ul>
        <li><img src="../media/jegyarak.png" alt="jegy"><a href="../index.php">Főoldal</a></li>
        <li><img src="../media/jegyarak.png" alt="jegy"><a href="jegyek.php">Jegyek</a></li>
        <li><img src="../media/jegyarak.png" alt="jegy"><a href="szolgaltatas.php">Szolgáltatások</a></li>
        <li><img src="../media/jegyarak.png" alt="jegy"><a href="lakok/lakok.php">Lakóink</a></li>
        <?php
        session_start();
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            echo '<li><img src="../media/jegyarak.png" alt="jegy"><a href="profil.php">Profil</a></li>';
            echo '<li><img src="../media/jegyarak.png" alt="jegy"><a href="logout.php">Kijelentkezés</a></li>';
        } else {
            echo '<li><img src="../media/jegyarak.png" alt="jegy"><a href="login.php">Bejelentkezés</a></li>';
            echo '<li><img src="../media/jegyarak.png" alt="jegy"><a href="register.php">Regisztráció</a></li>';
        }
        ?>
    </ul>
</nav>

<div><img src="../media/bejelentkezes.jpeg" alt="ez baj" id="hatter"></div>

<div class="flex">
    <form method="POST" action="login.php">
        <div class="bejelentkezes">
            <span style="color: red;"><?php echo $error_message; ?></span> <!-- Hibaüzenet megjelenítése -->
            <label><b>Felhasználó név</b></label>
            <input type="text" name="username" placeholder="Felhasználó név" required>
            <label><b>Jelszó</b></label>
            <input type="password" name="password" placeholder="Jelszó" required>
            <br><br>
            <div class="gombok">
                <input type="submit" value="Bejelentkezés">
                <button type="button" onclick="window.location.href='register.php';">Regisztráció</button>
            </div>
            <br><br>
        </div>
    </form>
</div>

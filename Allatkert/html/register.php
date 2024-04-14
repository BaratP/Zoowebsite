<?php
// Hiba változók inicializálása
$username_err = $firstname_err = $lastname_err = $email_err = $password_err = $confirm_password_err = $phone_err = $terms_err = "";

// Adatok feldolgozása, amikor a form elküldésre kerül
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Adatbázis-szerű fájl betöltése
    $data_file = 'users.txt';
    $current_data = file_exists($data_file) ? file_get_contents($data_file) : '';
    $users = $current_data ? explode("\n", $current_data) : [];

    $usernames = $emails = [];
    foreach ($users as $user) {
        list($stored_username, $stored_email) = explode('|', $user);
        $usernames[] = $stored_username;
        $emails[] = $stored_email;
    }

    // Felhasználónév ellenőrzése
    if (empty(trim($_POST['username']))) {
        $username_err = "A felhasználónév megadása kötelező!";
    } elseif (in_array($_POST['username'], $usernames)) {
        $username_err = "Ez a felhasználónév már foglalt.";
    }

    // Email ellenőrzése
    if (empty(trim($_POST['email']))) {
        $email_err = "Az email cím megadása kötelező!";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $email_err = "Érvénytelen email cím.";
    } elseif (in_array($_POST['email'], $emails)) {
        $email_err = "Ez az email cím már foglalt.";
    }

    // Jelszó és jelszó megerősítése ellenőrzése
    if (empty(trim($_POST['password']))) {
        $password_err = "Jelszó megadása kötelező!";
    } elseif (strlen(trim($_POST['password'])) < 6) {
        $password_err = "A jelszónak legalább 6 karakter hosszúnak kell lennie.";
    }

    if (empty(trim($_POST['confirm_password']))) {
        $confirm_password_err = "Jelszó megerősítése kötelező!";
    } elseif (trim($_POST['password']) !== trim($_POST['confirm_password'])) {
        $confirm_password_err = "A jelszavak nem egyeznek.";
    }
    if (empty(trim($_POST['phone']))) {
        $confirm_password_err = "Telefonszám megadása kötelező!";
    } elseif (strlen($_POST['phone']) < 9 || strlen($_POST['phone']) > 15) {
        $phone_err = "Érvénytelen telefonszám!";
    }
    if (!$_POST['terms']) {
        $terms_err = "El kell fogadni a felhasználói feltételeket!";
    }

    if (empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($phone_err) && empty($terms_err)) {
        // Jelszó hash-elése
        $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $new_user = $_POST['username'] . '|' . $_POST['email'] . '|' . $hashed_password . '|' . $_POST['firstname'] . '|' . $_POST['lastname'] . "\n";

        // Új felhasználó hozzáadása, ha elfogadta a feltételeket
        if ($_POST['terms']) {
            file_put_contents($data_file, $new_user, FILE_APPEND);
            echo "Sikeres regisztráció!";
        } else {
            echo "El kell fogadni a felhasználói feltételeket!";
        }

        // Redirect to login page
        header("Location: login.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Allatkert</title>
    <link rel="stylesheet" href="../css/register.css">
    <link rel="stylesheet" href="../css/kozos.css">
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
<div class="flex">
    <form method="POST" action="register.php">
        <div class="bejelentkezes">
            <label><b>Felhasználó név</b></label>
            <input type="text" name="username" placeholder="Felhasználó név" required>
            <span class="error"><?= isset($username_err) ? $username_err : "" ?></span>

            <label><b>Keresztnév</b></label>
            <input type="text" name="firstname" placeholder="Keresztnév" required>
            <span class="error"><?= isset($firstname_err) ? $firstname_err : "" ?></span>

            <label><b>Vezetéknév</b></label>
            <input type="text" name="lastname" placeholder="Vezetéknév" required>
            <span class="error"><?= isset($lastname_err) ? $lastname_err : "" ?></span>

            <label><b>Email Cím</b></label>
            <input type="email" name="email" placeholder="valaki@gmail.com" required>
            <span class="error"><?= isset($email_err) ? $email_err : "" ?></span>

            <label><b>Jelszó</b></label>
            <input type="password" name="password" placeholder="Jelszó" required>
            <span class="error"><?= isset($password_err) ? $password_err : "" ?></span>

            <label><b>Jelszó megerősítése</b></label>
            <input type="password" name="confirm_password" placeholder="Jelszó" required>
            <span class="error"><?= isset($confirm_password_err) ? $confirm_password_err : "" ?></span>

            <label><b>Telefonszám</b></label>
            <input type="tel" name="phone" placeholder="06309999999" required>
            <span class="error"><?= isset($phone_err) ? $phone_err : "" ?></span>

            <label><b>Felhasználói feltételek elfogadása</b></label>
            <input type="checkbox" name="terms" required>
            <span class="error"><?= isset($terms_err) ? $terms_err : "" ?></span>

            <label><b>Mennyire tetszik az oldal?</b></label>
            <input type="range" name="satisfaction" value="100">

            <br><br>
            <div class="gombok" style="margin-bottom: 20px">
                <button type="submit">Regisztrálás</button>
                <button type="reset">Visszaállítás</button>
            </div>
        </div>
    </form>
</div>
</body>
</html>

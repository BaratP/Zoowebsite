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
    if (empty(trim($_POST['confirm_password']))) {
        $confirm_password_err = "Jelszó megerősítése kötelező!";
    } elseif (trim($_POST['password']) !== trim($_POST['confirm_password'])) {
        $confirm_password_err = "A jelszavak nem egyeznek.";
    }
    if (empty(trim($_POST['phone']))) {
        $confirm_password_err = "Telefonszám megadása kötelező!";
    } elseif (!preg_match('/^\+?\d{9,15}$/', $_POST['terms'])) {
        $phone_err = "Érvénytelen telefonszám!";
    }
    if (!$_POST['terms']) {
        $terms_err = "El kell fogadni a felhasználói feltételeket!";
    }

    if (empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($phone_err) && empty($terms_err)) {
        // Jelszó hash-elése
        $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $new_user = $_POST['username'] . '|' . $_POST['email'] . '|' . $hashed_password . "\n";

        // Új felhasználó hozzáadása
        file_put_contents($data_file, $new_user, FILE_APPEND);
        echo "Sikeres regisztráció!";

        // Redirect to login page
        header("Location: login.html");
        exit();
    }
}
?>

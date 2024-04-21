<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php");
    exit();
}

// Fájl beolvasása és felhasználó adatainak kinyerése
$data_file = 'users.txt';
$current_data = file_exists($data_file) ? file_get_contents($data_file) : '';
$users = $current_data ? explode("\n", $current_data) : [];

// Felhasználó adatok keresése és törlése a users.txt-ből
foreach ($users as $key => $user) {
    list($stored_username, $stored_email, $stored_password, $stored_firstname, $stored_lastname) = explode('|', $user);
    if ($stored_username === $_SESSION['username']) {
        unset($users[$key]); // Törlés a tömbből
        $new_data = implode("\n", $users); // Új adatok összefűzése
        file_put_contents($data_file, $new_data); // Új adatok mentése a fájlba
        break;
    }
}

// Felhasználó kijelentkeztetése
$_SESSION = array(); // Session törlése
session_destroy(); // Session megsemmisítése

// Átirányítás az index.php-re
header("Location: ../index.php");
exit();
?>

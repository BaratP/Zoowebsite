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

// Felhasználó adatok keresése
foreach ($users as $user) {
    list($stored_username, $stored_email, $stored_password, $stored_firstname, $stored_lastname) = explode('|', $user);
    echo $_SESSION['username'];
    if ($stored_username === $_SESSION['username']) {
        $profile_username = $stored_username;
        $profile_firstname = $stored_firstname;
        $profile_lastname = $stored_lastname;
        $profile_email = $stored_email;
        break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Allatkert</title>
    <link rel="stylesheet" href="../css/profil.css">
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
<main>
    <section class="container">
        <form action="delete.php" method="POST">
            <img src="../media/OIG3%20(1).jpg" alt="Profilkép" class="avatar">
            <div class="profile-info">
                <label for="username">Felhasználónév:</label>
                <input type="text" id="username" value="<?php echo $stored_username; ?>" disabled>

                <label for="firstname">Keresztnév:</label>
                <input type="text" id="firstname" value="<?php echo $profile_firstname; ?>" disabled>

                <label for="lastname">Vezetéknév:</label>
                <input type="text" id="lastname" value="<?php echo $profile_lastname; ?>" disabled>

                <label for="email">Email:</label>
                <input type="email" id="email" value="<?php echo $profile_email; ?>" disabled>

                <input class="save-btn" value="Változások mentése">
                <input type="submit" class="save-btn" value="Profil törlése">
            </div>
        </form>
    </section>
    <section class="container">
        <h1>Eddig vásárolt jegyek</h1>
        <table>
            <tr>
                <th>Jegy Típusa</th>
                <th>Ár</th>
                <th>Mennyiség</th>
            </tr>
            <tr>
                <td>Teljseárújegy</td>
                <td>15000 Ft</td>
                <td>2</td>
            </tr>
            <tr>
                <td>Diákjegy</td>
                <td>5000 Ft</td>
                <td>4</td>
            </tr>
            <tr>
                <td>CsoportosJegy</td>
                <td>4500 Ft</td>
                <td>3</td>
            </tr>
        </table>
    </section>
</main>
</body>
</html>
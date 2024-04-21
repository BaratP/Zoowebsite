<?php
session_start();

function addToCart($jegyTipus, $ar) {
    $_SESSION['kosar'][] = array('tipus' => $jegyTipus, 'ar' => $ar, 'mennyiseg' => 1);
}

function deleteFromCart($index) {
    unset($_SESSION['kosar'][$index]);
}

function modifyPrice($index, $newPrice) {
    if (isset($_SESSION['kosar'][$index])) {
        $_SESSION['kosar'][$index]['ar'] = $newPrice;
    }
}

if (isset($_POST['submit'])) {
    addToCart($_POST['jegyTipus'], $_POST['ar']);
}

if (isset($_POST['delete']) && isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && $_SESSION['username'] === "ADMIN") {
    $index = $_POST['delete'];
    deleteFromCart($index);
}

if (isset($_POST['modify']) && isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && $_SESSION['username'] === "ADMIN") {
    $index = $_POST['modify'];
    $newPrice = $_POST['newPrice'];
    modifyPrice($index, $newPrice);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Allatkert</title>
    <link rel="stylesheet" href="../css/jegyek.css">
    <link rel="stylesheet" href="../css/kozos.css">
</head>
<body>
<nav class="nav">
    <ul>
        <li><img src="../media/jegyarak.png" alt="jegy"><a href="../index.php">Főoldal</a></li>
        <li><img src="../media/jegyarak.png" alt="jegy"><a href="jegyek.php" style="text-decoration: underline">Jegyek</a></li>
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
<br><br>
<div id="cim"><div><h1>Jegyárak</h1></div></div>
<br><br><br>
<div class="szoveg" id="kiemel">Felhívjuk kedves látogatóink figyelmét, hogy a belépőjegy egyszeri belépésre jogosít!</div>
<div class="szoveg">Érvényes 2024. január 1-től</div>
<hr>
<br><br>

<table class="jegyarak">
    <tr>
        <th>Egyéni</th>
        <th>Ár</th>
        <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            if ($_SESSION['username'] === "ADMIN") { ?>
                <th>Módosítás</th>
                <th>Törlés</th>
            <?php } else { ?>
                <th>Kosár</th>
            <?php }
        } ?>
    </tr>
    <?php
    // Jegyek típusainak és árainak listája
    $jegyek = array(
        array('tipus' => 'Felnőtt', 'ar' => 2500),
        array('tipus' => 'Gyermek (3 - 18 év)', 'ar' => 1800),
        array('tipus' => 'Gyermek (3 éves kor alatt)', 'ar' => 200),
        array('tipus' => 'Nyugdíjas', 'ar' => 1800),
        array('tipus' => 'Diák nappai tagozat (18 - 25 év)', 'ar' => 2000),
        array('tipus' => 'Kedvezményes jegy fogyatékkal élők, szociális otthonok lakói részére, +1 fő kísérő jegye is', 'ar' => 500)
    );

    // Jegyek sorainak generálása
    foreach ($jegyek as $index => $jegy) {
        echo '<tr>';
        echo '<td>' . $jegy['tipus'] . ':</td>';
        echo '<td>' . $jegy['ar'] . ' Ft</td>';
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            if ($_SESSION['username'] === "ADMIN") {
                echo '<td>';
                echo '<form method="post">';
                echo '<input type="hidden" name="modify" value="' . $index . '">';
                echo '<input type="number" name="newPrice" placeholder="Új ár" required>';
                echo '<button type="submit">Módosítás</button>';
                echo '</form>';
                echo '</td>';
                echo '<td>';
                echo '<form method="post">';
                echo '<input type="hidden" name="delete" value="' . $index . '">';
                echo '<button type="submit">Törlés</button>';
                echo '</form>';
                echo '</td>';
            } else {
                echo '<td>';
                echo '<form method="post">';
                echo '<input type="hidden" name="jegyTipus" value="' . $jegy['tipus'] . '">';
                echo '<input type="hidden" name="ar" value="' . $jegy['ar'] . '">';
                echo '<button type="submit" name="submit">Kosárba</button>';
                echo '</form>';
                echo '</td>';
            }
        }
        echo '</tr>';
    }
    ?>
</table>
<br>
<hr>
<br>
<table class="jegyarak2">
    <tr>
        <th>Csoportos</th>
        <th>Ár</th>
        <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            if ($_SESSION['username'] === "ADMIN") { ?>
                <th>Módosítás</th>
                <th>Törlés</th>
            <?php } else { ?>
                <th>Kosár</th>
            <?php }
        } ?>
    </tr>
    <?php
    // Csoportos jegyek típusainak és árainak listája
    $csoportos_jegyek = array(
        array('tipus' => 'Családi jegy (2 szülő + 2 gyermek)', 'ar' => 7000),
        array('tipus' => 'Családi jegy (2 szülő + 1 gyermek, 1 szülő + 2 gyermek)', 'ar' => 5000),
        array('tipus' => 'Családi jegy (1 szülő + 3 gyermek)', 'ar' => 7000),
        array('tipus' => 'Családi jegy (2 nagyszülő + 2 gyermek)', 'ar' => 5000),
        array('tipus' => 'Csoportos felnőtt kedvezményes jegy (10 fő felett)', 'ar' => 2000),
        array('tipus' => 'Csoportos nyugdíjas kedvezményes jegy (10 fő felett)', 'ar' => 1400)
    );

    // Csoportos jegyek sorainak generálása
    foreach ($csoportos_jegyek as $index => $csoportos_jegy) {
        echo '<tr>';
        echo '<td>' . $csoportos_jegy['tipus'] . ':</td>';
        echo '<td>' . $csoportos_jegy['ar'] . ' Ft</td>';
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            if ($_SESSION['username'] === "ADMIN") {
                echo '<td>';
                echo '<form method="post">';
                echo '<input type="hidden" name="modify" value="' . $index . '">';
                echo '<input type="number" name="newPrice" placeholder="Új ár" required>';
                echo '<button type="submit">Módosítás</button>';
                echo '</form>';
                echo '</td>';
                echo '<td>';
                echo '<form method="post">';
                echo '<input type="hidden" name="delete" value="' . $index . '">';
                echo '<button type="submit">Törlés</button>';
                echo '</form>';
                echo '</td>';
            } else {
                echo '<td>';
                echo '<form method="post">';
                echo '<input type="hidden" name="jegyTipus" value="' . $csoportos_jegy['tipus'] . '">';
                echo '<input type="hidden" name="ar" value="' . $csoportos_jegy['ar'] . '">';
                echo '<button type="submit" name="submit">Kosárba</button>';
                echo '</form>';
                echo '</td>';
            }
        }
        echo '</tr>';
    }
    ?>
</table>
<?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    if ($_SESSION['username'] === "ADMIN") { ?>
        <form method="post">
            <label for="newTicketType">Új jegy típusa:</label>
            <input type="text" id="newTicketType" name="newTicketType" required><br><br>
            <label for="newTicketPrice">Új jegy ára:</label>
            <input type="text" id="newTicketPrice" name="newTicketPrice" required><br><br>
            <button type="submit" name="addTicket">Új jegy hozzáadása</button>
        </form>
    <?php }
} ?>
<a href="kosar.php" id="cim"><h1>Kosarad</h1></a>
<br><br><br>
</body>
</html>

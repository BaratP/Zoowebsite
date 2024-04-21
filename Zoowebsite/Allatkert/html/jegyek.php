<<?php
session_start();

// Initialize 'jegyek' in the session if not already set
function loadTickets() {
    $filename = 'tickets.txt';
    if (file_exists($filename)) {
        $json = file_get_contents($filename);
        return json_decode($json, true);
    } else {
        return array(
            array('tipus' => 'Felnőtt', 'ar' => 2500),
            array('tipus' => 'Gyermek (3 - 18 év)', 'ar' => 1800),
            array('tipus' => 'Felnőtt', 'ar' => 2500),
            array('tipus' => 'Gyermek (3 - 18 év)', 'ar' => 1800),
            array('tipus' => 'Gyermek (3 éves kor alatt)', 'ar' => 200),
            array('tipus' => 'Nyugdíjas', 'ar' => 1800),
            array('tipus' => 'Diák nappai tagozat (18 - 25 év)', 'ar' => 2000),
            array('tipus' => 'Kedvezményes jegy fogyatékkal élők, szociális otthonok lakói részére, +1 fő kísérő jegye is', 'ar' => 500),
            array('tipus' => 'Családi jegy (2 szülő + 2 gyermek)', 'ar' => 7000),
            array('tipus' => 'Családi jegy (2 szülő + 1 gyermek, 1 szülő + 2 gyermek)', 'ar' => 5000),
            array('tipus' => 'Családi jegy (1 szülő + 3 gyermek)', 'ar' => 7000),
            array('tipus' => 'Családi jegy (2 nagyszülő + 2 gyermek)', 'ar' => 5000),
            array('tipus' => 'Csoportos felnőtt kedvezményes jegy (10 fő felett)', 'ar' => 2000),
            array('tipus' => 'Csoportos nyugdíjas kedvezményes jegy (10 fő felett)', 'ar' => 1400)
        );
    }
}
function removeDuplicates() {
    $tickets = loadTickets();
    $uniqueTickets = array_unique($tickets, SORT_REGULAR);
    saveTickets($uniqueTickets);
}
removeDuplicates();

function saveTickets($tickets) {
    $filename = 'tickets.txt';
    $json = json_encode($tickets, JSON_PRETTY_PRINT);
    file_put_contents($filename, $json);
}
function addNewTicket($type, $price) {
    $tickets = loadTickets();
    $tickets[] = array('tipus' => $type, 'ar' => $price);
    saveTickets($tickets);
}

function modifyPrice($index, $newPrice) {
    $tickets = loadTickets();
    if(isset($tickets[$index])) {
        $tickets[$index]['ar'] = $newPrice;
        saveTickets($tickets);
    }
}

function deleteTicket($index) {
    $tickets = loadTickets();
    array_splice($tickets, $index, 1);
    saveTickets($tickets);
}
function addToCart($jegyTipus, $ar) {
    $_SESSION['kosar'][] = array('tipus' => $jegyTipus, 'ar' => $ar, 'mennyiseg' => 1);
}
if (isset($_POST['submit'])) {
    addToCart($_POST['jegyTipus'], $_POST['ar']);
}


if (isset($_POST['modify']) && isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && $_SESSION['username'] === "ADMIN") {
    $index = $_POST['modify'];
    $newPrice = $_POST['newPrice'];
    modifyPrice($index, $newPrice);
    header("Location: jegyek.php"); // Újratöltjük az oldalt, hogy a változások látszódjanak
    exit(); // Megállítjuk a további szkript futását
}
if (isset($_POST['addTicket'])) {
    $newTicketType = $_POST['newTicketType'];
    $newTicketPrice = $_POST['newTicketPrice'];
    addNewTicket($newTicketType, $newTicketPrice);
    header("Location: jegyek.php"); // Újratöltjük az oldalt, hogy a változások látszódjanak
    exit(); // Megállítjuk a további szkript futását
}

if (isset($_POST['deleteTicket']) && isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && $_SESSION['username'] === "ADMIN") {
    $index = $_POST['deleteTicket'];
    deleteTicket($index);
    header("Location: jegyek.php");
    exit();
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
    $tickets = loadTickets(); // A jegyek betöltése a fájlból

    foreach ($tickets as $index => $jegy) {
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
                echo '<td>';
                echo '<form method="post">';
                echo '<input type="hidden" name="deleteTicket" value="' . $index . '">';
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

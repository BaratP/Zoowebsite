<?php
session_start();
function mergeDuplicateTickets() {
    if(isset($_SESSION['kosar']) && !empty($_SESSION['kosar'])) {
        $mergedTickets = array();
        foreach($_SESSION['kosar'] as $jegy) {
            $tipus = $jegy['tipus'];
            $ar = $jegy['ar'];
            $mennyiseg = $jegy['mennyiseg'];

            if(array_key_exists($tipus, $mergedTickets)) {
                // Ha a jegy már szerepel a tömbben, akkor növeljük a mennyiséget
                $mergedTickets[$tipus]['mennyiseg'] += $mennyiseg;
            } else {
                // Ha még nem szerepel a jegy a tömbben, akkor hozzáadjuk
                $mergedTickets[$tipus] = array('tipus' => $tipus, 'ar' => $ar, 'mennyiseg' => $mennyiseg);
            }
        }
        // Kosár tömb frissítése
        $_SESSION['kosar'] = array_values($mergedTickets);
    }
}

function modifyQuantity($tipus, $change) {
    if(isset($_SESSION['kosar']) && !empty($_SESSION['kosar'])) {
        foreach($_SESSION['kosar'] as &$jegy) {
            if($jegy['tipus'] === $tipus) {
                // Csak akkor módosítjuk a mennyiséget, ha az új mennyiség nem lenne negatív
                if($jegy['mennyiseg'] + $change >= 0) {
                    $jegy['mennyiseg'] += $change;
                }
                // Ha a mennyiség nulla vagy kevesebb, akkor töröljük az elemet
                if($jegy['mennyiseg'] <= 0) {
                    unset($jegy);
                }
                break; // Kilépünk a ciklusból, mert megtaláltuk az elemet
            }
        }
        // Kosár tömb frissítése
        $_SESSION['kosar'] = array_values($_SESSION['kosar']);
    }
}
function clearCart() {
    unset($_SESSION['kosar']);
}

if(isset($_POST['decrease'])) {
    modifyQuantity($_POST['tipus'], -1); // Csökkentjük a mennyiséget
} elseif(isset($_POST['increase'])) {
    modifyQuantity($_POST['tipus'], 1); // Növeljük a mennyiséget
} elseif(isset($_POST['remove'])) { // Új eset: Ha a "remove" gomb lett megnyomva
    removeFromCart($_POST['tipus']); // Hívjuk a removeFromCart függvényt
} elseif(isset($_POST['clear_cart'])) {
    clearCart(); // Töröljük a kosár tartalmát
    header("Location: jegyek.php"); // Átirányítás a jegyek oldalra
    exit();
}

mergeDuplicateTickets();

// Új függvény a jegy eltávolításához
function removeFromCart($tipus) {
    if(isset($_SESSION['kosar']) && !empty($_SESSION['kosar'])) {
        foreach($_SESSION['kosar'] as $key => $jegy) {
            if($jegy['tipus'] === $tipus) {
                unset($_SESSION['kosar'][$key]); // Töröljük az elemet a kosárból
                break; // Kilépünk a ciklusból, mert megtaláltuk az elemet
            }
        }
        // Kosár tömb frissítése
        $_SESSION['kosar'] = array_values($_SESSION['kosar']);
    }
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
<div id="cim"><div><h1>Kosarad</h1></div></div>
<br><br><br>
<hr>
<br><br>
<table class="jegyarak">
    <tr>
        <th>Jegy típusa</th>
        <th>Ár</th>
        <th>Mennyiség</th>
    </tr>
    <?php
    // Ellenőrizzük, hogy van-e kosár tartalom
    if(isset($_SESSION['kosar']) && !empty($_SESSION['kosar'])) {
        // Végigmegyünk a kosárban lévő elemeken
        foreach($_SESSION['kosar'] as $jegy) {
            echo "<tr>";
            echo "<td>{$jegy['tipus']}</td>";
            echo "<td>{$jegy['ar']} Ft</td>";
            echo "<td>";
            echo "<form method='post'>";
            echo "<input type='hidden' name='tipus' value='{$jegy['tipus']}'>";
            echo "<input type='hidden' name='ar' value='{$jegy['ar']}'>";
            echo "<button type='submit' name='decrease'>-</button>";
            echo " {$jegy['mennyiseg']} ";
            echo "<button type='submit' name='increase'>+</button>";
            echo "</form>";
            echo "</td>";
            echo "<td>"; // Új oszlop kezdete
            echo "<form method='post'>";
            echo "<input type='hidden' name='tipus' value='{$jegy['tipus']}'>";
            echo "<button type='submit' name='remove'>Törlés</button>"; // Törlés gomb
            echo "</form>";
            echo "</td>"; // Új oszlop vége
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='3'>A kosár üres</td></tr>";
    }
    ?>
</table>
<div style="display: flex; justify-content: center; align-items: center;margin-top: 1%;">
    <div>
        <form method="post" style="text-align: center;">
            <button type="submit" name="clear_cart">Törlés</button>
        </form>
        <form action="jegyek.php" style="text-align: center;">
            <button type="submit">Vásárlás</button>
        </form>
    </div>
</div>
<br><br><br>
</body>
</html>

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
                $mergedTickets[$tipus]['mennyiseg'] += $mennyiseg;
            } else {
                $mergedTickets[$tipus] = array('tipus' => $tipus, 'ar' => $ar, 'mennyiseg' => $mennyiseg);
            }
        }
        $_SESSION['kosar'] = array_values($mergedTickets);
    }
}

function modifyQuantity($tipus, $change) {
    if(isset($_SESSION['kosar']) && !empty($_SESSION['kosar'])) {
        foreach($_SESSION['kosar'] as &$jegy) {
            if($jegy['tipus'] === $tipus) {
                if($jegy['mennyiseg'] + $change >= 0) {
                    $jegy['mennyiseg'] += $change;
                }
                if($jegy['mennyiseg'] <= 0) {
                    unset($jegy);
                }
                break;
            }
        }
        $_SESSION['kosar'] = array_values($_SESSION['kosar']);
    }
}

function clearCart() {
    unset($_SESSION['kosar']);
}

if(isset($_POST['decrease'])) {
    modifyQuantity($_POST['tipus'], -1);
} elseif(isset($_POST['increase'])) {
    modifyQuantity($_POST['tipus'], 1);
} elseif(isset($_POST['remove'])) {
    removeFromCart($_POST['tipus']);
} elseif(isset($_POST['clear_cart'])) {
    clearCart();
    header("Location: jegyek.php");
    exit();
}

mergeDuplicateTickets();

function removeFromCart($tipus) {
    if(isset($_SESSION['kosar']) && !empty($_SESSION['kosar'])) {
        foreach($_SESSION['kosar'] as $key => $jegy) {
            if($jegy['tipus'] === $tipus) {
                unset($_SESSION['kosar'][$key]);
                break;
            }
        }
        $_SESSION['kosar'] = array_values($_SESSION['kosar']);
    }
}

/// Vásárlás funkció hozzáadása
if(isset($_POST['purchase'])) {
    if(isset($_SESSION['vasarlas'])) {
        $_SESSION['vasarlas'] = array_merge($_SESSION['vasarlas'], $_SESSION['kosar']); // Régi jegyek és új jegyek egyesítése
    } else {
        $_SESSION['vasarlas'] = $_SESSION['kosar']; // Ha nincsenek még régi jegyek
    }
    // Törlés helyett kosár tartalmának ürítése
    unset($_SESSION['kosar']);
    header("Location: profil.php"); // Profil oldalra való átirányítás
    exit();
}


// Ellenőrizzük, hogy létezik-e és nem üres-e a kosár tömb a session változók között
if(!isset($_SESSION['kosar']) || empty($_SESSION['kosar'])) {
    // Ha a kosár üres, inicializáljuk üres tömbbel
    $_SESSION['kosar'] = array();
}
// Jegy hozzáadása a kosárhoz
if(isset($_POST['add_to_cart'])) {
    $tipus = $_POST['tipus'];
    $ar = $_POST['ar'];
    $mennyiseg = $_POST['mennyiseg'];

    $uj_jegy = array('tipus' => $tipus, 'ar' => $ar, 'mennyiseg' => $mennyiseg);

    // Ellenőrizzük, hogy van-e már ilyen típusú jegy a kosárban
    $jegy_mezo = array_search($tipus, array_column($_SESSION['kosar'], 'tipus'));

    if($jegy_mezo !== false) {
        // Ha van már ilyen típusú jegy a kosárban, növeljük a mennyiséget
        $_SESSION['kosar'][$jegy_mezo]['mennyiseg'] += $mennyiseg;
    } else {
        // Ellenkező esetben adjuk hozzá az új jegyet a kosárhoz
        $_SESSION['kosar'][] = $uj_jegy;
    }

    header("Location: kosar.php");
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
    if(isset($_SESSION['kosar']) && !empty($_SESSION['kosar'])) {
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
            echo "<td>";
            echo "<form method='post'>";
            echo "<input type='hidden' name='tipus' value='{$jegy['tipus']}'>";
            echo "<button type='submit' name='remove'>Törlés</button>";
            echo "</form>";
            echo "</td>";
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
            <input type="hidden" name="purchase" value="1"> <!-- Rejtett mező a vásárlás jelzésére -->
            <button type="submit">Vásárlás</button>
        </form>
        <form method="post" style="text-align: center;">
            <button type="submit" name="clear_cart">Törlés</button>
        </form>
    </div>
</div>
<br><br><br>
</body>
</html>



<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Allatkert</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/kozos.css">
</head>
<body>
<nav class="nav">
    <ul>
        <li><img src="media/jegyarak.png" alt="jegy"><a href="index.php" style="text-decoration: underline">Főoldal</a></li>
        <li><img src="media/jegyarak.png" alt="jegy"><a href="html/jegyek.php">Jegyek</a></li>
        <li><img src="media/jegyarak.png" alt="jegy"><a href="html/szolgaltatas.php">Szolgáltatások</a></li>
        <li><img src="media/jegyarak.png" alt="jegy"><a href="html/lakok/lakok.php">Lakóink</a></li>
        <?php
        session_start();
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            echo '<li><img src="../media/jegyarak.png" alt="jegy"><a href="html/profil.php">Profil</a></li>';
            echo '<li><img src="../media/jegyarak.png" alt="jegy"><a href="html/logout.php">Kijelentkezés</a></li>';
        } else {
            echo '<li><img src="../media/jegyarak.png" alt="jegy"><a href="html/login.php">Bejelentkezés</a></li>';
            echo '<li><img src="../media/jegyarak.png" alt="jegy"><a href="html/register.php">Regisztráció</a></li>';
        }
        ?>
    </ul>
</nav>
<br><br>
<div><img src="media/lama.jpg" alt="ez baj" id="hatter"></div>

<div id="zoo"><div><h1>Lengyel Állatkert</h1></div></div>
<br><br>
<div id="udv"><div><h1>Üdvözöljük</h1></div></div>
<div id="a"><div><h1>Az</h1></div></div>
<div id="allatkert"><div><h1>Állatkertünkben</h1></div></div>
<article>
    <div><table class="tabla">
        <caption>Nyitvatartás</caption>
        <tr>
            <th>Nap</th>
            <th>Nyitás</th>
            <th>Zárás</th>
        </tr>
        <tr>
            <td>Hétfő</td>
            <td>8:00</td>
            <td>20:00</td>
        </tr>
        <tr>
            <td>Kedd</td>
            <td>8:00</td>
            <td>20:00</td>
        </tr>
        <tr>
            <td>Szerda</td>
            <td>8:00</td>
            <td>20:00</td>
        </tr>
        <tr>
            <td>Csütörtök</td>
            <td>8:00</td>
            <td>20:00</td>
        </tr>
        <tr>
            <td>Péntek</td>
            <td>8:00</td>
            <td>20:00</td>
        </tr>
        <tr>
            <td>Szombat</td>
            <td>8:00</td>
            <td>20:00</td>
        </tr>
        <tr>
            <td>Vasárnap</td>
            <td colspan="2" id="zarva">ZÁRVA</td>
        </tr>
    </table></div>
</article>

<article class="masszin">
    <div class="container">
        <div class="content left"><div id="cim"><div><h1><a href="html/lakok">Lakóink</a></h1></div></div></div>
        <div class="content right"><div id="cim2"><h1><a href="html/szolgaltatas.php">Szolgáltatások</a></h1></div></div>
    </div>
</article>

<article><div>
    <div id="cim3"><div><h1><a href="html/jegyek.php">Jegyek</a></h1></div></div>
</div></article>



</body>
</html>


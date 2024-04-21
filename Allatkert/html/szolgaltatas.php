<?php
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Allatkert</title>
    <link rel="stylesheet" href="../css/szolgaltatas.css">
    <link rel="stylesheet" href="../css/kozos.css">
</head>
<body>
<nav class="nav">
    <ul>
        <li><img src="../media/jegyarak.png" alt="jegy"><a href="../index.php">Főoldal</a></li>
        <li><img src="../media/jegyarak.png" alt="jegy"><a href="jegyek.php">Jegyek</a></li>
        <li><img src="../media/jegyarak.png" alt="jegy"><a href="szolgaltatas.php" style="text-decoration: underline">Szolgáltatások</a></li>
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
<article style="padding: 6% 0 0">
    <div id="cim"><div><h1>Lakóink</h1></div></div>
</article>
<article>
    <div style="transform: rotate(-1deg)">
        <img src="../media/szolgaltatas/OIG4.jpg" alt="állatkert" class="kozepreRakottKep">
    </div>
    <div class="flexbox">
        <p class="szoveg">A Lengyel Állatkert Afrika szavanna tematikájú új játszóterét 2018 júliusában adták át a
            nagyközönségnek. Ez az élményteli játszóhely a Modern Városok Program támogatásával jöhetett létre.
            A gyermekjátszótér, mely az Afrika szavannáinak hangulatát idézi, gyorsan a
            kicsik kedvelt helyévé vált. Ebben az afrikai témájú játszóhelyen a fiatalok
            megismerkedhetnek az afrikai vadon élőlényeivel, beleértve a tanzániai Serengeti
            Nemzeti Park izgalmas világát is. Egy kalandos élményhajó fedélzetén átélhetik
            azokat a pillanatokat, amikor az első állatok megérkeztek Afrikából a Lengyel
            Állatkertbe.
        </p>
    </div>
</article>
<div id="hely"></div>
<article class="row">
    <div class="flexbox">
        <p class="szoveg">A Lengyel Állatkert 2018 júliusában ünnepélyesen megnyitotta Afrika szavanna tematikájú új játszóterét,
            amelyet a nagyközönség is szívesen fogadott. Ez a különleges és izgalmas játszóhely valóságos élményt nyújt a látogatóknak,
            akik részesei lehetnek egy kis darabka Afrika varázsának. A játszótér létrehozását a Modern Városok Program támogatta,
            amely lehetővé tette, hogy egy olyan modern és interaktív közösségi teret hozzanak létre,
            amely inspirálja és szórakoztatja a gyerekeket és családjaikat egyaránt.
            A játszótér tervezése során kiemelt figyelmet fordítottak az autentikus afrikai elemekre és hangulatra,
            így a látogatók teljes mértékben belemerülhetnek a szavanna varázslatos világába.
        </p>
    </div>
    <div style="transform: rotate(2deg)">
        <img src="../media/szolgaltatas/OIG1.jpg" alt="állatkert" class="kozepreRakottKep">
    </div>
</article>
<article>
    <div class="flexbox" style="background-image: url('../media/szolgaltatas/rm141-nunny-02b.jpg')">
        <p class="szoveg">A Lengyel Állatkertben három ajándékbolt várja a látogatókat:
        a Fejes-völgyi főbejáraton érkezve az első a Kölyökdzsungel játszóház
        és terráriummal szemközt található, a második  az állatsimogató mellett,
        a harmadik pedig a Dinó Parkban található
        </p>
    </div>
    <div>
        <img src="../media/szolgaltatas/OIG4%20(1).jpg" alt="állatkert" class="kozepreRakottKep">
    </div>
</article>
<img src="../media/szolgaltatas/OIG2.jpg" alt="ez baj" id="hatter">
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Allatkert</title>
    <link rel="stylesheet" href="../../css/kozos.css">
    <link rel="stylesheet" href="../../css/lakokprofil.css">
</head>
<body>
<nav class="nav">
    <ul>
        <li><img src="../../media/jegyarak.png" alt="jegy"><a href="../../index.php">Főoldal</a></li>
        <li><img src="../../media/jegyarak.png" alt="jegy"><a href="../jegyek.php">Jegyek</a></li>
        <li><img src="../../media/jegyarak.png" alt="jegy"><a href="../szolgaltatas.php">Szolgáltatások</a></li>
        <li><img src="../../media/jegyarak.png" alt="jegy"><a href="lakok.php" style="text-decoration: underline">Lakóink</a></li>
        <?php
        session_start();
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            echo '<li><img src="../media/jegyarak.png" alt="jegy"><a href="../profil.php">Profil</a></li>';
            echo '<li><img src="../media/jegyarak.png" alt="jegy"><a href="../logout.php">Kijelentkezés</a></li>';
        } else {
            echo '<li><img src="../media/jegyarak.png" alt="jegy"><a href="../login.php">Bejelentkezés</a></li>';
            echo '<li><img src="../media/jegyarak.png" alt="jegy"><a href="../register.php">Regisztráció</a></li>';
        }
        ?>
    </ul>
</nav>
<div class="split">
    <div class="split">
        <div class="flow">
            <div><p>Bobber (hód/vombat)</p><a href="bober.php"><img src="../../media/lakok/elsoKep.png" alt="bober"></a></div>
            <div><p>Pingvin (indiai futó kacsa)</p><a href="pingvin.php"><img src="../../media/lakok/negyedikKep.png" alt="pingvin" id="aktualiskep"></a></div>
        </div>
    </div>
    <div class="split">
        <div class="flow">
            <div><p>Pocekai (patkány/mezei egér)</p><a href="pocekai.php"><img src="../../media/lakok/harmadikKep.png" alt="pocekai"></a></div>
            <div><p>Skunks (borz)</p><a href="skunks.php"><img src="../../media/lakok/masodikKep.png" alt="skunks"></a></div>
        </div>
    </div>
    <div class="lap">
        <video controls width="640" height="360" autoplay>
            <source src="../../media/allat2.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <hr>
        <h2>Pingvin (indiai futó kacsa)</h2>
        <pre>
            <span class="first-word">Tudományos név</span>	"Anas platyrhynchos domesticus"

            <span class="first-word">Származási régió</span>

            <span class="first-word">Vidék</span>	Anglia zászlaja Anglia

            <span class="first-word">Jellemzők</span>

            <span class="first-word">Vágott</span>	Átlagos

            <span class="first-word">Tollazat</span>	Barna, kék, fehér, pisztráng, vad, sárga
                        borsó, ezüstös vad, barnás kék pisztráng

            <span class="first-word">Egyéb</span>

            <span class="first-word">Diffúzió</span>	Globális

            használat	Tojás , dísz, meztelen csiga és csiga ellenőrzése.

            Az indiai futó egy kacsafajta, amely Angliából származik ,
            valószínűleg Ázsiából importálta ezt az országot.
            Eleinte tojásrakás céljából választották ki,
            amelyhez a kacsák jól teljesítenek,
            és évente átlagosan 200 tojást termelnek. Ez a kacsa mára a
            díszkacsaként egyre elterjedtebb a világon.
            Ezt a népszerűséget sajátos megközelítésének köszönheti,
            szinte függőleges és mindig futás benyomását kelti.
            Nagyon ritka esetekben meredek helyről felszállva vagy a repüléshez
            szükséges támasz segítségével repülhet,
            de nem megy túl messzire. Végül az indiai futót fel
            lehet használni harcra azokkal a
            meztelen csigákkal és csigákkal, amelyeket könnyen megesz</pre>
    </div>
</div>
</body>
</html>
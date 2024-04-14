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
            <div><p>Bobber (hód/vombat)</p><a href="bober.php"><img src="../../media/lakok/elsoKep.png" alt="bober" ></a></div>
            <div><p>Pingvin (indiai futó kacsa)</p><a href="pingvin.php"><img src="../../media/lakok/negyedikKep.png" alt="pingvin"></a></div>
        </div>
    </div>
    <div class="split">
        <div class="flow">
            <div><p>Pocekai (patkány/mezei egér)</p><a href="pocekai.html"><img src="../../media/lakok/harmadikKep.png" alt="pocekai" id="aktualiskep"></a></div>
            <div><p>Skunks (borz)</p><a href="skunks.php"><img src="../../media/lakok/masodikKep.png" alt="skunks"></a></div>
        </div>
    </div>
    <div class="lap">
        <video controls width="640" height="360" autoplay>
            <source src="../../media/allat1.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <hr>
        <h2>pocekai (patkány/mezei egér)</h2>
        <pre>
            <span class="first-word">Ország:</span>	Állatok (Animalia)

            <span class="first-word">Törzs:</span>	Gerinchúrosok (Chordata)

            <span class="first-word">Altörzs:</span>	Gerincesek (Vertebrata)

            <span class="first-word">Főosztály:</span>	Négylábúak (Tetrapoda)

            <span class="first-word">Osztály:</span>	Emlősök (Mammalia)

            <span class="first-word">Alosztály:</span>	Elevenszülő emlősök (Theria)

            <span class="first-word">Csoport:</span>	Eutheria

            <span class="first-word">Alosztályág:</span>	Méhlepényesek (Placentalia)

            <span class="first-word">Öregrend:</span>	Euarchontoglires

            <span class="first-word">Csoport:</span>	Glires

            <span class="first-word">Rend:</span>	Rágcsálók (Rodentia)

            <span class="first-word">Alrend:</span>	Egéralkatúak (Myomorpha)

            <span class="first-word">Öregcsalád:</span>	Muroidea

            <span class="first-word">Család:</span>	Egérfélék (Muridae)

            <span class="first-word">Alcsalád:</span>	Egérformák (Murinae)

            <span class="first-word">Nem:</span>	Apodemus

            Kaup, 1829

            <span class="first-word">Alnem:</span>	Sylvaemus

            <span class="first-word">Faj:</span>	A. sylvaticus</pre>
    </div>
</div>
</body>
</html>
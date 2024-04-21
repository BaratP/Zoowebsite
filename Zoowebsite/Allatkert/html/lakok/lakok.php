<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Allatkert</title>
    <link rel="stylesheet" href="../../css/lakok.css">
    <link rel="stylesheet" href="../../css/kozos.css">
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
<br><br>
<div id="cim"><div><h1>Lakóink</h1></div></div>
<br><br>
<div class="flex">Kattints a képre bővebb információkért!</div>
<hr>
<br><br>
<div class="flex">
    <div><a href="bober.php"><img src="../../media/lakok/elsoKep.png" alt="bober"></a></div>
    <div><a href="pingvin.php"><img src="../../media/lakok/negyedikKep.png" alt="pingvin"></a></div>
    <div><a href="pocekai.php"><img src="../../media/lakok/harmadikKep.png" alt="pocekai"></a></div>
    <div><a href="skunks.php"><img src="../../media/lakok/masodikKep.png" alt="skunks"></a></div>
</div>
<br><br>
<hr>
</body>
</html>
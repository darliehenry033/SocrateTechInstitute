<?php 
require_once __DIR__ . '/header.php';
?>

<header class="header-container">
    <div class="hamburger-menu-container">
        <div class="hamburger-menu">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <nav class="navigation-bar">
        <!-- removed: <div class="hamburger-menu close-x">...</div> -->

        <div class="nav-left">
            <a href="index.html">
                <img src="images/logowhite.png" alt="Socrate Tech Institute">
            </a>
        </div>

        <div class="nav-center">
            <a class="accueil" href="pages/index.php">Accueil</a>
            <a class="filières">Classes</a>
            <a class="filières">À Propos</a>
            <a class="inscription">Inscription</a>
            <a class="vieScolaire">Vie Scolaire</a>
        </div>

        <div class="nav-right">
            <a href="register.php" class="contact button register-btn">Enregistrer</a>
            <a href="login.php" class="connexion button connexion-btn">Connexion</a>
        </div>
    </nav>
</header>

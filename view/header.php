<header>
    <nav>
        <ol>
            <li class="Accueil"><a class="LiensVariés" href="<?= \core\Router::getInstance()->routeUri(ROUTE_HOME) ?>"><img src="assets/open-book1.png">FreeNote</img></a></li>
            <?php if (\core\Session::isLogged()) { ?>
                <?php if (\core\Session::getLogged()->admin) { ?>
                <li class="Liens"><a class="LiensVariés" href="<?= \core\Router::getInstance()->routeUri(ROUTE_ADMIN) ?>">Admin</a></li>
                <?php } ?>
            <li class="Liens"><a class="LiensVariés" href="<?= \core\Router::getInstance()->routeUri(ROUTE_PROFILE) ?>">Profil</a></li>
            <li class="Liens"><a class="LiensVariés" href="<?= \core\Router::getInstance()->routeUri(ROUTE_DISCONNECT) ?>">Se déconnecter</a></li>
            <?php } else { ?>
            <li class="Liens"><a class="LiensVariés" href="<?= \core\Router::getInstance()->routeUri(ROUTE_LOGIN) ?>">Se Connecter</a></li>
            <li class="Liens"><a class="LiensVariés" href="<?= \core\Router::getInstance()->routeUri(ROUTE_REGISTER) ?>">Inscription</a></li>
            <?php } ?>
        </ol>
    </nav>
</header>
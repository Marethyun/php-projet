<html lang="en">
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
    </head>
    <body>
    <?php if (isset($GLOBALS[DATASET_ENTRY]['error'])) { ?>
        <p style="color: red"><?= $GLOBALS[DATASET_ENTRY]['error'] ?></p>
    <?php } ?>
        <form action="<?= \core\Router::getInstance()->routeUri(ROUTE_LOGIN) ?>" method="post">
            <label>
                Username
                <input type="text" name="username">
            </label>
            <label>
                Password
                <input type="password" name="password">
            </label>
            <input type="submit">
        </form>
    </body>
</html>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>FreeNote - Se connecter</title>
        <?php include_once 'head.php' ?>
    </head>

    <body>
    <?php include_once 'header.php' ?>

    <main>
        <div class="box">
            <h1 class="hform">Se Connecter</h1>
            <form class="formulaires" action="<?= \core\Router::getInstance()->routeUri(ROUTE_LOGIN) ?>" method="POST">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" name="username" id="username"/>

                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password"/>

                <?php if (isset($GLOBALS[DATASET_ENTRY]['error'])) { ?>
                    <p class="messageerreur"><?= $GLOBALS[DATASET_ENTRY]['error'] ?></p>
                <?php } ?>

                <input type="submit" name="action" value="Valider" id="mailer">
                <p class="textchangementform">Besoin d'un compte ? <a class="changementformulaire" href="<?= \core\Router::getInstance()->routeUri(ROUTE_REGISTER) ?>>">S'inscrire</a></p>

            </form>
        </div>
    </main>

    <?php include_once 'footer.php' ?>
    </body>

</html>

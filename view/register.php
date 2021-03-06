<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>FreeNote</title>
        <?php include_once 'head.php' ?>
    </head>

    <body>
    <?php include_once 'header.php'?>

    <main>
        <div class="box">
            <h1 class="hform">Inscription</h1>
            <?php if (filter_var(REGISTRATIONS_OPENED, FILTER_VALIDATE_BOOLEAN)) { ?>
            <form class="formulaires" action="<?= \core\Router::getInstance()->routeUri(ROUTE_REGISTER) ?>" method="POST">
                <label for="username">Nom d'utilisateur</label><br>
                <small>Caractères aphanumériques et underscore, minimum 6 caractères, maximum 255</small><br>
                <input type="text" name="username" id="username"/>

                <label for="email">E-mail</label>
                <input type="text" name="email" id="email"/>

                <label for="password">Mot de Passe</label><br>
                <small>Minimum 6 caractères, maximum 255</small><br>
                <input type="password" name="password" id="password"/>


                <label for="password2">Verification du Mot de Passe</label>
                <input type="password" name="password_repeat" id="password2"/>

                <?php if (isset($GLOBALS[DATASET_ENTRY]['error'])) { ?>
                    <p class="messageerreur"><?= $GLOBALS[DATASET_ENTRY]['error'] ?></p>
                <?php } ?>

                <input type="submit" name="action" value="Valider" id="mailer">
                <p class="textchangementform">Tu as déjà un compte ? <a class="changementformulaire" href="<?= \core\Router::getInstance()->routeUri(ROUTE_LOGIN) ?>">Se Connecter</a></p>
            </form>
            <?php } else { ?>
            <p>Nous sommes désolés, mais les inscriptions sont fermées pour le moment.</p>
            <?php } ?>
        </div>
    </main>

    <?php include_once 'footer.php' ?>
    </body>

</html>

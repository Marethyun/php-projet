<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>FreeNote - Réinitialiser un mot de passe</title>
        <?php include_once 'head.php' ?>
    </head>

    <body>

    <main>
        <div class="boxreini">
            <h1 class="hform">Réinitialiser votre Mot de Passe</h1>
            <form class="modifmdpform" action="<?= \core\Router::getInstance()->routeUri(ROUTE_RESET, array('token' => $GLOBALS[DATASET_ENTRY]['reset_token'])) ?>" method="POST">
                <label for="password">Nouveau Mot de Passe</label>
                <input type="password" name="password" id="password"/>

                <label for="password">Verifier votre Nouveau Mot de Passe</label>
                <input type="password" name="password_repeat" id="password"/>

                <input type="hidden" name="reset_token" value="<?= $GLOBALS[DATASET_ENTRY]['reset_token'] ?>">

                <?php if (isset($GLOBALS[DATASET_ENTRY]['error'])) { ?>
                    <p style="color: red"><?= $GLOBALS[DATASET_ENTRY]['error'] ?></p>
                <?php } ?>

                <input type="submit" name="action" value="Enregistrer les modifications" id="mailer">
            </form>
        </div>
    </main>
    <?php include_once 'footer.php' ?>
    </body>

</html>

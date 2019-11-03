<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>FreeNote - Réinitialiser un mot de passe</title>
        <?php include_once 'head.php' ?>
    </head>

    <body>

    <div class="boxreini">
        <h1 class="hform">Entrez votre adresse mail</h1>
        <form class="modifmdpform" action="<?= \core\Router::getInstance()->routeUri(ROUTE_ASKRESET) ?>" method="POST">
            <label for="email">E-mail</label>
            <input type="text" name="email" id="email"/>
            <?php if (isset($GLOBALS[DATASET_ENTRY]['error'])) { ?>
                <p style="color: red"><?= $GLOBALS[DATASET_ENTRY]['error'] ?></p>
            <?php } ?>
            <?php if (isset($GLOBALS[DATASET_ENTRY]['success'])) { ?>
                <p style="color: green"><?= $GLOBALS[DATASET_ENTRY]['success'] ?></p>
            <?php } ?>

            <input type="submit" name="action" value="Valider" id="mailer">
        </form>
    </div>

    <?php include_once 'footer.php' ?>
    </body>

</html>

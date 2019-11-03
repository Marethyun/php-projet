<?php
$user = $GLOBALS[DATASET_ENTRY]['user'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Profil</title>
    </head>
    <body>
    <?php if (isset($GLOBALS[DATASET_ENTRY]['error'])) { ?>
        <p style="color: red"><?= $GLOBALS[DATASET_ENTRY]['error'] ?></p>
    <?php } ?>

    <?php if (isset($GLOBALS[DATASET_ENTRY]['success'])) { ?>
        <p style="color: green"><?= $GLOBALS[DATASET_ENTRY]['success'] ?></p>
    <?php } ?>
        <h1>Profil</h1>

        <label>
            Mail
            <input type="email" value="<?= $user->email ?>" disabled>
        </label>

        <label>
            Nom d'utilisateur
            <input type="text" value="<?= $user->username ?>" disabled>
        </label>

        <h2>Modifier le mot de passe</h2>
        <form action="<?= \core\Router::getInstance()->routeUri(ROUTE_PROFILE) ?>" method="post">
            <label>
                Mot de passe
                <input type="password" name="password">
            </label>

            <label>
                Répéter mot de passe
                <input type="password" name="password_repeat">
            </label>
            <input type="submit">
        </form>
    </body>
</html>
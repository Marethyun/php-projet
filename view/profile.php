<?php
$user = $GLOBALS[DATASET_ENTRY]['user'];
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Freenote - Profil</title>
        <?php include_once 'head.php' ?>
    </head>

    <body>
    <?php include_once 'header.php' ?>

    <main>
        <div class="box">
            <h1 class="hform">Votre Profil</h1>
            <div class="profilform">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" name="username" id="username" value="<?= $user->username ?>" disabled/>

                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" value="<?= $user->email ?>" disabled/>

                <p class="textchangementform">Vous voulez vous déconnecter ? <a class="changementformulaire" href="<?= \core\Router::getInstance()->routeUri(ROUTE_DISCONNECT) ?>">Se déconnecter</a></p>
            </div>
        </div>

        <div class="box">
            <h1 class="hform">Modifier votre Mot de Passe</h1>
            <form class="modifmdpform" action="<?= \core\Router::getInstance()->routeUri(ROUTE_PROFILE) ?>" method="POST">
                <label for="password">Nouveau Mot de Passe</label>
                <input type="password" name="password" id="password"/>

                <label for="password2">Verifier le mot de Passe</label>
                <input type="password" name="password_repeat" id="password2"/>

                <?php if (isset($GLOBALS[DATASET_ENTRY]['error'])) { ?>
                    <p style="color: red"><?= $GLOBALS[DATASET_ENTRY]['error'] ?></p>
                <?php } ?>

                <?php if (isset($GLOBALS[DATASET_ENTRY]['success'])) { ?>
                    <p style="color: green"><?= $GLOBALS[DATASET_ENTRY]['success'] ?></p>
                <?php } ?>

                <input type="submit" name="action" value="Enregistrer les modifications" id="mailer">
            </form>
        </div>
    </main>

    <?php include_once 'footer.php' ?>

    </body>
</html>

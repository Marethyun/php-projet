<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Accueil</title>
    </head>
    <body>
    <?php if (isset($GLOBALS[DATASET_ENTRY]['error'])) { ?>
        <p style="color: red"><?= $GLOBALS[DATASET_ENTRY]['error'] ?></p>
    <?php } ?>
        <h1>Bienvenue !</h1>

    <?php if (\core\Session::isLogged()) { ?>
        <form action="<?= \core\Router::getInstance()->routeUri(ROUTE_HOME) ?>" method="post">
            <input type="hidden" name="action" value="new_thread">
            <input type="submit" value="Nouvelle discussion">
        </form>
    <?php } ?>
        <h2>Discussions</h2>
        <table>
            <thead>
                <tr>
                    <th>Identifiant</th>
                    <th>Dernier message</th>
                    <th>État</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($GLOBALS[DATASET_ENTRY]['threads'] as $thread) { ?>
                <tr>
                    <td style="font-family: monospace"><a href="<?= \core\Router::getInstance()->routeUri(ROUTE_THREAD, array('thread' => \model\wrappers\Ids::toHex($thread->id))) ?>">#<?= \model\wrappers\Ids::toHex($thread->id) ?></a></td>
                    <td>
                        <?php if(empty($thread->messages)) { ?>(Discussion vide)<?php }?>
                        <?php if(empty(end($thread->messages)->fragments)) {?>
                            <?php if (!$thread->opened and count($thread->messages) >= 2) {?>
                                <?php foreach ($thread->messages[count($thread->messages) - 2]->fragments as $fragment) { ?>
                                    <?= $fragment->content ?>
                                <?php } ?>
                            <?php } else { ?>
                                (Discussion à compléter)
                            <?php } ?>
                        <?php } else { ?>
                            <?php foreach (end($thread->messages)->fragments as $fragment) { ?>
                                <?= $fragment->content ?>
                            <?php } ?>
                        <?php } ?>
                    </td>
                    <td><?= $thread->opened ? 'Ouverte' : 'Fermée' ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </body>
</html>

<!-- TODO -->

<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>FreeNote - Accueil</title>
        <?php include_once 'head.php' ?>
    </head>

    <body>
    <?php include_once 'header.php'?>

    <main>
        <div class="Zone">
            <h1 class="hform">Description du service</h1>
            <p class="paccueil">
                Coactique aliquotiens nostri pedites ad eos persequendos scandere clivos sublimes etiam si lapsantibus plantis fruticeta prensando vel dumos ad vertices venerint summos, inter arta tamen et invia nullas acies explicare permissi nec firmare nisu valido gressus: hoste discursatore rupium abscisa volvente, ruinis ponderum inmanium consternuntur, aut ex necessitate ultima fortiter dimicante, superati periculose per prona discedunt.
            </p>
        </div>

        <div class="Zone">
            <h1 class="hform">Discussions disponibles</h1>
            <table>
                <thead>
                <tr>
                    <th>Statut</th>
                    <th>Identifiant</th>
                    <th>Dernier message</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($GLOBALS[DATASET_ENTRY]['threads'] as $thread) { ?>
                    <tr>
                        <th>
                            <?php if ($thread->opened) { ?>
                            <span class="ouvert">Ouverte <i class="fas fa-check"></i></span>
                            <?php } else { ?>
                            <span class="fermé">Fermée <i class="fas fa-times"></i>
                            <?php } ?>
                        </th>
                        <th><a class="LiensVariés" href="<?= \core\Router::getInstance()->routeUri(ROUTE_THREAD, array('thread' => \model\wrappers\Ids::toHex($thread->id))) ?>"><?= \model\wrappers\Ids::toHex($thread->id) ?></a></th>
                        <th>
                            <?php if(empty($thread->messages)) { ?>(Discussion vide)<?php }?>
                            <?php if(empty(end($thread->messages)->fragments)) {?>
                                <?php if (!$thread->opened and count($thread->messages) >= 2) {?>
                                    <?php foreach ($thread->messages[count($thread->messages) - 2]->fragments as $fragment) { ?>
                                        <?= $fragment->content ?>
                                    <?php } ?>
                                <?php } else { ?>
                                    (Discussion à compléter)
                                <?php } ?>
                            <?php } else { ?>
                                <?php foreach (end($thread->messages)->fragments as $fragment) { ?>
                                    <?= $fragment->content ?>
                                <?php } ?>
                            <?php } ?>
                        </th>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

        <?php if (\core\Session::isLogged()) { ?>
        <div class="Zone">
            <!-- TODO Vérifier si c'est assez joli -->
            <?php if (isset($GLOBALS[DATASET_ENTRY]['error'])) { ?>
                <p style="color: red"><?= $GLOBALS[DATASET_ENTRY]['error'] ?></p>
            <?php } ?>
            <form class="formboutton" action="<?= \core\Router::getInstance()->routeUri(ROUTE_HOME) ?>" method="post">
                <input type="hidden" name="action" value="new_thread">
                <input type="submit" value="Créer une discussion">
            </form>
        </div>
        <?php } ?>

        <div class="Zone">
            <p class="paccueil">Vous êtes administrateur, tout le fonctionnement du site est entre vos mains, faites très attention à ce que vous faites si vous craignez les remarques des utilisateurs de freenote les plus haineux.<br>
            <ul>
                <li>Vous avez le pouvoir de :</li>
                <li>- Fermer les discussion quand vous jugez la météo idéale;</li>
                <li>- Configurer freenote à l'aide d'un <span class="souligner">magnifique</span> panneau d'administration.</li>
            </ul>
        </div>
    </main>

    <?php include_once 'footer.php' ?>

    </body>
</html>

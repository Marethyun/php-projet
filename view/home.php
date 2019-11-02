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
        <form action="/?controller=home" method="post">
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
                    <!-- TODO Généraliser la création de liens -->
                    <td style="font-family: monospace"><a href="<?= \core\Router::getInstance()->routeUrl(ROUTE_THREAD, array('thread' => \model\wrappers\Ids::toHex($thread->id))) ?>">#<?= \model\wrappers\Ids::toHex($thread->id) ?></a></td>
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
<?php
$thread = $GLOBALS[DATASET_ENTRY]['thread'];
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Discussion #<?= \model\wrappers\Ids::toHex($thread->id) ?> <?= $thread->opened ? '' : '(Fermée)' ?></title>
    </head>
    <body>
    <?php if (isset($GLOBALS[DATASET_ENTRY]['error'])) { ?>
        <p style="color: red"><?= $GLOBALS[DATASET_ENTRY]['error'] ?></p>
    <?php } ?>

    <?php if (isset($GLOBALS[DATASET_ENTRY]['success'])) { ?>
        <p style="color: green"><?= $GLOBALS[DATASET_ENTRY]['success'] ?></p>
    <?php } ?>

        <h1>Discussion <span style="font-family: monospace">#<?= \model\wrappers\Ids::toHex($thread->id) ?></span> <?= $thread->opened ? '' : '(Fermée)' ?></h1>
    <?php if (\core\Session::isLogged() and \core\Session::getLogged()->admin and $thread->opened) { ?>
        <form action="<?= \core\Router::getInstance()->routeUri(ROUTE_THREAD, array('thread' => \model\wrappers\Ids::toHex($thread->id))) ?>" method="post">
            <input type="hidden" name="action" value="close_thread">
            <label>
                <input type="submit" value="Fermer la discussion">
            </label>
        </form>
    <?php } ?>

    <?php foreach ($thread->messages as $km => $message) { ?>
        <div id="message">
        <?php if (empty($message->fragments)) { ?>
            <p> - (suite à écrire..)</p>
        <?php } else { ?>
            <p> - <?php foreach ($message->fragments as $kf => $fragment) { ?><?= $fragment->content ?> <?php } ?> <?php if (array_key_last($thread->messages) === $km) { ?>(suite à écrire..)<?php } ?></p>
        <?php } ?>
        </div>
        <?php if ($thread->opened and \core\Session::isLogged() and array_key_last($thread->messages) === $km) { ?>
        <form action="<?= \core\Router::getInstance()->routeUri(ROUTE_THREAD, array('thread' => \model\wrappers\Ids::toHex($thread->id))) ?>" method="post">
            <label>
                Message
                <input type="text" name="fragment">
            </label>
            <input type="hidden" name="message_id" value="<?= \model\wrappers\Ids::toHex($message->id) ?>">
            <input type="hidden" name="action" value="add_fragment">
            <input type="submit">
        </form>
        <?php } ?>
    <?php } ?>

    </body>
</html>
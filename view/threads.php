<?php
$thread = $GLOBALS[DATASET_ENTRY]['thread'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>FreeNote - Discussion #<?= \model\wrappers\Ids::toHex($thread->id) ?> <?= $thread->opened ? '' : '(Fermée)' ?></title>
        <?php include_once 'head.php' ?>
    </head>

    <body>
    <?php include_once 'header.php' ?>

    <main>
        <div class="DiscussionType">
            <h1>
                Discussion #<?= \model\wrappers\Ids::toHex($thread->id) ?>
                <?php if($thread->opened) { ?>
                    <span class="ouvert">Ouverte <i class="fas fa-check"></i></span>
                <?php } else { ?>
                    <span class="fermé">Fermée <i class="fas fa-times"></i>
                <?php } ?>
            </h1>

            <?php foreach ($thread->messages as $km => $message) { ?>
                <p class="message">
                <?php if (empty($message->fragments)) { ?>
                    (suite à écrire..)
                <?php } else { ?>
                    <?php foreach ($message->fragments as $kf => $fragment) { ?><abbr title="<?= $fragment->creator->username ?>" style="text-decoration: white dotted underline"><?= $fragment->content ?></abbr> <?php } ?> <?php if (array_key_last($thread->messages) === $km) { ?>(suite à écrire..)<?php } ?>
                <?php } ?>
                </p>
            <?php } ?>

            <?php if ($thread->opened and \core\Session::isLogged() and array_key_last($thread->messages) === $km) { ?>
            <form class="formulaires" action="<?= \core\Router::getInstance()->routeUri(ROUTE_THREAD, array('thread' => \model\wrappers\Ids::toHex($thread->id))) ?>" method="post">
                <input type="text" name="fragment">
                <input type="hidden" name="message_id" value="<?= \model\wrappers\Ids::toHex($message->id) ?>">
                <input type="hidden" name="action" value="add_fragment">
                <input type="submit" value="Poster" id="mailer">
            </form>
            <?php } ?>

            <?php if (isset($GLOBALS[DATASET_ENTRY]['error'])) { ?>
                <p style="color: red"><?= $GLOBALS[DATASET_ENTRY]['error'] ?></p>
            <?php } ?>

            <?php if (isset($GLOBALS[DATASET_ENTRY]['success'])) { ?>
                <p style="color: green"><?= $GLOBALS[DATASET_ENTRY]['success'] ?></p>
            <?php } ?>
        </div>


        <?php if (\core\Session::isLogged() and \core\Session::getLogged()->admin and $thread->opened) { ?>
        <div class="DiscussionType">
            <form class="formboutton" action="<?= \core\Router::getInstance()->routeUri(ROUTE_THREAD, array('thread' => \model\wrappers\Ids::toHex($thread->id))) ?>" method="POST">
                <input type="hidden" name="action" value="close_thread">
                <input type="submit" value="Fermeture de la Discussion" id="mailer">
            </form>
        </div>
        <?php } ?>
    </main>

    <?php include_once 'footer.php' ?>

    </body>
</html>

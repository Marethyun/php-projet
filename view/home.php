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
        <form>
            <input type="hidden" name="action" value="new_thread">
            <input type="submit" value="Nouvelle discussion">
        </form>
    <?php } ?>
        <h2>Discussions</h2>
        <table>
            <tbody>
            <?php foreach ($GLOBALS[DATASET_ENTRY]['threads'] as $thread) { ?>
                <tr>
                    <!-- TODO Généraliser la création de liens -->
                    <td><a href="<?= sprintf("/?controller=thread&thread=%s", \model\wrappers\Ids::toHex($thread->id)) ?>"><?= \model\wrappers\Ids::toHex($thread->id) ?></a></td>
                    <td><?= $thread->opened ? '' : '(Fermée)' ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </body>
</html>
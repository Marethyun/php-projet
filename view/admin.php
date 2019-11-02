<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Panneau d'administration</title>
    </head>
    <body>
        <h1>Panneau d'administration</h1>
        <p>Faites attention à ne pas changer une valeur dont vous ne comprendriez pas l'utilité.</p>
        <p>
            Si vous faites une erreur et que l'application ne fonctionne plus,
            vous pouvez changer ces mêmes valeurs manuellement dans  le fichier <span style="font-family: monospace"><?= CONFIG_FILE ?></span>.
        </p>

        <?php if (isset($GLOBALS[DATASET_ENTRY]['file_error'])) { ?>
        <p style="color: red">Une erreur tragique est survenue lors de modification du fichier de configuration</p>
        <?php } else { ?>

        <form action="<?= \core\Router::getInstance()->routeUri(ROUTE_ADMIN) ?>" method="post">
            <?php foreach ($GLOBALS[DATASET_ENTRY]['properties'] as $property) { ?>
                <label>
                    <input type="hidden" name="<?= 'type_' . $property->name ?>" value="<?= $property->type ?>">
                    <input style="width: 200px" type="<?= $property->type === \core\Properties::STRING_TYPE ? 'text' : 'number' ?>" name="<?= $property->name ?>" value="<?= $property->value ?>">
                    <span style="font-family: monospace"><?= $property->name ?></span>
                </label><br>
            <?php } ?>

            <input type="submit">
        </form>

        <?php } ?>
    </body>
</html>
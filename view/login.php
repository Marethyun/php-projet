<html lang="en">
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
    </head>
    <body>
    <?php if (isset($GLOBALS[DATASET_ENTRY]['error'])) { ?>
        <p style="color: red"><?= $GLOBALS[DATASET_ENTRY]['error'] ?></p>
    <?php } ?>
        <form action="<?= \core\Router::getInstance()->routeUri(ROUTE_LOGIN) ?>" method="post">
            <label>
                Username
                <input type="text" name="username">
            </label>
            <label>
                Password
                <input type="password" name="password">
            </label>
            <input type="submit">
        </form>
    </body>
</html>
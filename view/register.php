<html lang="en">
    <head>
        <title>Register</title>
        <meta charset="UTF-8">
    </head>
    <body>
    <?php if (isset($GLOBALS[DATASET_ENTRY]['error'])) { ?>
        <p style="color: red"><?= $GLOBALS[DATASET_ENTRY]['error'] ?></p>
    <?php } ?>
        <form action="<?= \core\Router::getInstance()->routeUri(ROUTE_REGISTER) ?>" method="post">
            <label>
                Username
                <input type="text" name="username">
            </label>
            <label>
                Mail
                <input type="text" name="email">
            </label>
            <label>
                Password
                <input type="password" name="password">
            </label>
            <label>
                Repeat password
                <input type="password" name="password_repeat">
            </label>
            <input type="submit">
        </form>
    </body>
</html>
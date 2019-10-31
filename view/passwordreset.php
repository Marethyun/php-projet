<html lang="en">
    <head>
        <title>Reset password</title>
        <meta charset="UTF-8">
    </head>
    <body>
    <?php if (isset($GLOBALS[DATASET_ENTRY]['error'])) { ?>
        <p style="color: red"><?= $GLOBALS[DATASET_ENTRY]['error'] ?></p>
    <?php } ?>
        <form action="/?controller=reset" method="post">
            <label>
                Password
                <input type="password" name="password">
            </label>
            <label>
                Repeat password
                <input type="password" name="password_repeat">
            </label>
            <input type="hidden" name="reset_token" value="<?= $GLOBALS[DATASET_ENTRY]['reset_token'] ?>">
            <input type="submit">
        </form>
    </body>
</html>
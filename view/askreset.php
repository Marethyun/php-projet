<html lang="en">
    <head>
        <title>Reset password</title>
        <meta charset="UTF-8">
    </head>
    <body>
    <?php if (isset($GLOBALS[DATASET_ENTRY]['error'])) { ?>
        <p style="color: red"><?= $GLOBALS[DATASET_ENTRY]['error'] ?></p>
    <?php } ?>
    <?php if (isset($GLOBALS[DATASET_ENTRY]['success'])) { ?>
        <p style="color: green"><?= $GLOBALS[DATASET_ENTRY]['success'] ?></p>
    <?php } ?>
        <form action="/?controller=askreset" method="post">
            <label>
                Email
                <input type="email" name="email">
            </label>
            <input type="submit">
        </form>
    </body>
</html>
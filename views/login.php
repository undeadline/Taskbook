<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <?php include 'parts/css.php'; ?>
</head>
<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">

            <h3>Login</h3>
            <!-- Login Form -->
            <form action="/login" method="post">
                <input type="text" class="fadeIn second" name="login" placeholder="login">
                <?php if (request()->error('login')) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo request()->first('login'); ?>
                    </div>
                <?php } ?>
                <input type="password" class="fadeIn third" name="password" placeholder="password">
                <?php if (request()->error('password')) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo request()->first('password'); ?>
                    </div>
                <?php } ?>
                <input type="submit" class="fadeIn fourth">
            </form>
            <?php if (request()->error('auth')) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo request()->first('auth'); ?>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php include 'parts/js.php'; ?>
</body>
</html>
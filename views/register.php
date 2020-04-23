<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <?php include 'parts/css.php'; ?>
</head>
<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">

            <h3>Register</h3>
            <!-- Login Form -->
            <form action="/register" method="post">
                <input type="text" class="fadeIn third" name="username" placeholder="username">
                <input type="text" class="fadeIn second" name="login" placeholder="login">
                <input type="password" class="fadeIn third" name="password" placeholder="password">
                <input type="submit" class="fadeIn fourth">
            </form>

        </div>
    </div>
    <?php include 'parts/js.php'; ?>
</body>
</html>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <?php include dirname(__FILE__) . '/../parts/css.php'; ?>
</head>
<body>
    <?php include dirname(__FILE__) . '/../parts/menu.php'; ?>
    <div class="container">
        <form action="/tasks/<?php echo $task->id ?>" method="post" class="mt-2 w-25">
            <div class="form-group">
                <label>Username</label>
                <input disabled type="text" class="form-control" value="<?php echo $task->name ?>">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input disabled type="text" class="form-control" value="<?php echo $task->email ?>">
            </div>
            <div class="form-group">
                <label>Task</label>
                <textarea class="form-control" rows="3" name="text"><?php echo $task->text ?></textarea>
            </div>
            <div class="form-group">
                <select class="custom-select my-1 mr-sm-2" name="status">
                    <option <?php if ($task->status === 'New') { echo 'selected'; } ?> value="New">New</option>
                    <option <?php if ($task->status === 'Done') { echo 'selected'; } ?> value="Done">Done</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>

    <?php include dirname(__FILE__) . '/../parts/js.php'; ?>
</body>
</html>
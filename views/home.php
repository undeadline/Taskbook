<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Taskbook</title>
    <?php include 'parts/css.php'; ?>
</head>
<body>

    <?php if (request()->session()->has('success'))
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        ' . request()->session()->get('success') . '        
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>';
    ?>

    <?php

    include 'parts/menu.php';

    if ($tasks) { ?>
    <div class="container pt-2">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th><a href="<?php (request()->has(['f','s']) && request()->query('s') === 'asc') ? print('/?f=name&s=desc') : print('/?f=name&s=asc'); ?>">Username</a></th>
                    <th><a href="<?php (request()->has(['f','s']) && request()->query('s') === 'asc') ? print('/?f=email&s=desc') : print('/?f=email&s=asc'); ?>">Email</a></th>
                    <th>Task</th>
                    <th><a href="<?php (request()->has(['f','s']) && request()->query('s') === 'asc') ? print('/?f=status&s=desc') : print('/?f=status&s=asc'); ?>">Status</a></th>
                    <?php if (auth()) { echo '<th>Action</th>'; } ?>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (auth()) {
                        foreach($tasks as $task) {
                            $edited = $task->edited ? '<span class="badge badge-warning">Admin Edited</span>' : '';
                            echo "
                                <tr>
                                    <td>$task->name</td>
                                    <td>$task->email</td>
                                    <td>$edited $task->text</td>
                                    <td>{$task->status}</td>
                                    <td>
                                        <a href='/tasks/$task->id'>
                                            Update
                                        </a>
                                    </td>
                                </tr>
                            ";
                        }
                    } else {
                        foreach($tasks as $task) {
                            $edited = $task->edited ? '<span class="badge badge-warning">Admin Edited</span>' : '';
                            echo "
                                <tr>
                                    <td>$task->name</td>
                                    <td>$task->email</td>
                                    <td>$edited $task->text</td>
                                    <td>$task->status</td>
                                </tr>
                            ";
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>

    <?php
        echo $links;
    ?>

    <?php } else { ?>

    <div class="container pt-2">
        <h5>Taskbook is empty</h5>
    </div>

    <?php } ?>

    <!-- Modal Create Task -->
    <div class="modal fade <?php request()->session()->has('errors') ? print('show') : print(''); ?>" id="newTask" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Create new task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/tasks" method="post" id="task-create-form">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Username</label>
                            <input type="text" class="form-control" placeholder="Enter username" name="name">
                            <?php if (request()->error('name')) { ?>
                                <div class="alert alert-danger mt-2" role="alert">
                                    <?php print(request()->first('name')) ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Email</label>
                            <input type="email" class="form-control" placeholder="Enter Email" name="email">
                            <?php if (request()->error('email')) { ?>
                                <div class="alert alert-danger mt-2" role="alert">
                                    <?php print(request()->first('email')) ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Task description</label>
                            <textarea class="form-control" rows="3" name="text"></textarea>
                            <?php if (request()->error('text')) { ?>
                                <div class="alert alert-danger mt-2" role="alert">
                                    <?php print(request()->first('text')) ?>
                                </div>
                            <?php } ?>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" form="task-create-form" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <?php include 'parts/js.php'; ?>
</body>
</html>
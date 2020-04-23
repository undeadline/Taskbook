<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">Taskbook</a>
        <div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newTask">New Task</button>
            <?php if (auth()) { ?>
                <a href="/logout" class="btn btn-secondary">Logout</a>
            <?php } else { ?>
                <a href="/login" class="btn btn-secondary">Login</a>
            <?php } ?>
        </div>
    </div>
</nav>
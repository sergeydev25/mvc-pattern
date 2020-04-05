<?php require "header.php"; ?>

<div style="max-width: 330px; margin: 0 auto">
    <h1>Please sign in</h1>

    <?php
    if ($data['error']) {?>
        <div class="alert alert-danger" role="alert">
            <?=$data['error']?>
        </div>
    <?php } ?>
    <form action="" method="post">
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required placeholder="Enter email">
        </div>
        <div class="form-group">
            <label for="email">Password</label>
            <input type="password" class="form-control" id="password" name="password" required placeholder="Enter password">
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    </form>
</div>

<?php require "footer.php"; ?>

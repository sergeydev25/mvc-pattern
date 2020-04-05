<?php require "header.php"; ?>

<h1>Create task</h1>

<form action="" method="post">
    <div class="form-group">
        <label for="user_name">User name</label>
        <input type="text" class="form-control" id="user_name" name="user_name" required placeholder="Enter user name">
    </div>
    <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control" id="email" name="email" required placeholder="Enter email">
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
    </div>
    <a href="/" class="btn btn-light">Back</a>
    <button type="submit" class="btn btn-primary">Save</button>
</form>

<?php require "footer.php"; ?>

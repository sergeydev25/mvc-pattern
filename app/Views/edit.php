<?php require "header.php"; ?>
    <h1>Edit task</h1>

    <form action="" method="post">
        <div class="form-group">
            <label for="user_name">User name</label>
            <input type="text" class="form-control" id="user_name" name="user_name" required placeholder="Enter user name" value="<?=$data['user_name']?>">
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required placeholder="Enter email" value="<?=$data['email']?>">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required><?=$data['description']?></textarea>
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="is_done" name="is_done" <?=$data['is_done'] ? 'checked' : ''?>>
            <label class="form-check-label" for="is_done">Task is done</label>
        </div><br>
        <a href="/" class="btn btn-light">Back</a>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>

<?php require "footer.php"; ?>


<?php use Core\Auth;

require "header.php"; ?>

    <h1>List tasks</h1>

    <div>
        <a href="/task/create" class="btn btn-primary">Create</a>
    </div><br>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">ID</th>
            <th scope="col">
                <div class="sort-column" id="user_name" style="cursor: pointer">
                    User name <i class="fa fa-fw fa-sort"></i>
                </div>
            </th>
            <th scope="col">
                <div class="sort-column" id="email" style="cursor: pointer">
                    Email <i class="fa fa-fw fa-sort"></i>
                </div>
            </th>
            <th scope="col">Description</th>
            <th scope="col">
                <div class="sort-column" id="is_done" style="cursor: pointer">
                    Status <i class="fa fa-fw fa-sort"></i>
                </div>
            </th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php $cnt = 0;?>
        <?php foreach ($data['data'] as $item) {?>
            <?php ++$cnt?>
            <tr>
                <th scope="row"><?=$cnt?></th>
                <td><?=$item['id']?></td>
                <td><?=$item['user_name']?></td>
                <td><?=$item['email']?></td>
                <td><?=$item['description']?></td>
                <td><?=$item['is_done'] ? 'Done' : ''?></td>
                <td>
                    <?php if (Auth::isAuth()) {?>
                        <a href="/task/edit/<?=$item['id']?>">Edit</a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

<?php require "paginator.php"; ?>
<?php require "footer.php"; ?>

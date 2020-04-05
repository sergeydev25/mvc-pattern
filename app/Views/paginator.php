<?php if ($data['paginator']['all_pages'] > 1) {?>
    <div>
        <nav>
            <ul class="pagination">
                <?php
                $query = $_GET;
                for ($i = 1; $i <= $data['paginator']['all_pages']; ++$i) {?>
                <li class="page-item <?=$data['paginator']['current_page'] == $i ? 'active' : ''?>">
                    <?php
                    $url = "#";
                    if ($data['paginator']['current_page'] != $i) {
                        $query['page'] = $i;
                        $url = '?' . http_build_query($query);
                    }
                    ?>
                    <a class="page-link" href="<?=$url?>"><?=$i?></a>
                </li>
                <?php } ?>
            </ul>
        </nav>
    </div>
<?php } ?>
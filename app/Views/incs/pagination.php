<nav aria-label="Page navigation example">
    <ul class="pagination">

        <?php if (!empty($first_page)) : ?>
            <li class="page-item">
                <a class="page-link" data-page=1 href="<?= $first_page ?>" aria-label="First page">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php endif; ?>
        <?php if (!empty($back)) : ?>
            <li class="page-item">
                <a class="page-link" data-page="<?= $current_page - 1 ?>" href="<?= $back ?>" aria-label="Previous page">
                    <span aria-hidden="true">&lt;</span>
                </a>
            </li>
        <?php endif; ?>

        <?php if (!empty($pages_left)) :
            foreach ($pages_left as $item) : ?>
                <li class="page-item">
                    <a class="page-link" data-page="<?= $item['number'] ?>" href="<?= $item['link'] ?>">
                        <?= $item['number'] ?>
                    </a>
                </li>
            <?php endforeach;
        endif; ?>

        <li class="page-item active">
            <a class="page-link" >
                <?= $current_page ?>
            </a>
        </li>

        <?php if (!empty($pages_right)) :
            foreach ($pages_right as $item) : ?>
                <li class="page-item">
                    <a class="page-link" data-page="<?= $item['number'] ?>" href="<?= $item['link'] ?>">
                        <?= $item['number'] ?>
                    </a>
                </li>
            <?php endforeach;
        endif; ?>

        <?php if (!empty($forward)) : ?>
            <li class="page-item">
                <a class="page-link" data-page="<?= $current_page + 1 ?>" href="<?= $forward ?>" aria-label="Next page">
                    <span aria-hidden="true">&gt;</span>
                </a>
            </li>
        <?php endif; ?>
        <?php if (!empty($last_page)) : ?>
            <li class="page-item">
                <a class="page-link" data-page="<?= $count_pages ?>" href="<?= $last_page ?>" aria-label="last_page">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        <?php endif; ?>

    </ul>
</nav>
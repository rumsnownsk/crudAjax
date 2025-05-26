<?php if (!empty($cities)): ?>
    <table class="table table-hover">
        <thead class="table-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">City</th>
            <th scope="col">Population</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($cities as $city) : ?>
            <tr id="city-<?= $city['id'] ?>">
                <th scope="row"><?= $city['id'] ?></th>
                <td class="name"><?= $city['name'] ?></td>
                <td class="population"><?= $city['population'] ?></td>
                <td>
                    <button class="btn btn-info btn-edit"
                            data-id="<?= $city['id'] ?>"
                            data-bs-toggle="modal"
                            data-bs-target="#editCity">Edit
                    </button>
                    <button class="btn btn-danger btn-delete" data-id="<?= $city['id'] ?>">Delete</button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Нет городов в базе данных</p>
<?php endif; ?>

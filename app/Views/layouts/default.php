<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>CRUD AJAX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
<!---content---->
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center h2 my-3">CRUD AJAX</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-md-6">

                    <button class="btn btn-primary rounded-0 btn-add" data-bs-toggle="modal" data-bs-target="#addCity">
                        add
                        City
                    </button>
                </div>
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <input type="text" id="search" class="form-control" placeholder="Search...">
                        <span class="input-group-text" id="clear-search">&times;</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div id="loader">
        <img src="/assets/ripple.svg" alt="">
    </div>
    <section id="content" class="content">
        <?= /** @var string $content */
        $content; ?>
    </section>

    <!---//end_content---->
</div>


<!-- Modal Редактировать город -->
<div class="modal fade" id="editCity" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel2">Редактировать город</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Редактировать город # <span id="editCity_id"></span></p>

                <form method="post" action="" id="updateCityForm">
                    <div class="mb-3">
                        <label for="editName" class="form-label">Name</label>
                        <input type="text" name="editName" class="form-control" id="editName"
                               placeholder="название города"
                               value="">
                    </div>

                    <div class="mb-3">
                        <label for="editPopulation" class="form-label">Population</label>
                        <input type="number" name="editPopulation" class="form-control" id="editPopulation"
                               placeholder="население" value="">


                        <input type="hidden" name="getCity">
                        <input type="hidden" name="editCity_id" id="editCity_id">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btn-edit-submit">Update City
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modals Добавить город-->

<div class="modal fade" id="addCity" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Добавить город</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="" id="addCityForm">
                    <div class="mb-3">
                        <label for="addName" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="addName" placeholder="название города">
                    </div>
                    <div class="mb-3">
                        <label for="addPopulation" class="form-label">Population</label>
                        <input type="number" name="population" class="form-control" id="addPopulation"
                               placeholder="население">
                        <input type="hidden" name="addCity">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btn-add-submit">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
<!--<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>-->

<script src="assets/js/mark.min.js"></script>
<script src="assets/js/sweetalert2.all.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
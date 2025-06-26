const divContent = document.querySelector('.content')
const table = document.querySelector('.table-responsive')
// delegate events (делегирование событий)
divContent.addEventListener('click', (e) => {
    // pagination
    if (e.target.className === 'page-link') {
        e.preventDefault()
        let page = +e.target.dataset.page; // "+" - означает привести к значению integer

        let searchParams = new URLSearchParams({page: page}).toString();

        if (page) {
            fetch(`/pgn?${searchParams}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    document.querySelector(".countCities").innerHTML = data.countCities
                    document.querySelector(".pagination").innerHTML = data.pagination
                    table.innerHTML = data.table
                });
        }
    }

    // Get City for edit
    if (e.target.classList.contains('btn-edit')) {
        let id = +e.target.dataset.id;
        if (id) {
            // console.log('str32 = ' + id)

            let searchParams = new URLSearchParams({
                id: id,
                action: 'getCity'
            });
            fetch(`/getCity?${searchParams}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    // console.log(data)
                    if (data.answer === 'success') {
                        document.getElementById('editName').value = data.city.name;
                        document.getElementById('editPopulation').value = data.city.population;
                        document.getElementById('city_id').value = data.city.id;
                        document.getElementById('header_city_id').innerHTML = data.city.id;
                    }
                })
        }
    }

    // delete City
    if (e.target.classList.contains('btn-delete')) {
        let id = +e.target.dataset.id;
        if (id) {
            console.log('str62 = ' + id)

            let searchParams = new URLSearchParams({
                id: id,
                action: 'deleteCity'
            }).toString();
            fetch(`/deleteCity`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: searchParams
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.answer === 'success') {
                        setTimeout(() => {
                            Swal.fire({
                                title: data.answer,
                                icon: data.answer,
                                html: data?.errors,
                                confirmButtonText: 'City is deleted'
                            });
                            if (data.answer === 'success') {
                                let tr = document.getElementById(`city-${id}`);
                                tr.remove()

                                addCityForm.reset();
                            }

                        }, 1000)
                    }
                })
        }
    }
})

// Update city
const updateCityForm = document.getElementById('updateCityForm')
const btnUpdateSubmit = document.getElementById('btn-edit-submit')

updateCityForm.addEventListener('submit', (e) => {
    e.preventDefault()
    // updateCityForm.textContent = 'Saving...'
    btnUpdateSubmit.disabled = true

    fetch('/updateCity', {
        method: 'post',
        headers: {
            // 'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new FormData(updateCityForm)
    })
        .then((response) => response.json())
        .then((data) => {
            setTimeout(() => {
                Swal.fire({
                    title: data.answer,
                    icon: data.answer,
                    html: data?.errors,
                    confirmButtonText: 'Cool'
                });
                if (data.answer === 'success') {
                    let idValue = document.getElementById('city_id').value;
                    let populationValue = document.getElementById('editPopulation').value;
                    let nameValue = document.getElementById('editName').value;
                    console.log('idValue = ' + idValue)
                    console.log('populationValue = ' + populationValue)
                    console.log('nameValue = ' + nameValue)

                    let tr = document.getElementById(`city-${idValue}`);
                    tr.querySelector('.name').innerHTML = nameValue;
                    tr.querySelector('.population').innerHTML = populationValue;
                }
                btnUpdateSubmit.textContent = 'Update';
                btnUpdateSubmit.disabled = false;
            }, 1000)
        })
})

// add city
const addCityForm = document.getElementById('addCityForm')
const btnAddSubmit = document.getElementById('btn-add-submit')

addCityForm.addEventListener('submit', (e) => {
    e.preventDefault()
    btnAddSubmit.textContent = 'Saving...'
    btnAddSubmit.disabled = true

    let form = new FormData(addCityForm)

    fetch('/addCity', {
        method: 'post',
        // headers: {
        //     'Accept': 'application/json',
        //     'Content-Type': 'application/json'
        // },
        body: new FormData(addCityForm)
    })
        .then((response) => response.json())
        .then((data) => {
            console.log(data)
            setTimeout(() => {
                Swal.fire({
                    title: data.answer,
                    icon: data.answer,
                    html: data?.errors,
                    confirmButtonText: 'Cool'
                });
                if (data.answer === 'success') {
                    addCityForm.reset();
                }
                btnAddSubmit.textContent = 'Save';
                btnAddSubmit.disabled = false;
            }, 1000)
        })
})

const sField = document.getElementById('search');
const loader = document.getElementById('loader');

sField.addEventListener('input', (e) => {
    let search = e.target.value.trim();
    if (search.length > 2) {
        // console.log(search)
        let searchParams = new URLSearchParams({
            search: search
        }).toString();
        fetch(`/search`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: searchParams
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.answer === 'success') {
                    loader.style.display = 'block';
                    setTimeout(() => {
                        table.innerHTML = data.table
                        let instance = new Mark(table)
                        instance.mark(search);
                        document.querySelector(".pagination").innerHTML = data.pagination
                        loader.style.display = 'none';
                    }, 500);

                }
            })
    } else if (search.length === 0) {
        let searchParams = new URLSearchParams({
            action: 'reloadTable'
        }).toString();
        fetch('/reloadTable?${searchParams}', {
            method: 'get',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
        })
            .then((response) => response.json())
            .then((data) => {
                document.querySelector(".countCities").innerHTML = data.countCities
                document.querySelector(".pagination").innerHTML = data.pagination
                table.innerHTML = data.table
            });
    }

})

document.getElementById('clear-search').addEventListener('click', () => {
    sField.value = '';
    let searchParams = new URLSearchParams({page: 1}).toString();

    fetch(`/pgn?${searchParams}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
    })
        .then((response) => response.json())
        .then((data) => {
            document.querySelector(".countCities").innerHTML = data.countCities
            document.querySelector(".pagination").innerHTML = data.pagination
            table.innerHTML = data.table
        });
})


const divContent = document.querySelector('.content')
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
                    document.querySelector(".table-responsive").innerHTML = data.table
                });
        }
    }

    // Get City for edit
    if (e.target.classList.contains('btn-edit')) {
        let id = +e.target.dataset.id;
        if (id) {
            console.log('str32 = ' + id)

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
                    console.log(data)
                    if (data.answer === 'success') {
                        document.getElementById('editName').value = data.city.name;
                        document.getElementById('editPopulation').value = data.city.population;
                        document.getElementById('editCity_id').innerHTML = data.city.id;
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
updateCityForm = document.getElementById('updateCityForm')
btnUpdateSubmit = document.getElementById('btn-edit-submit')

updateCityForm.addEventListener('submit', (e) => {
    e.preventDefault()
    updateCityForm.textContent = 'Saving...'
    btnUpdateSubmit.disabled = true

    let formData = new FormData(updateCityForm)
    formData.append('someKey', 'someValue')

    console.log(formData.get('name'))
    console.log(formData.get('someKey'))

    fetch('/updateCity', {
        method: 'post',
        body: formData
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
                    console.log(data)
                    // let idValue = document.getElementById('editCity_id').value;
                    // let nameValue = document.getElementById('editName').value;
                    // let populationValue = document.getElementById('editPopulation').value;
                    // let tr = document.getElementById(`city-${idValue}`);
                    // tr.querySelector('.name').innerHTML = nameValue;
                    // tr.querySelector('.population').innerHTML = populationValue;


                }
                btnUpdateSubmit.textContent = 'Save';
                btnUpdateSubmit.disabled = false;
            }, 1000)

        })
})

// add city
addCityForm = document.getElementById('addCityForm')
btnAddSubmit = document.getElementById('btn-add-submit')

addCityForm.addEventListener('submit', (e) => {
    e.preventDefault()
    btnAddSubmit.textContent = 'Saving...'
    btnAddSubmit.disabled = true

    let form = new FormData(addCityForm)

    console.log(addCityForm)

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
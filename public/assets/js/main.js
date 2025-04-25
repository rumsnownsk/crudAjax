$(function () {


    /* подсветка активного пункта меню в Навигации */
    let currentUri = location.origin + location.pathname.replace(/\/$/, '');
    $('.menu a').each(function () {
        let href = this.href.replace(/\/$/, '');
        if (currentUri === href) {
            $(this).addClass('active')
        }
    })

    let iziModalAlertSuccess = $('.iziModal-alert-success')
    let iziModalAlertError = $('.iziModal-alert-error')

    iziModalAlertSuccess.iziModal({
        padding: 20,
        title: 'Success',
        headerColor: '#00897b'
    })
    iziModalAlertError.iziModal({
        padding: 20,
        title: 'Error',
        headerColor: '#e53935'
    })


    /* отправка заявки для рассмотрения стоимости
    * получения Паспорта Фасада */
    $('.ajax-form').on('submit', function (e) {
        e.preventDefault();
        let form = $(this);
        let btn = form.find('button');
        let btnText = btn.text();
        let method = form.attr('method');
        if (method) {
            method = method.toLowerCase();
        }

        let action = form.attr('action') ? form.attr('action') : location.href;

        $.ajax({
            url: action,
            type: method === 'post' ? 'post' : 'get',
            data: form.serialize(),
            beforeSend: function () {
                btn.prop('disable', true).text('Отправляю...');
            },
            success: function (res) {
                res = JSON.parse(res);
                if (res.status === 'success'){
                    iziModalAlertSuccess.iziModal('setContent', res.data)
                    form.trigger('reset')
                    iziModalAlertSuccess.iziModal('open')
                    if (res.redirect){
                        $(document).on('closed', iziModalAlertSuccess, function (e) {
                            location = res.redirect
                        });
                    }
                } else {
                    iziModalAlertError.iziModal('setContent', {
                        content: res.data,
                    })
                    iziModalAlertError.iziModal('open')
                }
                btn.prop('disable', false).text(btnText);
            },
            error: function () {
                alert('server error');
                btn.prop('disable', false).text(btnText);
            }
        })
    })

    /* ajax-подгрузка контента на странице
    * Порядок получения паспорта */
    $(document).on('click', '.step_item', function (e) {
        $('a[data-id]').removeClass('active');
        e.preventDefault();

        let message = 'ok';
        let step_id = $(this).data('id') || 1;

        if (!step_id) {
            console.log('non is step_id')
            message = 'error with step_id'
            step_id = 1;
        }
        $(this).addClass('active');
        // $(this).css({'box-shadow': 'none'});

        $.ajax({
            url: '/ajaxRequest',
            type: 'get',
            dataType: "json",
            data: {
                step_id: step_id,
                message: message
            },
            success: function (res) {
                let el = document.querySelector('#desc_proc')
                el.remove();
                $('#proc_desc_area').append(res.page_step)
            },
            error: function () {
                console.log('ошибочка');
            }
        });
    })

    /* ajax-загрузка контента
     в зависимости от Категории
     на странице Готовые паспорта */
    $(document).on('click', '#categories a', function (e) {
        $('a#loadMore').prop("hidden", false)
        $('a[data-id]').removeClass('active');
        countClick = 0
        e.preventDefault();
        let message = 'ok';
        let catId = $(this).data('id');

        // if (!category_id) {
        //     console.log('non is category_id')
        //     message = 'error with step_id'
        //     category_id = 1;
        // }
        $(this).addClass('active');

        $.ajax({
            url: '/worksByCategoryId?catId='+catId,
            type: 'get',
            dataType: "json",
            data: {
                catId: catId,
                message: message
            },
            success: function (res) {
                $('#listWorks').empty()
                $('#listWorks').append(res.worksPage)
            },
            error: function () {
                console.log('ошибочка');
            }
        });
    })

    /* ajax-подгрузка ПАГИНАЦИЯ контента на странице
        "Готовые паспорта"
        при нажатии кнопки ЗАГРУЗИТЬ ЕЩЁ */
    let countClick = 0;
    $(document).on('click', 'a#loadMore', function (e) {
        e.preventDefault();

        let catId = '';
        console.log('old catId = '+catId)

        countClick = countClick + 1;
        catId = $('#categories a.active').data('id');
        console.log('catId = '+catId)
        console.log('countClick = '+countClick)

        $.ajax({
            url: "/loadMore",
            type: 'get',
            dataType: "json",
            data: {
                countClick: countClick,
                catId: catId
            },
            success: function (res) {
                if (res.status === false){
                    $('a#loadMore').prop("hidden", true)
                }
                let el = $('#listWorks')
                el.append(res.worksPage)
            },
            error: function () {
                console.log('ошибочка');
            }
        });
    })
})

/* ajax-загрузка контента
    при ПЕРВОЙ ЗАГРУЗКЕ страницы
    "Готовые паспорта" */
document.addEventListener('DOMContentLoaded', function () {
    setTimeout(function () {
        if (location.pathname === '/works'){
            let message = 'allWorks'
            $.ajax({
                url: "/allWorks",
                type: 'get',
                dataType: "json",
                data: {
                    message: message,
                },
                success: function (res) {
                    console.log('message = '+ res.message)
                    $('#listWorks').append(res.worksPage)
                    $("a#loadMore")
                        .prop("hidden", false)
                        .attr("href", $(location).attr('href'))
                },
                error: function () {
                    console.log('ошибочка: load all works');
                }
            });
        }
    }, 500); // Delay of 0.5 seconds
});




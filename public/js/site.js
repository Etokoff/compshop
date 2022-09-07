jQuery(document).ready(function($) {
    /*
     * Общие настройки ajax-запросов, отправка на сервер csrf-токена
     */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
/*
 * Пагинация
 */
    $('#pagination').change(function () {
        let uri = window.location.href.split('?')[0] + '?orderBy=' + $('#dropdownSortButton').attr('data-order');
        let pagination = $(this).val();
        uri = uri + '&pagination=' + pagination;
        $('.form-check-input').each(function (i, elem) {
            if (elem.checked) {
                uri = uri + '&';
                uri = uri + elem.name + "=yes";
            }
        });
        $.ajax({
            url: uri,
            type: 'GET',
            success: (data) => {
                $('#products').html(data);
                //console.log(data);
            },
        });
    });
/*
 * Соритровка
 */
    $('.sorting_item').click(function() {
        let orderBy = $(this).data('order');
        let uri = window.location.href.split('?')[0];
        //var strGET = window.location.search.replace( '?', '');
        //if (strGET.length>0) {
            //uri = uri + "&orderBy=" + orderBy;
        //} else {

        uri = uri + "?orderBy=" + orderBy;

        $('.form-check-input').each(function (i, elem) {
            if (elem.checked) {
                uri = uri + '&';
                uri = uri + elem.name + "=yes";
            }
        });
        $.ajax({
            url: uri,
            type: 'GET',
            success: (data) => {
                $('#dropdownSortButton').html($(this).html());
                $('#dropdownSortButton').attr('data-order', orderBy);
                $('#products').html(data);
                //console.log(data);
            },
        });
    });
/*
 *  Фильтр по (новинка, хит, распродажа, скидка)
 */
    $('.form-check-input').click(function () {
        if($(this).val()=='yes') {
            let uri = window.location.href.split('?')[0] + '?orderBy=' + $('#dropdownSortButton').attr('data-order');
            $('.form-check-input').each(function (i, elem) {
                if (elem.checked) {
                    uri = uri + '&';
                    uri = uri + elem.name + "=yes";
                }
            });
            $.ajax({
                url: uri,
                type: 'GET',
                success: (data) => {
                    $('#products').html(data);
                    //console.log(data);
                }
            });
        }
    });
/*
 * Получение данных профиля пользователя при оформлении заказа
 */
    $('form#profiles button[type="submit"]').hide();
    // при выборе профиля отправляем ajax-запрос, чтобы получить данные
    $('form#profiles select').change(function () {
        // если выбран элемент «Выберите профиль»
        if ($(this).val() == 0) {
            // очищаем все поля формы оформления заказа
            $('#checkout').trigger('reset');
            return;
        }
        var data = new FormData($('form#profiles')[0]);
        $.ajax({
            url: '/basket/profile',
            data: data,
            processData: false,
            contentType: false,
            type: 'POST',
            dataType: 'JSON',
            success: function(data) {
                $('input[name="name"]').val(data.profile.name);
                $('input[name="email"]').val(data.profile.email);
                $('input[name="phone"]').val(data.profile.phone);
                $('input[name="address"]').val(data.profile.address);
                $('textarea[name="comment"]').val(data.profile.comment);
            },
            error: function (reject) {
                alert(reject.responseJSON.error);
            }
        });
    });
    /*
     * Добавление товара в корзину с помощью ajax-запроса без перезагрузки
     */
    $('form.add-to-basket').submit(function (e) {
        // отменяем отправку формы стандартным способом
        e.preventDefault();
        // получаем данные этой формы добавления в корзину
        var $form = $(this);
        var data = new FormData($form[0]);
        $.ajax({
            url: $form.attr('action'),
            data: data,
            processData: false,
            contentType: false,
            type: 'POST',
            dataType: 'HTML',
            beforeSend: function () {
                //var spinner = ' <span class="spinner-border spinner-border-sm"></span>';
                //$form.find('button').append(spinner);
            },
            success: function(html) {
                //$form.find('.spinner-border').remove();
                $('#top-basket').html(html);
                //alert(html);
            }
        });
    });
});

/*
 * Раскрытие и скрытие пунктов меню каталога в левой колонке
 */
//$('#catalog-sidebar > ul ul').hide();
function ToggleCatalog(element) {
    var $badge = $(element);
    var closed = $badge.siblings('ul') && !$badge.siblings('ul').is(':visible');
    var id1 = $badge.siblings('ul').attr('id');

    if (closed) {
        $.ajax({
            url: '/catalog/category/menu/' + id1,
            data: {},
            type: 'GET',
            success: function (result) {
                $badge.siblings('ul').html(result);
            },
            error: function (reject) {
                alert(reject.responseJSON.error);
            }
        });
        $badge.siblings('ul').slideDown('normal', function () {
            $badge.children('i').removeClass('fa-plus').addClass('fa-minus');
        });
    } else {
        $badge.siblings('ul').slideUp('normal', function () {
            $badge.children('i').removeClass('fa-minus').addClass('fa-plus');
        });
    }
};

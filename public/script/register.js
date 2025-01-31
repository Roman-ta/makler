$(document).ready(function () {
    $('.header__register a').click(function (e) {
        e.preventDefault()
        if($('.auth').find('.modal-register').length > 0){
            $('.modal-register').css('display', 'block');
            return;
        }
        $.ajax({
            url: "forms",
            method: "POST",
            data : {action : 'register'},
            success: function (response) {
                $('.auth').append(response)

            }, error: function (error) {
                console.log(error)
            }
        })
    })

    $('.auth').on('click', '.modal-block__close', function () {
        $('.modal-register').css('display', 'none');
    })

// Ползунок переключения Phone - email
    $('.auth').on('click', '.slider-method__line', function () {
        $('.slider-method__circle').toggleClass('slider-method__active');
        $('.modal-form__email').toggleClass('modal-form__active');
        $('.modal-form__phone').toggleClass('modal-form__disable');
    })
});


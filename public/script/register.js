$(document).ready(function () {
    $('.header__register a').click(function (e) {
        e.preventDefault()
        $.ajax({
            url: "register",
            method: "POST",
            success: function (response) {
                $('.auth').append(response)

            }, error: function (error) {
                console.log(error)
            }
        })
    })

    $('.auth').on('click', '.modal-block__close', function () {
        $('.auth__container').css('display', 'none');
    })

// Ползунок
    $('.slider-method__line').click(function (){
        $('.slider-method__circle').toggleClass('slider-method__active');
        $('.modal-form__email').toggleClass('modal-form__active');
        $('.modal-form__phone').toggleClass('modal-form__disable');
    })

});


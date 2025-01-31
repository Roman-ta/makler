$(document).ready(function () {
    $('.header__signin a').click(function (e) {
        e.preventDefault()
        if($('.auth').find('.modal-auth').length > 0){
            $('.modal-auth').css('display', 'block');
            return;
        }
        $.ajax({
            url: "forms",
            method: "POST",
            data : {action : 'auth'},
            success: function (response) {
                $('.auth').append(response)

            }, error: function (error) {
                console.log(error)
            }
        })
    })

    $('.auth').on('click', '.modal-block__close', function () {
        $('.modal-auth').css('display', 'none');
    })
});


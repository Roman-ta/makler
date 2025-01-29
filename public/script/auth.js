$(document).ready(function () {
    $('.header__signin a').click(function (e) {
        e.preventDefault()
        $.ajax({
            url: "auth",
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
});


$('.header__signin a').click(function (e){
   e.preventDefault()
    $.ajax({
        url:"auth",
        method: "POST",
        success: function (response){
            $('.auth').html(response)
        }, error: function (error){
            console.log(error)
        }
    })
})
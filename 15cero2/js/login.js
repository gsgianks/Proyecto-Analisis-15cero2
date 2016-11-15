$(document).ready(function () {
  //  alert("hola");
    $('form').submit(function (e) {

        e.preventDefault();

        var data = $(this).serializeArray();
        //alert($(this).children("#tipo").val());
        $.ajax({
            url: 'controladoras/LoginController.php',
            type: 'post',
            dataType: 'json',
            data: data,
            success: function (resp) {
                if (resp.success === true) {
                    $('.login-section').fadeOut(500,function(){
                        $('.login-section').remove();
                        $('.links').css('height','2.5em');
                    });
                }
                else {
       //             alert(resp.rol);
                    $("#mensaje").html("*Usuario y/o contraseña incorrectos");
                }
            },
            error: function (jqXHR, estado, error) {
                alert('error log');
                console.log("fallo");
            }
        });
    });
});

$(document).ready(function () {
    //alert("informe");
    sumarTotal("informe_activos",4);
});

function sumarTotal(tabla, columna) {
    
    var resultVal = 0.0; 
         
    $("#"+tabla+" tbody tr").not(':first').not(':last').each(
        function() {
          //  alert($(this).find('td:eq(' + columna + ')'));
            var celdaValor = $(this).find('td:eq(' + columna + ')');
            var cantidad = $(this).find('td:eq(2)');
            var precio = $(this).find('td:eq(3)');

            $(this).find('td:eq(4)').text(parseFloat(precio.html().replace(',','.'))*parseFloat(cantidad.html().replace(',','.')));
            if (celdaValor.val() != null)
                    resultVal += parseFloat(celdaValor.html().replace(',','.'));   
        } //function
         
    ); //each
    $("#" + tabla + " tbody tr:last td:eq("+columna+")").html(resultVal.toFixed(2).toString().replace('.',','));   
}


function descuento(){
    $("#total").text(parseInt($("#total").text())-((parseInt($("#total").text())*$("#descuento").val())/100));
    $("#descuento").val("");
}
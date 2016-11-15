$(document).ready(function () {
    sumarTotal("informe_activos",2);
});

function sumarTotal(tabla, columna) {
    
    var resultVal = 0.0; 
         
    $("#"+tabla+" tbody tr").not(':first').not(':last').each(
        function() {
            alert($(this).find('td:eq(' + columna + ')'));
            var celdaValor = $(this).find('td:eq(' + columna + ')');
            
            if (celdaValor.val() != null)
                    resultVal += parseFloat(celdaValor.html().replace(',','.'));   
        } //function
         
    ); //each
    $("#" + tabla + " tbody tr:last td:eq("+columna+")").html(resultVal.toFixed(2).toString().replace('.',','));   
}
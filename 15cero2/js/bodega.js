$(document).ready(
    function(){
        $.ajax({
            url:'controladoras/BodegaController.php',
            data:{consulta:'bodegaPrincipal'},
            type:'post',
            dataType:'json',
            success:function(response){
                console.log(response);
                tbody=$('.replaceable');
                temp=tbody.clone();
                for(i=0;i<response.length;i++){
                    console.log(response[i]);
                    str='<tr>'+
                    '<td>'+response[i][0]+'</td>'+
                    '<td>'+response[i][1]+'</td>'+
                    '<td>'+response[i][2]+'</td></tr>';
                }
                console.log(str);
                temp.append(str);
                tbody.replaceWith(temp);
            },
            error:function(){alert('Ocurrio un error');}
        });
});
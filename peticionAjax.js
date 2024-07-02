
$(document).ready(function() {
    $("#buscador").on('input', function() {
        hacerPeticionAjax();
    });
});

function hacerPeticionAjax(){
    var actividad = $("#buscador").val();
    $.ajax({
        data: { actividad: actividad },
        url: "ajax.php",
        type: "get",
        success: function(data){
            procesaRespuestaAjax(data);
            
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la petición AJAX:", textStatus, errorThrown);
            
        }
    });
}

function procesaRespuestaAjax(respuesta){
    var res = "";
    for(var i = 0; i < respuesta.length; i++){
        console.log(respuesta[i].nombreAct);
        if(respuesta[i].publicada == 0){
            res += "<div class='resultado'><a href='actividad.php?id=" + respuesta[i].idAct + "'>" + respuesta[i].nombreAct + " (No publicada)</a></div>";
        }
        else{
            res += "<div class='resultado'><a href='actividad.php?id=" + respuesta[i].idAct + "'>" + respuesta[i].nombreAct + "</a></div>";
        }
        
    }

    $("#resultados").html(res);
}

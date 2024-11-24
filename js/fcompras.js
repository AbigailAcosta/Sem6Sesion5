$(document).ready(function () {
    load(1);
});

function borrar(id) {
    window.setTimeout(function () {
    $(".alert")
        .fadeTo(1000,0)
        .slideUp(1000, function () {
            $(this).remove();
        });
    }, 3000);
    Swal.fire({
        title:"Borrar registro de compra?",
        text:"¡No podrás revertir esto!",
        type:"warning",
        showCancelButton:true,
        confirmButtonColor:"#27BDBB",
        cancelButtonColor:"#E86F54",
        confirmButtonText:"Aceptar",
        cancelButtonText:"Cancelar",
    }).then((result) => {
        if(result.value) {
            $.ajax({
                type:"GET",
                url:"compras/buscarfactura.php",
                data:"numero_compra="+ id,
                beforeSend:function(objeto) {
                    $("#resultados").html("Cargando...");
                },
                success:function (data) {
                    //window.location.href = "listaarticulos.php";
                    $("#resultados").html(data);
                    load(1);
                },
            });
        }
    });
}

function load(page) {
    var textobuscar = $("#textobuscar").val();
    var url ="compras/buscarfactura.php";
    $("#loader").fadeIn("slow");
    var parametros = {
        action: "ajax",
        page: page,
        q: textobuscar,
    };
    $.ajax({
        url: url,
        data: parametros,
        beforeSend: function(objeto) {
            $("#loader").html(
                '<img width="15%" heigth="15%" src="images/loading.gif"> Cargando...'
            );
        },
        success: function(data) {
            $("#salidas").html(data).fadeIn("slow");
            $("#loader").html("");
        },
    }).fail(function (jqXHR, textStatus, errorThrown) {
        if(jqXHR.status===404) {
            window.location.assign("/semana6/tallerpoophp/404page.php?u=" + url);
        }
    });
}

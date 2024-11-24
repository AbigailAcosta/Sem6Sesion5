$(document).ready(function() {
    load(1);

    $('#afactura').submit(function() {
        var numero = $('#numero').val();
        var idpersona = $('#idpersona').val();
        var idusuario = $('#idusuario').val();
        var estado = $('#estado').val();
        var fecha = $('#fecha').val();
        var fechavalida = moment().format('YYYY-MM-DD');

        if (idpersona < 1) {
            alert('Debes seleccionar un proveedor!');
            $('#idpersona').focus();
            return false;
        }

        if (fecha.length < 0 || fecha > fechavalida) {
            alert('Seleccionar fecha válida!');
            $('#fecha').focus();
            return false;
        }

        if (estado < 1) {
            alert('Debes seleccionar una condición!');
            $('#estado').focus();
            return false;
        }

        if (numero.length < 15) {
            alert('Ingrese numero de factura!');
            $('#numero').focus();
            return false;
        }

        WindowCenter('../pdf/compra_pdf.php?idproveedor=' + idpersona + '&numero=' + numero + '&fecha=' + fecha + '&estado=' + estado + '&idusuario=' + idusuario,'Planilla de Compra', '', '1024', '768', 'true');
    });
});

function load(page) {
    var q = $('#q').val();
    $('#loader').fadeIn('slow');
    var parametros = {
        'action': 'ajax',
        'page': page,
        'q': q
    };
    $.ajax({
        url: 'buscaritem.php',
        data: parametros,
        beforeSend: function(objeto) {
            $('#loader').html('<img width="10%" heigth="10%" src="../images/loading.gif"> Cargando...');
        },
        success: function(data) {
            $('#outer_div').html(data).fadeIn('slow');
            $('#loader').html('');
        }
    });
}

function agregar(id) {
    var precio = document.getElementById("precio_" + id).value;
    var cantidad = document.getElementById("cantidad_" + id).value;
    var concepto = document.getElementById("concepto_" + id).value;
    
    if (isNaN(precio)) {
        alert('Esto no es numero!');
        document.getElementById("precio_" + id).focus();
        return false;
    }
    
    if (isNaN(cantidad)) {
        alert('Esto no es numero!');
        document.getElementById("cantidad_" + id).focus();
        return false;
    }
    
    var parametros = {
        'idConcepto': id,
        'concepto': concepto,
        'unitario': precio,
        'cantidad': cantidad
    };

    $.ajax({
        type: 'POST',
        url: '../compras/agregarfacturaitem.php',
        data: parametros,
        beforeSend: function(objeto) {
            $('#resultados').html("Cargando...");
        },
        success: function(data) {
            $('#resultados').empty();
            $('#resultados').html(data);
        }
    });
}

function eliminar(id) {
    Swal.fire({
        title: 'Eliminar este detalle?',
        text: "¡No podrás revertir esto!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#27BDBB',
        cancelButtonColor: '#E86F54',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: 'GET',
                url: '../compras/agregarfacturaitem.php',
                data: 'id=' + id,
                beforeSend: function(objeto) {
                    $('#resultados').html("Cargando...");
                },
                success: function(data) {
                    $('#resultados').html(data);
                }
            });
        }
    });
}

function imprimir(numero) {}

function number_format(number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + (Math.round(n * k) / k)
                .toFixed(prec);
        };
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
        .split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1)
            .join('0');
    }
    return s.join(dec);
}
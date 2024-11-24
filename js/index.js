$('#formLogin').submit(function(e) {
    e.preventDefault();
    var nombre = $.trim($("#nombre").val());
    var clave = $.trim($("#clave").val());

    if (nombre.length == "" || clave == "") {
        Swal.fire({
            type: 'warning',
            title: 'Ingrese un usuario y/o contraseña',
        });
        return false;
    } else {
        $.ajax({
            url: "php/login.php",
            type: "POST",
            datatype: "json",
            data: { nombre: nombre, clave: clave },
            success: function(data) {
                console.log(data);
                if (data == "null") {
                    Swal.fire({
                        type: 'error',
                        title: 'Usuario y/o clave incorrecta',
                    });
                } else {
                    Swal.fire({
                        type: 'success',
                        title: '¡Conexión exitosa!',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ingresar'
                    }).then((result) => {
                        if (result.value) {
                            window.location.href = "dashboard.php";
                        }
                    })
                }
            }
        });
    }
});
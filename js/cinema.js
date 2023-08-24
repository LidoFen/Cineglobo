function getTipos() {

    
    let dados = new FormData();
    dados.append("op", 2);

    $.ajax({
        url: "controller/controllerCinema.php",
        method: "POST",
        data: dados,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
    })

        .done(function (msg) {
            $('#selectLocalCinema').html(msg);

        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
}

function getCinemas() {

    let dados = new FormData();
    dados.append("op", 4);

    $.ajax({
        url: "controller/controllerCinema.php",
        method: "POST",
        data: dados,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
    })

        .done(function (msg) {
            $('#cinemaSessao').html(msg);

        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });

}

function getSalas() {

    let dados = new FormData();
    dados.append("op", 5);

    $.ajax({
        url: "controller/controllerCinema.php",
        method: "POST",
        data: dados,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
    })

        .done(function (msg) {
            $('#salaSessao').html(msg);

        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });

}

function registaCinema() {

    let dados = new FormData();
    dados.append("op", 1);
    dados.append("nomeCinema", $('#nomeCinema').val());
    dados.append("telefoneCinema", $('#telefoneCinema').val());
    dados.append("selectLocalCinema", $('#selectLocalCinema').val());
    dados.append("emailCinema", $('#emailCinema').val());



    $.ajax({
        url: "controller/controllerCinema.php",
        method: "POST",
        data: dados,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
    })

        .done(function (msg) {

            let obj = JSON.parse(msg);
            if (obj.flag) {
                alerta("Sucesso", obj.msg, "success");

                $("#nomeCinema").val("");
                $("#telefoneCinema").val("");
                $("#selectLocalCinema").val("-1");
                $("#emailCinema").val("");


            } else {
                alerta("Erro", obj.msg, "error");
            }

        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
}

function getListaCinemas() {


    let dados = new FormData();
    dados.append("op", 3);

    $.ajax({
        url: "controller/controllerCinema.php",
        method: "POST",
        data: dados,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
    })

        .done(function (msg) {
            $('#listaCinemas').html(msg)
            $('#tabelaCinemas').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese.json"
                }

            });
        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
}

function removerCinema(id) {

    let dados = new FormData();
    dados.append("op", 6);
    dados.append("id", id);

    $.ajax({
        url: "controller/controllerCinema.php",
        method: "POST",
        data: dados,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
    })

        .done(function (msg) {

            let obj = JSON.parse(msg);
            if (obj.flag) {
                alerta("Sucesso", obj.msg, "success");
                getListaCinemas();
            } else {
                alerta("Erro", obj.msg, "error");
            }

        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
}

function getDadosCinema(id) {

    let dados = new FormData();
    dados.append("op", 7);
    dados.append("id", id);

    $.ajax({
        url: "controller/controllerCinema.php",
        method: "POST",
        data: dados,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
    })

        .done(function (msg) {
            let obj = JSON.parse(msg);
            $('#nomeCinemaEdit').val(obj.dadosCinema.nome);
            $('#telefoneCinemaEdit').val(obj.dadosCinema.telefone);
            $('#selectLocalCinemaEdit').html(obj.localidade);
            $('#emailCinemaEdit').val(obj.dadosCinema.email);

            $('#modalCinema').modal('show');

            $('#btnGuardar').attr("onclick", "guardaEdit(" + obj.dadosCinema.id + ")")
        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
}

function guardaEdit(id) {

    let dados = new FormData();
    dados.append("op", 8);
    dados.append("id", id);
    dados.append("nome", $('#nomeCinemaEdit').val());
    dados.append("telefone", $('#telefoneCinemaEdit').val());
    dados.append("localidade", $('#selectLocalCinemaEdit').val());
    dados.append("email", $('#emailCinemaEdit').val());

    $.ajax({
        url: "controller/controllerCinema.php",
        method: "POST",
        data: dados,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
    })

        .done(function (msg) {

            let obj = JSON.parse(msg);
            if (obj.flag) {
                alerta("Sucesso", obj.msg, "success");
                $('#modalCinema').modal('hide');
                getListaCinemas();

            } else {
                alerta("Erro", obj.msg, "error");
            }

        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
}

function alerta(titulo, msg, icon) {

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })
      
      Toast.fire({
        icon: icon,
        title: titulo,
        text: msg,
        background: '#1F2425',
        color: "#6C7293"
      })
}

$(function () {
    getTipos();
    getListaCinemas();
    getCinemas();
    getSalas();

});
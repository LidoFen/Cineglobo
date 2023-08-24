function registaSessao() {

    let dados = new FormData();
    dados.append("op", 1);
    dados.append("descricaoSessao", $('#descricaoSessao').val());
    dados.append("cinemaSessao", $('#cinemaSessao').val());
    dados.append("filmeSessao", $('#filmeSessao').val());
    dados.append("salaSessao", $('#salaSessao').val());
    dados.append("horarioSessao", $('#horarioSessao').val());


    $.ajax({
        url: "controller/controllerSessao.php",
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

                $("#descricaoSessao").val("");
                $("#cinemaSessao").val("-1");
                $("#filmeSessao").val("-1");
                $("#salaSessao").val("-1");
                $("#horarioSessao").val("");


            } else {
                alerta("Erro", obj.msg, "error");
            }

        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
}


function getListaSessoes() {



    let dados = new FormData();
    dados.append("op", 2);

    $.ajax({
        url: "controller/controllerSessao.php",
        method: "POST",
        data: dados,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
    })

        .done(function (msg) {
            $('#listaSessoes').html(msg)
            
        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
}


function filtraSessoes() {
    var selectedFilmId = $("#filmeSessao").val(); // Get the selected film's ID
    
    let dados = new FormData();
    dados.append("op", 3); // Add an operation code to your server-side code
    dados.append("filmeId", selectedFilmId);


    
    $.ajax({
        url: "controller/controllerSessao.php",
        method: "POST",
        data: dados,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
    })
    .done(function (msg) {
        $('#listaSessoes').html(msg);

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
    getListaSessoes();

});
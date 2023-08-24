function getTipos() {

    let dados = new FormData();
    dados.append("op", 2);

    $.ajax({
        url: "controller/controllerUtilizador.php",
        method: "POST",
        data: dados,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
    })

        .done(function (msg) {
            $('#selectTipoUtilizador').html(msg);

        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
}

function registaUtilizador() {

    let dados = new FormData();
    dados.append("op", 1);
    dados.append("username", $('#username').val());
    dados.append("password", $('#password').val());
    dados.append("email", $('#email').val());
    dados.append("tipoUtilizador", $('#selectTipoUtilizador').val());



    $.ajax({
        url: "controller/controllerUtilizador.php",
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


            } else {
                alerta("Erro", obj.msg, "error");
            }

        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
}


function login(){

    let dados = new FormData();
    dados.append("op", 3);
    dados.append("username", $('#usernameLogin').val());
    dados.append("password", $('#passwordLogin').val());

    $.ajax({
    url: "controller/controllerUtilizador.php",
    method: "POST",
    data: dados,
    dataType: "html",
    cache: false,
    contentType: false,
    processData: false
    })
    
    .done(function( msg ) {

        let obj = JSON.parse(msg);
        if(obj.flag){
            alerta("Sucesso",obj.msg,"success");
        

            setTimeout(function(){ 
                window.location.href = "index.php";
            }, 3000);



        }else{
            alerta("Erro",obj.msg,"error");    
        }
        
    })
    
    .fail(function( jqXHR, textStatus ) {
    alert( "Request failed: " + textStatus );
    });
}


function logout() {
        let dados = new FormData();
        dados.append("op", 4);

        $.ajax({
            url: "controller/controllerUtilizador.php",
            method: "POST",
            data: dados,
            dataType: "html",
            cache: false,
            contentType: false,
            processData: false
        })

        .done(function(msg) {

            let obj = JSON.parse(msg);
            if(obj.flag) {

                alerta("Sucesso", obj.msg, "success");

                setTimeout(function() {
                    window.location.href = "index.php";
                }, 3000);
            } else {
                alerta("Erro", obj.msg, "error");
            }



        })

        .fail(function(jqXHR, textStatus) {
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
    
});
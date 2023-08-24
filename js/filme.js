

function getTipos() {

    let dados = new FormData();
    dados.append("op", 2);

    $.ajax({
        url: "controller/controllerFilme.php",
        method: "POST",
        data: dados,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
    })

        .done(function (msg) {
            $('#selectTipoFilme').html(msg);


        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
}

function getFilmes() {

    let dados = new FormData();
    dados.append("op", 4);

    $.ajax({
        url: "controller/controllerFilme.php",
        method: "POST",
        data: dados,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
    })

        .done(function (msg) {
            $('#filmeSessao').html(msg);

        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });

}

function registaFilme() {

    let dados = new FormData();
    dados.append("op", 1);
    dados.append("nomeFilme", $('#nomeFilme').val());
    dados.append("descricaoFilme", $('#descricaoFilme').val());
    dados.append("selectTipoFilme", $('#selectTipoFilme').val());
    dados.append("cartazFilme", $('#cartazFilme').prop('files')[0]);



    $.ajax({
        url: "controller/controllerFilme.php",
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


                $("#nomeFilme").val("");
                $("#descricaoFilme").val("");
                $("#selectTipoFilme").val("-1");
                $("#cartazFilme").val("");

                const cartazPreview = document.getElementById('cartazPreview');
                const cartazInput = document.getElementById('cartazFilme');

                cartazInput.value = ''; // Clear the file input
                cartazPreview.src = '#';
                cartazPreview.style.display = 'none';

            } else {
                alerta("Erro", obj.msg, "error");
            }

        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
}

function carregarDadosFilmes() {

    $.ajax({
        url: "controller/controllerFilme.php",
        method: "POST",
        data: { op: 3 },
        dataType: "json"
    })
        .done(function (data) {
            if (data.flag) {
                mostrarItems(data.filmes);
            } else {
                console.log("Erro a procurar items!");
            }
        })
        .fail(function (jqXHR, textStatus) {
            console.log("Request failed: " + textStatus);
        });
}

function mostrarItems(filmes) {
    const containerFilme = $("#listaFilmes");
    const barraPesquisa = $("#barraPesquisa");

    if (filmes.length == 0) {
        containerFilme.html("<p class='text-center' style='font-size: 18px;'>Sem filmes registados!</p>");
        return;
    }

    // Ir buscar a sessionData
    $.ajax({
        url: 'getSessionData.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            barraPesquisa.on("keyup", function () { // event Handler quando tecla é pressionada, executa funcao anónima
                const pesquisa = barraPesquisa.val().toLowerCase();
                containerFilme.empty(); // limpa o conteúdo existente

                filmes.forEach(filme => {
                    if (filme.nome.toLowerCase().includes(pesquisa)) {
                        const itemFilme = `
                        <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                            <div class="team-item h-100">
                                <div class="team-img position-relative overflow-hidden">
                                    <img class="img-fluid" src="${filme.cartaz}" alt="${filme.nome}">
                                    <div class="team-social">
                                    ${data.tipoUser === '1' || data.tipoUser === '2' ? `<button style='border: none;' type='button' class="btn btn-square" onclick="editaFilme(${filme.id})"><i class="bi bi-pencil-fill"></i></button>` : ''}
                                        ${data.tipoUser === '1' ? `<button type='button' class="btn btn-square" onclick="removeFilme(${filme.id})"><i class="bi bi-trash-fill"></i></button>` : ''}
                                        <button style='border: none;' type='button' class="btn btn-square" onclick="infoFilme(${filme.id})"><i class="bi bi-plus"></i></button>
                                        <button style='border: none;' type='button' class="btn btn-square" onclick="abrirTrailer('${filme.nome}')"><i class="bi bi-play"></i></button>
                                    </div>
                                </div>
                                <div class="bg-secondary text-center p-4">
                                    <h5 class="text-uppercase">${filme.nome}</h5>
                                    <span class="text-primary">${filme.tipo}</span>
                                    <p class="descricao">${filme.descricao}</p>
                                </div>
                            </div>
                        </div>
                        `;
                        containerFilme.append(itemFilme);
                    }
                });

                if (containerFilme.is(':empty')) { //Se não houver resultados, basicamente, se tiver "vazio"
                    containerFilme.append("<p class='text-center' style='font-size: 18px;'>Nenhum filme encontrado!</p>"); // Mostrar mensagem
                }
            });

            filmes.forEach(filme => {
                const itemFilme = `
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="team-item h-100">
                        <div class="team-img position-relative overflow-hidden">
                            <img class="img-fluid" src="${filme.cartaz}" alt="${filme.nome}">
                            <div class="team-social">
                            ${data.tipoUser === '1' || data.tipoUser === '2' ? `<button style='border: none;' type='button' class="btn btn-square" onclick="editaFilme(${filme.id})"><i class="bi bi-pencil-fill"></i></button>` : ''}
                                ${data.tipoUser === '1' ? `<button type='button' class="btn btn-square" onclick="removeFilme(${filme.id})"><i class="bi bi-trash-fill"></i></button>` : ''}
                                <button style='border: none;' type='button' class="btn btn-square" onclick="infoFilme(${filme.id})"><i class="bi bi-plus"></i></button>
                                <button style='border: none;' type='button' class="btn btn-square" onclick="abrirTrailer('${filme.nome}')"><i class="bi bi-play"></i></button>
                            </div>
                        </div>
                        <div class="bg-secondary text-center p-4">
                            <h5 class="text-uppercase">${filme.nome}</h5>
                            <span class="text-primary">${filme.tipo}</span>
                            <p class="descricao">${filme.descricao}</p>
                        </div>
                    </div>
                </div>
                `;
                containerFilme.append(itemFilme);
            });

        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Failed to fetch session data:', textStatus, errorThrown);
        }
    });
}


function removeFilme(id) {

    let dados = new FormData();
    dados.append("op", 5);
    dados.append("id", id);

    $.ajax({
        url: "controller/controllerFilme.php",
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
                $("#listaFilmes").empty();
                carregarDadosFilmes();
                mostrarItems();
            } else {
                alerta("Erro", obj.msg, "error");
            }

        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });

}

function editaFilme(id) {


    let dados = new FormData();
    dados.append("op", 6);
    dados.append("id", id);

    $.ajax({
        url: "controller/controllerFilme.php",
        method: "POST",
        data: dados,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
    })

        .done(function (msg) {

            let obj = JSON.parse(msg);

            $('#nomeFilmeEdit').val(obj.dadosFilme.nome);
            $('#descricaoFilmeEdit').val(obj.dadosFilme.descricao);
            $('#selectTipoFilmeEdit').html(obj.tipoFilme);

            $('#modalFilmeEdit').modal('show');


            $('#btnGuardar1').attr("onclick", "guardaEditFilme(" + obj.dadosFilme.id + ")")


        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });


}

function guardaEditFilme(id) {

    let dados = new FormData();
    dados.append("op", 7);
    dados.append("id", id);
    dados.append("nome", $('#nomeFilmeEdit').val());
    dados.append("descricao", $('#descricaoFilmeEdit').val());
    dados.append("tipo", $('#selectTipoFilmeEdit').val());
    dados.append("cartazFilme", $('#cartazFilmeEdit').prop('files')[0]);


    $.ajax({
        url: "controller/controllerFilme.php",
        method: "POST",
        data: dados,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
    })

        .done(function (msg) {
            console.log(msg);
            let obj = JSON.parse(msg);
            if (obj.flag) {
                alerta("Sucesso", obj.msg, "success");

                $('#nomeFilmeEdit').val("");
                $('#descricaoFilmeEdit').val("");
                $('#selectTipoFilmeEdit').val("-1");
                $('#cartazFilmeEdit').val("");


                $("#listaFilmes").empty();
                carregarDadosFilmes();
                mostrarItems();

            } else {
                alerta("Erro", obj.msg, "error");
            }

        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });


}

function infoFilme(id) {


    let dados = new FormData();
    dados.append("op", 8);
    dados.append("id", id);

    $.ajax({
        url: "controller/controllerFilme.php",
        method: "POST",
        data: dados,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false
    })

        .done(function (msg) {

            $('#listaFilmeInfo').html(msg)
            $('#modalFilmeInfo').modal('show');
        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
}


function abrirTrailer(filmeNome) {
    const chaveApi = 'AIzaSyCKPdT47f_Tq2Hsq_DvRzmG7n5kTMelka0'; // chave api
    const pesquisa = encodeURIComponent(filmeNome + ' official trailer'); // o que pesquisar
    const urlApi = `https://www.googleapis.com/youtube/v3/search?key=${chaveApi}&part=snippet&q=${pesquisa}&maxResults=1&type=video`; // endereço onde aplicar a chave e pesquisa

    fetch(urlApi) // dou fetch ás respostas do urlApi
        .then(response => response.json()) // Processar resposta como resposta JSON
        .then(data => {
            if (data.items && data.items.length > 0) { // se os dados tiverem items(video) e for maior que 0 (o urlApi já restringe os resultado máx 1), então encontrou video
                const videoId = data.items[0].id.videoId; // extrai o Id do video da resposta JSON do API
                const trailerUrl = `https://www.youtube.com/embed/${videoId}`; // aplica esse id a um URL base embed do youtube
                const trailerModal = new bootstrap.Modal(document.getElementById('trailerModal')); // cria um novo objecto modal e vai buscar o modal existente
                const trailerVideo = document.getElementById('trailerVideo'); // vai buscar o element onde está o trailer

                // adiciona o URL do trailer e mostra o modal
                trailerVideo.src = trailerUrl;
                trailerModal.show();

                // escuta pelo fecho do modal
                trailerModal._element.addEventListener('hidden.bs.modal', function () {
                    // quando o modal é fechado, dar reset a src do video
                    trailerVideo.src = '';
                });
            } else {
                console.log('Sem trailer encontrando para este filme!');
            }
        })
        .catch(error => {
            console.error('Pesquisa falhou com o seguinte erro: ', error);
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
    carregarDadosFilmes();
    getFilmes();
});
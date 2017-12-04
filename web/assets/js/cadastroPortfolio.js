var flagEditar = false;

var idAbrirEdicao;
var titleForm;
var descriptionForm;

function editarAtividade(id, dsTitle, dsDescription, idAtividade) {
    var idAberto;
    titleForm = dsTitle;
    descriptionForm = dsDescription;
    idAtividadeForm = idAtividade;
    $(".editarEachAtividade").each(function () {
        if ($(this).is(':visible')) {
            flagEditar = true;
            idAberto = $(this).attr('id');
        }
    });

    if (flagEditar == false) {
        openEditar(id);
    } else {
        idAbrirEdicao = id;
        closeEditar(idAberto);
    }
}

function openEditar(id) {
    var $formulario = $("#editarAtividade");
    document.getElementById("editAtiv_DsTitle").value = titleForm;
    document.getElementById("editAtiv_DsDescription").value = descriptionForm;
    document.getElementById("editAtiv_IdActivity").value = idAtividadeForm;
    $('#closeEditar').click(function () {
        closeEditar(id);
    });
    $("#" + id + ".editarEachAtividade").append($formulario);
    $formulario.css("display", "block");
    $("#" + id + ".editarEachAtividade").show();
}
function closeEditar(id) {
    $("#" + id + ".editarEachAtividade").hide();
    if (flagEditar) {
        flagEditar = false;
        // openEditar(idAbrirEdicao);
    }
}

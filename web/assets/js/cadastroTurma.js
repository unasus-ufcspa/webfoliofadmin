$("#formCadastroTurma").submit(function(e) {
    var dataString = {
        arrayAdministradoresDesativar: usuariosExcecao.usuariosExcecao
    };
    console.log(dataString);
    $.ajax({
        type: 'post',
        data: $("#formCadastroTurma").serialize(),
        contentType: 'application/json',
        dataType: 'json',
        url: '' + caminho + 'efetuarCadastroTurma',
        cache: false,
        processData: false,
        async: false,
        success: function (response) {
            console.log(response);
            location.reload();
        }
    });
});

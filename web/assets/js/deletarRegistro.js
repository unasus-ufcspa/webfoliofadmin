var listaUsers = [];

function addListaUser(id){
  var flagExiste = false;
  if(listaUsers.indexOf(id) != -1){
    var index = listaUsers.indexOf(id);
    listaUsers.splice(index, 1);
  }else{
    listaUsers.push(id);
  }
}

function atualizaFormPropositor(){
  if (listaUsers == null){
    $("#excluir_IdProposers").val("");
  }else{
    var novaString = "";
    for(var i = 0; i < listaUsers.length; i++){
      if(i == 0){
        novaString = novaString + "" + listaUsers[i];
      }else{
        novaString = novaString + ";" + listaUsers[i];
      }
    }
    $("#excluir_IdProposers").val(novaString);
  }
}

function atualizaFormAdministrador(){
  if (listaUsers == null){
    $("#excluir_IdUsers").val("");
  }else{
    var novaString = "";
    for(var i = 0; i < listaUsers.length; i++){
      if(i == 0){
        novaString = novaString + "" + listaUsers[i];
      }else{
        novaString = novaString + ";" + listaUsers[i];
      }
    }
    $("#excluir_IdUsers").val(novaString);
  }
}

function atualizaFormAluno(){
  if (listaUsers == null){
    $("#excluir_IdUsers").val("");
  }else{
    var novaString = "";
    for(var i = 0; i < listaUsers.length; i++){
      if(i == 0){
        novaString = novaString + "" + listaUsers[i];
      }else{
        novaString = novaString + ";" + listaUsers[i];
      }
    }
    $("#excluir_IdUsers").val(novaString);
  }
}

function atualizaFormTutor(){
  if (listaUsers == null){
    $("#excluir_IdUsers").val("");
  }else{
    var novaString = "";
    for(var i = 0; i < listaUsers.length; i++){
      if(i == 0){
        novaString = novaString + "" + listaUsers[i];
      }else{
        novaString = novaString + ";" + listaUsers[i];
      }
    }
    $("#excluir_IdUsers").val(novaString);
  }
}

function atualizaFormAtividade(){
  if (listaUsers == null){
    $("#excluir_IdItem").val("");
  }else{
    var novaString = "";
    for(var i = 0; i < listaUsers.length; i++){
      if(i == 0){
        novaString = novaString + "" + listaUsers[i];
      }else{
        novaString = novaString + ";" + listaUsers[i];
      }
    }
    $("#excluir_IdItem").val(novaString);
  }
}

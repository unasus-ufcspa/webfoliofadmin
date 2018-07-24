var listaPropositores = [];

function addListaProp(id){
  var flagExiste = false;
  if(listaPropositores.indexOf(id) != -1){
    var index = listaPropositores.indexOf(id);
    listaPropositores.splice(index, 1);
  }else{
    listaPropositores.push(id);
  }

  atualizaFormPropositor();
}

function atualizaFormPropositor(){
  if (listaPropositores == null){
    $("#excluir_IdProposers").val("");
  }else{
    var novaString = "";
    for(var i = 0; i < listaPropositores.length; i++){
      if(i == 0){
        novaString = novaString + "" + listaPropositores[i];
      }else{
        novaString = novaString + ";" + listaPropositores[i];
      }
    }
    $("#excluir_IdProposers").val(novaString);
  }
  console.log(listaPropositores);
  console.log($("#excluir_IdProposers").val());
}

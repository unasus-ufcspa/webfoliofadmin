function submenuCadastro(string) {
    switch(string){
      case "tutor":
       var x = document.getElementById("subMTutores");
      break;
      case "aluno":
        var x = document.getElementById("subMAlunos");
      break;
      case "prop":
        var x = document.getElementById("subMPropositores");
      break;
      case "port":
        var x = document.getElementById("subMPortfolios");
      break;
    }
    if (x.style.display != "block") {
        x.style.display="block";
    } else {
        x.style.display="none";
    }
}

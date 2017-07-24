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


var dragSrcEl = null;

function handleDragStart(e) {
  // Target (this) element is the source node.
  this.style.opacity = '0.4';

  dragSrcEl = this;

  e.dataTransfer.effectAllowed = 'move';
  e.dataTransfer.setData('text/html', this.innerHTML);
}

function handleDragOver(e) {
  if (e.preventDefault) {
    e.preventDefault(); // Necessary. Allows us to drop.
  }

  e.dataTransfer.dropEffect = 'move';  // See the section on the DataTransfer object.

  return false;
}

function handleDragEnter(e) {
  // this / e.target is the current hover target.
  this.classList.add('over');
}

function handleDragLeave(e) {
  this.classList.remove('over');  // this / e.target is previous target element.
}


var itens = document.querySelectorAll('.subitemCadastro');
[].forEach.call(itens, function(item) {
  item.addEventListener('dragstart', handleDragStart, false);
  item.addEventListener('dragenter', handleDragEnter, false);
  item.addEventListener('dragover', handleDragOver, false);
  item.addEventListener('dragleave', handleDragLeave, false);
});

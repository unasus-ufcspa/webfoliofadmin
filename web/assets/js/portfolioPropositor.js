var dragSrcEl = null;

function handleDragEnter(e) {
  this.classList.add('over');
}

function handleDragLeave(e) {
  this.classList.remove('over');
}

function handleDragEnd(e) {
  this.classList.remove('over');
}

function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    // ev.classList.add('itemAdicionado');
    ev.dataTransfer.effectAllowed = 'move';
    ev.dataTransfer.setData("text", ev.target.id);
    dragSrcEl = this;
}

function dropPort(ev) {
    if (ev.stopPropagation) {
      ev.stopPropagation(); // Stops some browsers from redirecting.
    }
    // if (dragSrcEl != this) {
      $( ".textArrastar:first" ).hide();
      $( ".logoArrastar:eq(0)" ).hide();
      var data = ev.dataTransfer.getData("text/html");
      // ev.target.appendChild(document.getElementById(data));
      // console.log(ev.dataTransfer.getData("text/html"));
      nodeItem = document.createElement('div');
      nodeItem.className += "subitemCadastro";
      nodeItem.innerHTML = ev.dataTransfer.getData("text/html");
      nodeExcluir = document.createElement('div');
      nodeExcluir.innerHTML = "+";
      nodeExcluir.className = "removerPortfolio";
      nodeItem.appendChild(nodeExcluir);
      // document.getElementsByClassName("boxPortfolio")[0].appendChild(document.getElementById(data));
      document.getElementsByClassName("boxPortfolio")[0].appendChild(nodeItem);

    // }
    return false;
}

function dropProp(ev) {
    if (ev.stopPropagation) {
      ev.stopPropagation(); // Stops some browsers from redirecting.
    }
    // if (dragSrcEl != this) {
      $( ".textArrastar:eq(1)" ).hide();
      $( ".logoArrastar:eq(1)" ).hide();
      var data = ev.dataTransfer.getData("text");
      // ev.target.appendChild(document.getElementById(data));

      document.getElementsByClassName("boxPropositor")[0].appendChild(document.getElementById(data));
    // }
    return false;
}
  var area = document.getElementById("boxArrastar")
  area.addEventListener('dragenter', handleDragEnter, false);
  area.addEventListener('dragleave', handleDragLeave, false);
  area.addEventListener('dragend', handleDragEnd, false);

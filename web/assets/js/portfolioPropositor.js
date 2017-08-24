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

    $( ".textArrastar:first" ).hide();
    $( ".logoArrastar:eq(0)" ).hide();

    node = document.createElement('div');
    node.innerHTML = ev.dataTransfer.getData("text/html");

    nodeItem = document.createElement('div');
    nodeItem.className += "itemPortfolioPropositor";
    nodeItem.id = node.childNodes[0].id;

    nodeItemInfo = document.createElement('div');
    nodeItemInfo.className += "infoPortfolio";

    if(node.textContent.length>35){
      nodeItemInfo.textContent = node.textContent.substr(0, 35)+"...";
    }else{
      nodeItemInfo.textContent = node.textContent;
    }

    nodeItemRemover = document.createElement('div');
    nodeItemRemover.innerHTML = "+";
    nodeItemRemover.className = "removerItemPortfolio";

    nodeItem.appendChild(nodeItemInfo);
    nodeItem.appendChild(nodeItemRemover);
    document.getElementsByClassName("boxPortfolio")[0].appendChild(nodeItem);
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

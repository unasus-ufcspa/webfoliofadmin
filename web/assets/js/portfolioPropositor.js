var dragSrcEl = null;
var arrayIdPortfolio = [];
var arrayIdPropositor = [];

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
function hasClass(element, cls) {
    return (' ' + element.className + ' ').indexOf(' ' + cls + ' ') > -1;
}
function dropPort(ev) {
  if (ev.stopPropagation) {
    ev.stopPropagation(); // Stops some browsers from redirecting.
  }

  var data = ev.dataTransfer.getData("text");
  var node = document.createElement('div');
  node.innerHTML = ev.dataTransfer.getData("text/html");

  if(hasClass(node.childNodes[0], 'subitemPortfolio')){
    var flagItemPresente=false;
    for(var i = 0; i<arrayIdPortfolio.length; i++){
      if(arrayIdPortfolio[i]==node.childNodes[0].id){
        flagItemPresente=true;
      }
    }

    if(flagItemPresente!=true){

      var nodeItem = document.createElement('div');
      nodeItem.className += "itemPortfolio";
      nodeItem.id = node.childNodes[0].id;
      arrayIdPortfolio.push(node.childNodes[0].id);

      $("a#"+nodeItem.id+".subitemPortfolio").css("color", "gray");

      var nodeItemInfo = document.createElement('div');
      nodeItemInfo.className += "infoPortfolio";

      if(node.textContent.length>35){
        nodeItemInfo.textContent = node.textContent.substr(0, 35)+"...";
      }else{
        nodeItemInfo.textContent = node.textContent;
      }

      var nodeItemRemover = document.createElement('div');
      nodeItemRemover.innerHTML = "+";
      nodeItemRemover.className = "removerItemPortProp";
      nodeItemRemover.onclick = function() {
        $("div#"+nodeItem.id+".itemPortfolio").remove();
        $("a#"+nodeItem.id+".subitemPortfolio").css("color", "white");
        arrayIdPortfolio.splice( arrayIdPortfolio.indexOf(nodeItem.id), 1 );
        if(arrayIdPortfolio.length==0){
          $( ".textArrastar:first" ).show();
          $( ".logoArrastar:eq(0)" ).show();

        }
      };

      nodeItem.appendChild(nodeItemInfo);
      nodeItem.appendChild(nodeItemRemover);
      document.getElementsByClassName("boxPortfolio")[0].appendChild(nodeItem);
    }

    $( ".textArrastar:first" ).hide();
    $( ".logoArrastar:eq(0)" ).hide();
    $("#salvarPortfolioPropositor_IdPortfolios").val(arrayIdPortfolio[0]);
  }

  return false;
}

function dropProp(ev) {
  if (ev.stopPropagation) {
    ev.stopPropagation(); // Stops some browsers from redirecting.
  }

  if(arrayIdPropositor.length==0){

  var data = ev.dataTransfer.getData("text");
  var node = document.createElement('div');
  node.innerHTML = ev.dataTransfer.getData("text/html");

  if(hasClass(node.childNodes[0], 'subitemPropositor')){
    var flagItemPresente=false;
    for(var i = 0; i<arrayIdPropositor.length; i++){
      if(arrayIdPropositor[i]==node.childNodes[0].id){
        flagItemPresente=true;
      }
    }

    if(flagItemPresente!=true){
      var nodeItem = document.createElement('div');
      nodeItem.className += "itemPropositor";
      nodeItem.id = node.childNodes[0].id;
      arrayIdPropositor.push(node.childNodes[0].id);

      $("a#"+nodeItem.id+".subitemPropositor").css("color", "gray");

      var nodeItemInfo = document.createElement('div');
      nodeItemInfo.className += "infoPropositor";

      if(node.textContent.length>35){
        nodeItemInfo.textContent = node.textContent.substr(0, 35)+"...";
      }else{
        nodeItemInfo.textContent = node.textContent;
      }

      var nodeItemRemover = document.createElement('div');
      nodeItemRemover.innerHTML = "+";
      nodeItemRemover.className = "removerItemPortProp";
      nodeItemRemover.onclick = function() {
        $("div#"+nodeItem.id+".itemPropositor").remove();
        $("a#"+nodeItem.id+".subitemPropositor").css("color", "white");
        arrayIdPropositor.splice( arrayIdPropositor.indexOf(nodeItem.id), 1 );
        if(arrayIdPropositor.length==0){
          $( ".textArrastar:eq(1)" ).show();
          $( ".logoArrastar:eq(1)" ).show();
        }
      };

      nodeItem.appendChild(nodeItemInfo);
      nodeItem.appendChild(nodeItemRemover);
      document.getElementsByClassName("boxPropositor")[0].appendChild(nodeItem);
    }

    $( ".textArrastar:eq(1)" ).hide();
    $( ".logoArrastar:eq(1)" ).hide();

    $("#salvarPortfolioPropositor_IdProposer").val(arrayIdPropositor[0]);
  }
}
  return false;
}
  var area = document.getElementById("boxArrastar");
  area.addEventListener('dragenter', handleDragEnter, false);
  area.addEventListener('dragleave', handleDragLeave, false);
  area.addEventListener('dragend', handleDragEnd, false);

  // function salvarPortfolioPropositor(){
  //   var idsPortfolios= arrayIdPortfolio.join(',');
  //   // for(var i=0;i<arrayIdPortfolio; i++){
  //   //   idsPortfolios+=arrayIdPortfolio[i]+";";
  //   // }
  //
  //   $("#salvarPortfolioPropositor_IdProposer").val(arrayIdPropositor[0]);
  //   $("#salvarPortfolioPropositor_IdPortfolios").val(idsPortfolios);
  //
  // }

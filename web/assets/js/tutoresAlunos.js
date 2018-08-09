var dragSrcEl = null;
var arrayIdTutorAluno = [];

var idTutores = document.getElementsByClassName("nomeTutor");
for(var i=0; i<idTutores.length; i++){
  arrayIdTutorAluno.push([idTutores[i].id, ]);
}
// console.log(arrayIdTutorAluno);

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
    ev.dataTransfer.effectAllowed = 'move';
    ev.dataTransfer.setData("text", ev.target.id);
    dragSrcEl = this;
}
function hasClass(element, cls) {
    return (' ' + element.className + ' ').indexOf(' ' + cls + ' ') > -1;
}

function dropAluno(ev) {
  if (ev.stopPropagation) {
    ev.stopPropagation(); // Stops some browsers from redirecting.
  }

  var data = ev.dataTransfer.getData("text");
  var node = document.createElement('div');
  node.innerHTML = ev.dataTransfer.getData("text/html");

  if(hasClass(node.childNodes[0], 'subitemAluno')){
    var flagItemPresente=false;
    var idBoxTutor = $(event.target).attr('id');

    for(var j = 0; j<arrayIdTutorAluno.length; j++){
      if(arrayIdTutorAluno[j][0] == idBoxTutor){
        var posicaoArrayTutor = j;
      }
    }

    for(var i = 1; i<arrayIdTutorAluno[posicaoArrayTutor].length; i++){
      if(arrayIdTutorAluno[posicaoArrayTutor][i]==node.childNodes[0].id){
        flagItemPresente=true;
      }
    }

    if(flagItemPresente!=true){
      var nodeItem = document.createElement('div');
      nodeItem.className += "itemAlunoTutor";
      nodeItem.id = node.childNodes[0].id;
      // console.log("Child Node "+  node.childNodes[0].id);
      // console.log("Pos Array  "+  posicaoArrayTutor);
      arrayIdTutorAluno[posicaoArrayTutor].push(nodeItem.id);

      var nodeItemInfo = document.createElement('div');
      nodeItemInfo.className += "infoAluno";

      if(node.textContent.length>35){
        nodeItemInfo.textContent = node.textContent.substr(0, 35)+"...";
      }else{
        nodeItemInfo.textContent = node.textContent;
      }

      var nodeItemRemover = document.createElement('div');
      nodeItemRemover.innerHTML = "+";
      nodeItemRemover.className = "removerAluno";
      nodeItemRemover.onclick = function() {
        $(this).parent().remove();
        arrayIdTutorAluno[posicaoArrayTutor].splice( arrayIdTutorAluno[posicaoArrayTutor].indexOf(nodeItem.id), 1 );
        if(arrayIdTutorAluno[posicaoArrayTutor].length==1){
          $( ".textArrastarAluno:eq("+posicaoArrayTutor+")" ).show();
          $( ".logoArrastar:eq("+posicaoArrayTutor+")" ).show();

          var clone = arrayIdTutorAluno.slice(0);
          for(x in clone) {
              if(clone[x] instanceof Array) {
                  clone[x] = clone[x].join(".");
              }
          }
          var novaString = clone.join(";");
          // console.log(novaString);
          $("#alunoTutor_IdAlunosTutores").val(novaString);

        }
      };

      nodeItem.appendChild(nodeItemInfo);
      nodeItem.appendChild(nodeItemRemover);
      document.getElementsByClassName("boxArrastarAluno")[posicaoArrayTutor].appendChild(nodeItem);
    }

    $( ".textArrastarAluno:eq("+posicaoArrayTutor+")" ).hide();
    $( ".logoArrastar:eq("+posicaoArrayTutor+")" ).hide();

    var clone = arrayIdTutorAluno.slice(0);
    for(x in clone) {
        if(clone[x] instanceof Array) {
            clone[x] = clone[x].join(".");
        }
    }
    var novaString = clone.join(";");
    // console.log(novaString);
    $("#alunoTutor_IdAlunosTutores").val(novaString);
  }
  // console.log("Log 3");
  // console.log(arrayIdTutorAluno);
  return false;
}

  var area = document.getElementsByClassName("boxArrastarAluno");
  for(var i = 0; i<area.length; i++){
    area[i].addEventListener('dragenter', handleDragEnter, false);
    area[i].addEventListener('dragleave', handleDragLeave, false);
    area[i].addEventListener('dragend', handleDragEnd, false);
  }

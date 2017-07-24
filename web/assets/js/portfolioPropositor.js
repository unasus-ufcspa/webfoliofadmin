var boxPortfolio = document.querySelectorAll('.boxArrastar');
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

function handleDrop(e) {
  // this/e.target is current target element.

  if (e.stopPropagation) {
    e.stopPropagation(); // Stops some browsers from redirecting.
  }

  // Don't do anything if dropping the same column we're dragging.
  if (dragSrcEl != this) {
    // Set the source column's HTML to the HTML of the columnwe dropped on.
    // dragSrcEl.innerHTML = this.innerHTML;
    // this.innerHTML = e.dataTransfer.getData('text/html');
    this.innerHTML = e.dataTransfer.getData('html');
  }

  return false;
}

function handleDragEnd(e) {
  // this/e.target is the source node.

  [].forEach.call(cols, function (box) {
    box.classList.remove('over');
  });
}

[].forEach.call(boxPortfolio, function(box) {
  box.addEventListener('dragenter', handleDragEnter, false);
  box.addEventListener('dragover', handleDragOver, false);
  box.addEventListener('dragleave', handleDragLeave, false);
  box.addEventListener('drop', handleDrop, false);
  box.addEventListener('dragend', handleDragEnd, false);
});

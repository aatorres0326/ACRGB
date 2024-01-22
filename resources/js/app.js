import './bootstrap';

function makeEditable(button) {
    var row = button.parentNode.parentNode;
    var cells = row.getElementsByClassName('editable');

    for (var i = 0; i < cells.length; i++) {
      cells[i].contentEditable = true;
    }

    button.innerHTML = 'Save';
    button.onclick = function() {
      saveChanges(this);
    };
  }

  function saveChanges(button) {
    var row = button.parentNode.parentNode;
    var cells = row.getElementsByClassName('editable');

    for (var i = 0; i < cells.length; i++) {
      cells[i].contentEditable = false;
    }

    button.innerHTML = 'Edit';
    button.onclick = function() {
      makeEditable(this);
    };
  }
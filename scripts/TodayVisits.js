var modal = document.getElementById("SummaryPatientModal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

function Get_history(){

  var form = document.createElement("form");   // shorter with jquery using $('#insert_form')
  form.setAttribute("method", "post");
  form.setAttribute("id", "hist");
  form.setAttribute("action", "History.php");

  var i = document.createElement("input");
  i.type = "text";
  i.name = "NameSearch";
  i.value = document.getElementById("NameF").value;

  var j = document.createElement("input");
  j.type = "text";
  j.name = "SurnameSearch";
  j.value = document.getElementById("SurnameF").value;

  form.appendChild(i);
  form.appendChild(j);
  document.body.appendChild(form);

  document.getElementById("hist").submit();
}


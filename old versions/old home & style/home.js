var modal = document.getElementById("SummaryPatientModal");
var modal2 = document.getElementById("AgendaModal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
var span2 = document.getElementsByClassName("close")[1];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}
span2.onclick = function() {
  modal2.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
  if (event.target == modal2) {
    modal2.style.display = "none";
  }
}


function OpenAgenda(){
  document.getElementById("AgendaModal").style.display = "block";
}
 
function RemoveBookingDate(){
	if (true) {
		var conf= confirm('Eliminare giornata? sono presenti pazienti');
		if (conf){
			$.ajax({
			    url: "RemoveBookingDate.php",
			    type: "POST",
			    data: { date: 'prova' },
			    success: function(){
			    	alert('Giornata rimossa correttamente');
				}
			});
			//REDIRECT DELLA PAGINA A EDIT GIORNO 
		}
	}
	else {
		$.ajax({
		    url: "RemoveBookingDate.php",
		    type: "POST",
		    data: { Date: 'prova'},
		    success: function(){
		    	alert('Giornata rimossa correttamente');
			}
		});
	}
}

function AddBookingDate(){

	var from = document.getElementById('fromHour');
	var to = document.getElementById('toHour');


	$.ajax({
	    url: "AddBookingDate.php",
	    type: "POST",
	    data: { Date: 'prova', Hours:'prova'},
	    success: function(){
	    	alert('Giornata aggiunta correttamente');
		}
	});
}
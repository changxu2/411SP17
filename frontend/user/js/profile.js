$(".editPlan").on('click', function(){
  window.location.replace('http://tripubproject.web.engr.illinois.edu/411SP17/frontend/trip/createTrip.php?planid='+this.id)
});

$("#add_trip").on('click', function(){
  $.post(document.URL, { "addTrip": "1"} );
});

$(".deletePlan").on('click', function(){
  alert(this.id)
  $.post(document.URL, { "deletePlan": this.id} );
});

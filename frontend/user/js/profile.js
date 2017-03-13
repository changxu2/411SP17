var jumpEdit = function(id){
  var url = window.location.hostname
  url += ('/trip/createTrip.php?planID=' + id)
  window.location(url);
}

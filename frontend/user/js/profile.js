$(document).ready(function() {
  var jumpEdit = function(){
    var url = window.location.hostname
    url += ('/trip/createTrip.php?planID=' + this.id)
    window.location(url);
  }
});

$(".editPlan").on('click', function(){
  window.location.replace('http://tripubproject.web.engr.illinois.edu/411SP17/frontend/trip/createTrip.php?planid='+this.id)
});

$("#add_trip").on('click', function(){
  $.post(document.URL, { "addTrip": "1"} , function(result){
      setTimeout(window.location.reload(), 4000)
  });
});

$(".deletePlan").on('click', function(){
  var str = this.id
  str = str.replace('d', '')
  $.post(document.URL, { "deletePlan": str}, function(result){
      setTimeout(window.location.reload(), 4000)
  });
});
$("#followUser").submit(function(e) {

    var url = "http://tripubproject.web.engr.illinois.edu/411SP17/frontend/user/profile.php"; // the script where you handle the form input.

    $.ajax({
           type: "POST",
           url: url,
           data: $("#followUser").serialize(), // serializes the form's elements.
           success: function(data)
           {
               setTimeout(window.location.reload(), 3000)
           }
         });

    e.preventDefault(); // avoid to execute the actual submit of the form.
});

var height = function(){
	var offsetHeight = document.getElementById('real-size').offsetHeight - 460;
	document.getElementById("chat-container").style.marginTop = offsetHeight+"px";
}

window.addEventListener("load", height);


$(".addLoc").on('click', function(){
  $.post(document.URL, { "addID": this.id} , function(result){
      setTimeout(window.location.reload(), 4000)
  });
});

$(".deleteLoc").on('click', function(){
  $.post(document.URL, { "deleteID": this.id} , function(result){
      setTimeout(window.location.reload(), 4000)
  });
});


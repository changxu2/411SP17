
// var height = function(){
// 	var offsetHeight = document.getElementById('real-size').offsetHeight - 460;
// 	document.getElementById("chat-container").style.marginTop = offsetHeight+"px";
// }

// window.addEventListener("load", height);

function close_chat(){
    var x = document.getElementById('to-close');
    if (x.style.display === 'none') {
        document.getElementById("minimize").innerHTML = "close";
        x.style.display = 'block';
    } else {
        x.style.display = 'none';
        document.getElementById("minimize").innerHTML = "open";
    }
}


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

$("button[name='like']").on('click', function(){
    var id = this.getAttribute('data-id');
    $.post(document.URL, { "likes": this.id, "userid": id} , function(result){
      setTimeout(window.location.reload(), 4000)
  });
    // avoid to execute the actual submit of the form.
});

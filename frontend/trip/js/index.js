$(".addLoc").on('click', function(){
  $.post(document.URL, { "addID": this.id} , function(result){
      setTimeout(window.location.reload(), 4000)
  });
});

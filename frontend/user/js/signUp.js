/* Simple VanillaJS to toggle class */
function show_function(){
  [].map.call(document.querySelectorAll('.profile'), function(el) {
    el.classList.toggle('profile--open');
  });
}

// document.getElementById('toggleProfile').addEventListener('load', function () {
//   [].map.call(document.querySelectorAll('.profile'), function(el) {
//     el.classList.toggle('profile--open');
//   });
// });
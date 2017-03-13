function appendNewLi(name, type) {
    var ul = document.getElementById("planlist");
    var li = document.createElement("li");
    li.appendChild(document.createTextNode(name + " " + type));
    //li.setAttribute("id", "element4"); // for later use if need to set new li id
    ul.appendChild(li);
    //alert(li.id);
}

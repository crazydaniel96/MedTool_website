window.onload = function(){
  var path=window.location.pathname;
  var elements=document.getElementsByClassName(path);
  for (element in elements){
    if (elements[element].tagName=="UL")
      elements[element].classList.add('in'); 
    else if (elements[element].tagName=="LI")
      elements[element].classList.add('active'); 
  }
};
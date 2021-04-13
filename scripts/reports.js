function Manage_New(){
  var select = document.getElementById("NewCat");

  var Category=document.getElementById("Category").value;

  if (Category=="Nuova categoria")
    select.disabled=false;
  else
    select.disabled=true;
}
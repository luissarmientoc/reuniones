<script>
 function loadCiudad(str)
 {
    document.getElementById("nombre_ciudad").value="";
    var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
   {
     if (xmlhttp.readyState==4 && xmlhttp.status==200)
     {
     document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
     }
   }
   xmlhttp.open("POST","buscarCiudades.php",true);
   xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
   xmlhttp.send("q="+str);
 }
 
function datoCiiu()
{
  /* Para obtener el valor */
  var cod = document.getElementById("id_ciudad").value;
  document.getElementById("codCiudad").value=cod;

  //alert(cod);
 
  /* Para obtener el texto */
  var combo = document.getElementById("id_ciudad");
  var selected = combo.options[combo.selectedIndex].text;
  document.getElementById("nombre_ciudad").value=selected;

  //alert(selected);  
}

</script>
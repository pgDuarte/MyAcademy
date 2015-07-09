function get_XmlHttp() {
  // create the variable that will contain the instance of the XMLHttpRequest object (initially with null value)
  var xmlHttp = null;

  if(window.XMLHttpRequest) {		// for Forefox, IE7+, Opera, Safari, ...
    xmlHttp = new XMLHttpRequest();
  }
  else if(window.ActiveXObject) {	// for Internet Explorer 5 or 6
    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
  }

  return xmlHttp;
}



function listAllPubs(userID)
{
 
 var request =  get_XmlHttp();	
 
 var formData = new FormData();
 formData.append('id', userID);
 formData.append('pubfunction', "listAllPubs");
 
 request.open("POST", "php/listpubs.php", true);			// define the request
 request.send(formData);		// sends data
 
   request.onreadystatechange = function() {
    if (request.readyState == 4) {      
      document.getElementById("listpubsvdsv").innerHTML = request.responseText;
    }
  }
}


function listAlltypePubs(userID)
{
 
 var request =  get_XmlHttp();	
 
 var formData = new FormData();
 formData.append('id', userID);
 formData.append('pubfunction', "listAlltypesPubs");
 
 request.open("POST", "php/listpubs.php", true);			// define the request
 request.send(formData);		// sends data
 
   request.onreadystatechange = function() {
    if (request.readyState == 4) {
      //alert(request.responseText);
      document.getElementById("indice").innerHTML = request.responseText;
    }
  }
  
  
}


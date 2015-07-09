// create the XMLHttpRequest object, according browser
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
    
    //Upload XML - Teaching
function teachxml(){
    var request =  get_XmlHttp();
    var data = new FormData();
    
    data.append('type','teachxml');
    var idusers = getUserID();
    data.append('idusers',idusers);    
    var file = document.getElementById('zipfile');
    data.append('zipfile', file.files[0]); 
    
    //verify extension file
    var ext = file.files[0]['name'].split('.')[1];    
    if(ext != "zip"){
        $('#zipfile').focus();
        alert("Please enter a valid file..\n ex:   sip.zip");
        return;
    };    
    $('#loadingmsg').modal({keyboard: false});
    
    request.open("POST","php/xml2sql.php", true);			// define the request
    request.send(data);		// sends data
    
    request.onreadystatechange = function() {
        if (request.readyState == 4) {            
            
            if(request.responseText=="success")
            {
                $('#loadingmsg').modal('hide');
                alert("The XML was uploaded!");
                location.reload();
            }else if(request.responseText=="error")
            {
                $('#loadingmsg').modal('hide');
                alert("You have to upload a valid XML.. \n (sip.xml)");
                location.reload();
            }else
            {
                $('#loadingmsg').modal('hide');
                alert(request.responseText);
                location.reload();
            }
        }
    }
} 
    
    // disciplines!! _______________________________________________________________________________________
    
    // return disciplines of an user
    function listdisciplines(serverPage, tagID, type) {
      var request =  get_XmlHttp();		// call the function for the XMLHttpRequest instance
      
      userID = getUserID();
      // create the URL with data that will be sent to the server (a pair index=value)
      var  url = serverPage+'?disciplines='+type+'&id='+userID;
    
      request.open("GET", url, true);			// define the request
      request.send(null);		// sends data
         
      // Check request status
      // If the response is received completely, will be transferred to the HTML tag with tagID
      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          document.getElementById(tagID).innerHTML = request.responseText;
        }
      }
    }
    
    //return all info about a discipline
    function disciplineinfo(serverPage, tagID, type, id) { //type é o nome da "função" que esta no php
      var request =  get_XmlHttp();		// call the function for the XMLHttpRequest instance         
      // create the URL with data that will be sent to the server (a pair index=value)
      if(id=='')
        return;
        
      var  url = serverPage+'?disciplines='+type+'&id='+id;         
      
      request.open("GET", url, true);			// define the request
      request.send(null);		// sends data
         
      // Check request status
      // If the response is received completely, will be transferred to the HTML tag with tagID
      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          document.getElementById(tagID).innerHTML = request.responseText;
        }
      }      
    }
    // function that creates discipline form
    function adddiscipline_form(serverPage, tagID, type) {
      var request =  get_XmlHttp();		// call the function for the XMLHttpRequest instance         
      // create the URL with data that will be sent to the server (a pair index=value)
       
      clearSelected("discicplineselectid");
      var  url = serverPage+'?disciplines='+type;

      request.open("GET", url, true);			// define the request
      request.send(null);		// sends data
         
      // Check request status
      // If the response is received completely, will be transferred to the HTML tag with tagID
      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          document.getElementById(tagID).innerHTML = request.responseText;
        }
      }
    }
    
    // function to insert discipline
    function insertdiscipline(serverPage, tagID ) {
        
        var request =  get_XmlHttp();		// call the function for the XMLHttpRequest instance
        var userID = getUserID();       
        var name = $('#name').val();
        var academicYear = $('#academicyear').val();
        var courseYear = $('#courseyear').val();
        var sNumber = $('#studentsnumber').val();
        var inst = $('#inst').val();
        var course = $('#course').val();
        
        if(name.length == 0){
            $('#name').focus();
            alert("Input is empty!");
            return;
        };
        
        if(academicYear.length == 0){
            $('#academicyear').focus();
            alert("Input is empty!");
            return;
        };
        
        if(courseYear.length == 0){
            $('#courseYear').focus();
            alert("Input is empty!");
            return;
        };
        
        if(inst.length == 0){
            $('#inst').focus();
            alert("Input is empty!");
            return;
        };
        
        if(course.length == 0){
            $('#course').focus();
            alert("Input is empty!");
            return;
        };
        

      
      // create the URL with data that will be sent to the server (a pair index=value)   
      var  url = serverPage+'?disciplines=insertdiscipline&userID='+userID+'&name='+name+'&academicYear='+academicYear+
      '&courseYear='+courseYear+'&sNumber='+sNumber+'&inst='+inst+'&course='+course;        
  
      request.open("GET", url, true);			// define the request
      request.send(null);		// sends data
         
      // Check request status
      // If the response is received completely, will be transferred to the HTML tag with tagID
      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          document.getElementById(tagID).innerHTML = request.responseText;
          listdisciplines('php/disciplines.php','disciplineselect','disciplineselect'); 
        }
      }                
    }
    
    // function to update discipline    
    function updatediscipline(serverPage, tagID,type, id) {
        
        var request =  get_XmlHttp();		// call the function for the XMLHttpRequest instance        
        var name = $('#name').val();
        var academicYear = $('#academicyear').val();
        var courseYear = $('#courseyear').val();
        var sNumber = $('#studentsnumber').val();
        var inst = $('#inst').val();
        var course = $('#course').val();
        
        if(name.length == 0){
            $('#name').focus();
            alert("Input is empty!");
            return;
        };
        
        if(academicYear.length == 0){
            $('#academicyear').focus();
            alert("Input is empty!");
            return;
        };
        
        if(courseYear.length == 0){
            $('#courseYear').focus();
            alert("Input is empty!");
            return;
        };
        
        if(inst.length == 0){
            $('#inst').focus();
            alert("Input is empty!");
            return;
        };
        
        if(course.length == 0){
            $('#course').focus();
            alert("Input is empty!");
            return;
        };

      // create the URL with data that will be sent to the server (a pair index=value)   
      var  url = serverPage+'?disciplines='+type+'&id='+id+'&name='+name+'&academicYear='+academicYear+
      '&courseYear='+courseYear+'&sNumber='+sNumber+'&inst='+inst+'&course='+course;        
  
      request.open("GET", url, true);			// define the request
      request.send(null);		// sends data
         
      // Check request status
      // If the response is received completely, will be transferred to the HTML tag with tagID
      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          document.getElementById(tagID).innerHTML = request.responseText;
        }
      }
      
      listdisciplines('php/disciplines.php','disciplineselect','disciplineselect',getUserID()); // ALTERAR AQUI !!!!! FUNÇÃO QUE RECOLHE USER ID COOKIE
    }
    
    // function to remove discipline and content    
    function removediscipline(serverPage, tagID,type, id) {          
      if(id=="")
        return;
      
      var request =  get_XmlHttp();		// call the function for the XMLHttpRequest instance                           

      // create the URL with data that will be sent to the server (a pair index=value)   
      var  url = serverPage+'?disciplines='+type+'&id='+id;        
  
      request.open("GET", url, true);			// define the request
      request.send(null);		// sends data
         
      // Check request status
      // If the response is received completely, will be transferred to the HTML tag with tagID
      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          document.getElementById(tagID).innerHTML = request.responseText;
        }
      }
      listdisciplines('php/disciplines.php','disciplineselect','disciplineselect',getUserID()); // ALTERAR AQUI !!!!! FUNÇÃO QUE RECOLHE USER ID COOKIE
    }
    
    
    
    // Content!! _______________________________________________________________________________________
    
    // return disciplines of an user
    function listdisciplinescontent(serverPage, tagID, type) {
      var request =  get_XmlHttp();		// call the function for the XMLHttpRequest instance
    
       var userID = getUserID();
      // create the URL with data that will be sent to the server (a pair index=value)
      var  url = serverPage+'?content='+type+'&id='+userID;
    
      request.open("GET", url, true);			// define the request
      request.send(null);		// sends data
         
      // Check request status
      // If the response is received completely, will be transferred to the HTML tag with tagID
      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          document.getElementById(tagID).innerHTML = request.responseText;
        }
      }
    }
    // return contents of an user
    function listcontent(serverPage, tagID, type, disciplineID) {
      var request =  get_XmlHttp();		// call the function for the XMLHttpRequest instance
    
       var userID = getUserID();
      // create the URL with data that will be sent to the server (a pair index=value)
      var  url = serverPage+'?content='+type+'&userID='+userID+'&disciplineID='+disciplineID;
    
        
      request.open("GET", url, true);			// define the request
      request.send(null);		// sends data
         
      // Check request status
      // If the response is received completely, will be transferred to the HTML tag with tagID
      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          document.getElementById(tagID).innerHTML = request.responseText;
        }
      }
    }
    // function that creates content form
    function addcontent_form(serverPage, tagID, type) {
      var request =  get_XmlHttp();		// call the function for the XMLHttpRequest instance         
      // create the URL with data that will be sent to the server (a pair index=value)
       
      clearSelected("contentselectid");
      var  url = serverPage+'?content='+type;
    
      request.open("GET", url, true);			// define the request
      request.send(null);		// sends data
         
      // Check request status
      // If the response is received completely, will be transferred to the HTML tag with tagID
      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          document.getElementById(tagID).innerHTML = request.responseText;
          adddkeywords_form('php/content.php', 'keywordsselect', 'keywords_form');
        }
      }
              
    }
    
    //create keywords form
    function adddkeywords_form(serverPage, tagID, type) {
      var request =  get_XmlHttp();		// call the function for the XMLHttpRequest instance         
      // create the URL with data that will be sent to the server (a pair index=value)
             
      var  url = serverPage+'?content='+type;
    
      request.open("GET", url, true);			// define the request
      request.send(null);		// sends data
         
      // Check request status
      // If the response is received completely, will be transferred to the HTML tag with tagID
      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          document.getElementById(tagID).innerHTML = request.responseText;          
          $('#'+tagID).multipleSelect('refresh');
        }
      }           
    }
    
    //shows keywords about a content
    function contentkeywords(serverPage, tagID, type, idcontent) {
      var request =  get_XmlHttp();		// call the function for the XMLHttpRequest instance         
      // create the URL with data that will be sent to the server (a pair index=value)
             
      var  url = serverPage+'?content='+type+'&idcontent='+idcontent;
    
      request.open("GET", url, true);			// define the request
      request.send(null);		// sends data
         
      // Check request status
      // If the response is received completely, will be transferred to the HTML tag with tagID
      request.onreadystatechange = function() {
        if (request.readyState == 4) {                                   
            $('#keywordsselect').multipleSelect('setSelects',request.responseText.split(" "));
        }
      }           
    }
    
    // function that return content info
    function contentinfo(serverPage, tagID, type, id) {
      var request =  get_XmlHttp();		// call the function for the XMLHttpRequest instance         
      // create the URL with data that will be sent to the server (a pair index=value)
      
      if(id=="")      
          return;      
             
      var  url = serverPage+'?content='+type+'&id='+id;
    
      request.open("GET", url, true);			// define the request
      request.send(null);		// sends data
         
      // Check request status
      // If the response is received completely, will be transferred to the HTML tag with tagID
      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          document.getElementById(tagID).innerHTML = request.responseText;
        }
      }
      contentkeywords('php/content.php', 'keywordsselect', 'contentkeywords', id);
    }
    
    
    function insertcontent(serverPage, tagID, type) {
      var request =  get_XmlHttp();		// call the function for the XMLHttpRequest instance
        var data = new FormData();
        var userID = getUserID();
        data.append('userID',userID);
        data.append('content',type);
        var iddiscipline = document.getElementById('discicplineselectid').value;
        data.append('iddiscipline',iddiscipline);
        var name = $('#name').val();
        data.append('name',name);
        var file = document.getElementById('file');
        data.append('file', file.files[0]);
        var doi = $('#doi').val();
        data.append('doi', doi);
        var description = $('#description').val();
        data.append('description',description);         
        var keywords = $('#keywordsselect').multipleSelect('getSelects');
        data.append('keywords',keywords);                      
    
        if(name.length == 0){
            $('#name').focus();
            alert("Input is empty!");
            return;
        };
        if(!file.files[0] && doi.length == 0 ){
            $('#file').focus();
            $('#doi').focus();
            alert("Input is empty! You have to fill one..");
            return;
        };       
        if(description.length == 0){
            $('#description').focus();
            alert("Input is empty!");
            return;
        };

        
        
             
      // create the URL with data that will be sent to the server (a pair index=value)     
      //var  url = serverPage+'?content='+type+'&userID='+userID+'&iddiscipline='+iddiscipline;
    
      request.open("POST", serverPage, true);			// define the request
      request.send(data);		// sends data
         
      // Check request status
      // If the response is received completely, will be transferred to the HTML tag with tagID
      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          document.getElementById(tagID).innerHTML = request.responseText;          
        }
      }
        listcontent('php/content.php','contentselect','listcontent',iddiscipline);  
        
    }
    
    
    // function to update content    
    function updatecontent(serverPage, tagID,type) {
        
        var request =  get_XmlHttp();		// call the function for the XMLHttpRequest instance
        var data = new FormData();
        var userID = getUserID();                   
        data.append('userID',userID);
        data.append('content',type);
        var iddiscipline = document.getElementById('discicplineselectid').value;
        data.append('iddiscipline',iddiscipline);
        var idcontent = document.getElementById('contentselectid').value;
        data.append('idcontent',idcontent);
        var name = $('#name').val();
        data.append('name',name);
        var file = document.getElementById('file');
        data.append('file', file.files[0]);
        var doi = $('#doi').val();
        data.append('doi', doi);
        var description = $('#description').val();
        data.append('description',description);         
        var keywords = $('#keywordsselect').multipleSelect('getSelects');
        data.append('keywords',keywords);
        
        
        if(name.length == 0){
            $('#name').focus();
            alert("Input is empty!");
            return;
        };
        
        if(description.length == 0){
            $('#description').focus();
            alert("Input is empty!");
            return;
        };

      // create the URL with data that will be sent to the server (a pair index=value)              
      request.open("POST", serverPage, true);			// define the request
      request.send(data);		// sends data
         
      // Check request status
      // If the response is received completely, will be transferred to the HTML tag with tagID
      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          document.getElementById(tagID).innerHTML = request.responseText;
        }
      }
      
      listcontent('php/content.php','contentselect','listcontent',document.getElementById('discicplineselectid').value); // ALTERAR AQUI !!!!! FUNÇÃO QUE RECOLHE USER ID COOKIE
    }
    
    
    
    // remove content
    function removecontent(serverPage, tagID,type, id) {          
      if(id=="")
        return;
        
      var request =  get_XmlHttp();		// call the function for the XMLHttpRequest instance                           
      var data = new FormData();
      // create the URL with data that will be sent to the server (a pair index=value)         
      
      data.append('idcontent',id);
      data.append('content',type);
  
      request.open("POST", serverPage, true);			// define the request
      request.send(data);		// sends data
         
      // Check request status
      // If the response is received completely, will be transferred to the HTML tag with tagID
      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          document.getElementById(tagID).innerHTML = request.responseText;
          listcontent('php/content.php','contentselect','listcontent',document.getElementById('discicplineselectid').value);
        }
      }
        // ALTERAR AQUI !!!!! FUNÇÃO QUE RECOLHE USER ID COOKIE
    }
    
    
    //clear select items from select option 
    function clearSelected(objectID){        
        var elements = document.getElementById(objectID).options;
        if(elements[elements.selectedIndex])
            elements[elements.selectedIndex].selected = false;            
    }         
    
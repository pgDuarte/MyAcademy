function counter() {

    var count = 0;

    $.ajax(
    {
        url: "php/counter.php",
        cache: false,
        async: false
    })
    .done(function(result)
    {
        count = $.parseJSON(result);
    });


    var htmlcode = "<b>myAcademy currently has " + count + " files and counting!</b>";

    document.getElementById("file_count").innerHTML = htmlcode;

}





//TITLE_____________________________________________________________

function t_sorta(){

    
    var priv = document.getElementById('usertype').value;

    var func = 0;

    $.post("php/index.php", {func:func, priv:priv}, function(data){
        if (data[0] != '1') {
            var stuff = $.parseJSON(data);
            var array = stuff.split(";");
            var titles = $.parseJSON(array[0]);
            var years = $.parseJSON(array[1]);
            var types = $.parseJSON(array[2]);
            var names = $.parseJSON(array[3]);
            var urls = $.parseJSON(array[4]);
            var emails = $.parseJSON(array[5]);
            var purls = $.parseJSON(array[6]);

            var htmlcode = "<h2>Titles (Alphabetically Sorted)</h2></br></br><ul>"

            for (var i = 0; i < titles.length; i++) {
                if (titles[i] == titles[i-1]) {
                    htmlcode = htmlcode + '-  <a href="' + purls[i] + '" class="fa fa-file-o" target="_blank"></a>';
                }else{
                    htmlcode = htmlcode + '<li><i>"' + titles[i] + '"</i> - ' + years[i] + ' (' + types[i] + "), <b><a onclick=\"show('" + emails[i] + "')\">" + names[i] + '</a>, <a href="mailto:' 
                    + emails[i] + '">' + emails[i] + '</a>: </b></li><a href="' + purls[i] + '" class="fa fa-file-o" target="_blank"></a>  ';
                }
            };
        }else{
        var htmlcode = "<h2>Titles (Alphabetically Sorted)</h2></br></br><ul>No results were found..."
        }
        

        htmlcode = htmlcode + '</ul>';

        document.getElementById("page-wrapper").innerHTML = htmlcode;
    });

}

function t_sortt(){

    var priv = document.getElementById('usertype').value;

    var func = 1;

    $.post("php/index.php", {func:func, priv:priv}, function(data){
        if (data[0] != '1') {
            var stuff = $.parseJSON(data);
            var array = stuff.split(";");
            var titles = $.parseJSON(array[0]);
            var years = $.parseJSON(array[1]);
            var types = $.parseJSON(array[2]);
            var names = $.parseJSON(array[3]);
            var urls = $.parseJSON(array[4]);
            var emails = $.parseJSON(array[5]);
            var purls = $.parseJSON(array[6]);

            var htmlcode = "<h2>Titles (Sorted by Most Recent)</h2></br></br><ul>"

            for (var i = 0; i < titles.length; i++) {
                if (titles[i] == titles[i-1]) {
                    htmlcode = htmlcode + '-  <a href="' + purls[i] + '" class="fa fa-file-o" target="_blank"></a>';
                }else{
                    htmlcode = htmlcode + '<li><i>"' + titles[i] + '"</i> - ' + years[i] + ' (' + types[i] + "), <b><a onclick=\"show('" + emails[i] + "')\">" + names[i] + '</a>, <a href="mailto:' 
                    + emails[i] + '">' + emails[i] + '</a>: </b></li><a href="' + purls[i] + '" class="fa fa-file-o" target="_blank"></a>  ';
                }
            };
        }else{
            var htmlcode = "<h2>Titles (Sorted by Most Recent)</h2></br></br><ul>No results were found..."
        }
        

        htmlcode = htmlcode + '</ul>';

        document.getElementById("page-wrapper").innerHTML = htmlcode;
    });

}

    //AUTHOR_________________________________________________________

function a_sorta(){

    var func = 2;

    $.post("php/index.php", {func:func}, function(data){
        if (data[0] != '1') {
            var stuff = $.parseJSON(data);
            var array = stuff.split(":");
            var names = $.parseJSON(array[0]);
            var urls = $.parseJSON(array[1]);
            var emails = $.parseJSON(array[2]);

            var htmlcode = "<h2>Teachers (Alphabetically Sorted)</h2></br></br><ul>"

            for (var i = 0; i < names.length; i++) {
                htmlcode = htmlcode + "<li><b><a onclick=\"show('" + emails[i] + "')\">" + names[i] + "</a>, <a href=\"mailto:" 
                + emails[i] + "\">" + emails[i] + "</a></b></li></br>";
            };
        }else{
            var htmlcode = "<h2>Teachers (Alphabetically Sorted)</h2></br></br><ul>No results were found..."
        }
        

        htmlcode = htmlcode + '</ul>';

        document.getElementById("page-wrapper").innerHTML = htmlcode;
    });

}

function a_sortt(){

    var func = 3;

    $.post("php/index.php", {func:func}, function(data){
        if (data[0] != '1') {
            var stuff = $.parseJSON(data);
            var array = stuff.split(":");
            var names = $.parseJSON(array[0]);
            var urls = $.parseJSON(array[1]);
            var emails = $.parseJSON(array[2]);

            var htmlcode = "<h2>Teachers (Sorted by Most Recent)</h2></br></br><ul>"

            for (var i = 0; i < names.length; i++) {
                htmlcode = htmlcode + "<li><b><a onclick=\"show('" + emails[i] + "')\">" + names[i] + "</a>, <a href=\"mailto:" 
                + emails[i] + "\">" + emails[i] + "</a></b></li></br>";
            };
        }else{
            var htmlcode = "<h2>Teachers (Sorted by Most Recent)</h2></br></br><ul>No results were found..."
        }
        

        htmlcode = htmlcode + '</ul>';

        document.getElementById("page-wrapper").innerHTML = htmlcode;
    });

}

function c_sorta(){

    var func = 4;

    $.post("php/index.php", {func:func}, function(data){
        if (data[0] != '1') {
            var stuff = $.parseJSON(data);
            var array = stuff.split(":");
            var names = $.parseJSON(array[0]);
            var aYears = $.parseJSON(array[1]);
            var cYears = $.parseJSON(array[2]);
            var nStudents = $.parseJSON(array[3]);
            var uris = $.parseJSON(array[4]);
            var courses = $.parseJSON(array[5]);
            var insts = $.parseJSON(array[6]);
            var unames = $.parseJSON(array[7]);
            var urls = $.parseJSON(array[8]);

            var htmlcode = "<h2>Courses (Alphabetically Sorted)</h2></br></br><ul>"

            for (var i = 0; i < names.length; i++) {
                htmlcode = htmlcode + '<li>' + cYears[i] + ': <a href="' + uris[i] + '">' + names[i] + '</a> (' 
                + aYears[i] + ' year), ' + courses[i] + ", <a onclick=\"show('" + urls[i] + "')\"><b>" + unames[i] + '</b></a> - ' + nStudents[i] + 
                ' students registered.</li></br>';
            };
        }else{
            var htmlcode = "<h2>Courses (Alphabetically Sorted)</h2></br></br><ul>No results were found..."
        }
        

        htmlcode = htmlcode + '</ul>';

        document.getElementById("page-wrapper").innerHTML = htmlcode;
    });
}

function c_sortt(){

        var func = 4;

        $.post("php/index.php", {func:func}, function(data){
        if (data[0] != '1') {
            var stuff = $.parseJSON(data);
            var array = stuff.split(":");
            var names = $.parseJSON(array[0]);
            var aYears = $.parseJSON(array[1]);
            var cYears = $.parseJSON(array[2]);
            var nStudents = $.parseJSON(array[3]);
            var uris = $.parseJSON(array[4]);
            var courses = $.parseJSON(array[5]);
            var insts = $.parseJSON(array[6]);
            var unames = $.parseJSON(array[7]);
            var urls = $.parseJSON(array[8]);

            var htmlcode = "<h2>Courses (Sorted by Most Recent)</h2></br></br><ul>"

            for (var i = 0; i < names.length; i++) {
                htmlcode = htmlcode + '<li>' + cYears[i] + ': <a href="' + uris[i] + '">' + names[i] + '</a> (' 
                + aYears[i] + ' year), ' + courses[i] + ", <a onclick=\"show('" + urls[i] + "')\"><b>" + unames[i] + '</b></a> - ' + nStudents[i] + 
                ' students registered.</li></br>';
            };
        }else{
            var htmlcode = "<h2>Courses (Sorted by Most Recent)</h2></br></br><ul>No results were found..."
        }    
        
        htmlcode = htmlcode + '</ul>';

        document.getElementById("page-wrapper").innerHTML = htmlcode;
    });

}


//MSC_________________________________________________________________

function m_sorta(){

    var func = 5;
    var priv = document.getElementById('usertype').value;

    $.post("php/index.php", {func:func, priv:priv}, function(data){
        if (data[0] != '1') {
            var stuff = $.parseJSON(data);
            var array = stuff.split(";");
            var titles = $.parseJSON(array[0]);
            var years = $.parseJSON(array[1]);
            var types = $.parseJSON(array[2]);
            var names = $.parseJSON(array[3]);
            var urls = $.parseJSON(array[4]);
            var emails = $.parseJSON(array[5]);
            var purls = $.parseJSON(array[6]);

            var htmlcode = "<h2>MSc Thesis (Alphabetically Sorted)</h2></br></br><ul>"

            for (var i = 0; i < titles.length; i++) {
                if (titles[i] == titles[i-1]) {
                    htmlcode = htmlcode + '-  <a href="' + purls[i] + '" class="fa fa-file-o" target="_blank"></a>';
                }else{
                    htmlcode = htmlcode + '<li><i>"' + titles[i] + '"</i> - ' + years[i] + ' (' + types[i] + "), <b><a onclick=\"show('" + emails[i] + "')\">" + names[i] + '</a>, <a href="mailto:' 
                    + emails[i] + '">' + emails[i] + '</a>: </b></li><a href="' + purls[i] + '" class="fa fa-file-o" target="_blank"></a>  ';
                }
            };
        }else{
            var htmlcode = "<h2>MSc Thesis (Alphabetically Sorted)</h2></br></br><ul>No results were found..."
        }
        

        htmlcode = htmlcode + '</ul>';

        document.getElementById("page-wrapper").innerHTML = htmlcode;
    });

}

function m_sortt(){

    var func = 6;
    var priv = document.getElementById('usertype').value;

    $.post("php/index.php", {func:func, priv:priv}, function(data){
        if (data[0] != '1') {
            var stuff = $.parseJSON(data);
            var array = stuff.split(";");
            var titles = $.parseJSON(array[0]);
            var years = $.parseJSON(array[1]);
            var types = $.parseJSON(array[2]);
            var names = $.parseJSON(array[3]);
            var urls = $.parseJSON(array[4]);
            var emails = $.parseJSON(array[5]);
            var purls = $.parseJSON(array[6]);

            var htmlcode = "<h2>MSc Thesis (Sorted by Most Recent)</h2></br></br><ul>"

            for (var i = 0; i < titles.length; i++) {
                if (titles[i] == titles[i-1]) {
                    htmlcode = htmlcode + '-  <a href="' + purls[i] + '" class="fa fa-file-o" target="_blank"></a>';
                }else{
                    htmlcode = htmlcode + '<li><i>"' + titles[i] + '"</i> - ' + years[i] + ' (' + types[i] + "), <b><a onclick=\"show('" + emails[i] + "')\">" + names[i] + '</a>, <a href="mailto:' 
                    + emails[i] + '">' + emails[i] + '</a>: </b></li><a href="' + purls[i] + '" class="fa fa-file-o" target="_blank"></a>  ';
                }
            };

        }else{
            var htmlcode = "<h2>MSc Thesis (Sorted by Most Recent)</h2></br></br><ul>No results were found..."
        }
        
        htmlcode = htmlcode + '</ul>';

        document.getElementById("page-wrapper").innerHTML = htmlcode;
    });

}


//PHD_________________________________________________________________

function p_sorta(){

    var func = 7;
    var priv = document.getElementById('usertype').value;

    $.post("php/index.php", {func:func, priv:priv}, function(data){
        
        if (data[0] != '1') {
            var stuff = $.parseJSON(data);
            var array = stuff.split(";");
            var titles = $.parseJSON(array[0]);
            var years = $.parseJSON(array[1]);
            var types = $.parseJSON(array[2]);
            var names = $.parseJSON(array[3]);
            var urls = $.parseJSON(array[4]);
            var emails = $.parseJSON(array[5]);
            var purls = $.parseJSON(array[6]);

            var htmlcode = "<h2>PhD Thesis (Alphabetically Sorted)</h2></br></br><ul>"

            for (var i = 0; i < titles.length; i++) {
                if (titles[i] == titles[i-1]) {
                    htmlcode = htmlcode + '-  <a href="' + purls[i] + '" class="fa fa-file-o" target="_blank"></a>';
                }else{
                    htmlcode = htmlcode + '<li><i>"' + titles[i] + '"</i> - ' + years[i] + ' (' + types[i] + "), <b><a onclick=\"show('" + emails[i] + "')\">" + names[i] + '</a>, <a href="mailto:' 
                    + emails[i] + '">' + emails[i] + '</a>: </b></li><a href="' + purls[i] + '" class="fa fa-file-o" target="_blank"></a>  ';
                }
            };
        }else{
            var htmlcode = "<h2>PhD Thesis (Alphabetically Sorted)</h2></br></br><ul>No results were found..."
        }

            htmlcode = htmlcode + '</ul>';

        document.getElementById("page-wrapper").innerHTML = htmlcode;
    });

}

function p_sortt(){

    var func = 8;
    var priv = document.getElementById('usertype').value;

    $.post("php/index.php", {func:func, priv:priv}, function(data){
        if (data[0] != '1') {    
            var stuff = $.parseJSON(data);
            var array = stuff.split(";");
            var titles = $.parseJSON(array[0]);
            var years = $.parseJSON(array[1]);
            var types = $.parseJSON(array[2]);
            var names = $.parseJSON(array[3]);
            var urls = $.parseJSON(array[4]);
            var emails = $.parseJSON(array[5]);
            var purls = $.parseJSON(array[6]);

            var htmlcode = "<h2>PhD Thesis (Sorted by Most Recent)</h2></br></br><ul>"

            for (var i = 0; i < titles.length; i++) {
                if (titles[i] == titles[i-1]) {
                    htmlcode = htmlcode + '-  <a href="' + purls[i] + '" class="fa fa-file-o" target="_blank"></a>';
                }else{
                    htmlcode = htmlcode + '<li><i>"' + titles[i] + '"</i> - ' + years[i] + ' (' + types[i] + "), <b><a onclick=\"show('" + emails[i] + "')\">" + names[i] + '</a>, <a href="mailto:' 
                    + emails[i] + '">' + emails[i] + '</a>: </b></li><a href="' + purls[i] + '" class="fa fa-file-o" target="_blank"></a>  ';
                }
            };
        }else{
            var htmlcode = "<h2>PhD Thesis (Sorted by Most Recent)</h2></br></br><ul>No results were found..."
        }

        htmlcode = htmlcode + '</ul>';

        document.getElementById("page-wrapper").innerHTML = htmlcode;
    });

}

function listAllDisciplinesbyUser(id)
{
      var userID = id;
      var request =  get_XmlHttp(); 
      
      var formData = new FormData();
      formData.append('teachingfunction', 'listDisciplinesbyUser');
      formData.append('id', userID);
      
      request.open("POST", "php/teaching.php", true);           // define the request
      request.send(formData);       // sends data
      
      request.onreadystatechange = function() {
      if (request.readyState == 4) {
         document.getElementById("22listAllDisciplines").innerHTML = request.responseText;
      }
      }
}

                                                    //create keywords form
        function listCourseSelect(id) {
          var request =  get_XmlHttp();     // call the function for the XMLHttpRequest instance         
          // create the URL with data that will be sent to the server (a pair index=value)
         
          var formData = new FormData();
          formData.append('teachingfunction', 'listCourseSelect');
          formData.append('id', id);
      
           request.open("POST", "php/teaching.php", true);          // define the request
           request.send(formData);      // sends data
      
          
             
          // Check request status
          // If the response is received completely, will be transferred to the HTML tag with tagID
          request.onreadystatechange = function() {
            if (request.readyState == 4) {
              document.getElementById("comboboxcourse").innerHTML = request.responseText;          
              //$('#combobox').multipleSelect('refresh');
            }
          }           
        }
        
       function listAcademicyearSelect(id) {
          var request =  get_XmlHttp();     // call the function for the XMLHttpRequest instance         
          // create the URL with data that will be sent to the server (a pair index=value)
         
          var formData = new FormData();
          formData.append('teachingfunction', 'listAcademicyearSelect');
          formData.append('id', id);
      
           request.open("POST", "php/teaching.php", true);          // define the request
           request.send(formData);      // sends data
      
          
             
          // Check request status
          // If the response is received completely, will be transferred to the HTML tag with tagID
          request.onreadystatechange = function() {
            if (request.readyState == 4) {
              document.getElementById("comboboxyear").innerHTML = request.responseText;      
             
            
            }
          }           
        }
        
        
         function listinstitutionSelect(id) {
          var request =  get_XmlHttp();     // call the function for the XMLHttpRequest instance         
          // create the URL with data that will be sent to the server (a pair index=value)
         
          var formData = new FormData();
          formData.append('teachingfunction', 'listinstitutionSelect');
          formData.append('id', id);
      
           request.open("POST", "php/teaching.php", true);          // define the request
           request.send(formData);      // sends data
      
          
             
          // Check request status
          // If the response is received completely, will be transferred to the HTML tag with tagID
          request.onreadystatechange = function() {
            if (request.readyState == 4) {
              document.getElementById("comboboxinst").innerHTML = request.responseText;          
            
            }
          }           
        }
        
        
        function sendqueries(query, id)
        {
            var userID = id;
            var request =  get_XmlHttp();   
      
            var formData = new FormData();
            formData.append('teachingfunction', 'listAlldisciplinesbyquery');
            formData.append('id', userID);
            formData.append('query', query);
            
            request.open("POST", "php/teaching.php", true);         // define the request
            request.send(formData);     // sends data
            
            request.onreadystatechange = function() {
            if (request.readyState == 4) {
               document.getElementById("22listAllDisciplines").innerHTML = request.responseText;
            }
            }
              
        }
        
        
        
        function search()
        {
            var e = document.getElementById("comboboxcourse"); // vai buscar o valor que está selecionado
            var idcourse = e.options[e.selectedIndex].value;
            
            
            var d = document.getElementById("comboboxyear"); // vai buscar o valor que está selecionado
            var idyear = d.options[d.selectedIndex].value;
            
            
            var f = document.getElementById("comboboxinst"); // vai buscar o valor que está selecionado
            var idinst = f.options[f.selectedIndex].value;
            
            
         ///course= replace(idcourse, '-', ' ');
         //inst =  replace(idinst, '-', ' ');
            
            
            if (idcourse)
            {
              
                  if (idyear)
                  {
                    
                      if (idinst)
                     {
                      var query = "select * from discipline where idusers='2' and courseName = '"+idcourse+"' and academicYear = '"+idyear+"' and inst ='"+idinst+"';";
                     // alert(query);
                       sendqueries(query, id);
                      // faz query com course, year, e inst
                     }else {
                             var query = "select * from discipline where idusers='2' and courseName = '"+idcourse+"' and academicYear = '"+idyear+"';";
                            // alert(query);
                             sendqueries(query, id);
                             //faz query com course e com year
                            }
                  }else {
                           if (idinst)
                           {
                           var query = "select * from discipline where idusers='2' and courseName = '"+idcourse+"'  and inst ='"+idinst+"';";
                          //  alert(query);
                              sendqueries(query, id);
                           // faz query com  course e com inst
                           }
                           else {
                            var query = "select * from discipline where idusers='2' and courseName = '"+idcourse+"';";
                              sendqueries(query, id);
                           // faz query com idcourse
                           }
                         }
            }
            else if (idyear)
            {
                if (idinst)
                {
                    var query = "select * from discipline where idusers='2'  and academicYear = '"+idyear+"' and inst ='"+idinst+"';";
                      sendqueries(query, id);
                   // alert("só idyear e id inst");
                //Query por instituição e year
                }else 
                {
                     var query = "select * from discipline where idusers='2'  and academicYear = '"+idyear+"';";
                       sendqueries(query, id);
                }
            }
            else  if (idinst)
            {
             var query = "select * from discipline where idusers='2'  and inst ='"+idinst+"';";
               sendqueries(query, id);
            // alert("só  id inst");
            // faz a query só para o idinst
            }else {listAllDisciplinesbyUser(id);}
        }
        
        
   



function get_XmlHttp() {
    // create the variable that will contain the instance of the XMLHttpRequest object (initially with null value)
    var xmlHttp = null;
  
    if(window.XMLHttpRequest) {     // for Forefox, IE7+, Opera, Safari, ...
      xmlHttp = new XMLHttpRequest();
    }
    else if(window.ActiveXObject) { // for Internet Explorer 5 or 6
      xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
  
    return xmlHttp;
  }
  
  // sends data to a php file, via GET, and displays the received answer
  
  // aqui tave
  function ajaxrequest(serverPage, tagID, userID) {
    var request =  get_XmlHttp();       // call the function for the XMLHttpRequest instance
  
    // create the URL with data that will be sent to the server (a pair index=value)
    var  url = serverPage+'?userList='+tagID+'&id='+userID;
  
    request.open("GET", url, true);         // define the request
    request.send(null);     // sends data
  
    // Check request status
    // If the response is received completely, will be transferred to the HTML tag with tagID
    request.onreadystatechange = function() {
      if (request.readyState == 4) {
        document.getElementById(tagID).innerHTML = request.responseText;
      }
    }
  }
  
  


function show(email){

    var stuff;

    $.post("php/idbyemail.php", {email:email}, function(data){
        stuff = $.parseJSON(data);
        var x = 
            "<div class=\"jumbotron\"> <div class=\"row\"> <div class=\"col-lg-2 text-center\"> <a id=\"image\">  <img src=\"FFFFFF-1.png\" alt=\"\" onload=\"ajaxrequest('php/server.php', 'image', '" + stuff + "'), ajaxrequest('php/server.php', 'name', '" + stuff + "'), ajaxrequest('php/server.php', 'info', '" + stuff + "')\" /> </a> </div> <div class=\"col-lg-4 text-center\" id=\"name\"> <h2> </br><small> </small></h2> </div> <div class=\"col-lg-2 text-center\"> <h2> </h2> </div> <div class=\"col-lg-4 text-left\" id=\"info\"> </div> </br></br></br><div class=\"row\"><pre><center><a onclick=\"showpubs('" + email + "')\" class=\"fa fa-file-text\"><h5>  Publications  </h5></a><a onclick=\"showsup('" + email + "')\" class=\"fa fa-eye\"><h5>  Thesis Supervision  </h5></a><a onclick=\"showex('" + email + "')\" class=\"fa fa-search\"><h5>  Thesis Examination  </h5></a><a onclick=\"showteach('" + email + "')\" class=\"fa fa-book\"><h5>  Teaching  </h5></a></center></pre></div> </div></div> <div id=\"din_content\">   </div>";

        document.getElementById("page-wrapper").innerHTML = x;
        
    }); 

    
}

function showpubs(email) {

    var stuff;

    $.post("php/idbyemail.php", {email:email}, function(data){
        stuff = $.parseJSON(data);
        var x = 
            "<img src=\"FFFFFF-1.png\" alt=\"\" onload=\"listAllPubs('" + stuff + "'), listAlltypePubs('" + stuff + "')\"/><div class=\"row\"> <div class=\"col-lg-12\" id=\"indice\"> <ol class=\"breadcrumb\"> </ol> </div> </div> <div class=\"row\"> <div class=\"col-lg-12\" id=\"listpubsvdsv\"> </div> </div>";

        document.getElementById("din_content").innerHTML = x;
        
    }); 

}

function showsup(email) {
    document.getElementById("din_content").innerHTML = "BADADAD";
}

function showex(email) {
    
}

function showteach(email) {
    
    $.post("php/idbyemail.php", {email:email}, function(data){
        stuff = $.parseJSON(data);
        document.getElementById("din_content").innerHTML = "<div class=\"row\"> <div class=\"col-lg-3\"> <label>Course</label> <select id=\"comboboxcourse\" style=\"width:250px;\"> </select> </div> <div class=\"col-lg-3\"> <label>Academic Year</label> <select id=\"comboboxyear\" style=\"width:250px;\"> </select> </div> <div class=\"col-lg-3\"> <label>Institution</label> <select id=\"comboboxinst\" style=\"width:250px;\"> </select> </div> </div> <div class=\"row\"> <div class=\"col-lg-12 text-right\"> <p> <button type=\"button\" class=\"fa fa-search btn btn-inverse\" onclick=\"search();\"></button> </p> </div> </div> <div class=\"row\"> <div class=\"col-lg-12\"> <p></br></p> </div> </div> <div class=\"row\"> <div class=\"col-lg-12\" id=\"22listAllDisciplines\"> </div> </div> <img src=\"FFFFFF-1.png\" alt=\"\" onload=\"listCourseSelect(" + stuff + "), listAcademicyearSelect(" + stuff + "), listinstitutionSelect(" + stuff + "), listAllDisciplinesbyUser(" + stuff + ")\"/> ";
        
    }); 
}


//DESTROY SESSION

function destroyer() {
    
    var func = 9;

    $.post("php/index.php", {func:func}, function(data){
             
    });

    window.location.replace("index.html");
}



//_____________________________________________

function kw_search() {

    var search_results, htmlcode;
    var func = 10;
    var search = document.getElementById('inputString').value;
    var priv = document.getElementById('usertype').value;

    $.post("php/index.php", {func:func, search:search, priv:priv}, function(data){

        var htmlcode = '<h2>Search Results</h2>';
        

        if (data[0] == "B") {
            data = data.substring(1);
            var stuff = $.parseJSON(data);
            var superarray = stuff.split("|");
            var pubarray = superarray[0];
            var carray = superarray[1];
            //pubs
            pubarray = pubarray.split(";");
            
            var titles = $.parseJSON(pubarray[0]);
            var years = $.parseJSON(pubarray[1]);
            var types = $.parseJSON(pubarray[2]);
            var names = $.parseJSON(pubarray[3]);
            var urls = $.parseJSON(pubarray[4]);
            var emails = $.parseJSON(pubarray[5]);
            var purls = $.parseJSON(pubarray[6]);

            var number = titles.length;
            var htmlcode = htmlcode + '</br> <h3>Publications: (' + number + ' Results)</h3>';

            for (var i = 0; i < titles.length; i++) {
                htmlcode = htmlcode + '<li><i>"' + titles[i] + '"</i> - ' + years[i] + ' (' + types[i] + "), <b><a onclick=\"show('" + emails[i] + "')\">" + names[i] + '</a>, <a href="mailto:' 
                + emails[i] + '">' + emails[i] + '</a> - <a href="' + purls[i] + '" class="fa fa-file-o" target="_blank"></a></b></li></br>';
            };

            htmlcode = htmlcode + '</ul>';


            //courses
            carray = carray.split(";");
            
            var cnames = $.parseJSON(carray[0]);
            var aYears = $.parseJSON(carray[1]);
            var cYears = $.parseJSON(carray[2]);
            var nStudents = $.parseJSON(carray[3]);
            var uris = $.parseJSON(carray[4]);
            var courses = $.parseJSON(carray[5]);
            var insts = $.parseJSON(carray[6]);
            var unames = $.parseJSON(carray[7]);
            var urls = $.parseJSON(carray[8]);

            htmlcode = htmlcode + '</br><h3>Courses: (' + cnames.length + ' Results)</h3></br></br><ul>';

            for (var i = 0; i < cnames.length; i++) {
                htmlcode = htmlcode + '<li>' + cYears[i] + ': <a href="' + uris[i] + '">' + cnames[i] + '</a> (' 
                + aYears[i] + ' year), ' + courses[i] + ", <a onclick=\"show('" + urls[i] + "')\"><b>" + unames[i] + '</b></a> - ' + nStudents[i] + 
                ' students registered.</li></br>';
            };

            htmlcode = htmlcode + '</ul>';

        }else if(data[0] == "P"){
            data = data.substring(1);
            var pubarray = $.parseJSON(data);
            
            //pubs
            pubarray = pubarray.split(";");
            
            var titles = $.parseJSON(pubarray[0]);
            var years = $.parseJSON(pubarray[1]);
            var types = $.parseJSON(pubarray[2]);
            var names = $.parseJSON(pubarray[3]);
            var urls = $.parseJSON(pubarray[4]);
            var emails = $.parseJSON(pubarray[5]);
            var purls = $.parseJSON(pubarray[6]);

            var number = titles.length;
            var htmlcode = htmlcode + '</br> <h3>Publications: (' + number + ' Results)</h3>';

            for (var i = 0; i < titles.length; i++) {
                htmlcode = htmlcode + '<li><i>"' + titles[i] + '"</i> - ' + years[i] + ' (' + types[i] + "), <b><a onclick=\"show('" + emails[i] + "')\">" + names[i] + '</a>, <a href="mailto:' 
                + emails[i] + '">' + emails[i] + '</a> - <a href="' + purls[i] + '" class="fa fa-file-o" target="_blank"></a></b></li></br>';
            };

            htmlcode = htmlcode + '</ul>';
            
        }else if(data[0] == "C"){
            data = data.substring(1);
            var carray = $.parseJSON(data);
            carray = carray.split(";");
            
            var cnames = $.parseJSON(carray[0]);
            var aYears = $.parseJSON(carray[1]);
            var cYears = $.parseJSON(carray[2]);
            var nStudents = $.parseJSON(carray[3]);
            var uris = $.parseJSON(carray[4]);
            var courses = $.parseJSON(carray[5]);
            var insts = $.parseJSON(carray[6]);
            var unames = $.parseJSON(carray[7]);
            var urls = $.parseJSON(carray[8]);

            htmlcode = htmlcode + '</br><h3>Courses: (' + cnames.length + ' Results)</h3></br></br><ul>';

            for (var i = 0; i < cnames.length; i++) {
                htmlcode = htmlcode + '<li>' + cYears[i] + ': <a href="' + uris[i] + '">' + cnames[i] + '</a> (' 
                + aYears[i] + ' year), ' + courses[i] + ", <a onclick=\"show('" + urls[i] + "')\"><b>" + unames[i] + '</b></a> - ' + nStudents[i] + 
                ' students registered.</li></br>';
            };

            htmlcode = htmlcode + '</ul>';

        }else{
            htmlcode = htmlcode + '</br></br>No results were found...';
        }

        document.getElementById("page-wrapper").innerHTML = htmlcode;
        
    });
    

}



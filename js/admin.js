//list keywords
function listkeywords(){
    var request =  get_XmlHttp();
    var data = new FormData();
       
    data.append('type','listkeywords');
    
    request.open("POST","php/admin.php", true);         // define the request
    request.send(data);     // sends data
    
    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            document.getElementById("keywordsselect").innerHTML = request.responseText;
        }
    }
}


//add kw form
function addkw_form(){
    
    clearSelected("keywordsselect");    
                
    document.getElementById("dyn_kw").innerHTML = "<label>Add Keyword</label> <br/> <input class=\"form-control\" id=\"new_kw\"> <br/> <button type=\"button\" class=\"btn btn-success btn-xs\" onclick=\"add_kw()\">Add</button>";
    
}

function add_kw(){
    var request =  get_XmlHttp();   
    var data = new FormData();
    
    data.append('type','insertkeyword');
    
    var kw = $('#new_kw').val();
    
    if(kw.length == 0){
      $('#new_kw').focus();
      alert("Input is empty!");
      return;
    };  

    data.append('kw',kw); 

    request.open("POST","php/admin.php", true);         // define the request
    request.send(data);     // sends data

    request.onreadystatechange = function() {
        if (request.readyState == 4) {  
            if(request.responseText == 0){
                listkeywords();
            }else if(request.responseText == 1){
                alert("Keyword already exists...")
            }
        }
    }

}

function rm_kw(){
    var sel = document.getElementById('keywordsselect');
    var kw = sel.options[sel.selectedIndex].value;
    var kwid = sel.options[sel.selectedIndex].id;
    //in use? 
    var request =  get_XmlHttp();   
    var data = new FormData();
    
    data.append('type','checkkeyword');
    data.append('kwid',kwid); 

    request.open("POST","php/admin.php", true);         // define the request
    request.send(data);     // sends data

    request.onreadystatechange = function() {
        if (request.readyState == 4) {  
            if(request.responseText == 0){
                //not in use -> remove
                remover(kwid);
                document.getElementById("dyn_kw").innerHTML ="";
            }else if(request.responseText == 1){
                //in use
                alert("Can't remove. Keyword is being used.")
            }
        }
    }
}
function remover(kwid){
    var request =  get_XmlHttp();   
    var data = new FormData();
    
    data.append('type','rmkeyword');
    data.append('kwid',kwid); 

    request.open("POST","php/admin.php", true);         // define the request
    request.send(data);     // sends data

    request.onreadystatechange = function() {
        if (request.readyState == 4) {  
            alert("Keyword removed.");
            listkeywords();
        }
    }
}



function check_kw(){

    var sel = document.getElementById('keywordsselect');
    var kw = sel.options[sel.selectedIndex].value;
    var kwid = sel.options[sel.selectedIndex].id;
    //in use? 
    var request =  get_XmlHttp();   
    var data = new FormData();
    
    data.append('type','checkkeyword');
    data.append('kwid',kwid); 

    request.open("POST","php/admin.php", true);         // define the request
    request.send(data);     // sends data

    request.onreadystatechange = function() {
        if (request.readyState == 4) {  
            if(request.responseText == 0){
                //not in use
                document.getElementById("dyn_kw").innerHTML = "<label>Edit Keyword</label><br/> <input class=\"form-control\" value=\"" + kw + "\" id = \"" + kwid + "\" name = \"toedit\"> <br/> <button type=\"button\" onclick=\"edit_kw()\" class=\"btn btn-success btn-xs\">Update</button>";
            }else if(request.responseText == 1){
                //in use
                document.getElementById("dyn_kw").innerHTML = "<label>Edit Keyword</label><br/> <input value=\"" + kw + "\" class=\"form-control\" id=\"disabledInput\" type=\"text\" placeholder=\"Disabled input\" disabled=\"\"> <br/> <button type=\"button\" class=\"btn btn-danger btn-xs\">In Use</button>";
            }
        }
    }
}


function edit_kw(){

    var sel = document.getElementById('keywordsselect');
    var kwid = sel.options[sel.selectedIndex].id;
    var kw = document.getElementsByName("toedit")[0].value;
    
    var request =  get_XmlHttp();   
    var data = new FormData();
    
    data.append('type','editkeyword');
    data.append('kwid',kwid); 
    data.append('kw',kw); 

    request.open("POST","php/admin.php", true);         // define the request
    request.send(data);     // sends data

    request.onreadystatechange = function() {
        if (request.readyState == 4) {  
            listkeywords();
            document.getElementById("dyn_kw").innerHTML ="";
        }
    }
}


//list all users
function listusers(){
    var request =  get_XmlHttp();
    var data = new FormData();
       
    data.append('type','listusers');
    data.append('iduser',getUserID());
    
    request.open("POST","php/admin.php", true);			// define the request
    request.send(data);		// sends data
    
    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            document.getElementById("usersselect").innerHTML = request.responseText;
        }
    }
}

//list user info
function listuserinfo(iduser){
    var request =  get_XmlHttp();
    var data = new FormData();
    
    if(iduser == "")
        return;
        
    listimage(iduser);
    data.append('type','listuserinfo');
    data.append('iduser',iduser);    
    
    
    request.open("POST","php/admin.php", true);			// define the request
    request.send(data);		// sends data
    
    request.onreadystatechange = function() {
        if (request.readyState == 4) {        
            document.getElementById("userinfo").innerHTML = request.responseText;
        }
    }
}
//list user info
function listimage(iduser){
    var request =  get_XmlHttp();
    var data = new FormData();
    
    if(iduser == "")
        return;
        
    data.append('type','listimage');
    data.append('iduser',iduser);    
    
    
    request.open("POST","php/admin.php", true);			// define the request
    request.send(data);		// sends data
    
    request.onreadystatechange = function() {
        if (request.readyState == 4) {        
            document.getElementById("userimage").innerHTML = request.responseText;
        }
    }
}

//add user form
function adduser_form(){
        
    var request =  get_XmlHttp();
    
    clearSelected("usersselect");    
        
    request.open("GET","php/admin.php?type=adduser_form", true);			// define the request
    request.send(null);		// sends data
    
    request.onreadystatechange = function() {
        if (request.readyState == 4) {        
            document.getElementById("userinfo").innerHTML = request.responseText;
        }
    }
    addimage_form();
}

//add image form
function addimage_form(){
    var request =  get_XmlHttp(); 
        
    request.open("GET","php/admin.php?type=addimage_form", true);			// define the request
    request.send(null);		// sends data
    
    request.onreadystatechange = function() {
        if (request.readyState == 4) {        
            document.getElementById("userimage").innerHTML = request.responseText;
        }
    }
}

//insert user
function insertuser(){
    var request =  get_XmlHttp();   
    var data = new FormData();
    
    data.append('type','insertuser');
    
    var name = $('#name').val();
    var usertag = $('#usertag').val();
    var email = $('#email').val();    
    var password = $('#password').val();
    var phnumber = $('#phnumber').val();
    var profile = $('#profile').val();
    var url = $('#url').val();
    var file = document.getElementById('image');
    var image = file.files[0]; 
    
    if(name.length == 0){
      $('#name').focus();
      alert("Input is empty!");
      return;
    };    
    if(usertag.length == 0){
      $('#usertag').focus();
      alert("Input is empty!");
      return;
    };    
    if(email.length == 0){
      $('#email').focus();
      alert("Input is empty!");
      return;
    };    
    if(password.length == 0){
      $('#password').focus();
      alert("Input is empty!");
      return;
    };
    if(phnumber.length == 0){
      $('#phnumber').focus();
      alert("Input is empty!");
      return;
    };
    if(profile.length == 0){
      $('#profile').focus();
      alert("Input is empty!");
      return;
    };   
    if(!image){
      $('#image').focus();
      alert("Input is empty!");
      return;
    }; 
    //verify extension file
    var ext = image['name'].split('.')[1];
    if(ext != "jpg" && ext != "JPG" && ext != "JPEG" && ext != "jpeg" && ext != "png" && ext != "PNG" && ext != "GIF" && ext != "gif" ){
        $('#image').focus();
        alert("Please enter a valid file..");
        return;
    };
    
    var hashpass= CryptoJS.MD5(password);
    data.append('name',name);
    data.append('usertag',usertag);
    data.append('email',email);
    data.append('hashpass',hashpass);    
    data.append('phnumber',phnumber);
    data.append('profile',profile);
    data.append('url',url);
    data.append('image',image);
       
    
    request.open("POST","php/admin.php", true);			// define the request
    request.send(data);		// sends data
    
       
    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            if(request.responseText == "usertag")
            {
                $('#usertag').focus();
                alert("User Tag already exists! Please try another..");
                return;
            }else if(request.responseText == "email")
            {
                $('#email').focus();
                alert("E-mail already exists! Please try another..");
                return;
            }else
            {
                document.getElementById("userinfo").innerHTML = request.responseText;
                listusers();
                addimage_form();
            }
        }
    }
}

//update user info
function updateuser(iduser){
    var request =  get_XmlHttp();   
    var data = new FormData();
    
    data.append('type','updateuser');
    
    var name = $('#name').val();
    var usertag = $('#usertag').val();        
    var password = $('#password').val();
    var phnumber = $('#phnumber').val();
    var profile = $('#profile').val();
    var url = $('#url').val();
    var file = document.getElementById('image');
    var image = file.files[0]; 
    
    if(name.length == 0){
      $('#name').focus();
      alert("Input is empty!");
      return;
    };             
    if(phnumber.length == 0){
      $('#phnumber').focus();
      alert("Input is empty!");
      return;
    };
    if(profile.length == 0){
      $('#profile').focus();
      alert("Input is empty!");
      return;
    };   
    
    //update image if selected
    if(image){      
      //verify extension file
        var ext = image['name'].split('.')[1];
        if(ext != "jpg" && ext != "JPG" && ext != "JPEG" && ext != "jpeg" && ext != "png" && ext != "PNG" && ext != "GIF" && ext != "gif" ){
            $('#image').focus();
            alert("Please enter a valid file..");
            return;
        };
        updateimage(iduser,image);  
    }; 
        
    if(password.length != 0){
        var hashpass= CryptoJS.MD5(password);
        updatepassword(iduser,hashpass);
    };
    
    data.append('iduser',iduser);
    data.append('name',name);
    data.append('usertag',usertag); 
    data.append('phnumber',phnumber);
    data.append('profile',profile);
    data.append('url',url);
       
    
    request.open("POST","php/admin.php", true);			// define the request
    request.send(data);		// sends data
    
       
    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            listusers();
            addimage_form();
            document.getElementById("userinfo").innerHTML = request.responseText;               
        }
    }      
}
function updatepassword(iduser,hashpass){

    var request =  get_XmlHttp();   
    var data = new FormData();
    
    data.append('type','updatepassword');
    data.append('iduser',iduser);
    data.append('hashpass',hashpass);
    
    request.open("POST","php/admin.php", true);			// define the request
    request.send(data);		// sends data
    
}

function updateimage(iduser,image){

    var request =  get_XmlHttp();   
    var data = new FormData();
    
    data.append('type','updateimage');
    data.append('iduser',iduser);
    data.append('image',image);
    
    request.open("POST","php/admin.php", true);			// define the request
    request.send(data);		// sends data
    
}
//remove user
function asktoremove(iduser){
    if(iduser =="")
        return;
    
    $('#removeconfirmation').modal({keyboard: false});  
}
function removeuser(iduser){
    var request =  get_XmlHttp(); 
    var data = new FormData();
    
    if(iduser =="")
        return;
    
    data.append('type','removeuser');
    data.append('iduser',iduser);
        
    request.open("POST","php/admin.php", true);			// define the request
    request.send(data);		// sends data
    
    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            if(request.responseText == "error")
            {
                alert("Error..");
                return;
            }else
                listusers();
                addimage_form();
                document.getElementById("userinfo").innerHTML = request.responseText;
        }
    }
}


/////AUTHORS______________________________________________________

function list_aut() {
    var request =  get_XmlHttp();
    var data = new FormData();
       
    data.append('type','listaut');
    
    request.open("POST","php/admin.php", true);         // define the request
    request.send(data);     // sends data
    
    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            document.getElementById("authorsselect").innerHTML = request.responseText;
        }
    }
}

function check() {
    var sel = document.getElementById('authorsselect');
    var author = sel.options[sel.selectedIndex].value;
    var authorid = sel.options[sel.selectedIndex].id;

    check_aut(author, authorid);
}


function check_aut(author, authorid) {

    var request =  get_XmlHttp();   
    var data = new FormData();
    
    data.append('type','checkaut');
    data.append('authorid', authorid); 

    request.open("POST","php/admin.php", true);         // define the request
    request.send(data);     // sends data

    request.onreadystatechange = function() {
        if (request.readyState == 4) {  
            if(request.responseText == 0){
                //not in use
                document.getElementById("dyn_aut").innerHTML = "<label>Edit Author</label><br/> <input class=\"form-control\" value=\"" + author + "\" id = \"" + authorid + "\" name = \"toedit\"> <br/> <button type=\"button\" onclick=\"edit_aut()\" class=\"btn btn-success btn-xs\">Update</button>";
            }else if(request.responseText == 1){
                //in use
                document.getElementById("dyn_aut").innerHTML = "<label>Edit Author</label><br/> <input value=\"" + author + "\" class=\"form-control\" id=\"disabledInput\" type=\"text\" placeholder=\"Disabled input\" disabled=\"\"> <br/> <button type=\"button\" class=\"btn btn-danger btn-xs\">In Use</button>";
            }
        }
    }
}

function autremover(authorid){
    var request =  get_XmlHttp();   
    var data = new FormData();
    
    data.append('type','rmaut');
    data.append('authorid', authorid); 

    request.open("POST","php/admin.php", true);         // define the request
    request.send(data);     // sends data

    request.onreadystatechange = function() {
        if (request.readyState == 4) {  
            list_aut();
        }
    }
}

function rm_aut(){

    var sel = document.getElementById('authorsselect');
    var author = sel.options[sel.selectedIndex].value;
    var authorid = sel.options[sel.selectedIndex].id;
    var request =  get_XmlHttp();   
    var data = new FormData();
    
    data.append('type','checkaut');
    data.append('authorid', authorid); 

    request.open("POST","php/admin.php", true);         // define the request
    request.send(data);     // sends data

    request.onreadystatechange = function() {
        if (request.readyState == 4) {  
            if(request.responseText == 0){
                //not in use
                autremover(authorid);
                document.getElementById("dyn_aut").innerHTML ="";
            }else if(request.responseText == 1){
                //in use
                alert("Can't remove. Author is utilized.")
            }
        }
    }

}


function edit_aut(){

    var sel = document.getElementById('authorsselect');
    var authorid = sel.options[sel.selectedIndex].id;
    var author = document.getElementsByName("toedit")[0].value;
    
    var request =  get_XmlHttp();   
    var data = new FormData();
    
    data.append('type','editaut');
    data.append('authorid', authorid); 
    data.append('author',author); 

    request.open("POST","php/admin.php", true);         // define the request
    request.send(data);     // sends data

    request.onreadystatechange = function() {
        if (request.readyState == 4) {  
            list_aut();
            document.getElementById("dyn_aut").innerHTML ="";
        }
    }
}


function rmall_aut() {
    var count = document.getElementById("authorsselect").length;
    var sel = document.getElementById('authorsselect');

    for (var i = 0; i < count; i++) {
        var author = sel.options[i].value;
        var authorid = sel.options[i].id;
        autremover(authorid);

    };
    

}

//clear select items from select option 
function clearSelected(objectID){        
    var elements = document.getElementById(objectID).options;
    if(elements[elements.selectedIndex])
        elements[elements.selectedIndex].selected = false;            
}   
// PUBLICATIONS
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

function pubselect(){
    var request =  get_XmlHttp();
    var iduser = getUserID();
        
    var data = new FormData();
    data.append('type', 'pubselect');
    data.append('iduser', iduser);
    request.open("POST", "php/pubs.php", true);			// define the request
    request.send(data);		// sends data
    
    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            document.getElementById("pubselect").innerHTML = request.responseText;            
        }
    }     
}

function pubinfo(idpub){    
    var request =  get_XmlHttp();
    if(idpub=='')
        return;
    var data = new FormData();
    data.append('type', 'pubinfo');
    data.append('idpub', idpub);
    request.open("POST", "php/pubs.php", true);			// define the request
    request.send(data);		// sends data
    
    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            document.getElementById("formatt").innerHTML = request.responseText;            
            getkeywords(idpub);
        }
    }    
}

function getkeywords(idpub){
    var request =  get_XmlHttp();    
        
    var data = new FormData();
    data.append('type', 'getkeywords');
    data.append('idpub', idpub);
    request.open("POST", "php/pubs.php", true);			// define the request
    request.send(data);		// sends data
    
    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            $('#keywordsselect').multipleSelect('setSelects',request.responseText.split(" "));
        }
    }     
}


function updateAtt(){
    var request =  get_XmlHttp();
    idpub = $('#idpub').val();
    if(idpub=='')
        return;
        
            
    var data = new FormData();
    data.append('type', 'updateAtt');
    data.append('idpub', idpub);
        
    var title = $('#title').val(); 
    data.append('title',title);  
    var privacy = $('#private').val();
    data.append('privacy',privacy);
    
    var keywords = $('#keywordsselect').multipleSelect('getSelects');
    data.append('keywords',keywords);
    
    
    if(title.length == 0){
        $('#title').focus();
        alert("Input is empty!");
        return;
    };        
        
    
    request.open("POST", "php/pubs.php", true);			// define the request
    request.send(data);		// sends data
    
    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            document.getElementById("formatt").innerHTML = request.responseText;                        
        }
    }        
}



//Upload XML
function pubsxml(){
    var request =  get_XmlHttp();
    var data = new FormData();
    
    data.append('type','pubsxml');
    var idusers = getUserID();
    data.append('idusers',idusers);    
    var file = document.getElementById('zipfile');
    data.append('zipfile', file.files[0]); 
    
    //verify extension file
    var ext = file.files[0]['name'].split('.')[1];
    //if(ext != "xml"){
    if(ext != "zip"){
        $('#zipfile').focus();
        alert("Please enter a valid file..\n ex:   sip.zip");
        return;
    };
    //$('#loadingmsg').modal('show');
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
//INSERT PUBLICATION
function insertpub(){
    var request =  get_XmlHttp();
    var data = new FormData();
    var idusers = getUserID();
    data.append('type','insertpub');
    data.append('idusers',idusers); // verificar aqui cookie!!!
    var title = $('#title').val(); 
    data.append('title',title);
    var idpub = $('#idpub').val();
    data.append('idpub',idpub);    
    var pubtype = $('#type').val();
    data.append('pubtype',pubtype);
    var year = $('#year').val();
    data.append('year',year);
    var privacy = $('#private').val();
    data.append('privacy',privacy);
    var userisauthor = document.getElementById('userisauthor').checked;         
    data.append('userisauthor',userisauthor);
    var useriseditor = document.getElementById('useriseditor').checked;
    data.append('useriseditor',useriseditor);    
    var keywords = $('#keywordsselect').multipleSelect('getSelects');
    data.append('keywords',keywords);
    
    //other attributes
    var natributes = $('#natributes').val();
    data.append('natributes',natributes);
    var nauthors = $('#nauthors').val();
    data.append('nauthors',nauthors);
    var nfiles = $('#nfiles').val();           
    data.append('nfiles',nfiles);
    
    if(title.length == 0){
        $('#title').focus();
        alert("Input is empty!");
        return;
    };
    if(idpub.length == 0){
        $('#idpub').focus();
        alert("Input is empty!");
        return;
    }; 
    if(pubtype.length == 0){
        $('#pubtype').focus();
        alert("Input is empty!");
        return;
    }; 
    if(year.length == 0){
        $('#year').focus();
        alert("Input is empty!");
        return;
    }; 
    if(privacy.length == 0){
        $('#privacy').focus();
        alert("Input is empty!");
        return;
    }; 
    
    
    var i = 1;    
    while(i <= natributes)
    {
        data.append('name'+i,$('#name'+i).val());
        data.append('value'+i,$('#value'+i).val()); 
        i++;
    }
    i = 1;    
    while(i <= nauthors)
    {
        data.append('A_name'+i,$('#A_name'+i).val());
        data.append('A_id'+i,$('#A_id'+i).val());        
        data.append('isauthor'+i,document.getElementById('isauthor'+i).checked);
        data.append('iseditor'+i,document.getElementById('iseditor'+i).checked);
        i++;
    }
    i = 1;
    var file;    
    while(i <= nfiles)
    {
        file = document.getElementById('file'+i);
        data.append('file'+i, file.files[0]);        
        data.append('filedesc'+i,$('#filedesc'+i).val());
        i++;
    }
    

    
    request.open("POST","php/pubs.php", true);			// define the request
    request.send(data);		// sends data
    
    // Check request status
    // If the response is received completely, will be transferred to the HTML tag with tagID
    request.onreadystatechange = function() {
        if (request.readyState == 4) {            
            if(request.responseText=="idpub")
            {
                alert("Publication ID already exists. Please try another.");
            }else
            if(request.responseText=="success")
            {
                alert("Your Publication was inserted!");
                location.reload();
            }else
            {
                alert(request.responseText);
                location.reload();
            }
        }
    }
}


// FUNCTIONS FOR DYNAMIC FORM 
$(document).ready(function(){
var counter = 2;

var files = 2;
var natributes=2; 

/* Func para adicionar  authors  */

$("#AddAuthors").click(function(){
    if(counter>10)
    {
        alert("The ceiling is 10 authors!");
        return false;
    }
    
    var newAuthor = document.createElement('fieldset');
    newAuthor.setAttribute("id", 'a' + counter);
    
    $('<p><br/></p>').appendTo(newAuthor);
    
    var newTable = document.createElement('table');
    newTable.setAttribute("id", 'tableauthors' + counter);
    newAuthor.appendChild(newTable);

    var newtr = document.createElement('tr');
    newtr.setAttribute("id","fauthrow"+counter);
    newtr.setAttribute("align","left");   
    newTable.appendChild(newtr);
    
    var newtd = document.createElement('td');
    newtd.setAttribute("id","auth_td"+counter);
    newtd.setAttribute("align","left");   
    newtr.appendChild(newtd);
    
    $('<label>Value </label>').appendTo(newtd);
    
    var newtd2 = document.createElement('td');
    newtd2.setAttribute("id","2auth_td"+counter);
    newtr.appendChild(newtd2);

    var newInputName = document.createElement('input');
    newInputName.setAttribute("type","text");
    newInputName.setAttribute("name","A_name"+counter);
    newInputName.setAttribute("id","A_name"+counter);   
    newInputName.setAttribute("size","50"); 
    newInputName.setAttribute("class","form-control"); 
    newtd2.appendChild(newInputName);
    
    
    var newtr2 = document.createElement('tr');
    newtr2.setAttribute("id","sauthrow"+counter);
    newtr2.setAttribute("align","left");   
    newTable.appendChild(newtr2);
    
    var newtd3 = document.createElement('td');
    newtd3.setAttribute("id","3auth_td"+counter);
    newtd3.setAttribute("align","left");   
    newtr2.appendChild(newtd3);
    
    $('<label>ID </label>').appendTo(newtd3);
    
    var newtd4 = document.createElement('td');
    newtd4.setAttribute("id","4auth_td"+counter);
    newtr2.appendChild(newtd4);

    var newInputeID = document.createElement('input');
    newInputeID.setAttribute("type","text");
    newInputeID.setAttribute("name","A_id"+counter);
    newInputeID.setAttribute("id","A_id"+counter);   
    newInputeID.setAttribute("size","50"); 
    newInputeID.setAttribute("class","form-control"); 
    newtd4.appendChild(newInputeID);
    
    //type
    var newtr3 = document.createElement('tr');
    newtr3.setAttribute("id","typerow"+counter);
    newtr3.setAttribute("align","left");   
    newTable.appendChild(newtr3);
    
    var newtd5 = document.createElement('td');
    newtd5.setAttribute("id","td1type"+counter);
    newtr3.appendChild(newtd5);
    
    var newLabelAuthor = document.createElement('label');
    newLabelAuthor.setAttribute("class","checkbox-inline");
    newtd5.appendChild(newLabelAuthor);
      
    var newInputRadio1 = document.createElement('input');
    newInputRadio1.setAttribute("type","checkbox");
    newInputRadio1.setAttribute("name","isauthor"+counter);
    newInputRadio1.setAttribute("id","isauthor"+counter);
    newInputRadio1.setAttribute("checked");
    newLabelAuthor.appendChild(newInputRadio1);
    
    $('<text>Author</text>').appendTo(newLabelAuthor);

    var newtd6 = document.createElement('td');
    newtd6.setAttribute("id","td2type"+counter);
    newtr3.appendChild(newtd6);
    
    var newLabelEditor = document.createElement('label');
    newLabelEditor.setAttribute("class","checkbox-inline");    
    newtd6.appendChild(newLabelEditor);    
    
    var newInputRadio2 = document.createElement('input');
    newInputRadio2.setAttribute("type","checkbox");
    newInputRadio2.setAttribute("name","iseditor"+counter);
    newInputRadio2.setAttribute("id","iseditor"+counter);
    newLabelEditor.appendChild(newInputRadio2);
    
    $('<text>Editor</text>').appendTo(newLabelEditor);

    $(newAuthor).appendTo("#authors");
    counter++;
}); 

/* Func para remover authors  */

  $("#RemoveAuhtors").click(function(){
    if(counter == 1)
    {
        alert("No more authors to remove");
        return false;
    }
    counter--;
    $("#a"+counter).remove();
});


/* Func para adicionar mais atributos  */

$("#otherAtributes").click(function(){


    var newAtribute = document.createElement('fieldset');
    newAtribute.setAttribute("id", 'at' + natributes); 
    
    $('<p><br/></p>').appendTo(newAtribute);
   
    var newTable = document.createElement('table');
    newTable.setAttribute("id", 'table' + natributes);
    newAtribute.appendChild(newTable);

    var newtr = document.createElement('tr');
    newtr.setAttribute("id","frow"+natributes);
    newtr.setAttribute("align","left");   
    newTable.appendChild(newtr);

    var newtd2 = document.createElement('td');
    newtd2.setAttribute("id","std"+natributes);
    newtr.appendChild(newtd2);


    var newInputname = document.createElement('input');
    newInputname.setAttribute("type","text");
    newInputname.setAttribute("placeholder","Attribute Name");
    newInputname.setAttribute("name","name"+natributes);
    newInputname.setAttribute("id","name"+natributes);   
    newInputname.setAttribute("class","form-control"); 
    newtd2.appendChild(newInputname);


    var newtr2 = document.createElement('tr');
    newtr2.setAttribute("id","srow"+natributes);
    newtr2.setAttribute("align","left");   
    newTable.appendChild(newtr2);
    
    var newtd4 = document.createElement('td');
    newtd4.setAttribute("id","ftd"+natributes);
    newtr2.appendChild(newtd4);

    var newInputvalue = document.createElement('input');
    newInputvalue.setAttribute("type","text");
    newInputname.setAttribute("placeholder","Value");
    newInputvalue.setAttribute("name","value"+natributes);
    newInputvalue.setAttribute("id","value"+natributes);   
    newInputvalue.setAttribute("class","form-control"); 
    
    newtd4.appendChild(newInputvalue);
    
    $(newAtribute).appendTo("#attributes");
    natributes++;
});

/* Func para remover outros atributos  */

    $("#remove").click(function(){
    if(natributes == 1)
    {
        alert("Já não há membros para remover");
        return false;
    }
    natributes--;
    $("#at"+natributes).remove();
});


 /* Func para adicionar mais ficheiros  */
 
    $("#morefiles").click(function(){
    if(files>10)
    {
        alert("O limite máximo são 10 ficheiros!");
        return false;
    }

    var newFile = document.createElement('fieldset');
    newFile.setAttribute("id", 'f' + files);
    
     $('<p><br/></p>').appendTo(newFile);


    var newTable = document.createElement('table');
    newTable.setAttribute("id", 'tablefiles' + files);
    newFile.appendChild(newTable);

    var newtr = document.createElement('tr');
    newtr.setAttribute("id","f_filesrow"+files);
    newtr.setAttribute("align","left");   
    newTable.appendChild(newtr);
 
    var newInputfile = document.createElement('input');
    newInputfile.setAttribute("type","file");
    newInputfile.setAttribute("align","left");
    newInputfile.setAttribute("name","file"+files);
    newInputfile.setAttribute("id","file"+files);   
    newtr.appendChild(newInputfile);
    
    var newtr2 = document.createElement('tr');
    newtr2.setAttribute("id","s_filesrow"+file);
    newtr2.setAttribute("align","left");   
    newTable.appendChild(newtr2);
    
    var newtd2 = document.createElement('td');
    newtd2.setAttribute("id","2files_td"+file);
    newtd2.setAttribute("align","left");   
    newtr2.appendChild(newtd2);
    
    var newInputdescription = document.createElement('input');
    newInputdescription.setAttribute("type","text");
    newInputdescription.setAttribute("placeholder","Description");
    newInputdescription.setAttribute("name","filedesc"+files);
    newInputdescription.setAttribute("id","filedesc"+files);   
    newInputdescription.setAttribute("size","50"); 
    newInputdescription.setAttribute("align","left"); 
    newInputdescription.setAttribute("required",""); 
    newInputdescription.setAttribute("class","form-control");
    newtd2.appendChild(newInputdescription);

    $(newFile).appendTo("#file");
    files++;
});       

    /* Func para remover files  */

    $("#removefiles").click(function(){
    if(files == 2)
    {
        alert("No more files to remove");
        return false;
    }
    files--;
    $("#f"+files).remove();
});




 /* Func para enviar os dados para o PHP  */

 $("#send").click(function(){
    document.getElementById('natributes').value = natributes-1;   
    document.getElementById('nauthors').value = counter-1;    
    document.getElementById('nfiles').value = files-1;
    
    insertpub();                      
});

});
  
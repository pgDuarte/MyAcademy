//Upload XML - Thesis Examination
function examxml(){
    var request =  get_XmlHttp();
    var data = new FormData();
    
    data.append('type','examxml');
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
                //location.reload();
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
 

function insertexam(){
    var request =  get_XmlHttp();
    var data = new FormData();
    
    data.append('type','insertexam');
    data.append('idusers',getUserID()); // verificar aqui cookie!!!
    var inst = $('#inst').val(); 
    data.append('inst',inst);
    var thetype = $('#type').val();
    data.append('thetype',thetype);    
    var ansiDate = $('#ansiDate').val();
    data.append('ansiDate',ansiDate);
    var date = $('#date').val();
    data.append('date',date);
    var name = $('#name').val();
    data.append('name',name);
    var number = $('#number').val();
    data.append('number',number);    
    var email = $('#email').val();    
    data.append('email',email);    
    var linkedin = $('#linkedin').val();    
    data.append('linkedin',linkedin);
    var description = $('#description').val();
    data.append('description',description);
    var address = $('#address').val();       
    data.append('address',address);
    var filetitle = $('#filetitle').val();    
    data.append('filetitle',filetitle);
    var file = document.getElementById('file');
    data.append('file', file.files[0]);
    var doi = $('#doi').val();    
    data.append('doi',doi);
    
    var keywords = $('#keywordsselect').multipleSelect('getSelects');
    data.append('keywords',keywords);  
    
    if(inst.length == 0){
        $('#inst').focus();
        alert("Input is empty!");
        return;
    };
    if(ansiDate.length == 0){
        $('#ansiDate').focus();
        alert("Input is empty!");
        return;
    };  
    if(name.length == 0){
        $('#name').focus();
        alert("Input is empty!");
        return;
    }; 
    if(number.length == 0){
        $('#number').focus();
        alert("Input is empty!");
        return;
    };     
    if(filetitle.length == 0){
        $('#filetitle').focus();
        alert("Input is empty!");
        return;
    }; 
    if(doi.length == 0 && !file.files[0]){
        $('#doi').focus();
        alert("Input is empty!");
        return;
    };    
        
    request.open("POST","php/theexam.php", true);			// define the request
    request.send(data);		// sends data
    
    // Check request status
    // If the response is received completely, will be transferred to the HTML tag with tagID
    request.onreadystatechange = function() {
        if (request.readyState == 4) {                        
            if(request.responseText=="success")
            {
                alert("Your Examination was inserted!");
                location.reload();
            }else
            {
                alert(request.responseText);
                location.reload();
            }
        }
    }
}

//Upload XML - Thesis Supervision
function supxml(){
    var request =  get_XmlHttp();
    var data = new FormData();
    
    data.append('type','supxml');
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


function insertsup(){
    var request =  get_XmlHttp();
    var data = new FormData();
    
    data.append('type','insertsup');
    data.append('idusers',getUserID()); // verificar aqui cookie!!!
    var inst = $('#inst').val(); 
    data.append('inst',inst);
    var thetype = $('#type').val();
    data.append('thetype',thetype);
    var status = $('#status').val();
    data.append('status',status);    
    var beginyear = $('#beginyear').val();
    data.append('beginyear',beginyear);
    var endyear = $('#endyear').val();
    data.append('endyear',endyear);    
    var cosupname = $('#cosupname').val();
    data.append('cosupname',cosupname);
    var cosupinst = $('#cosupinst').val();
    data.append('cosupinst',cosupinst);
    var name = $('#name').val();
    data.append('name',name);
    var number = $('#number').val();
    data.append('number',number);    
    var email = $('#email').val();    
    data.append('email',email);    
    var linkedin = $('#linkedin').val();    
    data.append('linkedin',linkedin);
    var description = $('#description').val();
    data.append('description',description);
    var address = $('#address').val();       
    data.append('address',address);
    var filetitle = $('#filetitle').val();    
    data.append('filetitle',filetitle);
    var file = document.getElementById('file');
    data.append('file', file.files[0]);
    var doi = $('#doi').val();    
    data.append('doi',doi);
    
    var keywords = $('#keywordsselect').multipleSelect('getSelects');
    data.append('keywords',keywords);   
    
    if(inst.length == 0){
        $('#inst').focus();
        alert("Input is empty!");
        return;
    };
    if(beginyear.length == 0){
        $('#beginyear').focus();
        alert("Input is empty!");
        return;
    };
    if(status == 'concluded')
    { 
        if(endyear.length == 0) 
        { 
            $('#endyear').focus(); 
            alert("Input is empty!"); 
            return; 
        } 
    };
    if(cosupname.length != 0 && cosupinst.length == 0){
        $('#cosupinst').focus();
        alert("Input is empty!");
        return;
    };
    
    if(cosupname.length == 0 && cosupinst.length != 0){
        $('#cosupname').focus();
        alert("Input is empty!");
        return;
    };
    if(name.length == 0){
        $('#name').focus();
        alert("Input is empty!");
        return;
    }; 
    if(number.length == 0){
        $('#number').focus();
        alert("Input is empty!");
        return;
    };      
    
    if(filetitle.length == 0){
        $('#filetitle').focus();
        alert("Input is empty!");
        return;
    };
    
    if(doi.length == 0 && !file.files[0]){
        $('#doi').focus();
        alert("Input is empty!");
        return;
    };    
        
    request.open("POST","php/thesup.php", true);			// define the request
    request.send(data);		// sends data
    
    // Check request status
    // If the response is received completely, will be transferred to the HTML tag with tagID
    request.onreadystatechange = function() {
        if (request.readyState == 4) {                        
            if(request.responseText=="success")
            {
                alert("Your Supervision was inserted!");
                location.reload();
            }else
            {
                alert(request.responseText);
                location.reload();
            }
        }
    }
}
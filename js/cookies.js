function getCookie()
{
    var session_credentials, id, name, profile;

    $.ajax(
    {
        url: "php/get_session.php",
        cache: false,
        async: false
    })
    .done(function(result)
    {
        session_credentials = $.parseJSON(result);
    });

    if (session_credentials != 1) {
        id = session_credentials.split(':')[0];
        name = session_credentials.split(':')[1];
        profile = session_credentials.split(':')[2];


        var code = '<input id = "usertype" value = "1" type="hidden"/><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> ' + name + '<b class="caret"></b></a> <ul class="dropdown-menu"><li><a href="myprofile.html"><i class="fa fa-user"></i> Profile</a></li><li><a href="editprofile.html"><i class="fa fa-edit"></i> Edit Personal Info </a></li><li class="divider"></li><li><a onclick="destroyer();"><i class="fa fa-power-off"></i> Log Out</a></li></ul>';

        document.getElementById("dyn_user").innerHTML = code;
    }else        
        window.location.replace("login.html");
}
function getUserID()
{
    var session_credentials, id, name, profile;

    $.ajax(
    {
        url: "php/get_session.php",
        cache: false,
        async: false
    })
    .done(function(result)
    {
        session_credentials = $.parseJSON(result);               
    });
    
    return session_credentials.split(':')[0];
}

function isAdmin()
{
    var session_credentials, id, name, profile;
    
    $.ajax(
    {
        url: "php/get_session.php",
        cache: false,
        async: false
    })
    .done(function(result)
    {               
        session_credentials = $.parseJSON(result);
        if(session_credentials.split(':')[2]=="administrator")
        {
            
            var code = '<a class="dropdown-toggle" data-toggle="dropdown" ><i class="fa fa-gears"></i> Admin Panel <b class="caret"></b></a><ul class="dropdown-menu"><li><a href="usersmanagement.html"><i class="fa fa-user"></i> Users Management</a></li><li><a href="keywordsmanagement.html"><i class="fa fa-key"></i> Keywords Management</a></li><li><a href="authorsmanagement.html"><i class="fa fa-pencil"></i> Authors Management</a></li>';
            document.getElementById("adminpanel").innerHTML = code;
        }           
    });
    return;
}

function isTeacher()
{
    var session_credentials, id, name, profile;
    
    $.ajax(
    {
        url: "php/get_session.php",
        cache: false,
        async: false
    })
    .done(function(result)
    {               
        session_credentials = $.parseJSON(result);
        if(session_credentials.split(':')[2]=="teacher")
        {                       
            window.location.replace("index.html");
        }           
    });
    return;
}
//DESTROY SESSION
function destroyer() {
    
    var func = 9;

    $.post("php/index.php", {func:func}, function(data){
             
    });

    window.location.replace("index.html");
}
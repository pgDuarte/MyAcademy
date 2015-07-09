<?php

header('Content-Type: text/html; charset=utf-8');

require_once('../nusoap/lib/nusoap.php');

//Webservice server WSDL URL address:
$wsdl = "http://localhost/site/php/webService.php?wsdl";
 
//Create client object
$client = new nusoap_client($wsdl, 'wsdl');
 
$err = $client->getError();
if ($err) {
	// Display the error
	echo '<h2>Constructor error</h2>' . $err;
	// At this point, you know the call that follows will fail
    exit();
}

if (strcmp($_REQUEST['type'], "listusers")==0) {
    
    $result = $client->call("listusers");
    $iduser = $_POST['iduser'];
    
    $count = count($result);
    $i=0;
    $string ="";
    while($i < $count)
    {
        if($iduser != $result[$i]['idusers'])
        {
            $string = $string."<option value='".$result[$i]['idusers']."'>".$result[$i]['name']." [ ".$result[$i]['idauthor']." - ".$result[$i]['profile']." ]</option>";
        }
        $i++;
    }
    
    echo $string;
}

if (strcmp($_REQUEST['type'], "listuserinfo")==0) {
           
    $iduser = $_POST['iduser'];
    
    $result = $client->call("listuserinfo",array('iduser'=>$iduser));
    $string = "
    <div class='row'>
         <div class='col-lg-8'>
             <label>Name</label>
             <input class='form-control' name='name' id='name' placeholder='First and last name' type='text'  value='".$result[0]['name']."'/>              
         </div>
         <div class='col-lg-4'>
             <label>User Tag</label>
             <input class='form-control' name='usertag' id='usertag' placeholder='ex: mar' disabled type='text' value='".$result[0]['idauthor']."'/>              
         </div>
     </div>
     <br/>
     <div class='row'>
         <div class='col-lg-8'>
             <label>E-mail</label>
             <input class='form-control' name='email' id='email' type='text' disabled value='".$result[0]['email']."'/>              
         </div>
         <div class='col-lg-4'>
             <label>Password</label>
             <input class='form-control' name='password' id='password' type='password'/>              
         </div>
     </div>
     <br/>
     <div class='row'>
         <div class='col-lg-4'>
             <label>Phone Number</label>
             <input class='form-control' name='phnumber' id='phnumber' type='text' value='".$result[0]['phonenumber']."'/>              
         </div>
         <div class='col-lg-4'>
             <label>Profile</label>
             <select class='form-control' name='profile' id='profile'>";

    if($result[0]['profile']=="teacher")
    {
        $string = $string."<option value='teacher' selected>Teacher</option>
                           <option value='administrator'>Administrator</option>";
    }else
    {
        $string = $string."<option value='teacher' >Teacher</option>
                           <option value='administrator' selected>Administrator</option>";
    }
    $string = $string."                            
             </select>
         </div>
     </div>
     <br/>
     <div class='row'>
         <div class='col-lg-8'>
             <label>Site</label>                                             
             <input class='form-control' name='url' id='url' placeholder='link' type='text' value='".$result[0]['url']."'/>              
         </div>     
     </div>
     <br/>
     <div class='text-left'>
         <button class='btn btn-success btn-xs' type='button' onclick='updateuser(".$iduser.")'>Update</button>
     </div>";
     echo $string;
       
}

if (strcmp($_REQUEST['type'], "listimage")==0) {
           
    $iduser = $_POST['iduser'];
    
    $result = $client->call("listuserinfo",array('iduser'=>$iduser));
    
    echo "<img alt=\"140x140\" data-src=\"holder.js/140x140\"  src=\"".$result[0]['imageuri']."\" class=\"img-thumbnail\"></img>
    <input class=\"btn btn-primary btn-sm text-center\" type=\"file\" name=\"image\" id=\"image\" data-bfi-disabled ></input>";    
       
}

if (strcmp($_REQUEST['type'], "adduser_form")==0) {
    echo "
    <div class='row'>
         <div class='col-lg-8'>
             <label>Name</label>
             <input class='form-control' name='name' placeholder='First and last name' id='name' type='text'/>              
         </div>
         <div class='col-lg-4'>
             <label>User Tag</label>
             <input class='form-control' name='usertag' id='usertag' placeholder='ex: mar' type='text'/>              
         </div>
     </div>
     <br/>
     <div class='row'>
         <div class='col-lg-8'>
             <label>E-mail</label>
             <input class='form-control' name='email' id='email' type='text'/>              
         </div>
         <div class='col-lg-4'>
             <label>Password</label>
             <input class='form-control' name='password' id='password' type='password'/>              
         </div>
     </div>
     <br/>
     <div class='row'>
         <div class='col-lg-4'>
             <label>Phone Number</label>
             <input class='form-control' name='phnumber' id='phnumber' type='text'/>              
         </div>
         <div class='col-lg-4'>
             <label>Profile</label>
             <select class='form-control' name='profile' id='profile'>
                 <option value='teacher'>Teacher</option>
                 <option value='administrator'>Administrator</option>
             </select>
         </div>
     </div>
     <br/>
     <div class='row'>
         <div class='col-lg-8'>
             <label>Site</label>                                             
             <input class='form-control' name='url' id='url' placeholder='link' type='text'/>              
         </div>     
     </div>
     <br/>
     <div class='text-left'>
         <button class='btn btn-success btn-xs' type='button' onclick='insertuser()'>Insert</button>
     </div>";
}

if (strcmp($_REQUEST['type'], "addimage_form")==0) {
    echo "
        <input class=\"btn btn-primary btn-sm \" type=\"file\" name=\"image\" id=\"image\" data-bfi-disabled ></input>
    ";
}

if (strcmp($_REQUEST['type'], "insertuser")==0) {

    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    
    $query = $dbh->prepare("INSERT INTO users (name, email, password, profile , phonenumber, imageuri, url, idauthor) VALUES (:name, :email, :password, :profile , :phonenumber, :imageuri, :url, :idauthor)");
    $query_authors = $dbh -> prepare("INSERT INTO authors (idauthor, name) VALUES (:idauthor, :name)");
    
    //header
    $name = $_POST['name'];
    $usertag = $_POST['usertag'];
    $email = $_POST['email'];
    $hashpass = $_POST['hashpass'];
    $phnumber = $_POST['phnumber'];
    $profile = $_POST['profile'];
    $url = $_POST['url'];  
    $flag = 0;      
    
    //verify
    $result = $dbh->query("SELECT * FROM authors WHERE idauthor = '".$usertag."'");        
    if($result->rowCount())
    {
        $result = $dbh->query("SELECT * FROM authors WHERE name = '".$name."'");
        if (!$result->rowCount())
       {
           echo "usertag";
           return;
       }
       $flag = 1;
    }
    $result = $dbh->query("SELECT * FROM users WHERE email = '".$email."'");        
    if($result->rowCount())
    {
        echo "email";
        return;
    }
    
    //insert author
    if($flag != 1)
    {        
        $query_authors->bindValue(":idauthor",$usertag, PDO::PARAM_STR);
        $query_authors->bindValue(":name",$name, PDO::PARAM_STR);                
        $query_authors->execute();
    }
    
    //create dir and save image
    $path = "users/".$email."/";
    $fName = iconv("utf-8", 'ISO-8859-1', $_FILES["image"]["name"]);
    
    if(!is_dir("../".$path))
    {
        mkdir("../".$path,0777,true);
    }
    move_uploaded_file($_FILES["image"]["tmp_name"],"../".$path.$fName);
    
    
    $query->bindValue(":name",$name, PDO::PARAM_STR);
    $query->bindValue(":email",$email, PDO::PARAM_STR);   
    $query->bindValue(":password",$hashpass, PDO::PARAM_STR);
    $query->bindValue(":profile",$profile, PDO::PARAM_STR);
    $query->bindValue(":phonenumber",$phnumber, PDO::PARAM_STR);
    $query->bindValue(":imageuri",$path.$_FILES["image"]["name"], PDO::PARAM_STR);
    $query->bindValue(":url",$url!=""?$url:NULL, PDO::PARAM_STR);
    $query->bindValue(":idauthor",$usertag, PDO::PARAM_STR);
    $query->execute();
           
    
    echo "<legend class='text-left'></legend><div class=\"col-lg-8\">  <div class=\"alert alert-success\"> <button type=\"button\" class=\"close\" data-dismiss=\"alert\" onclick='adduser_form(),listusers()' aria-hidden=\"true\">&times;</button> <h6>Success! The user ".$name." was inserted</h6> </div> </div> ";
}

if (strcmp($_REQUEST['type'], "updateuser")==0) {

    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    
    $query = $dbh->prepare("UPDATE `users` SET `name`=:name, `profile`=:profile, `phonenumber`=:phonenumber, `url`=:url WHERE `idusers`=:iduser");
    $query_authors = $dbh -> prepare("UPDATE `authors` SET `name`= :name WHERE `idauthor`=:idauthor");
    
    //header
    $iduser = $_POST['iduser'];
    $name = $_POST['name'];
    $usertag = $_POST['usertag'];        
    $phnumber = $_POST['phnumber'];
    $profile = $_POST['profile'];
    $url = $_POST['url'];       
    
    $query_authors->bindValue(":idauthor",$usertag, PDO::PARAM_STR);
    $query_authors->bindValue(":name",$name, PDO::PARAM_STR);                
    $query_authors->execute();
    
     
    $query->bindValue(":name",$name, PDO::PARAM_STR);    
    $query->bindValue(":profile",$profile, PDO::PARAM_STR);
    $query->bindValue(":phonenumber",$phnumber, PDO::PARAM_STR);
    $query->bindValue(":url",$url!=""?$url:NULL, PDO::PARAM_STR);
    $query->bindValue(":iduser",$iduser, PDO::PARAM_STR);
    $query->execute();
           
    
    echo "<legend class='text-left'></legend><div class=\"col-lg-8\">  <div class=\"alert alert-success\"> <button type=\"button\" class=\"close\" data-dismiss=\"alert\" onclick='adduser_form()' aria-hidden=\"true\">&times;</button> <h6>Success! The user ".$name." was updated</h6> </div> </div> ";
}

if (strcmp($_REQUEST['type'], "updateimage")==0) {

    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));   
    
    //header
    $iduser = $_POST['iduser'];
    $image = $_FILES['image'];
    
    $result = $dbh->query("SELECT * FROM users WHERE idusers = '".$iduser."'");
    if($result->rowCount())
    {
        $result = $result->fetch();
        $email = $result['email'];        
        $imageuri = $result['imageuri'];
        
        if(file_exists("../".$imageuri))        
            unlink("../".$imageuri);
            
        $fName = iconv("utf-8", 'ISO-8859-1', $_FILES["image"]["name"]);
        $path = "users/".$email."/";
        
        move_uploaded_file($_FILES["image"]["tmp_name"],"../".$path.$fName);
        
        $dbh->query("UPDATE `users` SET `imageuri`='".$path.$_FILES["image"]["name"]."' WHERE `idusers`='".$iduser."'");         
    }             
}

if (strcmp($_REQUEST['type'], "updatepassword")==0) {

    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));   
    
    //header
    $iduser = $_POST['iduser'];
    $hashpass = $_POST['hashpass'];   
    
    $dbh->query("UPDATE `users` SET `password`='".$hashpass."' WHERE `idusers`='".$iduser."'");  
}

if (strcmp($_REQUEST['type'], "removeuser")==0) {

    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));       
    
    //header
    $iduser = $_POST['iduser'];       
    
    //verify
    $result = $dbh->query("SELECT * FROM users WHERE idusers = '".$iduser."'");        
    if($result->rowCount())
    {
        $result= $result->fetch();
        $email = $result['email'];
        $name = $result['name'];
        //delete user
        $dbh->query("DELETE FROM `users` WHERE `idusers`='".$iduser."'");
        
        $path = "../users/".$email;
        if(is_dir($path))
        {
            delTree($path);
        }
        echo "<legend class='text-left'></legend><div class=\"col-lg-8\">  <div class=\"alert alert-success\"> <button type=\"button\" class=\"close\" data-dismiss=\"alert\" onclick='adduser_form(),listusers()' aria-hidden=\"true\">&times;</button> <h6>Success! The user ".$name." was removed</h6> </div> </div> ";
    }
    else
    {
        echo "error";
        return;
    }                     
}


if (strcmp($_REQUEST['type'], "editkeyword")==0) {
    
    $kwid = $_POST['kwid'];
    $kw = $_POST['kw'];
    $result = $client->call("editkeyword", array('kwid'=>$kwid, 'kw'=>$kw));

    echo $result;
}

if (strcmp($_REQUEST['type'], "checkkeyword")==0) {
    
    $kwid = $_POST['kwid'];
    $result = $client->call("checkkeyword", array('kwid'=>$kwid));

    echo $result;
}


if (strcmp($_REQUEST['type'], "rmkeyword")==0) {
    
    $kwid = $_POST['kwid'];
    $result = $client->call("rmkeyword", array('kwid'=>$kwid));

    echo $result;
}




if (strcmp($_REQUEST['type'], "insertkeyword")==0) {
    
    $kw = $_POST['kw'];
    $result = $client->call("insertkeyword", array('kw'=>$kw));

    echo $result;
}

if (strcmp($_REQUEST['type'], "listkeywords")==0) {
    
    $result = $client->call("listkeywords");
    
    $count = count($result);
    $i=0;
    $string ="";
    while($i < $count)
    {
     
            $string = $string."<option id=\"".$result[$i]['idkeywords']."\" value=\"".$result[$i]['name']."\" >" . $result[$i]['name'] . "</option>";
            $i++;
     
    }
    
    echo $string;
}



//AUTHORS_______________________________________________________________________

if (strcmp($_REQUEST['type'], "listaut")==0) {

    $result = $client->call("listaut");
    
    $count = count($result);
    $i=0;
    $string ="";
    while($i < $count)
    {
        $string = $string . "<option id=\"".$result[$i]['idauthor']."\" value=\"" . $result[$i]['name'] . "\">" . $result[$i]['name'] . "</option>";
        $i++;
    }
    
    echo $string;

}


if (strcmp($_REQUEST['type'], "checkaut")==0) {
    
    $authorid = $_POST['authorid'];
    $result = $client->call("checkaut", array('authorid'=>$authorid));

    echo $result;
}


if (strcmp($_REQUEST['type'], "rmaut")==0) {
    
    $authorid = $_POST['authorid'];
    $result = $client->call("rmaut", array('authorid'=>$authorid));

    echo $result;
}


if (strcmp($_REQUEST['type'], "editaut")==0) {
    
    $authorid = $_POST['authorid'];
    $author = $_POST['author'];
    $result = $client->call("editaut", array('authorid'=>$authorid, 'author'=>$author));

    echo $result;
}

//funçao que remove 
function delTree($dir) { 
   $files = array_diff(scandir($dir), array('.','..')); 
    foreach ($files as $file) { 
      (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); 
    } 
    return rmdir($dir); 
} 
?>
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

if (strcmp($_REQUEST['content'], "disciplineselect")==0) {
      
    $userID = $_GET['id'];          // get data

    $result = $client->call("listDisciplines", array('userID'=>$userID));
    
    $select = "<select id='discicplineselectid' class='form-control' multiple='' style='height: 250px;' onchange=\"listcontent('php/content.php','contentselect','listcontent',this.value),addcontent_form('php/content.php', 'contentform','addcontent_form')\">";

    $count = count($result);
    $i=0;
    
    while ($i < $count) {
        if($result[$i]['iddiscipline']!="")
        {    
           $select = $select."<option value='".$result[$i]['iddiscipline']."'>".$result[$i]['name'];
           if($result[$i]['academicYear']!="")
           {
              $select =$select." [".$result[$i]['academicYear']."]";
           }
           $select =$select."</option>";           
        }
        $i++;
    }
    $select = $select."<option selected='' value=''> - Other content -</option>";
    $select = $select."</select>";
    echo $select;
}

if (strcmp($_REQUEST['content'], "listcontent")==0) {
       
    $userID = $_GET['userID'];
    $disciplineID = $_GET['disciplineID'];          // get data

    $result = $client->call("listContent", array('userID'=>$userID));
    
    $select = "<select id='contentselectid' class='form-control' multiple='' style='height: 200px;' onchange=\"contentinfo('php/content.php','contentform','contentinfo',this.value)\">";
        
    $count = count($result);
    $i=0;
    
    while ($i < $count) {         
     if($result[$i]['iddiscipline']==$disciplineID)
     {
        $select = $select."<option value='".$result[$i]['idcontent']."'>".$result[$i]['name'];
        if($result[$i]['description']!="")
        {     
            $select =$select." [ ".$result[$i]['description']." ]";
        }
        $select =$select."</option>";
     }     
     $i++;
    }
   
     $select = $select."</select>";
    echo $select;
}


if (strcmp($_REQUEST['content'], "contentinfo")==0) {
     
    $contentid = $_GET['id'];          // get data
    
    $result = $client->call("contentinfo", array('idcontent'=>$contentid));	   
    
    $select =  "<div class='row'>
                    <div class='col-lg-12'>
                        <label>Name</label>
                        <input class='form-control' name='name' id='name' type='text' required='' value='".$result[0]['name']."'/>              
                    </div>
                </div>
                <br/>";                                                             
                if($result[0]['file'] != '')
                {
                $select = $select."
                
                <div class=\"alert-dismissable alert-info\"> 
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button> 
                <strong>   Current file: </strong>".$result[0]['file']."
                 </div>"; 
                }                              
                
     $select =   $select."
     
               <a onclick=\"$('#uploadfile').show(),$('#link').hide()\">Click here to upload file</a><a onclick=\"$('#uploadfile').hide(),$('#link').show()\"> or here to insert file link</a>
                
                <div class='row' id='uploadfile'>
                    <div class='col-lg-12'>                                                    
                        <input type='file' name='file' id='file'/>       
                    </div>
                </div>
                <div class='row' id='link' style=\"display:none;\">
                    <div class='col-lg-12'>
                        <input type='text' name='doi' id='doi' placeholder='ex: repositorium.sdum.uminho.pt' class='form-control' />              
                    </div>
                </div>
                <br/>
                <div class='row'>
                    <div class='col-lg-12'>                                                    
                        <input class='form-control' name='description' id='description' placeholder='Description' type='text' value='".$result[0]['description']."'/>              
                    </div>                
                </div>
                <br/>
                
                <div class='text-left'>
                    <button class='btn btn-success btn-xs' type='button' onclick=\"updatecontent('php/content.php','contentform','updatecontent')\">Update</button>
                </div>";
               
    echo $select;
}

if (strcmp($_REQUEST['content'], "contentkeywords")==0) {
     
    $contentid = $_GET['idcontent'];          // get data
        
    $result = $client->call("listcontentkeywords", array('idcontent'=>$contentid));	
    
    $count = count($result);
    $i=0;
    $select="";
    
    if($result[0]['idcontent']!="")
    {
        while ($i < $count) {
            $select=$select.$result[$i]['idkeywords'];
            if($i+1 < $count)
            {
                $select=$select." ";
            }
            $i++;
        }
    }                    
    echo $select;    
}

if (strcmp($_REQUEST['content'], "addcontent_form")==0) {
     
    
    $select =  "<div class='row'>
                    <div class='col-lg-12'>
                        <label>Name</label>
                        <input class='form-control' name='name' id='name' type='text' required=''/>              
                    </div>
                </div>
                <br/>   
                <a onclick=\"$('#uploadfile').toggle(),$('#link').toggle()\">Click here to upload file</a><a onclick=\"$('#uploadfile').toggle(),$('#link').toggle()\"> or here to insert file link</a>
                
                <div class='row' id='uploadfile'>
                    <div class='col-lg-12'>                                                    
                        <input type='file' name='file' id='file'/>       
                    </div>
                </div>
                <div class='row' id='link' style=\"display:none;\">
                    <div class='col-lg-12'>
                        <input type='text' name='doi' id='doi' placeholder='ex: repositorium.sdum.uminho.pt' class='form-control' />              
                    </div>
                </div>
                <br/>
                <div class='row'>
                    <div class='col-lg-12'>                                                    
                        <input class='form-control' name='description' id='description' placeholder='Description' type='text'/>              
                    </div>                
                </div>
                <br/>
                
                <div class='text-left'>
                    <button class='btn btn-success btn-xs' type='button' onclick=\"insertcontent('php/content.php','contentform','insertcontent')\">Insert</button>
                </div>";

               //ALTERAR ID DO UTILIZADOR, COLOCAR COOKIE PARA IR BUSCAR O ID
    echo $select;
}

if (strcmp($_REQUEST['content'], "keywords_form")==0) {
//função que adiciona o formulario das keywords que estao na tabela keywords

    $result = $client->call("listkeywords");
    
    $count = count($result);
    $i=0;
    $select="";
    while ($i < $count) {
        if($result[$i]['idkeywords']!=""){           
            $select = $select."<option value='".$result[$i]['idkeywords']."'>".$result[$i]['name'];
            $select =$select."</option>";
        }         
        $i++;
    }
    echo $select;
}

if (strcmp($_REQUEST['content'], "insertcontent")==0) {

    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $query = $dbh->prepare("INSERT INTO content (name, description, file, iddiscipline, idusers) 
    VALUES (:name, :description, :file, :iddiscipline, :idusers)");
    
    
    $userID = $_POST['userID'];
    $iddiscipline = $_POST['iddiscipline'];        
    $name = $_POST['name']; 
    $description = $_POST['description'];
    $doi = $_POST['doi'];
    $keywords = $_POST['keywords'];
         
    //upload or file link?
    if(!empty($doi))
    {
        $query->bindValue(":file",$doi, PDO::PARAM_STR);
    }else
    if(!empty($_FILES['file']))
    {        
        if($_FILES['file']['error'] != UPLOAD_ERR_NO_FILE)
        {        
            $fName = iconv("utf-8", 'ISO-8859-1', $_FILES["file"]["name"]);
                  
            //path of file                        
            if($iddiscipline =="")
            {
                $result= $dbh->query("SELECT email FROM users WHERE idusers='".$userID."'");
                $email = $result->fetch()['email']; 
                $path = "users/".$email."/teaching/others/";   
            }else
            {
                $result = $dbh->query("SELECT uri FROM discipline WHERE iddiscipline='".$iddiscipline."'");
                $disciplinepath = $result->fetch()['uri'];
                $path = $disciplinepath;
            }                                                                                       
            if (file_exists("../".$path.$fName ))
            {
                echo $_FILES["file"]["name"] . " already exists. ";
            }
            else
            {
                if (!is_dir("../".$path)) {
                    mkdir("../".$path,0777,true);         
                }            
                move_uploaded_file($_FILES["file"]["tmp_name"],
                "../".$path.$fName);                               
            }            
            $query->bindValue(":file",(!empty($_FILES['file'])) ? $path.$_FILES["file"]["name"]:NULL, PDO::PARAM_STR);                                        
        }
    }
    
    //insert db
    $query->bindValue(":name",$name, PDO::PARAM_STR);
    $query->bindValue(":description",($description != "") ? $description:NULL, PDO::PARAM_STR);   
    $query->bindValue(":iddiscipline",($iddiscipline != "") ? $iddiscipline:NULL, PDO::PARAM_STR);
    $query->bindValue(":idusers",$userID, PDO::PARAM_STR);    
    $result = $query->execute();
    $idcontent = $dbh->lastInsertId();
    
    //keywords
    if($keywords != "")
    {
        $i=0;
        $keywords = explode(',',$keywords);
        $count = count($keywords);       
        while($i<$count)
        {
            $dbh->query("INSERT INTO contentkeyword (idcontent, idkeywords) VALUES (".$idcontent.",".$keywords[$i].")");
            $i++;
        }
    }
    
    echo "<legend class='text-left'></legend><div class=\"col-lg-8\">  <div class=\"alert alert-success\"> <button type=\"button\" onclick=\"addcontent_form('php/content.php', 'contentform','addcontent_form');\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button> <h6>Success! Your content was inserted</h6> </div> </div> ";       
       
}

if (strcmp($_REQUEST['content'], "updatecontent")==0) {

    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $query = $dbh->prepare("UPDATE `content` SET `name`=:name, `description`=:description, `file`=:file WHERE `idcontent`=:idcontent");
    
    $userID = $_POST['userID'];
    $iddiscipline = $_POST['iddiscipline'];
    $doi = $_POST['doi'];
    $idcontent = $_POST['idcontent'];        
    $name = $_POST['name']; 
    $description = $_POST['description'];
    $keywords = $_POST['keywords'];
    
    
    //verify 
    $result = $dbh->query("SELECT * FROM content WHERE idcontent=".$idcontent);
    if($result->rowCount())
    {
        $result = $result->fetchAll();
        $filename= $result[0]['file'];
        
        if(empty($_FILES['file']) && empty($doi))
        {
            $query->bindValue(":file",$filename, PDO::PARAM_STR);
        }else if((!empty($_FILES['file']) && $_FILES["file"]["name"] == $filename) && empty($doi) )
        {
            $query->bindValue(":file",$filename, PDO::PARAM_STR);
        }else
        {
            // delete file
            if($result[0]['file']!="")
            {
                $path = iconv("utf-8", 'ISO-8859-1',$result[0]['file']);                  
                if(file_exists("../".$path))
                {
                    unlink("../".$path);
                }
            }
            //upload or file link?
            if(!empty($doi))
            {
                $query->bindValue(":file",$doi, PDO::PARAM_STR);
            }else
            //upload new file
            if(!empty($_FILES['file']) && $_FILES['file']['error'] != UPLOAD_ERR_NO_FILE)
            {        
                $fName = iconv("utf-8", 'ISO-8859-1', $_FILES["file"]["name"]);
                      
                //path of file                        
                if($iddiscipline =="")
                {
                    $result= $dbh->query("SELECT email FROM users WHERE idusers='".$userID."'");
                    $email = $result->fetch()['email']; 
                    $path = "users/".$email."/teaching/others/";   
                }else
                {
                    $result = $dbh->query("SELECT uri FROM discipline WHERE iddiscipline='".$iddiscipline."'");
                    $disciplinepath = $result->fetch()['uri'];
                    $path = $disciplinepath."/";
                }                                                                                       
                if (file_exists("../".$path.$fName ))
                {
                    echo $_FILES["file"]["name"] . " already exists. ";
                }
                else
                {
                    if (!is_dir("../".$path)) {
                        mkdir("../".$path,0777,true);         
                    }            
                    move_uploaded_file($_FILES["file"]["tmp_name"],
                    "../".$path.$fName);                               
                }                     
                $query->bindValue(":file",$path.$_FILES["file"]["name"], PDO::PARAM_STR);                     
            }             
        }       
        //insert db
        $query->bindValue(":name",$name, PDO::PARAM_STR);
        $query->bindValue(":description",($description != "") ? $description:NULL, PDO::PARAM_STR);             
        $query->bindValue(":idcontent",$idcontent, PDO::PARAM_STR);                  
        $query->execute();
        
        //update keywords
        
        if($keywords != "")
        {
            $dbh->query("DELETE FROM contentkeyword` WHERE `indcontent`='".$idcontent."'");
            $i=0;
            $keywords = explode(',',$keywords);
            $count = count($keywords);       
            while($i<$count)
            {
                $dbh->query("INSERT INTO contentkeyword (idcontent, idkeywords) VALUES (".$idcontent.",".$keywords[$i].")");
                $i++;
            }
        }
        echo "<legend class='text-left'></legend><div class=\"col-lg-8\">  <div class=\"alert alert-success\"> <button type=\"button\" onclick=\"addcontent_form('php/content.php', 'contentform','addcontent_form')\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button> <h6>Success! Your discipline was updated</h6> </div> </div> ";       
       
    }else return;   
}

if (strcmp($_REQUEST['content'], "removecontent")==0) {

    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $query_contentkeyword = $dbh->prepare("DELETE FROM contentkeyword WHERE `idcontent`=:idcontent");
    $query_content = $dbh->prepare("DELETE FROM content WHERE `idcontent`=:idcontent");
    
    $idcontent = $_POST['idcontent'];      
    
    $result = $dbh->query("SELECT * FROM content WHERE idcontent=".$idcontent);
    if($result->rowCount())
    {
        $result = $result->fetchAll();
        
        //remove keywords
        $query_contentkeyword->bindValue(":idcontent",$idcontent, PDO::PARAM_STR);
        $query_contentkeyword->execute();
        
        // delete file
        if($result[0]['file']!="")
        {
            $path = iconv("utf-8", 'ISO-8859-1',$result[0]['file']);                  
            if(file_exists("../".$path))
            {
                unlink("../".$path);
            }
        }
        
        //remove content
        $query_content->bindValue(":idcontent",$idcontent, PDO::PARAM_STR); 
        $query_content->execute();
        
        echo "<legend class='text-left'></legend><div class=\"col-lg-8\">  <div class=\"alert alert-success\"> <button type=\"button\" onclick=\"addcontent_form('php/content.php', 'contentform','addcontent_form')\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button> <h6>Success! Your content was deleted</h6> </div> </div> ";
        
    }else return;
}
     
?>
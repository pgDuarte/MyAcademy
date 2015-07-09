<?php

    
    header('Content-Type: text/html; charset=utf-8');

if (strcmp($_POST['type'], "updateAtt") == 0){

    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    
    // Header    
    $title = $_POST['title'];
    $idpub = $_POST['idpub'];      
    $private = $_POST['privacy'];    
    $keywords = $_POST['keywords'];
    
    $dbh->query("UPDATE `publications` SET `title`='".$title."', `private`='".$private."' WHERE `idpublication`='".$idpub."';");
    
    if($keywords != "")
    {
        $dbh->query("DELETE FROM pubkeyword` WHERE `idpublication`='".$idpub."'");
        $i=0;
        $keywords = explode(',',$keywords);
        $count = count($keywords);       
        while($i<$count)
        {
            $dbh->query("INSERT INTO pubkeyword (idpublication, idkeywords) VALUES ('".$idpub."',".$keywords[$i].")");
            $i++;
        }
    }

    echo "<legend class='text-left'></legend><div class=\"col-lg-8\">  <div class=\"alert alert-success\"> <button type=\"button\" onclick=\"pubselect(),location.reload();\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button> <h6>Success! Your publicatioin was updated</h6> </div> </div> ";

}
    
if (strcmp($_POST['type'], "pubselect") == 0)
{
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    
    $iduser = $_POST['iduser'];
    
    $result = $dbh->query("select * from publications where idusers='".$iduser."'");
    $result = $result->fetchAll();
           
    
    $count = count($result);       
    $string ="";
    $i=0;
    
    while($i < $count)
    {
        if($result[$i]['idpublication']!="")
        {    
           $string = $string."<option value='".$result[$i]['idpublication']."'>".$result[$i]['title'];
           if($result[$i]['year']!="")
           {
              $string =$string." [".$result[$i]['year']."]";
           }
           $string = $string."</option>";           
        }
        $i++;
    }
    
    echo $string;
}

if (strcmp($_REQUEST['type'], "getkeywords")==0) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    
    $idpub = $_POST['idpub'];
        
    $result = $dbh->query("select * from pubkeyword where idpublication='".$idpub."'");	
    $result = $result->fetchAll();
    
    $count = count($result);
    $i=0;
    $string="";
    
    if($result[0]['idpublication']!="")
    {
        while ($i < $count) {
            $string=$string.$result[$i]['idkeywords'];
            if($i+1 < $count)
            {
                $string=$string." ";
            }
            $i++;
        }
    }                    
    echo $string;    
}

if (strcmp($_POST['type'], "pubinfo") == 0)
{
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    
    $idpub = $_POST['idpub'];
    
    $result = $dbh->query("select * from publications where idpublication='".$idpub."'");
    $result = $result->fetch();
    $string ="";
    $string = $string. "
        <div class='row'>
        <div class='col-lg-12'>
            <label>Title</label>            
            <input class='form-control' name='title' id='title' type='text' value='".$result['title']."'/>                                  
        </div>
    </div>
    <br/>
    <div class='row'>
        <div class='col-lg-4'>
            <label>Publication ID</label>            
            <input class='form-control' name='idpub' id='idpub' type='text' disabled='' value='".$result['idpublication']."'/>                                              
        </div>
        
        <div class='col-lg-4'>
            <label>Type</label>                     
            <select class='form-control' name='type' id='type' disabled=''>";
            
            if($result['type']=="article")$string=$string."<option value='article' selected>Article</option>";                             
             else $string=$string."<option value='article'>Article</option>";             
             if($result['type']=="book")$string=$string."<option value='book' selected>Book</option>";                             
             else $string=$string."<option value='book'>Book</option>";             
             if($result['type']=="inbook")$string=$string."<option value='inbook' selected>Inbook</option>";                             
             else $string=$string."<option value='inbook'>Inbook</option>";             
             if($result['type']=="proceedings")$string=$string."<option value='proceedings' selected>Proceedings</option>";                             
             else $string=$string."<option value='proceedings'>Proceedings</option>";
             if($result['type']=="inproceedings")$string=$string."<option value='inproceedings' selected>Inproceedings</option>";                             
             else $string=$string."<option value='inproceedings'>Inproceedings</option>";
             if($result['type']=="misc")$string=$string."<option value='misc' selected>Misc</option>";                             
             else $string=$string."<option value='misc'>Misc</option>";
             if($result['type']=="msc")$string=$string."<option value='msc' selected>MSc</option>";                             
             else $string=$string."<option value='msc'>MSc</option>";
             if($result['type']=="phd")$string=$string."<option value='phd' selected>PhD</option>";                             
             else $string=$string."<option value='phd'>PhD</option>";
                
    $string=$string."
            </select>                                   
        </div>                                                                  
    </div>
    <br/>
    
    <div class='row'>
        <div class='col-lg-4'>
            <label>Year</label>            
            <input class='form-control' name='year' id='year' type='number' min='1960' max='2060' value='".$result['year']."' disabled='' />                        
        </div>
        <div class='col-lg-4'>
            <label>Privacy</label>            
            <select class='form-control' name='private' id='private'>";
        if($result['private']=="0")$string=$string."<option value='0' selected>Public</option>";                             
             else $string=$string."<option value='0'>Public</option>"; 
             if($result['private']=="1")$string=$string."<option value='1' selected>Private</option>";                             
             else $string=$string."<option value='1'>Private</option>";
$string=$string."              
    </div>
    <br/>";
    
    echo $string;

}        

if (strcmp($_POST['type'], "insertpub")==0) {

    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

  //preparar queries
    $query_pub = $dbh->prepare("INSERT INTO publications (idpublication, type, title, year, private, idusers) VALUES (:idpublication, :type, :title, :year, :private, :idusers)");
    $query_pubother = $dbh->prepare("INSERT INTO pubother (idpublication, name, value) VALUES (:idpublication, :name, :value)");
    $query_pubaut = $dbh->prepare("INSERT INTO pubaut (idpublication, idauthor, type) VALUES (:idpublication, :idauthor, :type)");
    $query_authors = $dbh -> prepare("INSERT INTO authors (idauthor, name) VALUES (:idauthor, :name)");
    $query_deliverables = $dbh -> prepare("INSERT INTO deliverables (type, url, description, idpublication) VALUES (:type, :url, :description, :idpublication)");
   
    // Header
    $iduser = $_POST['idusers'];
    $title = $_POST['title'];
    $type = $_POST['pubtype'];
    $year = $_POST['year'];
    $private = $_POST['privacy'];
    $idpub = $_POST['idpub'];
    $keywords = $_POST['keywords'];
    $nauthors = $_POST['nauthors'];
    $nattributes = $_POST['natributes'];
  
    
    //verify idpub
    $result = $dbh->query("SELECT title FROM publications WHERE idpublication = '".$idpub."'");
    
    if($result->rowCount())
    {
        echo "idpub";
        return;        
    }else
    {
        //insert publication
        
        $query_pub->bindValue(":idpublication",$idpub, PDO::PARAM_STR);
        $query_pub->bindValue(":type",$type, PDO::PARAM_STR);
        $query_pub->bindValue(":title",$title, PDO::PARAM_STR);
        $query_pub->bindValue(":year",$year, PDO::PARAM_STR);
        $query_pub->bindValue(":private",$private, PDO::PARAM_STR);              
        $query_pub->bindValue(":idusers",$iduser, PDO::PARAM_STR);     
        $query_pub->execute();
        
        
        //insert pubother - other attributes
        if($_POST['name1'] != "")
        {
            for ($tr = 1; $tr <= $nattributes; $tr++) {
            
                $name = $_POST['name'.$tr];
                $value = $_POST['value'.$tr];
                $query_pubother->bindValue(":idpublication",$idpub, PDO::PARAM_STR);
                $query_pubother->bindValue(":name",$name, PDO::PARAM_STR);
                $query_pubother->bindValue(":value",$value, PDO::PARAM_STR);
                $query_pubother->execute();  
            }
        }   
        
        //insert user pubaut as an author and/or editor
        $result = $dbh->query("SELECT idauthor FROM users WHERE idusers = ".$iduser);        
        if($result->rowCount())
        {
            $id = $result->fetch()['idauthor'];
            
            if($_POST['userisauthor'] == "true")
            {
                $query_pubaut->bindValue(":idpublication",$idpub, PDO::PARAM_STR);
                $query_pubaut->bindValue(":idauthor",$id, PDO::PARAM_STR);
                $query_pubaut->bindValue(":type","author", PDO::PARAM_STR);                 
                $query_pubaut->execute();               
            }

            if($_POST['useriseditor'] == "true")
            {
                $query_pubaut->bindValue(":idpublication",$idpub, PDO::PARAM_STR);
                $query_pubaut->bindValue(":idauthor",$id, PDO::PARAM_STR);
                $query_pubaut->bindValue(":type","editor", PDO::PARAM_STR);                 
                $query_pubaut->execute();               
            }           
        }   
        
        //insert authors and pubaut        
        if($_POST['A_name1'] != "")
        {
            for ($tr = 1; $tr <= $nauthors; $tr++) {
            
                $name = $_POST['A_name'.$tr];
                $id = $_POST['A_id'.$tr];                
                
                $result = $dbh->query("SELECT name FROM authors WHERE idauthor = '".$id."'");
                
                if($result->rowCount())
                {                
                    if ($name == $result->fetch()['name'])
                    {                    
                        //insert pubaut
                        
                        if($_POST['isauthor'.$tr]== "true")
                        {
                            $query_pubaut->bindValue(":idpublication",$idpub, PDO::PARAM_STR);
                            $query_pubaut->bindValue(":idauthor",$id, PDO::PARAM_STR);
                            $query_pubaut->bindValue(":type","author", PDO::PARAM_STR);                 
                            $query_pubaut->execute();               
                        }
            
                        if($_POST['iseditor'.$tr]== "true")
                        {
                            $query_pubaut->bindValue(":idpublication",$idpub, PDO::PARAM_STR);
                            $query_pubaut->bindValue(":idauthor",$id, PDO::PARAM_STR);
                            $query_pubaut->bindValue(":type","editor", PDO::PARAM_STR);                 
                            $query_pubaut->execute();               
                        }
                    }else
                    {
                        echo "The author ID already exists but it's not the same. Please go to edit section and enter again this author with another ID.\n";
                    }
                }else
                {
                    $query_authors->bindValue(":idauthor",$id, PDO::PARAM_STR);
                    $query_authors->bindValue(":name",$name, PDO::PARAM_STR);                
                    $query_authors->execute(); 
                    
                    //insert pubaut
                    if($_POST['isauthor'.$tr] == "true")
                    {
                        $query_pubaut->bindValue(":idpublication",$idpub, PDO::PARAM_STR);
                        $query_pubaut->bindValue(":idauthor",$id, PDO::PARAM_STR);
                        $query_pubaut->bindValue(":type","author", PDO::PARAM_STR);                 
                        $query_pubaut->execute();               
                    }
        
                    if($_POST['iseditor'.$tr] == "true")
                    {
                        $query_pubaut->bindValue(":idpublication",$idpub, PDO::PARAM_STR);
                        $query_pubaut->bindValue(":idauthor",$id, PDO::PARAM_STR);
                        $query_pubaut->bindValue(":type","editor", PDO::PARAM_STR);                 
                        $query_pubaut->execute();               
                    }     
                }                             
            }
        }
         
        //insert deliverables
        if(isset($_FILES['file1']) && $_FILES['file1']['error'] != UPLOAD_ERR_NO_FILE)     
        {
            for($fl=1; $fl<=$_POST["nfiles"]; $fl++)
            {
                $resultado = $dbh->query("SELECT email FROM users WHERE idusers = ".$iduser);
                $email = $resultado->fetch()['email'];
                $fName = iconv("utf-8", 'ISO-8859-1', $_FILES["file".$fl]["name"]);                
                                                                                                      
                $path = "users/".$email."/deliverables/".$type."/".$year."/";
                                           
                if (!file_exists("../".$path.$fName))                
                {
                    if (!is_dir("../".$path)) {
                        mkdir("../".$path,0777,true);
                    }
                    move_uploaded_file($_FILES["file".$fl]["tmp_name"],
                    "../".$path.$fName);                                      
                }
                
                $ext = end(explode(".", $_FILES["file".$fl]["name"]));
                //insert deliverable
                $query_deliverables->bindValue(":type",$ext, PDO::PARAM_STR);
                $query_deliverables->bindValue(":url",$path.$_FILES["file".$fl]["name"], PDO::PARAM_STR);
                $query_deliverables->bindValue(":description",$_POST['filedesc'.$fl], PDO::PARAM_STR);
                $query_deliverables->bindValue(":idpublication",$idpub, PDO::PARAM_STR);
                $query_deliverables->execute();                                          
            }
        }
            //keywords
        if($keywords != "")
        {
            $i=0;
            $keywords = explode(',',$keywords);
            $count = count($keywords);       
            while($i<$count)
            {
                $dbh->query("INSERT INTO pubkeyword (idpublication, idkeywords) VALUES ('".$idpub."',".$keywords[$i].")");
                $i++;
            }
        }
        echo "success";
    }
}      
?>
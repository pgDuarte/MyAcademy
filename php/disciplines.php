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


if (strcmp($_GET['disciplines'], "disciplineselect")==0) {

    $str = $_GET['disciplines'];    
    $userID = $_GET['id'];          // get data

    $result = $client->call("listDisciplines", array('userID'=>$userID));
    
    $select = "<select id='discicplineselectid' class='form-control' multiple='' style='height: 250px;' onchange=\"disciplineinfo('php/disciplines.php','disciplinecontent','disciplinecontent',this.value)\">";

    $count = count($result);
    $i=0;
    
    while ($i < $count) {    
     $select = $select."<option value='".$result[$i]['iddiscipline']."'>".$result[$i]['name'];
     if($result[$i]['academicYear']!="")
     {
        $select =$select." [".$result[$i]['academicYear']."]";
     }
     $select =$select."</option>";
     $i++;
    }
   
     $select = $select."</select>";
    echo $select;
}


if (strcmp($_GET['disciplines'], "disciplinecontent")==0) {

    $str = $_GET['disciplines'];    
    $disciplineID = $_GET['id'];          // get data
    
    $result = $client->call("disciplineinfo", array('id'=>$disciplineID));
    
    
    $select = "<legend class='text-left'></legend>";
    $select = $select."<div class='row'>
                <div class='col-lg-6'>
                  <label>Name</label>
                  <input class='form-control' name='name' id='name' type='text' required='' value='".$result[0]['name']."'/>              
                </div>
                
                <div class='col-lg-3'>
                  <label>Academic year</label>
                  <input class='form-control' name='academicyear' id='academicyear' type='text' required='' value='".$result[0]['academicYear']."'/>              
                </div>
              </div>
              
              <br/>
              
              <div class='row'>
                <div class='col-lg-2'>
                  <label>Course year</label>
                  <input class='form-control' name='courseyear' id='courseyear' type='number' min='1' max='9' value='".$result[0]['courseYear']."'/>              
                </div>
                
                <div class='col-lg-3'>
                  <label>Number of students</label>
                  <input class='form-control' name='studentsnumber' id='studentsnumber' type='number' min='1' max='200' value='".$result[0]['nStudents']."'/>              
                </div>              
              </div>
              
              <br/>
              
              <div class='row'>
                <div class='col-lg-6'>
                  <label>Institution</label>
                  <input class='form-control' name='inst' id='inst' type='text' value='".$result[0]['inst']."'/>
                </div>
                
                <div class='col-lg-5'>
                  <label>Course name</label>
                  <input class='form-control' name='course' id='course' type='text' value='".$result[0]['courseName']."'/>
                </div>              
              </div>
              <br/>
              <div class='text-left'>
                <button class='btn btn-success btn-xs' type='button' onclick=\"updatediscipline('php/disciplines.php', 'disciplinecontent','updatediscipline',".$disciplineID.");\">Update</button>
              </div>";
               
    echo $select;
}

if (strcmp($_GET['disciplines'], "adddiscipline_form")==0) {
     
    $select = "<legend class='text-left'></legend>";
    $select = $select."<div class='row'>
                <div class='col-lg-6'>
                  <label>Name</label>
                  <input class='form-control' name='name' id='name' type='text' required='' />              
                </div>
                
                <div class='col-lg-3'>
                  <label>Academic year</label>
                  <input class='form-control' name='academicyear' id='academicyear' type='text' required='' placeholder='ex: 2013/2014' />              
                </div>
              </div>
              
              <br/>
              
              <div class='row'>
                <div class='col-lg-2'>
                  <label>Course year</label>
                  <input class='form-control' name='courseyear' id='courseyear' type='number' min='1' max='9' value='5'/>              
                </div>
                
                <div class='col-lg-3'>
                  <label>Number of students</label>
                  <input class='form-control' name='studentsnumber' id='studentsnumber' type='number' min='1' max='200'/>              
                </div>              
              </div>
              
              <br/>
              
              <div class='row'>
                <div class='col-lg-6'>
                  <label>Institution</label>
                  <input class='form-control' name='inst' id='inst' type='text'/>
                </div>
                
                <div class='col-lg-5'>
                  <label>Course name</label>
                  <input class='form-control' name='course' id='course' type='text'/>
                </div>              
              </div>
              <br/>
              <div class='text-left'>
                <button class='btn btn-success btn-xs' type='button' onclick=\"insertdiscipline('php/disciplines.php', 'disciplinecontent')\">Insert</button>
              </div>";               
    echo $select;
}

if (strcmp($_GET['disciplines'], "insertdiscipline")==0) {

    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $query = $dbh->prepare("INSERT INTO discipline (name, academicYear, courseYear, nStudents, uri, inst, courseName, idusers) 
    VALUES (:name, :academicYear, :courseYear, :nStudents, :uri, :inst, :course, :idusers)");
    
    $userID = $_GET['userID'];        
    $name = $_GET['name']; 
    $academicYear = $_GET['academicYear'];
    $courseYear = $_GET['courseYear'];
    $nStudents = $_GET['sNumber'];
    $inst = $_GET['inst'];
    $course = $_GET['course'];
    
    //verify 
    $result = $dbh->query("SELECT * FROM discipline WHERE name = '".$name."' and academicYear = '".$academicYear."' and idusers='".$userID."'");
    if(!$result->rowCount())
    {
        //create dir
        $result = $dbh->query("SELECT email FROM users WHERE idusers='".$userID."'");
        $email = $result->fetch()['email'];
        $year = explode("/", $academicYear);
        if(count($year)>1)
        {
            $dir = "users/".$email."/teaching/".iconv("utf-8", 'ISO-8859-1', $name)."-".$year[0]."_".$year[1]."/";
            $uri = "users/".$email."/teaching/".$name."-".$year[0]."_".$year[1]."/";
        }else
        {
            $dir = "users/".$email."/teaching/".iconv("utf-8", 'ISO-8859-1', $name)."-".$academicYear."/";
            $uri = "users/".$email."/teaching/".$name."-".$academicYear."/";
        }
        
        if(!is_dir("../".$dir))
        {
            mkdir("../".$dir,0777,true);
        }
        //insert db
        $query->bindValue(":name",$name, PDO::PARAM_STR);
        $query->bindValue(":academicYear",$academicYear, PDO::PARAM_STR);
        $query->bindValue(":courseYear",($courseYear != "") ? $courseYear:NULL, PDO::PARAM_STR);
        $query->bindValue(":nStudents",($nStudents != "") ? $nStudents:NULL, PDO::PARAM_STR);
        $query->bindValue(":uri",($uri != "") ? $uri:NULL, PDO::PARAM_STR);
        $query->bindValue(":inst",($inst != "") ? $inst:NULL, PDO::PARAM_STR);
        $query->bindValue(":course",($course != "") ? $course:NULL, PDO::PARAM_STR);
        $query->bindValue(":idusers",$userID, PDO::PARAM_STR);            
        $result = $query->execute();
        
        echo "<legend class='text-left'></legend><div class=\"col-lg-8\">  <div class=\"alert alert-success\"> <button type=\"button\" onclick=\"adddiscipline_form('php/disciplines.php','disciplinecontent','adddiscipline_form');\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button> <h6>Success! Your discipline was inserted</h6> </div> </div> ";       
       
    }else return;   
}

if (strcmp($_GET['disciplines'], "updatediscipline")==0) {

    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));    
    $query = $dbh->prepare("UPDATE discipline SET `name`=:name, `academicYear`=:academicYear, `courseYear`=:courseYear, `nStudents`=:nStudents, `courseName`=:courseName, `inst`=:inst WHERE `iddiscipline`=:iddiscipline");
    $id = $_GET['id'];        
    $name = $_GET['name']; 
    $academicYear = $_GET['academicYear'];
    $courseYear = $_GET['courseYear'];
    $nStudents = $_GET['sNumber'];
    $inst = $_GET['inst'];
    $course = $_GET['course'];
    
    //verify 
    $result = $dbh->query("SELECT * FROM discipline WHERE iddiscipline=".$id);
    if($result->rowCount())
    {
        //insert db
        $query->bindValue(":name",$name, PDO::PARAM_STR);
        $query->bindValue(":academicYear",$academicYear, PDO::PARAM_STR);
        $query->bindValue(":courseYear",($courseYear != "") ? $courseYear:NULL, PDO::PARAM_STR);
        $query->bindValue(":nStudents",($nStudents != "") ? $nStudents:NULL, PDO::PARAM_STR);       
        $query->bindValue(":inst",($inst != "") ? $inst:NULL, PDO::PARAM_STR);
        $query->bindValue(":courseName",($course != "") ? $course:NULL, PDO::PARAM_STR);
        $query->bindValue(":iddiscipline",($id != "") ? $id:NULL, PDO::PARAM_STR);                
        $result = $query->execute();
        
        echo "<legend class='text-left'></legend><div class=\"col-lg-8\">  <div class=\"alert alert-success\"> <button type=\"button\" onclick=\"disciplineinfo('php/disciplines.php','disciplinecontent','disciplinecontent',".$id.")\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button> <h6>Success! Your discipline was updated</h6> </div> </div> ";       
       
    }else return;   
}

if (strcmp($_GET['disciplines'], "removediscipline")==0) {

    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $query_discipline = $dbh->prepare("DELETE FROM discipline WHERE `iddiscipline`=:iddiscipline");
    $query_content = $dbh->prepare("DELETE FROM content WHERE `iddiscipline`=:iddiscipline");
    
    $id = $_GET['id'];        
    
    //verify 
    $result = $dbh->query("SELECT * FROM discipline WHERE iddiscipline=".$id);
    if($result->rowCount())
    {
        //get url of old dir        
        $olddir = iconv("utf-8", 'ISO-8859-1',$result->fetch()['uri']);     
        
        $tokens = explode('/', $olddir);         
                                                
        if($tokens[0] == "users")
        {
            $dir = "../".$olddir;
            if(is_dir($dir))
            {
                delTree($dir);                     
            }
        }
        //insert db
        $query_discipline->bindValue(":iddiscipline",($id != "") ? $id:NULL, PDO::PARAM_STR);    
        $query_content->bindValue(":iddiscipline",($id != "") ? $id:NULL, PDO::PARAM_STR);                   
        $result = $query_discipline->execute();
        $result = $query_content->execute();
        
        echo "<legend class='text-left'></legend><div class=\"col-lg-8\">  <div class=\"alert alert-success\"> <button type=\"button\" onclick=\"adddiscipline_form('php/disciplines.php','disciplinecontent','adddiscipline_form')\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button> <h6>Success! Your discipline was removed</h6> </div> </div> ";       
       
    }else return;   
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
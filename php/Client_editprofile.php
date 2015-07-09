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


// Para apresentar toda a informação correspondente ao Perfil do Utilizador
if (strcmp($_GET['editprofile'], "JOB1")==0) {
    $str = $_GET['editprofile'];    
    $userID = $_GET['id'];   
    $idwork = $_GET['idObject'];
    
    $row = $client->call('listWork', array('userID'=>$userID, 'idwork' => $idwork) );
    $pieces = explode(",", $row['overview']);
    $count = count($pieces);

         $echo_work = "<form class=\"form-inline\" role=\"form\" action=\"\" method=\"post\" enctype=\"multipart/form-data\" id=\"form_workexp\" >
                 <div class=\"row\" >
                  <div class=\"col-lg-5\" >
                    <div class=\"form-group\">
                      <label>Partnership</label>
                      <input class=\"form-control\" name=\"partnership\" id=\"partnership\" placeholder=\"Partnership Name\" value=\"".$row['partnership']."\"></input>
                    </div>
                  </div>
                  
                  <div class=\"col-lg-5\">
                    <div class=\"form-group\">
                      <label>Job's Name</label>
                      <input class=\"form-control\" name=\"jobname\" id=\"jobname\" placeholder=\"Insert Job's Name\" value=\"".$row['profession']."\"></input>
                    </div>
                  </div> 
                </div>
                
                <br></br>
                
                <div class=\"row\">
                  <div class=\"col-lg-5\">
                    <div class=\"form-group\">
                      <label>Year of Begin</label>
                      <input class=\"form-control\" type=\"number\" min=\"1960\" max=\"2060\"  name=\"ybegin\" id=\"ybegin\" placeholder=\"e.g: 2012\" value=\"".$row['begin']."\"></input>
                    </div>
                  </div>
                  
                  <div class=\"col-lg-5\">
                    <div class=\"form-group\">
                      <label>Year of end</label>
                      <input class=\"form-control\" type=\"number\" min=\"1960\" max=\"2060\"   name=\"yend\" id=\"yend\" placeholder=\"e.g: 2013\" value=\"".$row['end']."\"></input>
                      <p class=\"help-block\">  
                        If is still your current job does not insert end date
                      </p>
                    </div>
                  </div> 
                </div>
                
                 <div class=\"row\" id=\"tasks\">
                 <div class=\"col-lg-5\">
                 <div class=\"row\">
                 ";
                
               
               $i = 1;
               while ($i <=$count) {
                    $echo_work = $echo_work."<div class=\"col-lg-12\" id=\"col_tasks".$i."\"> <div class=\"form-group\" id=\"form-group_tasks\"> <label id=\"lbTasks\">Task ".$i.":</label> <input class=\"form-control\" id=\"task".$i."\" placeholder=\"Insert task\" value=\"".$pieces[$i-1]."\"></input> </div></div> ";
                    $i= $i+1;
                }
                
  
               $echo_work = $echo_work."</div></div>
                   <div class=\"col-lg-5\" id=\"new_RowTasks\">
                   
                  </div></div>
               
               <div class=\"row\">
                  <div class=\"col-lg-7\">
                    <br></br>
                    <p>
                      <button class=\"btn btn-primary btn-xs\" type=\"button\" onclick=\"addTask(1);\">
                        + Task
                      </button>
                      
                      <button class=\"btn btn-danger btn-xs\" type=\"button\" onclick=\"removeTask(1);\">
                        - Task
                      </button>     
                    </p>
                  </div>
                </div>  
                <div class=\"row\">   
                  <div class=\"col-lg-7\">
                   
                  </div> 
                  </div> <!-- row -->
                
                  <div class=\"col-lg-12 text-right\">
                    <button class=\"btn btn-info btn-sm\" type=\"button\" onclick=\"updatework();\">
                      + Update
                    </button>
                </div>   
               
                </div>
                </form>";
    
    echo $echo_work;
}

if (strcmp($_GET['editprofile'], "workselect")==0) {
    $str = $_GET['editprofile'];    
    $userID = $_GET['id'];          // get data

   $row = $client->call("work_experience_List", array('id'=>$userID) );
    
    $select = "<select class=\"form-control\" id =\"workSelectx\"  multiple=\"\" style=\"width: 268px; padding: 5px;\" onchange=\"requestInfo('workSelectx','".$userID."','JOB1');\">";

    $count =count($row);
    $i=0;
    while ($i < $count) {
     $select = $select."<option id=workselect".$i."\" value=".$row[$i]['idwork'].">".$row[$i]['idwork']." - ".$row[$i]['profession']."</option>";
     $i++;
    }
   
     $select = $select."</select>";
    echo $select;
}


// Para o painel de seleção das Skills

if (strcmp($_GET['editprofile'], "allSkills")==0) {
    $str = $_GET['editprofile'];    
    $userID = $_GET['id'];          // get data

    $row = $client->call($str, array('id'=>$userID) );
    
    $select = "<select class=\"form-control\" id =\"skillSelectx\"  multiple=\"\" style=\"width: 268px; padding: 5px;\" onchange=\"requestInfo('skillSelectx','".$userID."','skill_name_col');\" >";

    
    $count =count($row);
    $i=0;
    while ($i < $count) {
    $select = $select."<option id=allSkills".$i." value=".$row[$i]['idskills'].">".$row[$i]['idskills']." - ".$row[$i]['skill']."</option>";
    $i++;
    }
    
    $select = $select."</select>";
    echo $select;
}

// Para apresentar a informação correspondente a uma skill 
if (strcmp($_GET['editprofile'], "skill_name_col")==0) {
    $str = $_GET['editprofile'];    
    $userID = $_GET['id'];   
    $idSkill = $_GET['idObject'];
    
    $row = $client->call('listSkill', array('userID'=>$userID, 'idskill' => $idSkill) );
    
    
   echo " <div class=\"row\" id=\"Skill\">
   
           <form class=\"form-inline\" role=\"form\" action=\"\" method=\"post\" enctype=\"multipart/form-data\" id=\"form_skill\" >
                <div class=\"form-group\" id=\"form\">
                      <label>Skill Name: </label>
                      <input class=\"form-control\" size = \"40\" id=\"skill_name\" placeholder=\" e.g: Programming, Networking\" value=\"".$row['skill']."\"></input>
                </div>
                <br></br>
                <div class=\"form-group\">
                      <label>Description: </label>
                      <textarea class=\"form-control\" size = \"60\" rows=\"4\" id=\"skill_description\" placeholder=\"Insert Description\" >".$row['Description']."</textarea>
                </div>
                
                
                 <div class=\"col-lg-12 text-right\">
                    <button class=\"btn btn-info btn-sm\" type=\"button\" onclick=\"updateskill();\">
                        + Update
                    </button>
                 </div>
               
            </form>
         </div>";
}




if (strcmp($_GET['editprofile'], "allEducation")==0) {
    $str = $_GET['editprofile'];    
    $userID = $_GET['id'];          // get data

    $row = $client->call($str, array('id'=>$userID) );
    
    $select = "<select class=\"form-control\" id =\"educationSelectx\"  multiple=\"\" style=\"width: 268px; padding: 5px;\" onchange=\"requestInfo('educationSelectx','".$userID."','education');\" >";

    $count =count($row);
    $i=0;

    while ($i <$count) {
    $select = $select."<option id=allEducation".$i."\"  value=".$row[$i]['ideducation'].">".$row[$i]['ideducation']." - ".$row[$i]['curse']."</option>";
    $i++;
    }
    
    $select = $select."</select>";
    echo $select;
}


// Para apresentar a informação correspondente a uma skill 
if (strcmp($_GET['editprofile'], "education")==0) {
    $str = $_GET['editprofile'];    
    $userID = $_GET['id'];   
    $idEducation = $_GET['idObject'];
    
    $row = $client->call('listCourse', array('userID'=>$userID, 'idCourse' => $idEducation) );
   
    
    
   echo "<div class=\"row\" id=\"course\"> 
                <form class=\"form-inline\" role=\"form\" action=\"\" method=\"post\" enctype=\"multipart/form-data\" id=\"form_education\" >
                 <div class=\"col-lg-6\">
                    <div class=\"form-group\">
                      <label>School</label>
                      <input class=\"form-control\" placeholder=\"School Name\" id=\"school\"  value=\"".$row['school']."\"></input>
                    </div>
                    
                    <div class=\"form-group\">
                      <label> Course </label>
                      <input class=\"form-control\" placeholder=\"Course Name\" id=\"coursevalue\"  value=\"".$row['curse']."\"></input> 
                    </div>
                 </div>
                 
                 <div class=\"form-group\">
                   <label>
                     Degree
                   </label>
                   <input class=\"form-control\"  id=\"level\" value=\"".$row['level']."\"></input>
                 </div>
                 
                 <div class=\"form-group\">
                   <label> Description</label>
                   <textarea class=\"form-control\" rows=\"3\" id=\"description\" >".$row['description']."</textarea>
                 </div>
                 
                </div> <!-- row -->
                <div class=\"row\">
                  <div class=\"col-lg-12 text-right\">
                    <button class=\"btn btn-info btn-sm\" type=\"button\" onclick=\"updateeducation();\">
                      + Update
                    </button>
                  </div>
                </div>
                
                 </form>
                </div>";
}

?>
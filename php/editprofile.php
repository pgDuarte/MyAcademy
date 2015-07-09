<?php



    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));




/**************************************************************************************************************************************************************************
                                                            Header    - Info about User      
**************************************************************************************************************************************************************************/

//Editar a informação do header
if (strcmp($_REQUEST['editprofile'], "editname")==0) {
    $str = $_POST['editprofile'];  
    
 
      
    $userID = $_REQUEST['id']; 
    $firstName = $_REQUEST['firstName']; 
    $lastName = $_REQUEST['lastName']; 
    $email = $_REQUEST['email']; 
    $website = $_REQUEST['website']; 
    $phone =$_REQUEST['phone']; 
    $name = $firstName." ".$lastName;
    
    
    $infouser = $dbh->query("SELECT * FROM users WHERE idusers = '".$userID."'");
    $infouser = $infouser->fetch();
        
    if($_REQUEST['hashcurrentpassword']!="")
    {
        if($_REQUEST['hashpassword']!="")
        {
             // vai ver a password atual a base de dados 
            $sql = "SELECT password FROM users WHERE idusers = '".$userID."'";
            $res = $dbh->query($sql);
            $row = $res->fetch();
            
            // compara se a hashcurrentpassword é igual à password
            if (strcmp($_REQUEST['hashcurrentpassword'], $row['password'])==0)
            {  
                  $dbh->query("UPDATE `authors` SET `name`= '".$name."' WHERE `idauthor`='".$infouser['idauthor']."'");
                  $sql =  "UPDATE users SET name='".$name."', password='".$_REQUEST['hashpassword']."', email='".$email."', `phonenumber`='".$phone."', `url`='".$website."' where idusers ='".$userID."'";
                  
            }
            else 
            {
            
             $echo_code = "<div class=\"row\">
                      <div class=\"col-lg-5\">
                        <div class=\"form-group\">
                          <label>First Name</label>
                          <input class=\"form-control\" id=\"firstName\" placeholder=\"Insert your First Name\" value=\"".$firstName."\"></input>
                        </div>
                      </div>
                      
                         <div class=\"col-lg-5\">
                           <div class=\"form-group\">
                             <label>Last Name</label>
                             <input class=\"form-control\" id=\"lastName\" placeholder=\"Insert your Last Name\" value=\"".$lastName."\"></input>
                           </div>
                         </div>
                         
                         </div>
                    
                       <div class=\"row\">
                      <div class=\"col-lg-5\">
                        <div class=\"form-group\">
                          <label>Email</label>
                          <input type=\"email\" class=\"form-control\" id=\"email\" placeholder=\"Insert your Email\"  value=\"".$email."\"></input>
                        </div>
                      </div>
                      
                         <div class=\"col-lg-5\">
                        <div class=\"form-group\">
                          <label>Current Password</label>
                          <input type=\"password\" class=\"form-control\" id=\"currentpassword\" placeholder=\"Current Password\"  value=\"\"></input>
                        </div>
                      </div>
                      
                   </div>
                      
                     
                    
                    <div class=\"row\">
                    
                      <div class=\"col-lg-5\">
                        <div class=\"form-group\">
                          <label>New Password</label>
                          <input type=\"password\" class=\"form-control\" id=\"password\" placeholder=\"\"  value=\"\"></input>
                        </div>
                      </div>
                      
                       <div class=\"col-lg-5\">
                        <div class=\"form-group\">
                          <label>Repeat Password</label>
                          <input type=\"password\" class=\"form-control\" id=\"passwordrepeat\" placeholder=\"\"  value=\"\"></input>
                        </div>
                      </div>
                      
                    </div>
                    
                    
                    <div class=\"row\"> 
                      
                      <div class=\"col-lg-5\">
                       <div class=\"form-group\">
                         <label>WebSite</label>
                         <input class=\"form-control\" id=\"website\" placeholder=\"Insert your Website\"  value=\"".$website."\"></input>  
                       </div>
                      </div>
                      
                       
                      <div class=\"col-lg-5\">
                       <div class=\"form-group\">
                         <label>Phone</label>
                         <input class=\"form-control\"  type=\"tel\" id=\"phone\" placeholder=\"Insert your Number Phone\"  value=\"".$phone."\"></input>                      
                       </div>
                      </div>
                      
                       

                    </div>
                    
                    <div class=\"row\"> 
                        <div class=\"col-lg-10\">
                            <div class=\"alert alert-danger\">
                                <strong>ERROR!</strong> invalid password ... 
                            </div>
                        </div>
                     </div>
                
                  </div>";
                  
               echo $echo_code;
               return;
            }
       
        }
    }
     else 
            {
                $dbh->query("UPDATE `authors` SET `name`= '".$name."' WHERE `idauthor`='".$infouser['idauthor']."'");
                $sql =  "UPDATE users SET name='".$name."', email='".$email."', `phonenumber`='".$phone."', `url`='".$website."' where idusers ='".$userID."'";
            }
            
    if($dbh->query($sql))
    {
    
     $echo_code = "     <div class=\"row\">
                      <div class=\"col-lg-5\">
                        <div class=\"form-group\">
                          <label>First Name</label>
                          <input class=\"form-control\" id=\"firstName\" placeholder=\"Insert your First Name\" value=\"".$firstName."\"></input>
                        </div>
                      </div>
                      
                         <div class=\"col-lg-5\">
                           <div class=\"form-group\">
                             <label>Last Name</label>
                             <input class=\"form-control\" id=\"lastName\" placeholder=\"Insert your Last Name\" value=\"".$lastName."\"></input>
                           </div>
                         </div>
                         
                         </div>
                    
                       <div class=\"row\">
                      <div class=\"col-lg-5\">
                        <div class=\"form-group\">
                          <label>Email</label>
                          <input type=\"email\" class=\"form-control\" id=\"email\" placeholder=\"Insert your Email\"  value=\"".$email."\"></input>
                        </div>
                      </div>
                      
                         <div class=\"col-lg-5\">
                        <div class=\"form-group\">
                          <label>Current Password</label>
                          <input type=\"password\" class=\"form-control\" id=\"currentpassword\" placeholder=\"Current Password\"  value=\"\"></input>
                        </div>
                      </div>
                      
                   </div>
                      
                     
                    
                    <div class=\"row\">
                    
                      <div class=\"col-lg-5\">
                        <div class=\"form-group\">
                          <label>New Password</label>
                          <input type=\"password\" class=\"form-control\" id=\"password\" placeholder=\"\"  value=\"\"></input>
                        </div>
                      </div>
                      
                       <div class=\"col-lg-5\">
                        <div class=\"form-group\">
                          <label>Repeat Password</label>
                          <input type=\"password\" class=\"form-control\" id=\"passwordrepeat\" placeholder=\"\"  value=\"\"></input>
                        </div>
                      </div>
                      
                    </div>
                    
                    
                    <div class=\"row\"> 
                      
                      <div class=\"col-lg-5\">
                       <div class=\"form-group\">
                         <label>WebSite</label>
                         <input class=\"form-control\" id=\"website\" placeholder=\"Insert your Website\"  value=\"".$website."\"></input>  
                       </div>
                      </div>
                      
                       
                      <div class=\"col-lg-5\">
                       <div class=\"form-group\">
                         <label>Phone</label>
                         <input class=\"form-control\"  type=\"tel\" id=\"phone\" placeholder=\"Insert your Number Phone\"  value=\"".$phone."\"></input>                      
                       </div>
                      </div>
                      
                       
                    </div>
                    
                     <div class=\"row\">
                       <div class=\"col-lg-10\">
                            <div class=\"alert alert-success\">
                                <strong>Well done!</strong> update was realized with  success ..
                            </div>
                        </div>
                       </div>
                
                  </div>";
                   
                   echo $echo_code;
    }
    
}



/********************************************************************************************************/
// vai buscar a informação do utilizador a base de dados e apresenta em forma de formulário
if (strcmp($_REQUEST['editprofile'], "name")==0) {
    $str = $_REQUEST['editprofile'];    
    $userID = $_REQUEST['id'];          // get data


    $sql = "SELECT * FROM users WHERE idusers = '".$userID."'";
    $res = $dbh->query($sql);
    $row = $res->fetch();
    
    $pieces = explode(" ", $row['name']);

    
     echo "<div class=\"row\">
                      <div class=\"col-lg-5\">
                        <div class=\"form-group\">
                          <label>First Name</label>
                          <input class=\"form-control\" id=\"firstName\" placeholder=\"Insert your First Name\" value=\"".$pieces[0]."\"></input>
                        </div>
                      </div>
                      
                      <div class=\"col-lg-5\">
                        <div class=\"form-group\">
                          <label>Last Name</label>
                          <input class=\"form-control\" id=\"lastName\" placeholder=\"Insert your Last Name\"  value=\"".$pieces[1]."\"></input>
                        </div>
                      </div>
                      
                      </div>
                    
                    <div class=\"row\">
                      <div class=\"col-lg-5\">
                        <div class=\"form-group\">
                          <label>Email</label>
                          <input type=\"email\" class=\"form-control\" id=\"email\" placeholder=\"Insert your Email\"  value=\"".$row['email']."\"></input>
                        </div>
                      </div>
                      
                         <div class=\"col-lg-5\">
                        <div class=\"form-group\">
                          <label>Current Password</label>
                          <input type=\"password\" class=\"form-control\" id=\"currentpassword\" placeholder=\"Current Password\"  value=\"\"></input>
                        </div>
                      </div>
                      
                   </div>
                      
                     
                    
                    <div class=\"row\">
                    
                      <div class=\"col-lg-5\">
                        <div class=\"form-group\">
                          <label>New Password</label>
                          <input type=\"password\" class=\"form-control\" id=\"password\" placeholder=\"\"  value=\"\"></input>
                        </div>
                      </div>
                      
                       <div class=\"col-lg-5\">
                        <div class=\"form-group\">
                          <label>Repeat Password</label>
                          <input type=\"password\" class=\"form-control\" id=\"passwordrepeat\" placeholder=\"\"  value=\"\"></input>
                        </div>
                      </div>
                      
                    </div>
                    
                    
                    <div class=\"row\"> 
                      
                      <div class=\"col-lg-5\">
                       <div class=\"form-group\">
                         <label>WebSite</label>
                         <input class=\"form-control\" id=\"website\" placeholder=\"Insert your Website\"  value=\"".$row['url']."\"></input>  
                       </div>
                      </div>
                      
                       
                      <div class=\"col-lg-5\">
                       <div class=\"form-group\">
                         <label>Phone</label>
                         <input class=\"form-control\"  type=\"tel\" id=\"phone\" placeholder=\"Insert your Number Phone\"  value=\"".$row['phonenumber']."\"></input>                      
                       </div>
                      </div>
                      
                       
                    </div>
                
                  </div>";
                  
                  
}

/********************************************************************************************************/
// vai buscar a a descrição do utilizador 
   if (strcmp($_REQUEST['editprofile'], "prof_prof")==0) {
    $str = $_REQUEST['editprofile'];    
    $userID = $_REQUEST['id'];          // get data
    
    $sql = "SELECT personal_profile FROM users WHERE idusers = '".$userID."'";
    $res = $dbh->query($sql);
    $row = $res->fetch();
    
      echo " <textarea class=\"form-control\" rows=\"3\">".$row['personal_profile']."</textarea> </br> </hr>";
      
    }
   
   
/********************************************************************************************************/
// vai buscar a imagem 
if (strcmp($_REQUEST['editprofile'], "image")==0) {
    $str = $_REQUEST['editprofile'];    
    $userID = $_REQUEST['id'];          // get data


    $sql = "SELECT imageuri FROM users WHERE idusers = '".$userID."'";
    $res = $dbh->query($sql);
    $row = $res->fetch();
    
                 
    
    if (($res->rowCount() != 0)) {
               echo "<a>
                        <!-- Imagem depois dinamica por parte do utilizador-->
                        <img alt=\"140x140\" data-src=\"holder.js/140x140\"  src=\"".$row['imageuri']."\" class=\"img-thumbnail\"></img>
                     </a>
                        <h3><small>Please specify a image file:<br></small></h3>
                       <form method=\"post\" enctype=\"multipart/form-data\" \">
                            <input class=\"btn btn-primary btn-sm\" type=\"file\" name=\"images\" id=\"images\" data-bfi-disabled ></input>
                             <input class=\"btn btn-primary btn-sm\" type='button' id='btn' value='Upload!' onclick=\"uploadimage();\"></input>
                        </form>";}
                      else 
                      {
                        echo " <h3><small>Please specify a image file:<br></small></h3>
                        <form method=\"post\" enctype=\"multipart/form-data\" \">
                            <input class=\"btn btn-primary btn-sm\" type=\"file\" name=\"images\" id=\"images\" data-bfi-disabled ></input>
                             <input class=\"btn btn-primary btn-sm\" type='button' id='btn' value='Upload!'  onclick=\"uploadimage();\"></input>
                        </form>";
                      }          
}

/**************************************************************************************************************************************************************************
                                                                        Work & Experience            
**************************************************************************************************************************************************************************/


// cria a barra de seleção atualizada

if (strcmp($_REQUEST['editprofile'], "workselect")==0) {
    $str = $_REQUEST['editprofile'];    
    $userID = $_REQUEST['id'];          // get data

    $sql = "SELECT * FROM workexperience WHERE idusers = '".$userID."'";
    $res = $dbh->query($sql);
    
    $select = "<select class=\"form-control\" id =\"workSelectx\"  multiple=\"\" style=\"width: 268px; padding: 5px;\" onchange=\"requestInfo('workSelectx','".$userID."','JOB1');\">";

    while ($row = $res->fetch()) {
    
     $select = $select."<option value=".$row['idwork']."\">".$row['idwork']." - ".$row['profession']."</option>";
    }
    

    
    $select = $select."</select>";
    echo $select;
}




//Editar a informação do header
if (strcmp($_REQUEST['editprofile'], "create_work")==0) {
    $str = $_REQUEST['editprofile'];    
   
    $userID = $_REQUEST['id']; 
    $profession = $_REQUEST['jobname']; 
    $partnership = $_REQUEST['partnership']; 
    $begin = $_REQUEST['ybegin']; 
    $end = $_REQUEST['yend']; 
    $numTasks = $_REQUEST['numTasks']; 
     // são as tasks .. ciclo para ver quantas foram introduzidas
    
    
    $query = $dbh->prepare("INSERT INTO `workexperience` (`profession`,`partnership`,`begin`,`end`,`idusers`,`overview`) VALUES (:profession, :partnership, :begin, :end, :idusers, :overview)");
    $query->bindValue(":idusers",$userID, PDO::PARAM_STR);
    $query->bindValue(":profession",$profession, PDO::PARAM_STR);
    $query->bindValue(":partnership",$partnership, PDO::PARAM_STR);
    $query->bindValue(":begin",$begin, PDO::PARAM_STR);
    $query->bindValue(":end",$end, PDO::PARAM_STR);
   
    $overview = $_REQUEST['task1'];
    
    for ($i=2; $i<=$numTasks; $i++)
    {
     $overview = $overview.",".$_REQUEST['task'.$i];
    }
    
    $query->bindValue(":overview",$overview, PDO::PARAM_STR);
    $query->execute(); 
    
    echo $dbh->lastInsertId();
}



//Editar a informação do header
if (strcmp($_REQUEST['editprofile'], "update_work")==0) {
    $str = $_REQUEST['editprofile'];    
   
    $idusers = $_REQUEST['id']; 
    $idwork = $_REQUEST['idwork']; 
    $profession = $_REQUEST['jobname']; 
    $partnership = $_REQUEST['partnership']; 
    $begin = $_REQUEST['ybegin']; 
    $end = $_REQUEST['yend']; 
    $numTasks = $_REQUEST['numTasks']; 
     // são as tasks .. ciclo para ver quantas foram introduzidas
    

    
    $query = $dbh->prepare("UPDATE workexperience  SET `profession`=:profession, `partnership`=:partnership, `begin`=:begin, `end`=:end, `overview`=:overview, `idusers`=:idusers  WHERE `idwork`=:idwork;");
    
    $query->bindValue(":idusers",$idusers, PDO::PARAM_STR);
    $query->bindValue(":profession",$profession, PDO::PARAM_STR);
    $query->bindValue(":partnership",$partnership, PDO::PARAM_STR);
    $query->bindValue(":begin",$begin, PDO::PARAM_STR);
    $query->bindValue(":end",$end, PDO::PARAM_STR);
    $query->bindValue(":idwork",$idwork, PDO::PARAM_STR);
   
    $overview = $_REQUEST['task1'];
    
    for ($i=2; $i<=$numTasks; $i++)
    {
     $overview = $overview.",".$_REQUEST['task'.$i];
    }

    $query->bindValue(":overview",$overview, PDO::PARAM_STR);
    $query->execute(); 
    
    
    
    //echo $dbh->lastInsertId();
}
/***********************************************************************************************************************************************************************************/
// remove o work e apresenta a nova barra de seleção

if (strcmp($_REQUEST['editprofile'], "remove_work")==0) {
    $str = $_REQUEST['editprofile'];    
    $userID = $_REQUEST['id'];   
    $work2remove = $_REQUEST['idObject'];     // get data
    
    $sql = "DELETE FROM workexperience WHERE idwork = '".$work2remove."'";
    $res = $dbh->query($sql);
    print_r($res);
 }
 
 
 
 
 // remove o trabalho e apresenta a nova barra de seleção
if (strcmp($_REQUEST['editprofile'], "remove_skill")==0) {
    $str = $_REQUEST['editprofile'];    
    $userID = $_REQUEST['id'];   
    $skill2remove = $_REQUEST['idObject'];     // get data
    
    $sql = "DELETE FROM skills WHERE idskills = '".$skill2remove."'";
    $res = $dbh->query($sql);
    print_r($res);
 }
 
 
 
 
  // remove o trabalho e apresenta a nova barra de seleção
if (strcmp($_REQUEST['editprofile'], "remove_education")==0) {
    $str = $_REQUEST['editprofile'];    
    $userID = $_REQUEST['id'];   
    $edu2remove = $_REQUEST['idObject'];     // get data
    
    $sql = "DELETE FROM education WHERE ideducation = '".$edu2remove."'";
    $res = $dbh->query($sql);
    print_r($res);
 }



/***********************************************************************************************************************************************************************************/
// Formulário para criação de Work & experience
if (strcmp($_REQUEST['editprofile'], "JOB1")==0) {
    $str = $_REQUEST['editprofile'];  
  
    
         $echo_work = "<form class=\"form-inline\" role=\"form\"  method=\"post\" enctype=\"multipart/form-data\" id=\"form_workexp\" >

                <div class=\"row\" >
                  <div class=\"col-lg-5\" >
                    <div class=\"form-group\">
                      <label>Partnership</label>
                      <input class=\"form-control\" name=\"partnership\" id=\"partnership\" placeholder=\"Partnership Name\" requierd></input>
                    </div>
                  </div>
                  
                  <div class=\"col-lg-5\">
                    <div class=\"form-group\">
                      <label>Job's Name</label>
                      <input class=\"form-control\" name=\"jobname\" id=\"jobname\" placeholder=\"Insert Job's Name\" requierd></input>
                    </div>
                  </div> 
                </div>
                
                <br></br>
                
                <div class=\"row\">
                  <div class=\"col-lg-5\">
                    <div class=\"form-group\">
                      <label>Year of Begin</label>
                      <input class=\"form-control\" type=\"number\" min=\"1960\" max=\"2060\" name=\"ybegin\" id=\"ybegin\" placeholder=\"e.g: 2012\" requierd></input>
                    </div>
                  </div>
                  
                  <div class=\"col-lg-5\">
                    <div class=\"form-group\">
                      <label>Year of end</label>
                      <input class=\"form-control\" type=\"number\" min=\"1960\" max=\"2060\" name=\"yend\" id=\"yend\" placeholder=\"e.g: 2013\"></input>
                      <p class=\"help-block\">  
                        If is still your current job does not insert end date
                      </p>
                    </div>
                  </div> 
                </div>
                
                <div class=\"row\">
                  <div class=\"col-lg-5\" id=\"new_RowTasks\">
                    <div class=\"form-group\" id=\"form-group_tasks\">
                      <label id=\"lbTasks\">Task 1:</label>
                      <input class=\"form-control\" name = \"task1\"id=\"task1\" placeholder=\"Insert task\" requierd></input>
                    </div>
                  </div>
                  
                  <div class=\"col-lg-5\">
                  </div>
                </div>
                  

                
                <div class=\"row\">
                  <div class=\"col-lg-7\">
                    <br></br>
                    <p>
                      <button class=\"btn btn-info btn-xs\" type=\"button\" onclick=\"addTask(1);\">
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
                  <div class=\"col-lg-3\">
                 <button class=\"btn btn-success\" type=\"button\" value=\"Insert\" onclick=\"create_work();\">Insert</button>
                 </div>
                 </div>
                  </form>";
    
    echo $echo_work;
}




/**************************************************************************************************************************************************************************
                                                                       Skills         
**************************************************************************************************************************************************************************/



if (strcmp($_REQUEST['editprofile'], "skill_name_col")==0) {
    $str = $_REQUEST['editprofile'];  
    
    $echo_skill =  "<div class=\"row\" id=\"Skill\">
                        <form class=\"form-inline\" role=\"form\"  method=\"post\" id=\"form_skill\" >
                             <div class=\"form-group\" id=\"form\">
                               <label>Skill Name: </label>
                               <input class=\"form-control\"  name=\"skill_name\" id=\"skill_name\"  placeholder=\" e.g: Programming, Networking\"></input>
                             </div>
                             <br></br>
                             <div class=\"form-group\">
                               <label>Description: </label>
                               <textarea class=\"form-control\" rows=\"3\"  name=\"skill_description\" id=\"skill_description\" placeholder=\"Insert Description\"></textarea>
                             </div>
                            <div class=\"row\">
                                  <div class=\"col-lg-7\">
                                  </div>
                                  <div class=\"col-lg-3\">
                                     <button class=\"btn btn-success\" type=\"button\" value=\"Insert\" onclick=\"creat_skill();\">Insert</button>
                                  </div>
                             </div>
                        </form>
                  </div>";
               
         echo $echo_skill;

}


if (strcmp($_REQUEST['editprofile'], "create_skill")==0) {
    $str = $_REQUEST['editprofile'];
    $idusers = $_REQUEST['id'];
    $skill = $_REQUEST['skill_name'];
    $Description = $_REQUEST['skill_description'];

    $query = $dbh->prepare("INSERT INTO skills (skill,Description,idusers) VALUES (:skill, :Description, :idusers)");
    $query->bindValue(":Description",$Description, PDO::PARAM_STR);
    $query->bindValue(":idusers",$idusers, PDO::PARAM_STR);
    $query->bindValue(":skill",$skill, PDO::PARAM_STR);
    
    $query->execute(); 
    
    echo $dbh->lastInsertId();
}



if (strcmp($_REQUEST['editprofile'], "update_skill")==0) {

    $str = $_REQUEST['editprofile'];
    $idusers = $_REQUEST['id'];
    $skill = $_REQUEST['skill_name'];
    $Description = $_REQUEST['skill_description'];
    $idskill = $_REQUEST['idskill'];
    
  
    $sql =  "UPDATE skills SET skill='".$skill."', Description='".$Description."', idusers='".$idusers."' where idskills ='".$idskill."'";
    $dbh->query($sql);
    
    echo "".$idusers." ".$skill." ".$Description." ".$idskill." ".$sql;
}
    

if (strcmp($_REQUEST['editprofile'], "education")==0) {
    
    $echo_education = " <div class=\"row\" id=\"course\">
                <form class=\"form-inline\" role=\"form\"  method=\"post\" enctype=\"multipart/form-data\" id=\"form_education\" >
                <div class=\"col-lg-6\">
                    <div class=\"form-group\">
                      <label>School</label>
                      <input class=\"form-control\" placeholder=\"School Name\" name =\"school\" id=\"school\"></input>
                    </div>
                    
                    <div class=\"form-group\">
                      <label> Course </label>
                      <input class=\"form-control\" placeholder=\"Course Name\" name=\"courseval\" id=\"courseval\"></input> 
                    </div>
                 </div>
                 
                 <div class=\"form-group\">
                   <label>
                     Degree
                   </label>
                   <input class=\"form-control\" placeholder=\"Degree, e.g: Master, Phd\" placeholder=\"\" name=\"degree\" id=\"degree\"></input>
                 </div>
                 
                 <div class=\"form-group\">
                   <label> Description</label>
                   <textarea class=\"form-control\" rows=\"3\" placeholder=\"Description about the course\" name=\"education_description\" id=\"education_description\"></textarea>
                 </div>
                 <div class=\"row\">
                  <div class=\"col-lg-7\">
                  </div>
                  <div class=\"col-lg-3\">
                 <button class=\"btn btn-success\" type=\"button\" name=\"action\" value=\"Insert\" onclick=\"creat_education();\">Insert</button>
                 </div>
                 </div>
                </form>
                </div>";
                
                echo $echo_education;
                
                }




if (strcmp($_REQUEST['editprofile'], "create_education")==0) {

    $str = $_REQUEST['editprofile'];
    $idusers = $_REQUEST['id'];
    $school = $_REQUEST['school'];
    $course = $_REQUEST['course'];
    $degree = $_REQUEST['degree'];
    $education_description = $_REQUEST['education_description'];

    $query = $dbh->prepare("INSERT INTO education (school, curse, level, description, idusers) VALUES (:school, :curse, :level, :description, :idusers)");
    $query->bindValue(":school",$school, PDO::PARAM_STR);
    $query->bindValue(":curse",$course, PDO::PARAM_STR);
    $query->bindValue(":level",$degree, PDO::PARAM_STR);
    $query->bindValue(":description",$education_description, PDO::PARAM_STR);
    $query->bindValue(":idusers",$idusers, PDO::PARAM_STR);
    
    $query->execute(); 
    
    echo $dbh->lastInsertId();

}

if (strcmp($_REQUEST['editprofile'], "update_education")==0) {

    $str = $_REQUEST['editprofile'];
    $idusers = $_REQUEST['id'];
    $school = $_REQUEST['school'];
    $course = $_REQUEST['course'];
    $degree = $_REQUEST['degree'];
    $education_description = $_REQUEST['description'];
    $ideducation = $_REQUEST['ideducation'];
    
    $sql =  "UPDATE education SET school='".$school."', curse='".$course."', level='".$degree."', description='".$education_description."' where ideducation ='".$ideducation."'";
    $dbh->query($sql);
   
}



    

?>
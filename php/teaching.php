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





if (strcmp($_POST['teachingfunction'], "listDisciplinesbyUser")==0) {
    
    $userID = $_POST['id'];          // get data
    $disciplines = $client->call('listDisciplinesbyUser', array('userID'=>$userID) );
    

    
    $ndisciplines = count($disciplines);
    $tabela = "";
   
   if($ndisciplines==0) $tabela=$tabela."<div class=\"alert alert-danger\"> There are no correspondences... </div>";
   
   if ($ndisciplines>0){
    
    $tabela =  "<table class=\"table table-hover\">
                            <thead>
                                <tr>
                                    <th>Academic Year</th>
                                    <th>Discipline Name</th>
                                    <th>Course Name</th>
                                    <th class=\"hidden-xs\">Course Year</th>
                                    <th class=\"hidden-xs\">Institution</th>
                                    <th class=\"hidden-xs\">Content</th>
                                </tr>
                            </thead>
                            <tbody>";
                            
                           }
    
    for ($i=0; $i<$ndisciplines; $i++)
    {
    
                      $tabela=$tabela."<tr>
                                            <td>".$disciplines[$i]['academicYear']."</td>
                                            <td>".$disciplines[$i]['name']."</td>
                                            <td>".$disciplines[$i]['courseName']."</td>
                                            <td class=\"hidden-xs\">".$disciplines[$i]['courseYear']."</td>
                                            <td class=\"hidden-xs\">".$disciplines[$i]['inst']."</td>
                                            <td class=\"hidden-xs\" id=\"idcisciplina\" align =\"right\"> 
                                            
                                                <button class=\"btn btn-primary btn-xs \"  type=\"button\" onclick=\"$('#di".$disciplines[$i]['iddiscipline']."').toggle()\"> <i class=\"fa fa-caret-square-o-up\"></i> </button>
                                                
                                                
                                                <div style=\"display: none;\" id=\"di".$disciplines[$i]['iddiscipline']."\" class=\"row\" align=\"text-align-left\">
                                                ";
                                                
                                                
                                              $content = $client->call('listContentByDiscipline', array('iddiscipline'=>$disciplines[$i]['iddiscipline']) );
                                              $ncontent = count($content);
                                              
                                              if ($ncontent>0)
                                              { 
                                                $tabela=$tabela. " <ul class=\"list-group\">";
                                              
                                                for ($j=0; $j<$ncontent; $j++){
                                                 $tabela=$tabela." <li class=\"list-group-item\"><p >".$content[$j]['name']."</br><h6><samall>".$content[$j]['description']."</small></h6></p><p align=\"right\"><a class=\"fa fa-file-o\" href=\"".$content[$j]['file']."\"></a></p></li>";
                                                  }
                                                  
                                                   $tabela=$tabela. "  </ul> ";
                                                
                                               } else { $tabela=$tabela. "<a href=\"content.html\"> <span class=\"badge badge-warning\" >0 Files</span></a> ";}
                                                
                                     $tabela=$tabela. " 
                                     </div>
                                     </td>
                                     </tr>";
     
    }
    
    $tabela = $tabela." </tbody>
                        </table>";
    echo $tabela;

}

if (strcmp($_REQUEST['teachingfunction'], "listCourseSelect")==0) {
//função que adiciona o formulario das keywords que estao na tabela keywords

    $userID = $_POST['id'];          // get data
    $courses = $client->call('listCourseSelect', array('userID'=>$userID) );
    
 
    $ncourses = count($courses);

    $select="<option> </option>";
    
           
   for ($i=0; $i<$ncourses; $i++) {
             
             
            //$select = $select."<option value=".$courses[$i]['courseName'].">".$courses[$i]['courseName']."</option>";
            $select = $select."<option>".$courses[$i]['courseName']."</option>";
             
    }
    echo $select;
}

if (strcmp($_REQUEST['teachingfunction'], "listAcademicyearSelect")==0) {
//função que adiciona o formulario das keywords que estao na tabela keywords

    $userID = $_POST['id'];          // get data
    $academicYear = $client->call('listAcademicyearSelect', array('userID'=>$userID) );
    
 
    $nyears = count($academicYear);

    $select="<option> </option>";
    
           
   for ($i=0; $i<$nyears; $i++) {
         
            $select = $select."<option>".$academicYear[$i]['academicYear']."</option>";
             
    }
    echo $select;
}


if (strcmp($_REQUEST['teachingfunction'], "listinstitutionSelect")==0) {
//função que adiciona o formulario das keywords que estao na tabela keywords

    $userID = $_POST['id'];          // get data
    $inst = $client->call('listinstitutionSelect', array('userID'=>$userID) );
    $ninst = count($inst);
    $select="<option> </option>";

    for ($i=0; $i<$ninst; $i++) {
     $select = $select."<option>".$inst[$i]['inst']."</option>";        
     }
     
    echo $select;
}




if (strcmp($_POST['teachingfunction'], "listAlldisciplinesbyquery")==0) {
    
    $userID = $_POST['id'];   
    $query = $_POST['query'];
       
         // get data
    $disciplines = $client->call('listAlldisciplinesbyquery', array('userID'=>$userID, 'query'=>$query) );
    
    $tabela = "";
    
    $ndisciplines = count($disciplines);
    if($ndisciplines>0){
    
     $tabela =  "<table class=\"table table-hover\">
                             <thead>
                                 <tr>
                                     <th>Academic Year</th>
                                     <th>Discipline Name</th>
                                     <th>Course Name</th>
                                     <th class=\"hidden-xs\">Course Year</th>
                                     <th class=\"hidden-xs\">Institution</th>
                                     <th class=\"hidden-xs\">Content</th>
                                 </tr>
                             </thead>
                             <tbody>";
                            }
   

    if($ndisciplines==0) {
    $tabela=$tabela."<div class=\"alert alert-danger\"> There are no correspondences... </div>";}
    
    for ($i=0; $i<$ndisciplines; $i++)
    {
    
                      $tabela=$tabela."<tr>
                                            <td>".$disciplines[$i]['academicYear']."</td>
                                            <td>".$disciplines[$i]['name']."</td>
                                            <td>".$disciplines[$i]['courseName']."</td>
                                            <td class=\"hidden-xs\">".$disciplines[$i]['courseYear']."</td>
                                            <td class=\"hidden-xs\">".$disciplines[$i]['inst']."</td>
                                            <td class=\"hidden-xs\" id=\"idcisciplina\" align =\"right\"> 
                                            
                                                <button class=\"btn btn-primary btn-xs \"  type=\"button\" onclick=\"$('#di".$disciplines[$i]['iddiscipline']."').toggle()\"> <i class=\"fa fa-caret-square-o-up\"></i> </button>
                                                
                                                
                                                <div style=\"display: none;\" id=\"di".$disciplines[$i]['iddiscipline']."\" class=\"row\" align=\"text-align-left\">
                                                ";
                                                
                                                
                                              $content = $client->call('listContentByDiscipline', array('iddiscipline'=>$disciplines[$i]['iddiscipline']) );
                                              $ncontent = count($content);
                                              
                                              if ($ncontent>0)
                                              { 
                                                $tabela=$tabela. " <ul class=\"list-group\">";
                                              
                                                for ($j=0; $j<$ncontent; $j++){
                                                 $tabela=$tabela." <li class=\"list-group-item\"><p >".$content[$j]['name']."</br><h6><samall>".$content[$j]['description']."</small></h6></p><p align=\"right\"><a class=\"fa fa-file-o\" href=\"".$content[$j]['file']."\"></a></p></li>";
                                                  }
                                                  
                                                   $tabela=$tabela. "  </ul> ";
                                                
                                               } else { $tabela=$tabela. "<a href=\"content.html\"> <span class=\"badge badge-warning\" >0 Files</span></a> ";}
                                                
                                     $tabela=$tabela. " 
                                     </div>
                                     </td>
                                     </tr>";
     
    }
    
    $tabela = $tabela." </tbody>
                        </table>";
    echo $tabela;

}








//print "</body></html>";



?>
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





if (strcmp($_POST['examinationsfunction'], "listAllExaminationsByUser")==0) {
    
    $userID = $_POST['id'];          // get data
    $examinations = $client->call('listAllExaminationsByUser', array('userID'=>$userID) );
    

    $nexaminations = count($examinations);
    $tabela = "";
   
   
   if($nexaminations==0) $tabela=$tabela."<div class=\"alert alert-danger\"> There are no correspondences... </div>";
   
   if ($nexaminations>0){
    
    $tabela =  "<table class=\"table table-hover\">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th class=\"hidden-xs\">Type</th>
                                    <th>Title</th>
                                    <th>Institution</th>
                                    <th >Student</th>
                                    <th class=\"hidden-xs\">Document</th>
                                </tr>
                            </thead>
                            <tbody>";
                            
                           
    
    for ($i=0; $i<$nexaminations; $i++)
    {
    
                      $tabela=$tabela."<tr>
                                            <td>".$examinations[$i]['ansi']."</td>
                                            <td class=\"hidden-xs\">".$examinations[$i]['type']."</td>
                                            <td>".$examinations[$i]['title']."</td>
                                            <td >".$examinations[$i]['inst']."</td>
                                            <td >".$examinations[$i]['name']."   ";
                                            
                                            
                                            	if (!empty($examinations[$i]['description']) || !empty($examinations[$i]['address']) || !empty($examinations[$i]['email']) ||  !empty($examinations[$i]['linkedin'])){
                                            
                                                $tabela=$tabela."<button class=\"btn btn-primary btn-xs \"  type=\"button\" onclick=\"$('#ex".$examinations[$i]['idtheexam']."').toggle()\";>
                                                    <i class=\"fa fa-caret-square-o-up\"></i>
                                                 </button>
                                                    
                                                    
                                                <div style=\"display: none;\" id=\"ex".$examinations[$i]['idtheexam']."\" class=\"row\" align=\"text-align-left\">
                                                
                                                <ul class=\"list-group\">";
                                                     
                                                     
                                              if (!empty($examinations[$i]['description'])) {
                                              $tabela=$tabela."<li class=\"list-group-item\">  ".$examinations[$i]['description']."</br>";
                                              }
                                                    
                                              if (!empty($examinations[$i]['address'])){
                                               $tabela=$tabela."<a target=\"new\" class=\"fa fa-external-link\" href=\"".$examinations[$i]['address']."\"> ".$examinations[$i]['address']."</a>  </br>";
                                              }
                                                    
                                              if (!empty($examinations[$i]['email']))
                                              { 
                                              $tabela=$tabela."<a href=\"mailto:".$examinations[$i]['email']."\" class=\"fa fa-envelope-o\"> ".$examinations[$i]['email']." </a> </br>";
                                              }
                                                    
                                              if (!empty($examinations[$i]['linkedin']))
                                              {
                                              $tabela=$tabela."<a  target=\"new\" class=\"fa fa-linkedin-square\" href=\"".$examinations[$i]['linkedin']."\"> ".$examinations[$i]['linkedin']." </a> ";
                                              }
                                                     
                                                    $tabela=$tabela."</li></ul> 
                                               
                                               </div>";
                                                
                                                }
                                     $tabela=$tabela."</td>";
                                     
                                            
                                     
                                     
                                     if (!empty($examinations[$i]['doi']))  
                                     {
                                     $tabela=$tabela. "<td class=\"hidden-xs\"> File <a target=\"new\" href=\"".$examinations[$i]['doi']."\" class=\"fa fa-download\"></a></td>";
                                     }
                                     
                                     $tabela=$tabela."</tr>";     
                                                  
    }
     
     $tabela = $tabela." </tbody>
                        </table>";

    }
    
   
    echo $tabela;

}



if (strcmp($_POST['examinationsfunction'], "listExambyquery")==0) {
    
    $userID = $_POST['id'];          // get data
    $query = $_POST['query'];
    $examinations = $client->call('listExambyquery', array('userID'=>$userID, 'query'=>$query) );
    

    $nexaminations = count($examinations);
    $tabela = "";
    

   
   if($nexaminations==0) $tabela=$tabela."<div class=\"alert alert-danger\"> There are no correspondences... </div>";
   
   if ($nexaminations>0){
    
    $tabela =  "<table class=\"table table-hover\">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th class=\"hidden-xs\">Type</th>
                                    <th>Title</th>
                                    <th>Institution</th>
                                    <th >Student</th>
                                    <th class=\"hidden-xs\">Document</th>
                                </tr>
                            </thead>
                            <tbody>";
                            
                           
    
    for ($i=0; $i<$nexaminations; $i++)
    {
    
                      $tabela=$tabela."<tr>
                                            <td>".$examinations[$i]['ansi']."</td>
                                            <td class=\"hidden-xs\">".$examinations[$i]['type']."</td>
                                            <td>".$examinations[$i]['title']."</td>
                                            <td>".$examinations[$i]['inst']."</td>
                                            <td>".$examinations[$i]['name']."   ";
                                            
                                            
                                            	if (!empty($examinations[$i]['description']) || !empty($examinations[$i]['address']) || !empty($examinations[$i]['email']) ||  !empty($examinations[$i]['linkedin'])){
                                            
                                                $tabela=$tabela."<button class=\"btn btn-primary btn-xs \"  type=\"button\" onclick=\"$('#ex".$examinations[$i]['idtheexam']."').toggle()\";>
                                                    <i class=\"fa fa-caret-square-o-up\"></i>
                                                 </button>
                                                    
                                                    
                                                <div style=\"display: none;\" id=\"ex".$examinations[$i]['idtheexam']."\" class=\"row\" align=\"text-align-left\">
                                                
                                                <ul class=\"list-group\">";
                                                     
                                                     
                                              if (!empty($examinations[$i]['description'])) {
                                              $tabela=$tabela."<li class=\"list-group-item\">  ".$examinations[$i]['description']."</br>";
                                              }
                                                    
                                              if (!empty($examinations[$i]['address'])){
                                               $tabela=$tabela."<a target=\"new\" class=\"fa fa-external-link\" href=\"".$examinations[$i]['address']."\"> ".$examinations[$i]['address']."</a>  </br>";
                                              }
                                                    
                                              if (!empty($examinations[$i]['email']))
                                              { 
                                              $tabela=$tabela."<a href=\"mailto:".$examinations[$i]['email']."\" class=\"fa fa-envelope-o\"> ".$examinations[$i]['email']." </a> </br>";
                                              }
                                                    
                                              if (!empty($examinations[$i]['linkedin']))
                                              {
                                              $tabela=$tabela."<a  target=\"new\" class=\"fa fa-linkedin-square\" href=\"".$examinations[$i]['linkedin']."\"> ".$examinations[$i]['linkedin']." </a> ";
                                              }
                                                     
                                                    $tabela=$tabela."</li></ul> 
                                               
                                               </div>";
                                                
                                                }
                                     $tabela=$tabela."</td>";
                                     
                                            
                                     
                                     
                                     if (!empty($examinations[$i]['doi']))  
                                     {
                                     $tabela=$tabela. "<td class=\"hidden-xs\"> File <a target=\"new\" href=\"".$examinations[$i]['doi']."\" class=\"fa fa-download\"></a></td>";
                                     }
                                     
                                     $tabela=$tabela."</tr>";     
                                                  
    }
     
     $tabela = $tabela." </tbody>
                        </table>";

    }
    
   
    echo $tabela;

}


// Listar as comboboxs
if (strcmp($_POST['examinationsfunction'], "comboboxkeywords")==0) {

    $userID = $_POST['id'];          // get data
    $inst = $client->call('listExamKeywords', array('userID'=>$userID) );
    $ninst = count($inst);
    $select="<option> </option>";

    for ($i=0; $i<$ninst; $i++) {
     $select = $select."<option>".$inst[$i]['name']."</option>";        
     }
     
    echo $select;
}


if (strcmp($_POST['examinationsfunction'], "comboboxinst")==0) {

    $userID = $_POST['id'];          // get data
    $inst = $client->call('listExamInstitution', array('userID'=>$userID) );
    $ninst = count($inst);
    $select="<option> </option>";

    for ($i=0; $i<$ninst; $i++) {
     $select = $select."<option>".$inst[$i]['inst']."</option>";        
     }
     
    echo $select;
    

}

if (strcmp($_POST['examinationsfunction'], "comboboxdate")==0) {
    
    $userID = $_POST['id'];          // get data
    $inst = $client->call('listExamDate', array('userID'=>$userID) );
    $ninst = count($inst);
    $select="<option> </option>";

    for ($i=0; $i<$ninst; $i++) {
     $select = $select."<option>".$inst[$i]['ansi']."</option>";        
     }
     
    echo $select;

}






//print "</body></html>";



?>
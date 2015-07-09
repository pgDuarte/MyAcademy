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



if (strcmp($_POST['supervisionsfunction'], "listAllsupervisionsByUser")==0) {
    
    $userID = $_POST['id'];          // get data
    $supervisions = $client->call('listAllSupervisionsByUser', array('userID'=>$userID) );
    
      
    $nsupervisions = count($supervisions);    
    $tabela = "";
  
    
   if($nsupervisions==0) $tabela=$tabela."<div class=\"alert alert-danger\"> There are no correspondences... </div>";
   
   if ($nsupervisions>0){
    
    $tabela = $tabela."<table class=\"table table-hover\">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Student</th>
                                    <th class=\"hidden-xs\">Co-supervisor</th>
                                    <th class=\"hidden-xs\">Institution</th>
                                    <th class=\"hidden-xs\">Status</th>
                                    <th class=\"hidden-xs\">Document</th>
                                </tr>
                            </thead>
                            <tbody>";
                                                  
    
    for ($i=0; $i<$nsupervisions; $i++)
    {
    
    
    $tabela= $tabela."   <tr>
        <td>".$supervisions[$i]['title']."</td>
        <td> ".$supervisions[$i]['name']."";
                                    
        if (!empty($supervisions[$i]['description']) || !empty($supervisions[$i]['address']) || !empty($supervisions[$i]['email']) ||  !empty($supervisions[$i]['linkedin']))
        {
                                      
        $tabela= $tabela." <button class=\"btn btn-primary btn-xs \"  type=\"button\" onclick=\"$('#student".$supervisions[$i]['idthesup']."').toggle()\";>
        <i class=\"fa fa-caret-square-o-up\"></i>
        </button>
                                      
        <div style=\"display: none;\" id=\"student".$supervisions[$i]['idthesup']."\" class=\"row\" align=\"text-align-left\">
                                      
        <ul class=\"list-group\"> <li class=\"list-group-item\">";
                                      
                if (!empty($supervisions[$i]['description'])) {
                    $tabela=$tabela."".$supervisions[$i]['description']."</br>";
                }
                
                if (!empty($supervisions[$i]['address'])){
                    $tabela=$tabela."<a target=\"new\" class=\"fa fa-external-link\" href=\"".$supervisions[$i]['address']."\"> ".$supervisions[$i]['address']."</a>  </br>";
                }
                                               
                if (!empty($supervisions[$i]['email']))
                { 
                    $tabela=$tabela."<a href=\"mailto:".$supervisions[$i]['email']."\" class=\"fa fa-envelope-o\"> ".$supervisions[$i]['email']." </a> </br>";
                }
                                                 
                if (!empty($supervisions[$i]['linkedin']))
                {
                    $tabela=$tabela."<a  target=\"new\" class=\"fa fa-linkedin-square\" href=\"".$supervisions[$i]['linkedin']."\"> ".$supervisions[$i]['linkedin']." </a> ";
                }
                                                             
       $tabela=$tabela."</li></ul> 
                                               
       </div>";
                                                
       }
                                       
        $tabela= $tabela."</td>";
                                              
                                              

        
                  
                                        
         //cosupervisor
         // verificar se as variaveis description, address, email, linkedin estão definidas e não vazias 
         if(!empty($supervisions[$i]['cosupname']))
         {
         $tabela= $tabela."<td>".$supervisions[$i]['cosupname'];
                                        
             if(!empty($supervisions[$i]['cosupinst']))
             {
                $tabela= $tabela."<br> <small>".$supervisions[$i]['cosupinst']."</small></br>";
             }
                                        
        $tabela= $tabela."</td>";
                                    
        }
        else if(empty($supervisions[$i]['copsupname'])) {
            $tabela= $tabela."<td><small>There is no co supervisor</small></td>";
        }
                                    
        $tabela= $tabela."<td>".$supervisions[$i]['inst']."</td>";
        $tabela= $tabela."<td class=\"hidden-xs\">".$supervisions[$i]['status']."<br></br>";
                                    
        if(!empty($supervisions[$i]['endyear']))
        {
        $tabela= $tabela." <small>".$supervisions[$i]['beginyear']."-".$supervisions[$i]['endyear']." </small> </td>";
        } else 
        {
        $tabela= $tabela." <small>begin: ".$supervisions[$i]['beginyear']." </small> </td>";
        }
                                    
        if (!empty($supervisions[$i]['doi'])) 
        {
        $tabela= $tabela." <td class=\"hidden-xs\"> File <a target=\"new\" href=\"".$supervisions[$i]['doi']."\" class=\"fa fa-download\"></a></td>";        
        }
        else {$tabela= $tabela." <td>0 Files </td>";}
        $tabela=$tabela."</tr>"; 
                                   
     }    
                                                  
    
     $tabela = $tabela." </tbody>
                        </table>";

    }
    
   
    echo $tabela;

}


if (strcmp($_POST['supervisionsfunction'], "lisSupByquery")==0) {
    
    $userID = $_POST['id'];          // get data
    $query = $_POST['query'];
    $supervisions = $client->call('lisSupByquery', array('userID'=>$userID, 'query'=>$query) );
       
    $nsupervisions = count($supervisions);
    
    $tabela = "";
  
    
   if($supervisions=="") $tabela=$tabela."<div class=\"alert alert-danger\"> There are no correspondences... </div>";
   else
   if ($nsupervisions>0){
    
    $tabela = $tabela."<table class=\"table table-hover\">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Student</th>
                                    <th class=\"hidden-xs\">Co-supervisor</th>
                                    <th class=\"hidden-xs\">Institution</th>
                                    <th class=\"hidden-xs\">Status</th>
                                    <th class=\"hidden-xs\">Document</th>
                                </tr>
                            </thead>
                            <tbody>";
                                                  
    
    for ($i=0; $i<$nsupervisions; $i++)
    {
    
    
    $tabela= $tabela."   <tr>
        <td>".$supervisions[$i]['title']."</td>
        <td> ".$supervisions[$i]['name']."";
                                    
        if (!empty($supervisions[$i]['description']) || !empty($supervisions[$i]['address']) || !empty($supervisions[$i]['email']) ||  !empty($supervisions[$i]['linkedin']))
        {
                                      
        $tabela= $tabela." <button class=\"btn btn-primary btn-xs \"  type=\"button\" onclick=\"$('#student".$supervisions[$i]['idthesup']."').toggle()\";>
        <i class=\"fa fa-caret-square-o-up\"></i>
        </button>
                                      
        <div style=\"display: none;\" id=\"student".$supervisions[$i]['idthesup']."\" class=\"row\" align=\"text-align-left\">
                                      
        <ul class=\"list-group\"> <li class=\"list-group-item\">";
                                      
                if (!empty($supervisions[$i]['description'])) {
                    $tabela=$tabela."".$supervisions[$i]['description']."</br>";
                }
                
                if (!empty($supervisions[$i]['address'])){
                    $tabela=$tabela."<a target=\"new\" class=\"fa fa-external-link\" href=\"".$supervisions[$i]['address']."\"> ".$supervisions[$i]['address']."</a>  </br>";
                }
                                               
                if (!empty($supervisions[$i]['email']))
                { 
                    $tabela=$tabela."<a href=\"mailto:".$supervisions[$i]['email']."\" class=\"fa fa-envelope-o\"> ".$supervisions[$i]['email']." </a> </br>";
                }
                                                 
                if (!empty($supervisions[$i]['linkedin']))
                {
                    $tabela=$tabela."<a  target=\"new\" class=\"fa fa-linkedin-square\" href=\"".$supervisions[$i]['linkedin']."\"> ".$supervisions[$i]['linkedin']." </a> ";
                }
                                                             
       $tabela=$tabela."</li></ul> 
                                               
       </div>";
                                                
       }
                                       
        $tabela= $tabela."</td>";
                                              
                                              

                                        
         //cosupervisor
         // verificar se as variaveis description, address, email, linkedin estão definidas e não vazias 
         if(!empty($supervisions[$i]['cosupname']))
         {
         $tabela= $tabela."<td>".$supervisions[$i]['cosupname'];
                                        
             if(!empty($supervisions[$i]['cosupinst']))
             {
                $tabela= $tabela."<br> <small>".$supervisions[$i]['cosupinst']."</small></br>";
             }
                                        
        $tabela= $tabela."</td>";
                                    
        }
        else if(empty($supervisions[$i]['copsupname'])) {
            $tabela= $tabela."<td><small>There is no co supervisor</small></td>";
        }
                                    
        $tabela= $tabela."<td>".$supervisions[$i]['inst']."</td>";
        $tabela= $tabela."<td class=\"hidden-xs\">".$supervisions[$i]['status']."<br></br>";
                                    
        if(!empty($supervisions[$i]['endyear']))
        {
        $tabela= $tabela." <small>".$supervisions[$i]['beginyear']."-".$supervisions[$i]['endyear']." </small> </td>";
        } else 
        {
        $tabela= $tabela." <small>begin: ".$supervisions[$i]['beginyear']." </small> </td>";
        }
                                    
        if (!empty($supervisions[$i]['doi'])) 
        {
        $tabela= $tabela." <td class=\"hidden-xs\"> File <a target=\"new\" href=\"".$supervisions[$i]['doi']."\" class=\"fa fa-download\"></a></td>";        
        }
        else {$tabela= $tabela." <td>0 Files </td>";}
        $tabela=$tabela."</tr>"; 
                                   
     }    
                                                  
    
     $tabela = $tabela." </tbody>
                        </table>";

    }
    

    echo $tabela;

}



// Listar as comboboxs
if (strcmp($_POST['supervisionsfunction'], "comboboxkeywords")==0) {

    $userID = $_POST['id'];          // get data
    $supkey = $client->call('listSupKeywords', array('userID'=>$userID) );
    $nsupkey = count($supkey);
    $select="<option> </option>";

    for ($i=0; $i<$nsupkey; $i++) {
     $select = $select."<option>".$supkey[$i]['name']."</option>";        
     }
     
    echo $select;
}

// Listar as comboboxs
if (strcmp($_POST['supervisionsfunction'], "comboboxtitle")==0) {

    $userID = $_POST['id'];          // get data
    $suptitles = $client->call('listSupTitles', array('userID'=>$userID) );
    $nsuptitles = count($suptitles);
    $select="<option> </option>";

    for ($i=0; $i<$nsuptitles; $i++) {
     $select = $select."<option>".$suptitles[$i]['title']."</option>";        
     }
     
    echo $select;
}

?>
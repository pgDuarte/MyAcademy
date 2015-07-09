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

if (strcmp($_POST['pubfunction'], "listAlltypesPubs")==0) {
    
    $userID = $_POST['id'];          // get data
    $type = $client->call('listAllTypesPub', array('userID'=>$userID) );
    $ntype = count($type);
    
    $indice = "<ol class=\"breadcrumb\">";
    
    for ($i=0; $i<$ntype; $i++)
    {
     $indice = $indice." <li> <a href=\"#".$type[$i]['type']."\"><i class=\"fa fa-hand-o-right\"></i> ".$type[$i]['type']."</a></li> ";
    }
    
    $indice = $indice."</ol>";
    echo $indice;
}

    
if (strcmp($_POST['pubfunction'], "listAllPubs")==0) {
    $userID = $_POST['id'];          // get data
  
    $row = $client->call('listAllPubsbyUser', array('userID'=>$userID) );


    $count = count($row);   
    $i=0;
    $flag=0;
    $flag1=0;
    $true = 1;
    $false = 0;
  
    $lista="<ul>";
    $string = "";
    
    if($count==0)
    {    
        echo "<b>No publications stored</b>";
        return;
    }
    
    while ($i < $count) {
    
        $string = "<li>";
        $authors = $client->call('listAllAuthorsbyPub', array('idpublication'=>$row[$i]['idpublication']) );
        $atributos = $client->call('listAllotherAtributesbyPub', array('idpublication'=>$row[$i]['idpublication']) );
        $deliverables = $client->call('listAllderiverablesbyPub', array('idpublication'=>$row[$i]['idpublication']) );
        $nauthors = count($authors);
        $natributes = count($atributos);
        $ndeliverables = count($deliverables);

        //percorre todos os autores da publicação 
        $aux = 0;       
        for ($j =0; $j<$nauthors; $j++)
        {
            if($authors[$j]['name']!="" && $authors[$j]['type']=="author"){                              
                $names = explode(" ", $authors[$j]['name']);
                if($aux<1){
                    $string =$string. " ". $names[1].", ".$names[0][0]."."; 
                }else  $string =$string. ", ". $names[1].", ".$names[0][0].".";
                $aux++; 
            }
        }    
        $aux = 0;     
        
        //percorre todos os editores da publicação
        for ($j=0; $j<$nauthors; $j++)
        {
            if($authors[$j]['name']!="" && $authors[$j]['type']=="editor"){            
                $names = explode(" ", $authors[$j]['name']);
                if($aux<1){                             
                    $string =$string. ", Editors: ". $names[1].", ".$names[0][0]."."; 
                }else  $string =$string. ", ". $names[1].", ".$names[0][0].".";
                $aux++; 
            }
        }         

        $string = $string.", (".$row[$i]['year'].")";
        $string = $string.", ".$row[$i]['title'];

        for ($j =0; $j<$natributes; $j++)
        {
        
            // Verifica se a variável  existe
    	   if (isset($atributos[$j]['name'])) {
    		// Verifica se a variavel está vazia ou não
          		if (!empty($atributos[$j]['name'])) {
              		if (strcmp($atributos[$j]['name'], "doi")==0) $string = $string.", <a target='_blank' href='".$atributos[$j]['value']."'>".$atributos[$j]['value']."</a>";
              		else
              		    if (strcmp($atributos[$j]['name'], "subtitle")==0) $string = $string.", \"".$atributos[$j]['value']."\"";
              		    else	          		              		    
              		        if (strcmp($atributos[$j]['name'], "issn")==0) $string = $string.", [ISSN:".$atributos[$j]['value']."]";
              		        else	
              		            if (strcmp($atributos[$j]['name'], "isbn")==0) $string = $string.", [ISBN:".$atributos[$j]['value']."]";
              		            else
              		            $string = $string.", ".$atributos[$j]['value']."";
          		}          		          		  
    		}
        }
        $del = "";
        
        //NOTE CHECK HREF
        
        for ($k =0; $k<$ndeliverables; $k++)
        {
         // Verifica se a variável  existe
    	   if (isset($deliverables[$k]['type'])) {
    	    if (isset($deliverables[$k]['url'])) {
    	     if (isset($deliverables[$k]['type'])) {
    	       if (!empty($deliverables[$k]['type'])){
    	           if (!empty($deliverables[$k]['url'])){    	                   	                   
                       $del = ", [".$deliverables[$k]['type']."] <a class=\"fa fa-file-o\" href=\"".$deliverables[$k]['url']."\" ></a> <a class=\"fa fa-download\" href='".$deliverables[$k]['url']."' download></a> ";            	         	       
            	       $string = $string."".$del;            	       
            	       $del = "";
    	           }
    	       }
    	      }
    	    }    
          }
        }
            
     
        $string = $string."</li><br/>"; 
        
        
           if ($flag==1)
            {                
                if (strcmp($row[$i]['type'], $typeaux)!=0)
                {
                    $typeaux = $row[$i]['type'];
                    $type= "<b> <a name=\"".$row[$i]['type']."\">". $row[$i]['type'] ."</a> </b>";                    
                    $lista = $lista."</br>".$type."</br>";
                }
                else $type = $type;
            }else
            {                
              $typeaux = $row[$i]['type'];
              $type= "<b> <a name=\"".$row[$i]['type']."\">". $row[$i]['type'] ."</a> </b>";
              $lista = $lista."</br>".$type."</br>";
              $flag=1;
            }

            $lista = $lista.$string;
    
            $i++;
            $string = "";
    
    }
    
    $lista = $lista."</ul>";
    
    echo $lista;
       
 } 

?>
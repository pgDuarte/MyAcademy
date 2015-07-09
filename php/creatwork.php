<?php

header('Content-Type: text/html; charset=utf-8');

$dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
       
      $query = $dbh->prepare("INSERT INTO `workexperience` (`profession`,`partnership`,`begin`,`end`,`idusers`,`overview`) VALUES (:profession, :partnership, :begin, :end, :idusers, :overview)");
      
      $query->bindValue(":idusers","2", PDO::PARAM_STR);
      
       if (strcmp($_REQUEST['jobname'], ""))
       {
       $query->bindValue(":profession",$_REQUEST['jobname'], PDO::PARAM_STR);
              
        if (strcmp($_REQUEST['partnership'], ""))
        {
       
         $query->bindValue(":partnership",$_REQUEST['partnership'], PDO::PARAM_STR);
           
            if (strcmp($_REQUEST['ybegin'], ""))
            {
                $query->bindValue(":begin",$_REQUEST['ybegin'], PDO::PARAM_STR);
                
                if (strcmp($_REQUEST['yend'], ""))
                {
                    $query->bindValue(":end",$_REQUEST['yend'], PDO::PARAM_STR);
            
                }
                else  $query->bindValue(":end","", PDO::PARAM_STR);
                
                if (strcmp($_REQUEST['task1'], "")!=0)
                {
                    $tasks = "".$_REQUEST['task1'];
                    $numRow=2;
                   
                   if(isset($_REQUEST['newtask2']))
                   {
                            $task ="".$_REQUEST['newtask2'];
                           
                          
                           
                            while(strcmp($task, "")!=0)
                            { 
                                $tasks=$tasks.",".$task;
                                
                                $numRow ++;
                                $task = "newtask".$numRow."";
                                if(isset($_REQUEST[$task]))
                                {
                                $task ="".$_REQUEST[$task];
                                }
                                else $task = "";
                                
                            }
                    }
                    
                    $query->bindValue(":overview",$tasks, PDO::PARAM_STR);
            
                }
                else $query->bindValue(":overview","", PDO::PARAM_STR);
                
                $query->execute(); 
                
            }
        }
       }
      
       
    echo '<script type="text/javascript"> alert ("I am sorry but there has been an error submitting your request please try again or call us on 01983 872244");
    
    history.back();
     </script>';
     
     
?>
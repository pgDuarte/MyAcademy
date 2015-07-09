<?php


    if($_FILES["images"]["error"] != UPLOAD_ERR_NO_FILE)
    {
        //header
        $iduser = $_POST['id'];
        $image = $_FILES['images'];
        $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        
        $result = $dbh->query("SELECT * FROM users WHERE idusers = '".$iduser."'");
        if($result->rowCount())
        {
            $result = $result->fetch();
            $email = $result['email'];        
            $imageuri = $result['imageuri'];
            
            if(file_exists("../".$imageuri))        
                unlink("../".$imageuri);
                
            $fName = iconv("utf-8", 'ISO-8859-1', $_FILES["images"]["name"]);
            $path = "users/".$email."/";
            
            move_uploaded_file($_FILES["images"]["tmp_name"],"../".$path.$fName);
            
            $dbh->query("UPDATE `users` SET `imageuri`='".$path.$_FILES["images"]["name"]."' WHERE `idusers`='".$iduser."'");     
            
            echo "<h2>Succcessfuly Uploaded Images</h2>";    
        }  
	
    }
    else echo "<h2>Error Uploaded Images</h2>";
?>
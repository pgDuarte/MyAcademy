<?php




$dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));



if (strcmp($_GET['userList'], "name")==0) {
    $str = $_GET['userList'];    
    $userID = $_GET['id'];          // get data


    $sql = "SELECT profession FROM workexperience WHERE idusers = '".$userID."';";
    $res = $dbh->query($sql);
    $prof = $res->fetch();
   
    
    $sql = "SELECT * FROM users WHERE idusers = '".$userID."'";
    $res = $dbh->query($sql);
    $name = $res->fetch();
     
    echo "<h2>" . $name['name'] . "<small> [".$name['idauthor']."]</small></h2><h2><small>". $prof['profession']."</small></h2>";

}

/********************************************************************************************************/
// vai buscar a imagem 
if (strcmp($_GET['userList'], "image")==0) {
    $str = $_GET['userList'];    
    $userID = $_GET['id'];          // get data


    $sql = "SELECT imageuri FROM users WHERE idusers = '".$userID."'";
    $res = $dbh->query($sql);
    $row = $res->fetch();
    
                 
    
    if (($res->rowCount() != 0)) {
               echo "<a>
                        <!-- Imagem depois dinamica por parte do utilizador-->
                        <img alt=\"140x140\" data-src=\"holder.js/140x140\"  src=\"".$row['imageuri']."\" class=\"img-thumbnail\"></img>
                     </a>";
                       
    }
}



// if data are received via GET, with index of 'test' tec_skill
if (strcmp($_GET['userList'], "info")==0) {
    $str = $_GET['userList'];    
    $userID = $_GET['id'];          // get data

    $sth = $dbh->prepare("SELECT * FROM users WHERE idusers = '".$userID."'");
    $sth->execute();

     $row = $sth->fetch(PDO::FETCH_ASSOC);
     echo "<h5>Email: <a href='mailto:".$row['email']."'>".$row['email']."</a></h5>";
     echo "<h5>Website: <a target='_blank' href='".$row['url']."'>".$row['url']."</a></h5>";
     echo "<h5>Phone: ".$row['phonenumber']."</h5>";
    
}

// if data are received via GET, with index of 'test' tec_skill
if (strcmp($_GET['userList'], "prof_prof")==0) {
    $str = $_GET['userList'];    
    $userID = $_GET['id'];          // get data

    $sth = $dbh->prepare("SELECT * FROM users WHERE idusers = '".$userID."'");
    $sth->execute();
    
    $row = $sth->fetch(PDO::FETCH_ASSOC);    
    echo "<p>".$row['personal_profile']."</p>";
    echo "</br>  </hr>";
}


                    
                    

// if data are received via GET, with index of 'test' work_exp
if (strcmp($_GET['userList'], "work_exp")==0) {
    $str = $_GET['userList'];    
    $userID = $_GET['id'];          // get data

    $sth = $dbh->prepare("SELECT * FROM workexperience WHERE idusers = '".$userID."'");
    $sth->execute();
  
    while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
     echo "<div>";
        echo "<h3>" . $row['profession'] . "</br>";
        echo "<small>" . $row['partnership'] . ", <small> ". $row['begin']."-".$row['end']." </small></small></h3>";
     echo "</div>";
     
     $pieces = explode(", ", $row['overview']);
     
     echo "<ul>";
     
        for($i=0; $i<count($pieces); $i++)
        {
        echo "<li>" . $pieces[$i] . "</li>";
        }
        
     echo "</ul>";
     
     echo "<hr> </hr>";
    }
    
}

// if data are received via GET, with index of 'test' tec_skill
if (strcmp($_GET['userList'], "tec_skill")==0) {
    $str = $_GET['userList'];    
    $userID = $_GET['id'];          // get data

    $sth = $dbh->prepare("SELECT * FROM skills WHERE idusers = '".$userID."'");
    $sth->execute();

    while ($row = $sth->fetch(PDO::FETCH_ASSOC)) 
     {
     echo "<div>";
     echo "<h3>" . $row['skill'] . "</h3></br>";
     echo "<p>" . $row['Description'] . "</p>";
     echo "</div>";
     echo "<hr> </hr>";
     }
}

// if data are received via GET, with index of 'test' tec_skill
if (strcmp($_GET['userList'], "edu")==0) {
    $str = $_GET['userList'];    
    $userID = $_GET['id'];          // get data

    $sth = $dbh->prepare("SELECT * FROM education WHERE idusers = '".$userID."'");
    $sth->execute();

     while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
     echo "<div>";
        echo "<h3>" . $row['school'] . "</br>";
        echo "<small>" . $row['curse'] . ", ". $row['level']."</small></h3>";
     echo "</div>";
     
     $pieces = explode(", ", $row['description']);
     
     echo "<ul>";
     
        for($i=0; $i<count($pieces); $i++)
        {
        echo "<li>" . $pieces[$i] . "</li>";
        }
        
     echo "</ul>";
     
     echo "<hr> </hr>";
    }
}




?> 
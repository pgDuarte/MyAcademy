<?php 
header('Content-Type: text/html; charset=utf-8');
/*****************************************************************************************************************************************
                                                         Web Service - WSDL 
                                                       MIECOM - Engenharia WEB 
*****************************************************************************************************************************************/	


require_once('../nusoap/lib/nusoap.php');
 
$server = new nusoap_server;
 
$server->configureWSDL('server', 'urn:server');
 
$server->wsdl->schemaTargetNamespace = 'urn:server';


/*****************************************************************************************************************************************
                                                         Registration Complex Typs
*****************************************************************************************************************************************/	
 
//SOAP complex type return type (an array/struct)
$server->wsdl->addComplexType(
    'Person',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'id_user' => array('name' => 'id_user', 'type' => 'xsd:int'),
        'fullname' => array('name' => 'fullname', 'type' => 'xsd:string'),
        'email' => array('name' => 'email', 'type' => 'xsd:string'),
        'level' => array('name' => 'level', 'type' => 'xsd:int')
    )
);



/*****************************************************************************************************************************************
                                                         Registration Services
*****************************************************************************************************************************************/	

 
 //LOGIN
$server->register('login',
			array('username' => 'xsd:string', 'password'=>'xsd:string'),  //parameters
			array('return' => 'tns:Person'),  //output
			'urn:server',   //namespace
			'urn:server#loginServer',  //soapaction
			'rpc', // style
			'encoded', // use
			'Check user login');  //description

// list all users
$server->register('listusers',
			array(),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#listusers',  //soapaction
			'rpc', // style
			'encoded', // use
			'List all users');  //description
			
// list user info
$server->register('listuserinfo',
			array('iduser' => 'xsd:int'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#listusers',  //soapaction
			'rpc', // style
			'encoded', // use
			'List all users');  //description	

// ALL Education List		
$server->register('descriptionProfile',
			array('email' => 'xsd:string', 'id'=>'xsd:int'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#descriptionProfileServer',  //soapaction
			'rpc', // style
			'encoded', // use
			'List profile description about the person ');  //description
			


 //Work & Experience List
$server->register('work_experience_List',  // method name:        
            array('id'=>'xsd:int'), // parameter list:
            array('return'=>'xsd:Array'),// return value(array()):
            'urn:server',// namespace:
            false, // soapaction: (use default)
            'rpc', // style: rpc or document
            'encoded',// use: encoded or literal
            'List All Work experience '); // description: documentation for the method

 
// ALL Skills List		
$server->register('allSkills',
			array('id'=>'xsd:int'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#allSkillsServer',  //soapaction
			'rpc', // style
			'encoded', // use
			'list all the skills of a user');  //description
			

// ALL Education List		
$server->register('allEducation',
			array('email' => 'xsd:string', 'id'=>'xsd:int'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#allEducationServer',  //soapaction
			'rpc', // style
			'encoded', // use
			'List All Academic Course ');  //description
			
			
// ALL Education List		
$server->register('userInformation',
			array('email' => 'xsd:string', 'id'=>'xsd:int'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#userInformationServer',  //soapaction
			'rpc', // style
			'encoded', // use
			'List user information ');  //description
			
// List One Work
$server->register('listWork',
			array('userID' => 'xsd:int', 'idwork'=>'xsd:int'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#listWorkServer',  //soapaction
			'rpc', // style
			'encoded', // use
			'List work information ');  //description
			
			
			// List One Work
$server->register('listSkill',
			array('userID' => 'xsd:int', 'idskill'=>'xsd:int'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#listSkillServer',  //soapaction
			'rpc', // style
			'encoded', // use
			'List skill information ');  //description
			
			
			// List One Work
						
$server->register('listCourse',
			array('userID' => 'xsd:int', 'idCourse'=>'xsd:int'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#listCourseServer',  //soapaction
			'rpc', // style
			'encoded', // use
			'List course information ');  //description
			
			
			
			// List All publications for 
			
$server->register('listAllPubsbyUser',
			array('userID' => 'xsd:int'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#listAllPubsUserServer',  //soapaction
			'rpc', // style
			'encoded', // use
			'List All Publications by User ');  //description


$server->register('listAllotherAtributesbyPub',
			array('idpublication' => 'xsd:string'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#listAllotherAtributesbyPubServer',  //soapaction
			'rpc', // style
			'encoded', // use
			'List All other atributes of one publication');  //description
			
$server->register('listAllAuthorsbyPub',
			array('idpublication' => 'xsd:string'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#listAllAuthorsbyPubServer',  //soapaction
			'rpc', // style
			'encoded', // use
			'List All other atributes of one publication');  //description
			
			
$server->register('listAllderiverablesbyPub',
			array('idpublication' => 'xsd:string'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#listAllderiverablesbyPubServer',  //soapaction
			'rpc', // style
			'encoded', // use
			'List All deliverables of one publication');  //description
			

$server->register('listAllTypesPub',
			array('userID' => 'xsd:int'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#listAllTypesPubServer',  //soapaction
			'rpc', // style
			'encoded', // use
			'List All types of publications');  //description			
			
$server->register('listDisciplinesbyUser',
			array('userID' => 'xsd:int'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#listDisciplinesbyUserServer',  //soapaction
			'rpc', // style
			'encoded', // use
			'List All disciplines by user');  //description			
			
// List all user's disciplines
$server->register('listDisciplines',
			array('userID' => 'xsd:int'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#listDisciplinesServer',  //soapaction
			'rpc', // style
			'encoded', // use
			"List all user's disciplines information ");  //description

// List info about discipline			
$server->register('disciplineinfo',
			array('id' => 'xsd:int'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#disciplineinfoServer',  //soapaction
			'rpc', // style
			'encoded', // use
			"List discipline information ");  //description
			
// List all discipline content
$server->register('listContent',
			array('userID' => 'xsd:int'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#listContentsServer',  //soapaction
			'rpc', // style
			'encoded', // use
			"List all discipline content information ");  //description
			
// List content info
$server->register('contentinfo',
			array('idcontent' => 'xsd:int'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#listcontentinfoServer',  //soapaction
			'rpc', // style
			'encoded', // use
			"List content information ");  //description						
			
// List keywords
$server->register('listkeywords',
			array(),
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#listkeywords',  //soapaction
			'rpc', // style
			'encoded', // use
			"List all keywords");  //description	
			
// List keywords about a content 
$server->register('listcontentkeywords',
			array('idcontent' => 'xsd:int'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#listkeywordscontent',  //soapaction
			'rpc', // style
			'encoded', // use
			" List keywords about a content ");  //description	
			
			// List keywords about a content 
$server->register('listContentByDiscipline',
			array('iddiscipline' => 'xsd:int'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#listContentByDisciplineServer',  //soapaction
			'rpc', // style
			'encoded', // use
			" List all content by discipline");  //description	
			

			// List courses  
$server->register('listCourseSelect',
			array('userID' => 'xsd:int'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#listCourseSelectServer',  //soapaction
			'rpc', // style
			'encoded', // use
			" List all curses ");  //description	
			
			// List academic years
$server->register('listAcademicyearSelect',
			array('userID' => 'xsd:int'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#listAcademicyearSelectServer',  //soapaction
			'rpc', // style
			'encoded', // use
			" List all academic years ");  //description
			
			// List institutions years
$server->register('listinstitutionSelect',
			array('userID' => 'xsd:int'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#listinstitutionSelectServer',  //soapaction
			'rpc', // style
			'encoded', // use
			" List all institutions ");  //description	
			
						// List institutions years
$server->register('listAlldisciplinesbyquery',
			array('userID' => 'xsd:int', 'query'=>'xsd:string'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#listAlldisciplinesbyqueryServer',  //soapaction
			'rpc', // style
			'encoded', // use
			" List all disiplines by query ");  //description	
			
			
$server->register('listAllExaminationsByUser',
			array('userID' => 'xsd:int', 'query'=>'xsd:string'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#listAllExaminationsByUserServer',  //soapaction
			'rpc', // style
			'encoded', // use
			" List all examinations by User");  //description	
			

			
						// List institutions years
$server->register('listExamInstitution',
			array('userID' => 'xsd:int'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#listExamInstitutionServer',  //soapaction
			'rpc', // style
			'encoded', // use
			" List all institutions by examinations");  //description	
			
									// List institutions years
$server->register('listExamDate',
			array('userID' => 'xsd:int'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#listExamDateServer',  //soapaction
			'rpc', // style
			'encoded', // use
			" List all dates by examinations");  //description	
			
			
									// List institutions years
$server->register('listExamKeywords',
			array('userID' => 'xsd:int'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#listExamKeywordsServer',  //soapaction
			'rpc', // style
			'encoded', // use
			" List all keywords  by examinations");  //description	
			
            // examinations by queyr
$server->register('listExambyquery',
			array('userID' => 'xsd:int', 'query'=>'xsd:string'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#listExambyqueryServer',  //soapaction
			'rpc', // style
			'encoded', // use
			" List all examinations by query");  //description	
			
			
			

$server->register('listAllSupervisionsByUser',
			array('userID' => 'xsd:int'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#listAllSupervisionsByUserServer',  //soapaction
			'rpc', // style
			'encoded', // use
			" List all Supervisions by user");  //description	
			

$server->register('listSupKeywords',
			array('userID' => 'xsd:int'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#listSupKeywordsServer',  //soapaction
			'rpc', // style
			'encoded', // use
			" List all keywords of supervisions by user");  //description	
			
$server->register('listSupTitles',
			array('userID' => 'xsd:int'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#listSupKeywordsServer',  //soapaction
			'rpc', // style
			'encoded', // use
			" List all titles of supervisions by user");  //description	
						
			
			


            // examinations by queyr
$server->register('lisSupByquery',
			array('userID' => 'xsd:int', 'query'=>'xsd:string'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#lisSupByqueryServer',  //soapaction
			'rpc', // style
			'encoded', // use
			" List all supervisions by query");  //description	
			

$server->register('insertkeyword',
			array('kw' => 'xsd:string'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#insertkeywordServer',  //soapaction
			'rpc', // style
			'encoded', // use
			" Insert a keyword in the DB ");  //description	

$server->register('checkkeyword',
			array('kwid' => 'xsd:int'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#checkkeywordServer',  //soapaction
			'rpc', // style
			'encoded', // use
			" Check if keyword is in use ");  //description		
			
$server->register('editkeyword',
			array('kwid' => 'xsd:int', 'kw' => 'xsd:string'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#editkeywordServer',  //soapaction
			'rpc', // style
			'encoded', // use
			" Edit a keyword ");  //description				
			
$server->register('rmkeyword',
			array('kwid' => 'xsd:int'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#rmkeywordServer',  //soapaction
			'rpc', // style
			'encoded', // use
			" Remove a keyword ");  //description	
			
$server->register('listaut',
			array(),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#listaut',  //soapaction
			'rpc', // style
			'encoded', // use
			'List all users');  //description	


$server->register('checkaut',
			array('authorid' => 'xsd:string'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#checkautServer',  //soapaction
			'rpc', // style
			'encoded', // use
			" Check if author has pubs ");  //description		
			
		
$server->register('rmaut',
			array('authorid' => 'xsd:string'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#rmautServer',  //soapaction
			'rpc', // style
			'encoded', // use
			" Remove author ");  //description		

$server->register('editaut',
			array('authorid' => 'xsd:string', 'author' => 'xsd:string'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#editautServer',  //soapaction
			'rpc', // style
			'encoded', // use
			" Edit author ");  //description				

			// examinations by queyr
$server->register('listAllExaminationatributtes',
			array('userID' => 'xsd:int', 'idexam'=>'xsd:int'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#listAllExaminationatributtesServer',  //soapaction
			'rpc', // style
			'encoded', // use
			" List examination info by idexamination");  //description	
			
						// examinations by queyr
$server->register('liststudentbyExam',
			array('idexam'=>'xsd:int'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#liststudentbyExamServer',  //soapaction
			'rpc', // style
			'encoded', // use
			" List student info by idexamination");  //description	
			
						// examinations by queyr
$server->register('listexamkeywordsbyexam',
			array('idexam'=>'xsd:int'),  //parameters
			array('return' => 'xsd:Array'),  //output
			'urn:server',   //namespace
			'urn:server#listexamkeywordsServer',  //soapaction
			'rpc', // style
			'encoded', // use
			" List keywords info by idexamination");  //description	
/*****************************************************************************************************************************************
                                                                Functions
*****************************************************************************************************************************************/		
			
//Login function implementation 
function login($username, $password) {
        $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        return array(
		'id_user'=>'1',
		'fullname'=>'John Reese',
		'email'=>'john@reese.com',
		'level'=>'99'
		);
}


//list all users
function listusers() {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("SELECT * FROM users");
    $result = $res->fetchAll();
    return $result;
}

//list all users
function listuserinfo($id) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("SELECT * FROM users where idusers='".$id."'");
    $result = $res->fetchAll();
    return $result;
}


 //work_experience_List function implementation 
function work_experience_List($id) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("SELECT * FROM workexperience where idusers = '".$id."'");
    $result = $res->fetchAll();
    return $result;
}

 //work_experience_List function implementation 
function allSkills($id) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("SELECT * FROM skills where idusers = '".$id."'");
    $result = $res->fetchAll();
    return $result;
}


 //work_experience_List function implementation 
function allEducation($email, $id) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("SELECT * FROM education where idusers = '".$id."'");
    $result = $res->fetchAll();
    return $result;
}



function descriptionProfile($email, $id) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("SELECT personal_profile FROM users where idusers = '".$id."'");
    $result = $res->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function userInformation($email, $id) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("SELECT * FROM users where idusers = '".$id."'");
    $result = $res->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function listWork($userID, $idwork) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("SELECT * FROM workexperience WHERE idusers = '".$userID."' and idwork ='".$idwork."'");
    $result = $res->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function listSkill($userID, $idskill) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("SELECT * FROM skills WHERE idusers = '".$userID."' and idskills ='".$idskill."'");
    $result = $res->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function listCourse($userID, $idCourse) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("SELECT * FROM education WHERE idusers = '".$userID."' and ideducation ='".$idCourse."'");
    $result = $res->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function listAllPubsbyUser($userID) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("select publications.idpublication, users.name, publications.type, publications.title, publications.year from publications, users where publications.idusers = '".$userID."' and users.idusers = '".$userID."' ORDer By publications.type, publications.year desc");
    $result = $res->fetchAll();
    return $result;
}

function listAllAuthorsbyPub($idpublication) { 
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("select authors.name, pubaut.type, pubaut.idpublication from pubaut, authors where  pubaut.idpublication= '".$idpublication."' and pubaut.idauthor = authors.idauthor");
    $result = $res->fetchAll();
    return $result;

}

function listAllotherAtributesbyPub($idpublication) { 
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("select pubother.name, pubother.value from pubother where pubother.idpublication='".$idpublication."'");
    $result = $res->fetchAll();
    return $result;
}

function listAllderiverablesbyPub($idpublication) { 
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("select deliverables.type, deliverables.url, deliverables.description from deliverables where deliverables.idpublication='".$idpublication."'");
    $result = $res->fetchAll();
    return $result;
}

function listAllTypesPub($userID) { 
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("SELECT DISTINCT type FROM engweb.publications where publications.idusers='".$userID."' order by type;");
    $result = $res->fetchAll();
    return $result;
}


function listDisciplinesbyUser($userID) { 
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("SELECT * FROM engweb.discipline where idusers = '".$userID."' order by academicYear desc;");
    $result = $res->fetchAll();
    return $result;
}




function listDisciplines($userID) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("SELECT * FROM discipline WHERE idusers = '".$userID."'");    
    $result = $res->fetchAll();
    return $result;
}

function disciplineinfo($id) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("SELECT * FROM discipline WHERE iddiscipline = '".$id."'");    
    $result = $res->fetchAll();
    return $result;
}

function listContent($userID) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("SELECT * FROM content WHERE idusers = '".$userID."'");    
    $result = $res->fetchAll();
    return $result;
}

function contentinfo($idcontent) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("SELECT * FROM content WHERE idcontent = '".$idcontent."'");    
    $result = $res->fetchAll();
    return $result;
}

function listkeywords() {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("SELECT * FROM keywords");    
    $result = $res->fetchAll();
    return $result;
}			

function listcontentkeywords($idcontent) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("SELECT * FROM contentkeyword where idcontent='".$idcontent."'");  
    $result = $res->fetchAll();
    return $result;
}

function listContentByDiscipline($iddiscipline) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("SELECT * FROM engweb.content where iddiscipline='".$iddiscipline."';");    
    $result = $res->fetchAll();
    return $result;
}

//course
function listCourseSelect($userID) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("select Distinct courseName from discipline where idusers='".$userID."' order by courseName ");    
    $result = $res->fetchAll();
    return $result;
}

//academic year
function listAcademicyearSelect($userID) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("select Distinct academicYear from discipline where idusers='".$userID."' order by academicYear desc");    
    $result = $res->fetchAll();
    return $result;
}

//institution
function listinstitutionSelect($userID) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("select Distinct inst from discipline where idusers='".$userID."' order by inst");    
    $result = $res->fetchAll();
    return $result;
}

//institution
function listAlldisciplinesbyquery($userID, $query) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query($query);    
    $result = $res->fetchAll();
    return $result;
}



//institution
function listAllExaminationsByUser($userID) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    
    $res = $dbh->query("select student.name, theexam.idtheexam, student.description, student.address,
	student.email, student.linkedin, document.title,
	document.doi, theexam.inst, theexam.ansi, theexam.type
	from student, document, theexam where
	theexam.idusers = '".$userID."' and
	theexam.iddocument= document.iddocument and
	document.idstudent = student.idstudent order by ansi desc ;");  
	  
    $result = $res->fetchAll();
    return $result;
}

//institution
function listExamInstitution($userID) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("select distinct theexam.inst from theexam where theexam.idusers = '".$userID."' order by inst;");    
    $result = $res->fetchAll();
    return $result;
}

//institution
function listExamDate($userID) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("select distinct theexam.ansi from theexam where theexam.idusers = '".$userID."' order by theexam.ansi desc ;");    
    $result = $res->fetchAll();
    return $result;
}

//institution
function listExamKeywords($userID) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("select distinct keywords.name from theexam, examkeyword, keywords where theexam.idusers = '".$userID."' and
                        theexam.idtheexam = examkeyword.idtheexam and
                        examkeyword.idkeywords = keywords.idkeywords order by keywords.name;");    
    $result = $res->fetchAll();
    return $result;
}


//institution
function listExambyquery($userID, $query) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query($query);    
    $result = $res->fetchAll();
    return $result;
}



//institution
function listAllSupervisionsByUser($userID) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("SELECT thesup.type, thesup.status, thesup.inst, thesup.beginyear, thesup.endyear, thesup.cosupname, thesup.idthesup,
     thesup.cosupinst, document.title, document.doi, student.name, student.idstudent, student.description, student.address,
     student.email, student.linkedin, users.name as namesupervisor 
     from thesup, document, student, users where
     thesup.idusers = users.idusers and users.idusers = '".$userID."' and document.iddocument = thesup.iddocument and student.idstudent = document.idstudent order by thesup.status;");    
    $result = $res->fetchAll();
    return $result;
}


//institution
function listSupKeywords($userID) {
    
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("select distinct keywords.name from keywords, supkeyword, thesup, users where  thesup.idusers = users.idusers and users.idusers = '".$userID."' and  thesup.idthesup = supkeyword.idthesup and supkeyword.idkeywords = keywords.idkeywords order by keywords.name;");    
    $result = $res->fetchAll();
    return $result;
    
}


function listSupTitles($userID) {
    
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("select document.title from thesup, document  where thesup.idusers = '".$userID."' and thesup.iddocument = document.iddocument order by document.title ;");    
    $result = $res->fetchAll();
    return $result;
    
}


//institution
function lisSupByquery($userID, $query) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query($query);    
    $result = $res->fetchAll();
    return $result;
}





function insertkeyword($kw) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("SELECT * FROM keywords WHERE name =\"" . $kw . "\"");
    $rows = $res->rowCount();
    if($rows > 0) {
    	return 1;
    }else{
    	$dbh->query("INSERT INTO keywords (name) VALUES (\"" . $kw . "\");");
	    return 0;
	}
}

function checkkeyword($kwid) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("SELECT idkeywords FROM pubkeyword WHERE idkeywords = \"" . $kwid . "\" UNION SELECT idkeywords FROM contentkeyword WHERE idkeywords = \"" . $kwid . "\" UNION SELECT idkeywords FROM examkeyword WHERE idkeywords = \"" . $kwid . "\" UNION SELECT idkeywords FROM supkeyword WHERE idkeywords = \"" . $kwid . "\";");
    $rows = $res->rowCount();
    if($rows > 0) {
    	return 1;
    }else{
	    return 0;
	}
}

function editkeyword($kwid, $kw) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("UPDATE keywords SET name = '" . $kw . "' WHERE idkeywords = '" . $kwid . "';");
    
    return 0;
}

function rmkeyword($kwid) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("DELETE FROM keywords WHERE idkeywords = '" . $kwid . "';");
    
    return 0;
}


//////AUTHORS____________________________________________________________________________
function listaut() {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("SELECT * FROM authors");
    $result = $res->fetchAll();
    return $result;
}

function checkaut($authorid) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("SELECT * FROM pubaut WHERE idauthor =\"" . $authorid . "\"");
    $rows = $res->rowCount();
    if($rows > 0) {
    	return 1;
    }else{
	    return 0;
	}
}

function rmaut($authorid) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("DELETE FROM authors WHERE idauthor = '" . $authorid . "';");
    
    return 0;
}

function editaut($authorid, $author) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("UPDATE authors SET name = '" . $author . "' WHERE idauthor = '" . $authorid . "';");
    $res = $dbh->query("UPDATE users SET name = '" . $author . "' WHERE idauthor = '" . $authorid . "';");
    
    return 0;
}


function listAllExaminationatributtes($userID, $idexam) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("select * from theexam where idtheexam = '".$idexam."';");    
    $result = $res->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function liststudentbyExam($idexam) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("select * from document, theexam, student where theexam.idtheexam='".$idexam."' and theexam.iddocument = document.iddocument and document.idstudent = student.idstudent;");    
    $result = $res->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function listexamkeywordsbyexam($idexam) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $res = $dbh->query("SELECT * FROM examkeyword where idtheexam='".$idexam."';");  
    $result = $res->fetchAll();
    return $result;
}		










//***********************************************************************************************************************************************

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
 
$server->service($HTTP_RAW_POST_DATA);

?>
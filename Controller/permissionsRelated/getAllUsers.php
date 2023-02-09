
<?php

session_start();
$GLOBALS['state'] = 1;
require_once '../../odm-load.php';

$dataDir = $GLOBALS['CONFIG']['dataDir'];
$userperms_obj = new UserPermission($_SESSION['uid'], $pdo);

$showCheckBox = false;
$rejectpage = false;
if(isset($_GET['designation']) && isset($_GET['department'])){
    $designation = $_GET['designation'];
    $department = $_GET['department'];
    $query = "SELECT * FROM {$GLOBALS['CONFIG']['db_prefix']}user where department = $department and Designation = $designation ORDER BY `odm_user`.`last_name` ASC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $num_rows = $stmt->rowCount();
    if($num_rows>0){
        $result_Send = array();        
        foreach($result as $row){
            array_push($result_Send,array($row['id'],$row['last_name']." , ".$row['first_name']));
        }
        print_r(json_encode($result_Send));
    }else{
        print_r(json_encode(array("No records found!")));
    }
    // print_r(json_encode(array("Abhi nhi")));
}
elseif(isset($_GET['userID'])){
    $userID = $_GET['userID'];
    $query = "SELECT * FROM {$GLOBALS['CONFIG']['db_prefix']}user where id= $userID ";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $num_rows = $stmt->rowCount();
    if($num_rows>0){
        $result_Send = array();        
        foreach($result as $row){
            array_push($result_Send,array($row['id'],$row['last_name']." , ".$row['first_name']));
        }
        print_r(json_encode($result_Send));
    }else{
        print_r(json_encode(array("No records found!")));
    }
    // print_r(json_encode(array("Abhi nhi")));
}
else{
    $query = "SELECT * FROM {$GLOBALS['CONFIG']['db_prefix']}user ORDER BY `odm_user`.`last_name` ASC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $num_rows = $stmt->rowCount();
    if($num_rows>0){
        $result_Send = array();        
        foreach($result as $row){
            array_push($result_Send,array($row['id'],$row['last_name']." , ".$row['first_name']));
        }
        print_r(json_encode($result_Send));
    }
}

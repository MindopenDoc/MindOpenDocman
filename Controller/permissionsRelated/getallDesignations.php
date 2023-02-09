
<?php

session_start();
$GLOBALS['state'] = 1;
require_once '../../odm-load.php';

$dataDir = $GLOBALS['CONFIG']['dataDir'];
$userperms_obj = new UserPermission($_SESSION['uid'], $pdo);

$showCheckBox = false;
$rejectpage = false;
if(isset($_GET['query'])){
    $deptCond = $_GET['query'];
    $query = "SELECT * FROM {$GLOBALS['CONFIG']['db_prefix']}designation where dept_id = $deptCond ORDER BY `odm_designation`.`name` ASC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $num_rows = $stmt->rowCount();
    if($num_rows>0){
        $result_Send = array();        
        foreach($result as $row){
            array_push($result_Send,array($row['id'],$row['name']));
        }
        print_r(json_encode($result_Send));
    }
    else{
        print_r(json_encode(array("No records found!")));
    }
}
elseif(isset($_GET['userQuery'])){
    $userQuery = $_GET['userQuery'];
    $query = "SELECT * FROM {$GLOBALS['CONFIG']['db_prefix']}designation where id = $userQuery ";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $num_rows = $stmt->rowCount();
    if($num_rows>0){
        $result_Send = array();        
        foreach($result as $row){
            array_push($result_Send,array($row['id'],$row['name'],$row['dept_id']));
        }
        print_r(json_encode($result_Send));
    }
    else{
        print_r(json_encode(array("No records found!")));
    }
}
else{
    
    $query = "SELECT * FROM {$GLOBALS['CONFIG']['db_prefix']}designation ORDER BY `odm_designation`.`name` ASC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $num_rows = $stmt->rowCount();
    if($num_rows>0){
        $result_Send = array();        
        foreach($result as $row){
            array_push($result_Send,array($row['id'],$row['name']));
        }
        print_r(json_encode($result_Send));
    }
}

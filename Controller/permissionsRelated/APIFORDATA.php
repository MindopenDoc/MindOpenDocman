
<?php

session_start();
$GLOBALS['state'] = 1;
require_once '../../odm-load.php';
$dataDir = $GLOBALS['CONFIG']['dataDir'];
include('../../udf_functions.php');
require_once("../../AccessLog_class.php");
require_once("../../User_Perms_class.php");
$userperms_obj = new UserPermission($_SESSION['uid'], $pdo);
if (!isset($_REQUEST['id']) || $_REQUEST['id'] == '') {
    print_r(json_encode("Error while Handling Data !"));
    die();
}
$showCheckBox = false;
$rejectpage = false;
if(isset($_GET['query'])){
     echo "Nothing !";
}
else{
    $filedata = new FileData($_REQUEST['id'], $pdo);
    $query = "SELECT * FROM {$GLOBALS['CONFIG']['db_prefix']}department ORDER BY `odm_department`.`name` ASC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $num_rows = $stmt->rowCount();
    if($num_rows>0){
        $result_Send = array();      
        foreach($result as $row){
            $dept_id = $row['id'];
            $design_query = "SELECT * FROM {$GLOBALS['CONFIG']['db_prefix']}designation where dept_id = $dept_id ORDER BY `odm_designation`.`name` ASC";
            $design_stmt = $pdo->prepare($design_query);
            $design_stmt->execute();
            $design_result = $design_stmt->fetchAll();
            $design_num_rows = $design_stmt->rowCount();
            if($num_rows>0){
                $design_result_array = array();
                foreach($design_result as $design_row){
                    $design_id = $design_row['id'];
                    $user_query = "SELECT * FROM {$GLOBALS['CONFIG']['db_prefix']}user where department = $dept_id and Designation = $design_id ORDER BY `odm_user`.`last_name` ASC";
                    $user_stmt = $pdo->prepare($user_query);
                    $user_stmt->execute();
                    $user_result = $user_stmt->fetchAll();
                    $user_num_rows = $user_stmt->rowCount();
                    $user_result_array = array();
                    if($user_num_rows>0){
                        foreach($user_result as $user_row){
                            array_push($user_result_array,array("id"=>$user_row['id'],"name"=>$user_row['first_name']));
                        }
                    }
                    array_push($design_result_array, array("id"=>$design_row['id'],"name"=>$design_row['name'],"rights"=> $filedata->getDesignRights($design_row['id']),"users"=>$user_result_array));
                }
            }
            array_push($result_Send,array("id"=>$row['id'],"name"=>$row['name'],"rights"=> $filedata->getDeptRights($row['id']),"designations"=>$design_result_array));
        }
        print_r(json_encode($result_Send));
    }
}

<?php
session_start();
include('../../odm-load.php');

if (!isset($_SESSION['uid'])) {
    redirect_visitor();
}

include('../../udf_functions.php');
require_once("../../AccessLog_class.php");
require_once("../../User_Perms_class.php");

$user_perms_obj = new User_Perms($_SESSION['uid'], $pdo);

if (!isset($_REQUEST['id']) || $_REQUEST['id'] == '') {
    print_r(json_encode("Error while Handling Data !"));
    die();
}

$filedata = new FileData($_REQUEST['id'], $pdo);
 
    checkUserPermission($_REQUEST['id'], $filedata->ADMIN_RIGHT, $filedata);

    $current_user_dept = $user_perms_obj->user_obj->getDeptId();

    $data_id = $_REQUEST['id'];
    // includes
    $department_query = "SELECT department FROM {$GLOBALS['CONFIG']['db_prefix']}user WHERE id=:user_id";
    $department_stmt = $pdo->prepare($department_query);
    $department_stmt->bindParam(':user_id', $_SESSION['uid']);
    $department_stmt->execute();
    $result = $department_stmt->fetchAll();

    $filedata = new FileData($data_id, $pdo);

    // error check
    if (!$filedata->exists()) {
        print_r(json_encode("file not found!"));
        exit;
    } else {
        $category = $filedata->getCategory();
        $realname = $filedata->getName();
        $description = $filedata->getDescription();
        $comment = $filedata->getComment();
        $owner_id = $filedata->getOwner();
        $department = $filedata->getDepartment();
        $designation = $filedata->getDesignation();


        //CHM
        $table_name_query = "SELECT table_name FROM {$GLOBALS['CONFIG']['db_prefix']}udf WHERE field_type = '4'";
        $table_name_stmt = $pdo->prepare($table_name_query);
        $table_name_stmt->execute();
        $result = $table_name_stmt->fetchAll();

        $num_rows = $table_name_stmt->rowCount();
        
        $t_name = array();
        $i = 0;
        foreach ($result as $data) {
            $explode_v = explode('_', $data['table_name']);
            $t_name = $explode_v[2];
            $i++;
        }

        // For the User dropdown
        $avail_users = $user_perms_obj->user_obj->getAllUsers($pdo);
        
        // We need to set a form value for the current department so that
        // it can be pre-selected on the form
        $avail_departments = Department::getAllDepartments($pdo);


        $avail_categories = Category::getAllCategories($pdo);

        $cats_array = array();
        foreach ($avail_categories as $avail_category) {
            array_push($cats_array, $avail_category);
        }

     // populate DESIGNATION list 
        $designation_query = "SELECT id, name FROM {$GLOBALS['CONFIG']['db_prefix']}designation ORDER BY name";
        $designation_stmt = $pdo->prepare($designation_query);
        $designation_stmt->execute(array());
        $designation_list = $designation_stmt->fetchAll();
        // END DESIGNATION
        $designation_perms_array = array();
        foreach ($designation_list as $design) {
            $designation_list_perms['name'] = $design['name'];
            $designation_list_perms['id'] = $design['id'];
            $designation_list_perms['rights'] = $filedata->getDesignRights($design['id']);
            array_push($designation_perms_array, $designation_list_perms);
        }


        //////Populate department perm list/////////////////
        $dept_perms_array = array();
        foreach ($avail_departments as $dept) {
            $avail_dept_perms['name'] = $dept['name'];
            $avail_dept_perms['id'] = $dept['id'];
            $avail_dept_perms['rights'] = $filedata->getDeptRights($dept['id']);
            array_push($dept_perms_array, $avail_dept_perms);
        }
        
        //////Populate users perm list/////////////////
        $user_perms_array = array();
        foreach ($avail_users as $user) {
            $avail_user_perms['fid'] = $data_id;
            $avail_user_perms['first_name'] = $user['first_name'];
            $avail_user_perms['last_name'] = $user['last_name'];
            $avail_user_perms['id'] = $user['id'];
            $avail_user_perms['rights'] = $user_perms_obj->getPermissionForUser($user['id'], $data_id);
            array_push($user_perms_array, $avail_user_perms);
        }

        print_r(json_encode(array("pre_selected_department"=>$dept_perms_array,"pre_selected_designation"=>$designation_perms_array,"pre_selected_owner"=>$user_perms_array)));
        die();

       
    }//end else
 
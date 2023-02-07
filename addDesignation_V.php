 

<?php
    session_start();
    include('odm-load.php');

    if (!isset($_SESSION['uid'])) {
        redirect_visitor();
    }

    include('udf_functions.php');
    require_once("AccessLog_class.php");
    require_once("File_class.php");
    require_once('Reviewer_class.php');
    require_once('Email_class.php');

    $user_obj = new User($_SESSION['uid'], $pdo);

    if (!$user_obj->canAdd()) {
        redirect_visitor('out.php');
    }
    if (!isset($_POST['submit']))
    {
         
        $last_message = (isset($_REQUEST['last_message']) ? $_REQUEST['last_message'] : '');
        draw_header(msg('Add Designation'), $last_message);
        $current_user_dept = $user_obj->getDeptId();

        $index = 0;

        //CHM - Pull in the sub-select values
        $query = "SELECT * FROM {$GLOBALS['CONFIG']['db_prefix']}designation ";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $num_rows = $stmt->rowCount();
        
        $i=0;
        
        $t_name = array();
        $design_perms_array = array();
        foreach ($result as $desig) {
            $avail_design_perms['name'] = $desig['name'];
            $avail_design_perms['id'] = $desig['id'];
            $thisDept = $desig['dept_id'];
            $dept_query = "SELECT * FROM {$GLOBALS['CONFIG']['db_prefix']}department where id = $thisDept";
            $Dstmt = $pdo->prepare($dept_query);
            $Dstmt->execute();
            $Dresult = $Dstmt->fetchAll();
            $num_rows_D = $Dstmt->rowCount();
            if ($num_rows_D === 1){
                $avail_design_perms['dept_id'] = $Dresult[0]['name'];
            }
            array_push($design_perms_array, $avail_design_perms);
        }
        $allDepartments = Department::getAllDepartments($pdo);        
        $GLOBALS['smarty']->assign('is_admin', $user_obj->isAdmin());
        $GLOBALS['smarty']->assign('design_perms_array', $design_perms_array);
        $GLOBALS['smarty']->assign('alldepartments', $allDepartments);
        $GLOBALS['smarty']->assign('user_id', $_SESSION['uid']);
        $GLOBALS['smarty']->assign('db_prefix', $GLOBALS['CONFIG']['db_prefix']);
        display_smarty_template('addDesignation.tpl');
         
    }else{
        $pdo = $GLOBALS['pdo'];
        if(isset($_POST['InputDesignation']) && isset($_POST['SelectDepartment'])){
            $newDesignation =  trim($_POST['InputDesignation']," ");
            $SelectDept =  $_POST['SelectDepartment'];
            $query = "SELECT * FROM {$GLOBALS['CONFIG']['db_prefix']}designation where name = '$newDesignation' and dept_id = $SelectDept";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $num_rows = $stmt->rowCount();
            foreach ($result as $var) {
                if (strtoupper($_POST['InputDesignation'])  === strtoupper($var['name']) && $var['dept_id']  == $SelectDept ){
                    echo "Designation already Exist";
                    header('Location:error.php?last_message='.urlencode("Designation already Exist"));
                    die();
                }
            }
            $designation_data_query = "INSERT INTO 
            {$GLOBALS['CONFIG']['db_prefix']}designation (
                name,
                dept_id
            )
                VALUES
            (
                :name,
                :dept_id
            )";
            $designation_data_stmt = $pdo->prepare($designation_data_query);
            $designation_data_stmt->bindParam(':name', $newDesignation);
            $designation_data_stmt->bindParam(':dept_id', $SelectDept);
            $designation_data_stmt->execute();
            // get id from INSERT operation
            $designationId = $pdo->lastInsertId();
            header('Location: addDesignation_V.php?last_message='.urlencode("Designation Added"));
            exit;
        }
    }
    draw_footer();
    ?>
 
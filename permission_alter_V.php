<?php
session_start();
include('odm-load.php');

if (!isset($_SESSION['uid'])) {
    redirect_visitor();
}

include('udf_functions.php');
require_once("AccessLog_class.php");
require_once("User_Perms_class.php");

$user_perms_obj = new User_Perms($_SESSION['uid'], $pdo);

$last_message = (isset($_REQUEST['last_message']) ? $_REQUEST['last_message'] : '');

if (!isset($_REQUEST['id']) || $_REQUEST['id'] == '') {
    header('Location:error.php?ec=2');
    exit;
}

if (strchr($_REQUEST['id'], '_')) {
    header('Location:error.php?ec=20');
}

$filedata = new FileData($_REQUEST['id'], $pdo);

if ($filedata->isArchived()) {
    header('Location:error.php?ec=21');
}

if (!isset($_POST['submit'])) {

    checkUserPermission($_REQUEST['id'], $filedata->ADMIN_RIGHT, $filedata);
    $last_message = (isset($_REQUEST['last_message']) ? $_REQUEST['last_message'] : '');
    draw_header(msg('area_add_new_file'), $last_message);
    $current_user_dept = $user_perms_obj->user_obj->getDeptId();

    $data_id = $_REQUEST['id'];
    // includes
    $department_query = "SELECT department FROM {$GLOBALS['CONFIG']['db_prefix']}user WHERE id=:user_id";
    $department_stmt = $pdo->prepare($department_query);
    $department_stmt->bindParam(':user_id', $_SESSION['uid']);
    $department_stmt->execute();
    $result = $department_stmt->fetchAll();

    if ($department_stmt->rowCount() != 1) {
        header('Location:error.php?ec=14');
        exit; //non-unique error
    }

    $filedata = new FileData($data_id, $pdo);

    // error check
    if (!$filedata->exists()) {
        header('Location:error.php?ec=2');
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

        
        
        //////Populate department perm list/////////////////
        $dept_perms_array = array();
        foreach ($avail_departments as $dept) {
            $avail_dept_perms['name'] = $dept['name'];
            $avail_dept_perms['id'] = $dept['id'];
            $avail_dept_perms['rights'] = $filedata->getDeptRights($dept['id']);
            array_push($dept_perms_array, $avail_dept_perms);
        }
        
        // populate DESIGNATION list 
           $designation_query = "SELECT id, name FROM {$GLOBALS['CONFIG']['db_prefix']}designation WHERE dept_id = $department ORDER BY name";
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

        $GLOBALS['smarty']->assign('file_id', $filedata->getId());
        $GLOBALS['smarty']->assign('realname', $filedata->name);
        $GLOBALS['smarty']->assign('allDepartments', $avail_departments);
        // $GLOBALS['smarty']->assign('designation_list', $designation_perms_array);
        $GLOBALS['smarty']->assign('current_user_dept', $current_user_dept);
        $GLOBALS['smarty']->assign('t_name', $t_name);
        $GLOBALS['smarty']->assign('is_admin', $user_perms_obj->user_obj->isAdmin());
        $GLOBALS['smarty']->assign('avail_users', $user_perms_array);
        $GLOBALS['smarty']->assign('avail_depts', $dept_perms_array);
        $GLOBALS['smarty']->assign('cats_array', $cats_array);
        $GLOBALS['smarty']->assign('user_id', $_SESSION['uid']);
        $GLOBALS['smarty']->assign('pre_selected_owner', $owner_id);
        $GLOBALS['smarty']->assign('pre_selected_category', $category);
        $GLOBALS['smarty']->assign('pre_selected_department', $department);
        $GLOBALS['smarty']->assign('pre_selected_designation', $designation);
        $GLOBALS['smarty']->assign('description', $description);
        $GLOBALS['smarty']->assign('comment', $comment);
        $GLOBALS['smarty']->assign('db_prefix', $GLOBALS['CONFIG']['db_prefix']);
        display_smarty_template('_RefilePermisionModify.tpl');
    }
} else {
    echo "Into else condition!";
    // //invalid file
    // if (empty($_FILES)) {
    //     header('Location:error.php?ec=11');
    //     exit;
    // }

    // $numberOfFiles = count($_FILES['file']['name']);
    // $tmp_name = array();
    // // First we need to make sure all files are allowed types
    // for ($count = 0; $count < $numberOfFiles; $count++) {
    //     if (empty($_FILES['file']['name'][$count])) {
    //         $last_message = $GLOBALS['lang']['addpage_file_missing'];
    //         header('Location: error.php?last_message=' . urlencode($last_message));
    //         exit;
    //     }
          
    //     // Check ini max upload size
    //     if ($_FILES['file']['error'][$count] == 1) {
    //         $last_message = 'Upload Failed - check your upload_max_filesize directive in php.ini';
    //         header('Location: error.php?last_message=' . urlencode($last_message));
    //         exit;
    //     }

    //     $tmp_name[$count] = realpath($_FILES['file']['tmp_name'][$count]);
    //     // Lets lookup the try mime type
    //     $file_mime = File::mime($tmp_name[$count], $_FILES['file']['name'][$count]);

    //     $allowedFile = 0;
        
    //     // check file type
    //     foreach ($GLOBALS['CONFIG']['allowedFileTypes'] as $allowed_type) {
    //         if ($file_mime == $allowed_type) {
    //             $allowedFile = 1;
    //             break;
    //         }
    //     }

    //     // illegal file type!
    //     if (!isset($allowedFile) || $allowedFile != 1) {
    //         $last_message = 'MIMETYPE: ' . $file_mime . ' Failed';
    //         header('Location:error.php?ec=13&last_message=' . urlencode($last_message));
    //         exit;
    //     }
    // }
    
    // //submited form
    // for ($count = 0; $count<$numberOfFiles; $count++) {
    //     if ($GLOBALS['CONFIG']['authorization'] == 'True') {
    //         $publishable = '0';
    //     } else {
    //         $publishable= '1';
    //     }
    //     $result_array = array();
        
    //     // If the admin has chosen to assign the department
    //     // Set it here. Otherwise just use the session UID's department
    //     if ($user_obj->isAdmin() && isset($_REQUEST['file_department'])) {
    //         $current_user_dept = $_REQUEST['file_department'];
    //     } else {
    //         $current_user_dept = $user_obj->getDeptId();
    //     }
        
    //     // File is bigger than what php.ini post/upload/memory limits allow.
    //     if ($_FILES['file']['error'][$count] == '1') {
    //         header('Location:error.php?ec=26');
    //         exit;
    //     }

    //     // File too big?
    //     if ($_FILES['file']['size'][$count] >  $GLOBALS['CONFIG']['max_filesize']) {
    //         header('Location:error.php?ec=25');
    //         exit;
    //     }

    //     // Check to make sure the dir is available and writable
    //     if (!is_dir($GLOBALS['CONFIG']['dataDir'])) {
    //         $last_message=$GLOBALS['CONFIG']['dataDir'] . ' missing!';
    //         header('Location:error.php?ec=23&last_message=' . urlencode($last_message));
    //         exit;
    //     } else {
    //         if (!is_writable($GLOBALS['CONFIG']['dataDir'])) {
    //             $last_message=msg('message_folder_perms_error'). ': ' . $GLOBALS['CONFIG']['dataDir'] . ' ' . msg('message_not_writable');
    //             header('Location:error.php?ec=23&last_message=' . urlencode($last_message));
    //             exit;
    //         }
    //     }

    //     // We need to verify that the temporary upload is there before we continue
    //     if (!is_uploaded_file($tmp_name[$count])) {
    //         header('Location: error.php?ec=18');
    //         exit;
    //     }

    //     // all checks completed, proceed!

    //     // Run the onDuringAdd() plugin function
    //     callPluginMethod('onDuringAdd');

    //     // If the admin has chosen to assign the owner
    //     // Set it here. Otherwise just use the session UID
    //     if ($user_obj->isAdmin() && isset($_REQUEST['file_owner'])) {
    //         $owner_id = $_REQUEST['file_owner'];
    //     } else {
    //         $owner_id = $_SESSION['uid'];
    //     }
    //     // print_r($_FILES['file']['name'][$count]);
    //     //Anshuman Code start
    //     $check =$_FILES['file']['name'][$count];
    //     $file=(explode(".",$check));
    //     $version=0;
    //     $finalversion="";
    //     $flag="SELECT count(id) FROM {$GLOBALS['CONFIG']['db_prefix']}data WHERE realname LIKE '$file[0]%'";
    //     $ans=$pdo->prepare($flag);
    //     $ans->execute();
    //     $result = $ans->setFetchMode(PDO::FETCH_ASSOC);
    //     foreach(($ans->fetchAll()) as $k=>$v) {
    //      $version=($v['count(id)']);
    //     if($version){
    //         $str =$_FILES['file']['name'][$count];
    //         $str2=(explode(".",$str));
    //         $final=$str2[0].$version.".".$str2[1];
    //     }
    //     else{
    //         $final=$_FILES['file']['name'][$count];
    //     }
    //     // die();
    //     // INSERT file info into data table
    //     $keyworddata='No keyword Available';
    //     if(isset($_POST['keyword'])){
    //         $keyworddata=$_POST['keyword'];
    //     }
    //     if(isset($_POST['file_department']) && isset($_POST['cat']) && isset($_POST['subcat'])){
    //         $dap=$_POST['file_department'];
    //         $cat=$_POST['cat'];
    //         $subcat=$_POST['subcat'];
    //         $file_data_query = "INSERT INTO 
    //     {$GLOBALS['CONFIG']['db_prefix']}data (
    //         status,
    //         category,
    //         owner,
    //         realname,
    //         created,
    //         description,
    //         department,
    //         comment,
    //         default_rights,
    //         publishable,
    //         depart,
    //         dep_category,
    //         sub_category,
    //         keyword,
    //         Designation
    //     )
    //         VALUES
    //     (
    //         0,
    //         :category,
    //         :owner_id,
    //         :realname,
    //         NOW(),
    //         :description,
    //         :current_user_dept,
    //         :comment,
    //         0,
    //         $publishable,
    //         $dap,
    //         $cat,
    //         $subcat,
    //         :keyworddata,
    //         :designation

    //     )";
    //     }
    //     //Anshuman Code end
    //     else{
    //     $file_data_query = "INSERT INTO 
    //     {$GLOBALS['CONFIG']['db_prefix']}data (
    //         status,
    //         category,
    //         owner,
    //         realname,
    //         created,
    //         description,
    //         department,
    //         comment,
    //         default_rights,
    //         publishable,
    //         keyword,
    //         Designation
    //     )
    //         VALUES
    //     (
    //         0,
    //         :category,
    //         :owner_id,
    //         :realname,
    //         NOW(),
    //         :description,
    //         :current_user_dept,
    //         :comment,
    //         0,
    //         $publishable,
    //         :keyworddata,
    //         :designation
    //     )";
    //     }
    //     // die();
    //     $file_data_stmt = $pdo->prepare($file_data_query);
        
    //     $file_data_stmt->bindParam(':category', $_REQUEST['category']);
    //     $file_data_stmt->bindParam(':owner_id', $owner_id);
    //     // $file_data_stmt->bindParam(':realname', $_FILES['file']['name'][$count]);// 
    //     //Anshuman Code start
    //     $file_data_stmt->bindParam(':realname',$final);//for the versio of the final 
    //     //Anshuman code end
    //     $file_data_stmt->bindParam(':description', $_REQUEST['description']);
    //     $file_data_stmt->bindParam(':current_user_dept', $current_user_dept);
    //     $file_data_stmt->bindParam(':comment', $_REQUEST['comment']);
    //     $file_data_stmt->bindParam(':keyworddata', $keyworddata);
    //     $file_data_stmt->bindParam(':designation', $_REQUEST['designation']);
    //     $file_data_stmt->execute();

    //     // get id from INSERT operation
    //     $fileId = $pdo->lastInsertId();

    //     udf_add_file_insert($fileId);

    //     $username = $user_obj->getUserName();
        
    //     // Add a file history entry
    //     $history_query = "INSERT INTO {$GLOBALS['CONFIG']['db_prefix']}log 
    //         (
    //             id,
    //             modified_on, 
    //             modified_by,
    //             note,
    //             revision
    //         ) VALUES ( 
    //             '$fileId',
    //             NOW(),
    //             :username,
    //             'Initial import',
    //             'current'
    //         )";
        
    //     $history_stmt = $pdo->prepare($history_query);
    //     $history_stmt->bindParam(':username', $username);
    //     $history_stmt->execute();

    //     //Insert Designation Rights into dept_perms
    //     foreach ($_POST['designation_permission'] as $design_id=>$design_perm) {
    //         $design_perms_query = "
    //             INSERT INTO 
    //                 {$GLOBALS['CONFIG']['db_prefix']}designation_perms 
    //                 (
    //                     fid, 
    //                     rights, 
    //                     design_id
    //                 ) VALUES (
    //                     $fileId, 
    //                     :design_perm, 
    //                     :design_id
    //                 )";
                
    //         $design_perms_stmt = $pdo->prepare($design_perms_query);
    //         $design_perms_stmt->bindParam(':design_perm', $design_perm);
    //         $design_perms_stmt->bindParam(':design_id', $design_id);
    //         $design_perms_stmt->execute();
    //     }

    //     //Insert Department Rights into dept_perms
    //     foreach ($_POST['department_permission'] as $dept_id=>$dept_perm) {
    //         $dept_perms_query = "
    //             INSERT INTO 
    //                 {$GLOBALS['CONFIG']['db_prefix']}dept_perms 
    //                 (
    //                     fid, 
    //                     rights, 
    //                     dept_id
    //                 ) VALUES (
    //                     $fileId, 
    //                     :dept_perm, 
    //                     :dept_id
    //                 )";
                
    //         $dept_perms_stmt = $pdo->prepare($dept_perms_query);
    //         $dept_perms_stmt->bindParam(':dept_perm', $dept_perm);
    //         $dept_perms_stmt->bindParam(':dept_id', $dept_id);
    //         $dept_perms_stmt->execute();
    //     }
    //     // Search for similar names in the two array (merge the array.  repetitions are deleted)
    //     // In case of repetitions, higher priority ones stay.
    //     // Priority is in this order (admin, modify, read, view)

    //     foreach ($_REQUEST['user_permission'] as $user_id => $permission) {
    //         $user_perms_query = "INSERT INTO {$GLOBALS['CONFIG']['db_prefix']}user_perms (fid, uid, rights) VALUES($fileId, :user_id, :permission)";
            
    //         $user_perms_stmt = $pdo->prepare($user_perms_query);
    //         $user_perms_stmt->bindParam(':user_id', $user_id);
    //         $user_perms_stmt->bindParam(':permission', $permission);
    //         $user_perms_stmt->execute();
    //     }

    //     // use id to generate a file name
    //     // save uploaded file with new name
    //     $newFileName = $fileId . '.dat';

    //     move_uploaded_file($tmp_name[$count], $GLOBALS['CONFIG']['dataDir'] . '/' . $newFileName);
    //     //copy($GLOBALS['CONFIG']['dataDir'] . '/' . ($fileId-1) . '.dat', $GLOBALS['CONFIG']['dataDir'] . '/' . $newFileName);

    //     AccessLog::addLogEntry($fileId, 'A', $pdo);
        
    //     // back to main page
    //     $message = urlencode(msg('message_document_added'));
        
    //     /**
    //      * Send out email notifications to reviewers
    //      */
    //     $file_obj = new FileData($fileId, $pdo);
    //     $get_full_name = $user_obj->getFullName();
    //     $full_name = $get_full_name[0] . ' ' . $get_full_name[1];
    //     $from = $user_obj->getEmailAddress();
     
    //     $department = $file_obj->getDepartment();
        
    //     $reviewer_obj = new Reviewer($fileId, $pdo);
    //     $reviewer_list = $reviewer_obj->getReviewersForDepartment($department);

    //     $date = date('Y-m-d H:i:s T');
        
    //     // Build email for general notices
    //     $mail_subject = msg('addpage_new_file_added');
    //     $mail_body2 = msg('email_a_new_file_has_been_added') . PHP_EOL . PHP_EOL;
    //     $mail_body2.=msg('label_filename') . ':  ' . $file_obj->getName() . PHP_EOL . PHP_EOL;
    //     $mail_body2.=msg('label_status') . ': ' . msg('addpage_new') . PHP_EOL . PHP_EOL;
    //     $mail_body2.=msg('date') . ': ' . $date . PHP_EOL . PHP_EOL;
    //     $mail_body2.=msg('addpage_uploader') . ': ' . $full_name . PHP_EOL . PHP_EOL;
    //     $mail_body2.=msg('email_thank_you') . ',' . PHP_EOL . PHP_EOL;
    //     $mail_body2.=msg('email_automated_document_messenger') . PHP_EOL . PHP_EOL;
    //     $mail_body2.=$GLOBALS['CONFIG']['base_url'] . PHP_EOL . PHP_EOL;
        
    //     $email_obj = new Email();
    //     $email_obj->setFullName($full_name);
    //     $email_obj->setSubject($mail_subject);
    //     $email_obj->setFrom($from);
    //     $email_obj->setRecipients($reviewer_list);
    //     $email_obj->setBody($mail_body2);
    //     $email_obj->sendEmail();
    
    //     //email_users_id($mail_from, $reviewer_list, $mail_subject, $mail_body2, $mail_headers);
    //     // Call the plugin API
    //     callPluginMethod('onAfterAdd', $fileId);
    // }
        
    // header('Location: details.php?id=' . $fileId . '&last_message=' . urlencode($message));
    // exit;
// }
}

// draw_footer();


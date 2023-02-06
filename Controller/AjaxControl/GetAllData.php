
<?php

    use Aura\Html\Escaper as e;
    require_once("../../File_class.php");
    session_start();
    $GLOBALS['state'] = 1;
    require_once '../../odm-load.php';

    $dataDir = $GLOBALS['CONFIG']['dataDir'];
    $userID = $_SESSION['uid'];
    $userperms_obj = new UserPermission($_SESSION['uid'], $pdo);

    $showCheckBox = false;
    $rejectpage = false;
        $servername = "localhost";
        $username = "opendocman";
        $password = "ideavate123";
        $dbname = "OpenDocMan";
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

    function SwitchCheckCase($checkState){
        switch($checkState){
            case 'Department': return "department";
            case 'Author': return "owner";
            case 'Designation': return "Designation";
            case 'File Category': return "category";
            case 'Status': return "status";
            default : return null;
        }
    }
        
    function parentElementTable($parentElemt){
            
        switch ($parentElemt) {
        case "department": return "odm_department";
        case "dep_category": return "category";
        case "sub_category": return "subcategory";
        case "Designation": return "odm_designation";
        case "owner": return "odm_user";
        case "category": return "odm_category";
        case "status": return "odm_data";
            default: return NULL;
        }
    }
    function parentElementTableColumn($parentElemt){
        
        switch ($parentElemt) {
        case "odm_department": return "name";
        case "category": return "cat_name";
        case "subcategory": return "sub_cat_name";
        case "odm_designation": return "name";
        case "odm_user": return "first_name";
        case "odm_data": return "status";
        case "odm_category": return "name";
            default: return NULL;
        }
    }

    $QueryParam =  $_GET['query'];
    // var_dump($QueryParam);
    $ValuePar = json_decode($QueryParam, false);
    if(count($ValuePar) == 4 && strtolower($ValuePar[3]->name) == "department" && $ValuePar[3]->id == "1" ){
        $subCategory = $ValuePar[0]; 
        $Category = $ValuePar[1]; 
        $DepartmentValue = $ValuePar[2]; 
        $Department = $ValuePar[3];
        $DepartmentName = SwitchCheckCase($Department->name);
        $DepartmentTable = parentElementTable($DepartmentName);
        $parentElementTableColumn = parentElementTableColumn($DepartmentTable);

        $Query="SELECT id FROM $DepartmentTable WHERE $parentElementTableColumn LIKE '$DepartmentValue->name';";
        $result = $conn->query($Query);
        if($result->num_rows === 1){
            // print_r($result);
            $id = NULL;
            while($row= $result->fetch_assoc()){
                $id = $row['id'];
            }
            $departmentid =   explode(" ",$DepartmentValue->id);
            $departmentid = end($departmentid);
            $categoryid =  explode(" ",$Category->id);
            $categoryid = end($categoryid);
            $subcategoryid = explode(" ",$subCategory->id);
            $subcategoryid = end($subcategoryid);
            if ($departmentid !== $id){
                die ("Mismatched Data Please Refresh the page !");
            }
            $Query="SELECT * FROM `odm_data` WHERE `odm_data`.`department` = '$departmentid' and `odm_data`.`dep_category` = '$categoryid' and `odm_data`.`sub_category` = '$subcategoryid' ; ";
            $result = $conn->query($Query);
        }
    }
    else{
        $Child = $ValuePar[0]; 
        $UskaParent = $ValuePar[1];
        $TableColumnGet = SwitchCheckCase($UskaParent->name);
        $ChildID =   explode(" ",$Child->id);
        $ChildID = end($ChildID);
        $Query="SELECT * FROM `odm_data` WHERE `odm_data`.`$TableColumnGet` = '$ChildID' ; ";
        $result = $conn->query($Query);
    }
    if ($result->num_rows > 0){
        $file_list_arr = array();
        while($row = $result->fetch_assoc()){
            $fileid = $row['id'];
                $Query_odm_user_perms="SELECT * FROM `odm_user_perms` WHERE `odm_user_perms`.`fid` = $fileid and `odm_user_perms`.`uid` = $userID ;";
                $Results_odm_user_perms = $conn->query($Query_odm_user_perms);
                if($Results_odm_user_perms->num_rows === 1){
                    $rights = NULL;
                    while($row= $Results_odm_user_perms->fetch_assoc()){
                        $rights = $row['rights'];
                    }
                    if($rights <= 1){
                        continue;
                    }
                }
                $file_obj = new FileData($fileid, $pdo);
                $userAccessLevel = $userperms_obj->getAuthority($fileid, $file_obj);
                $description = $file_obj->getDescription();
                $keyword= $file_obj->getkeyword();
                if ($file_obj->getStatus() == 0 and $userAccessLevel >= $userperms_obj->VIEW_RIGHT) {
                    $lock = false;
                } else {
                    $lock = true;
                }
                if ($description == '') {
                    $description = msg('message_no_description_available');
                }
        
                $created_date = fix_date($file_obj->getCreatedDate());
                if ($file_obj->getModifiedDate()) {
                    $modified_date = fix_date($file_obj->getModifiedDate());
                } else {
                    $modified_date = $created_date;
                }
                $full_name_array = $file_obj->getOwnerFullName();
                $owner_name = $full_name_array[1] . ', ' . $full_name_array[0];
                $dept_name = $file_obj->getDeptName();
                $realname = $file_obj->getRealname();
                //Get the file size in bytes.
                $filesize = display_filesize($dataDir . $fileid . '.dat');
                if ($userAccessLevel >= $userperms_obj->READ_RIGHT) {
                    $suffix = strtolower((substr($realname, ((strrpos($realname, ".") + 1)))));
                    $mimetype = File::mime_by_ext($suffix);
                    $view_link = 'view_file.php?submit=view&id=' . urlencode(e::h($fileid)) . '&mimetype=' . urlencode("$mimetype");
                } else {
                    $view_link = 'none';
                }
        
                $details_link = 'details.php?id=' . e::h($fileid) . '&state=' . (e::h(1 + 1));
                $read = array($userperms_obj->READ_RIGHT, 'r');
                $write = array($userperms_obj->WRITE_RIGHT, 'w');
                $admin = array($userperms_obj->ADMIN_RIGHT, 'a');
                $rights = array($read, $write, $admin);
                $index_found = -1;
                //$rights[max][0] = admin, $rights[max-1][0]=write, ..., $right[min][0]=view
                //if $userright matches with $rights[max][0], then this user has all the rights of $rights[max][0]
                //and everything below it.
                for ($i = sizeof($rights) - 1; $i >= 0; $i--) {
                    if ($userAccessLevel == $rights[$i][0]) {
                        $index_found = $i;
                        $i = 0;
                    }
                }
                //Found the user right, now bold every below it.  For those that matches, make them different.
                
                //check for publishable file because we don't need to show them !!
                if (!$file_obj->isPublishable()){ 
                    continue;  
                }

                //For everything above it, blank out
                for ($i = $index_found + 1; $i < sizeof($rights); $i++) {
                    $rights[$i][1] = '-';
                }
                $file_list_arr[] = array(
                    'id' => $fileid,
                    'view_link' => $view_link,
                    'details_link' => $details_link,
                    'filename' => $realname,
                    'description' => $description,
                    'rights' => $rights,
                    'created_date' => $created_date,
                    'modified_date' => $modified_date,
                    'owner_name' => $owner_name,
                    'dept_name' => $dept_name,
                    'filesize' => $filesize,
                    'lock' => $lock,
                    'showCheckbox' => $showCheckBox,
                    'rejectpage' => $rejectpage,
                    'keyword' => $keyword
                );
        }
        try {
            echo  json_encode($file_list_arr);
        }
        catch(Exception $e) {
            echo  json_encode(array("Error While Accessing the Records "));
            die();
        }
    }
    else{
        echo  json_encode(array("No records found !"));
    }


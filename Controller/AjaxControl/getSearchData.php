
<?php
    use Aura\Html\Escaper as e;
    require_once("../../File_class.php");
    session_start();
    $GLOBALS['state'] = 1;
    require_once '../../odm-load.php';
    
    $dataDir = $GLOBALS['CONFIG']['dataDir'];
    $userperms_obj = new UserPermission($_SESSION['uid'], $pdo);
    
    $showCheckBox = false;
    $rejectpage = false;

    // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    $flag=0;
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
    
    function parentElementTable($parentElemt){
         
        switch ($parentElemt) {
        case "department": return "odm_department";
        case "dep_category": return "category";
        case "sub_category": return "subcategory";
        case "Designation": return "odm_designation";
        case "owner": return "odm_user";
        case "status": return "odm_data";
        case "category": return "odm_category";
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
    if(isset($_GET['currentElemt']) &&  isset($_GET['parentElemt'])){
        // echo "Yha check hota hai parent ka sath?";
        $currentElemt = $_REQUEST['currentElemt'];
        $parentElemt = $_REQUEST['parentElemt'];
        $parentTable =  parentElementTable($parentElemt);
        $parentTableColumn = parentElementTableColumn($parentTable);
        $Query="SELECT id FROM $parentTable WHERE $parentTableColumn LIKE '$currentElemt';";
        $result = $conn->query($Query);
        // print_r($result);
        if($result->num_rows === 1){
            // print_r($result);
            $id = NULL;
            while($row= $result->fetch_assoc()){
                $id = $row['id'];
            }
            $odm_data_query = "SELECT * FROM odm_data WHERE $parentElemt = $id ;";
            $data_result = $conn->query($odm_data_query);
            $return_res = array();
            if($data_result->num_rows >= 0){
                while($row=$data_result->fetch_assoc()){
                    $fileid = $row['id'];
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
                // print_r($file_list_arr);
                try {
                    echo  json_encode($file_list_arr);
                }
                catch(Exception $e) {
                    echo  json_encode(array("Ritik"));
                }
                
            }
            else{
                echo  json_encode(array("No records found !"));
            }
        }
        else{
            echo  json_encode(array("No records found !"));
        }
        
        // update in the code to get better results 

        // update yha tak krna ka try krta hai 
    }
    else{
        echo  json_encode(array("Parent ka bina hai yeh current wala !!!"));
    }

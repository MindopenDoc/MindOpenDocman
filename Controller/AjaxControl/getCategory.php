
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
        default: return NULL;
        }
    }
    function parentElementTableColumn($parentElemt){
         
        switch ($parentElemt) {
        case "odm_department": return "name";
        case "category": return "cat_name";
        case "subcategory": return "sub_cat_name";
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
            $odm_category_query = "SELECT * FROM category WHERE pr_id = $id ;";
            $data_result = $conn->query($odm_category_query);
            $resultData = array();
            if($data_result->num_rows >= 0){
                while($rowRe = $data_result->fetch_assoc()){
                    array_push($resultData,$rowRe);
                }
                echo  json_encode($resultData);
                die();
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


<?php
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
    if(isset($_GET['currentElemt']) ){
        $currentElemt = $_REQUEST['currentElemt'];
        $currentTable =  parentElementTable($currentElemt);
        $currentTableColumn = parentElementTableColumn($currentTable);
        $Query="SELECT $currentTableColumn  FROM $currentTable ";
       
        $result = $conn->query($Query);
        if($result->num_rows >= 1){
            $returnArray = array();
            while($row= $result->fetch_assoc()){
                // $id = $row['id'];
                array_push($returnArray,$row[$currentTableColumn]);
                // print_r($row[$currentTableColumn]);
            }
        } 
        print_r(json_encode($returnArray));
        die();
    }
    else{
        echo "Parent ka bina hai yeh current wala !!!";
    }

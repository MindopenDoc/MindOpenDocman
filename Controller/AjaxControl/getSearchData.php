
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
    if(isset($_GET['currentElemt']) &&  isset($_GET['parentElemt'])){
        // echo "Yha check hota hai parent ka sath?";
        $currentElemt = $_REQUEST['currentElemt'];
        $parentElemt = $_REQUEST['parentElemt'];
        $parentTable =  parentElementTable($parentElemt);
        $parentTableColumn = parentElementTableColumn($parentTable);
        $Query="SELECT id FROM $parentTable WHERE $parentTableColumn LIKE '$currentElemt';";
        $result = $conn->query($Query);
        if($result->num_rows === 1){
            
            $id = NULL;
            while($row= $result->fetch_assoc()){
                $id = $row['id'];
            }
            $odm_data_query = "SELECT * FROM odm_data WHERE $parentElemt = $id ;";
            $data_result = $conn->query($odm_data_query);
            $return_res = array();
            if($data_result->num_rows >= 0){
                while($row=$data_result->fetch_assoc()){
                    array_push($return_res,$row);
                }
                echo json_encode($return_res);
            }
            else{
                echo json_encode(array("No records found !"));
            }
        }
        else{
            echo json_encode(array("No records found !"));
        }
        


        // $id="SELECT id FROM $parentElemt WHERE cat_name='$cat'";
        // $result = $conn->query($id);
        // if(!$result){
        //     while($row = $result->fetch_assoc())
        //     {
        //         $pr_subcat=$row['id'];
        //     }
        //     $sql2="INSERT INTO subcategory (pr_id,sub_cat_name) VALUES ($pr_subcat,'$subcat')";
        //     if (!$conn->query($sql2) === TRUE) {
        //         die("Error: " . $sql2. "<br>" . $conn->error);
         
        //    }
        //    header("Location:http://localhost:8080/opendocman/out.php");

    }
    else{
        echo "Parent ka bina hai yeh current wala !!!";
    }

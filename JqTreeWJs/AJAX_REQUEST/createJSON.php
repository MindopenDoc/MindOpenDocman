<?php
 
    $FullTree = array();
    $flag=0;
    $servername = "localhost";
    $username = "opendocman";
    $password = "ideavate123";
    $dbname = "OpenDocMan";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $DepartmentTree = array("name"=>"Department","id"=>123);
    $Query="SELECT * FROM `odm_department`";
       
    $result = $conn->query($Query);
    if($result->num_rows >= 1){
        $departmentEntries = array();
        while($row= $result->fetch_assoc()){
            $pr_id = $row['id'];
            $CategoryQuery="SELECT * FROM `category` WHERE `category`.`pr_id` = $pr_id";
            $Categoryresult = $conn->query($CategoryQuery);
            if($Categoryresult->num_rows >= 1){
                // echo "Behki behki aada !!<br>";
                $categoryEntries = array();
                while($Categoryrow= $Categoryresult->fetch_assoc()){ 
                    array_push($categoryEntries,array("name"=>$Categoryrow['cat_name'],"id"=>$Categoryrow['id']));
                }
                // print_r($categoryEntries);
                array_push($departmentEntries,array("name"=>$row['name'],"id"=>$row['id'],"children"=>$categoryEntries));
            }
            else{
                array_push($departmentEntries,array("name"=>$row['name'],"id"=>$row['id']));
            }
           
        }
        $DepartmentTree['children'] = $departmentEntries;
        // print_r(json_encode($DepartmentTree));
    } 

    $UserTree = array("name"=>"Author","id"=>124);
    $Query="SELECT id,username as name FROM `odm_user`";
       
    $result = $conn->query($Query);
    if($result->num_rows >= 1){
        $departmentEntries = array();
        while($row= $result->fetch_assoc()){ array_push($departmentEntries,array("name"=>$row['name'],"id"=>$row['id']));}
        $UserTree['children'] = $departmentEntries;
        // print_r(json_encode($UserTree));
    } 
    array_push($FullTree,$DepartmentTree); //  FullTree
    array_push($FullTree,$UserTree);  
    print_r(json_encode($FullTree));
    die();


?>


// if ($row['id']){
            //     $pr_id = $row['id'];
            //     $CategoryQuery="SELECT * FROM `category` WHERE `category`.`pr_id` = $pr_id";
            //     $Categoryresult = $conn->query($CategoryQuery);
            //     if($Categoryresult->num_rows >= 1){
            //         $categoryEntries = array();
            //         while($Categoryrow= $Categoryresult->fetch_assoc()){ 
            //             array_push($categoryEntries,array("name"=>$Categoryrow['cat_name'],"id"=>$Categoryrow['id']));
            //         }
            //     }
            //     array_push($departmentEntries,array("name"=>$row['name'],"id"=>$row['id'],"children"=>$categoryEntries));
            // }
            // else{
                array_push($departmentEntries,array("name"=>$row['name'],"id"=>$row['id']));
            // }